<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';


$sql = 'SELECT id, name, type FROM content_type;';
$result = mysqli_query($connection, $sql);
$content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);


$type_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$validation_errors = [];
$required = ['title', 'tags'];
$page_content = include_template('add_templates/adding-post.php', ['content_types' => $content_types, 'validation_errors' => $validation_errors, 'type_id' => $type_id]);

switch (validate_type_id($type_id, $content_types)) {
    case 1:
        header('Location: add.php?id=1');
        break;
    case 2:
        header('Location: error.php?code=404');
        break;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rules = [
        'title' => function ($value) {
            return validate_filled($value);
        },
        'tags' => function ($value) {
            return validate_tag($value);
        },
        'photo-link' => function ($value) {
            return validate_photo_link($value);
        },
        'video' => function ($value) {
            return validate_video($value);
        },
        'quote_auth' => function ($value) {
            return validate_text($value, QUOTE_AUF_MIN_LENGTH, QUOTE_AUF_MAX_LENGTH);
        }
    ];


    $post = filter_input_array(INPUT_POST, [
        'title' => FILTER_DEFAULT,
        'text' => FILTER_DEFAULT,
        'quote_auth' => FILTER_DEFAULT,
        'photo-link' => FILTER_VALIDATE_URL,
        'video' => FILTER_VALIDATE_URL,
        'link' => FILTER_VALIDATE_URL,
        'tags' => FILTER_DEFAULT,
        'content_type_id' => $type_id
    ], true);


    switch ($type_id) {
        case 1:
            $required[] = 'text';
            break;
        case 2:
            $required[] = 'quote_auth';
            $required[] = 'text';
            break;
        case 3:
            // Валидация файла
            if (!empty($_FILES['userpic-file-photo']['name'])) {
                $tmp_name = $_FILES['userpic-file-photo']['tmp-name'];
                $path = $_FILES['userpic-file-photo']['name'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file_type = finfo_file($finfo, $tmp_name);
                $filename = uniqid();

                switch ($file_type) {
                    case 'image/gif':
                        $filename .= '.gif';
                        break;
                    case 'image/jpeg':
                        $filename .= '.jpg';
                        break;
                    case 'image/png':
                        $filename .= '.png';
                }

                if ($file_type !== 'image/gif' || $file_type !== 'image/jpg' || $file_type !== 'image/png') {
                    $validation_errors['file'] = 'Загрузите файл формата gif, jpeg или png';
                } else {
                    move_uploaded_file($tmp_name, '/uploads' . $filename);
                    $post['photo-link'] = $filename;
                }
            } else if (empty($post['photo-link'])) {
                $validation_errors['file'] = 'Вы не загрузили файл и не добавили ссылку';
            }

            if (!isset($_FILES['userpic-file-photo']['name'])) { //если файл с фото не добавлен, то проверяем ссылку.
                $required[] = 'photo-link';
            }
            break;
        case 4:
            $required[] = 'link';
            $required['link'] = function ($value) { // не смог придумать как сделать это более элегантно
                if ($value) { // не хотелось ради этого отдельную функцию валидации создавать, но могу, если надо
                    return null;
                }
                return 'Введите верный URL';
            };
            break;
        case 5:
            $required[] = 'video';
            break;
    }

    foreach ($post as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $validation_errors[$key] = $rule($value);
        }
        if (in_array($key, $required) && empty($value)) {
            $validation_errors[$key] = 'Поле ' . $key . ' надо заполнить';
        }
    }
    $validation_errors = array_diff($validation_errors, array(''));

    if ($validation_errors) {
        $page_content = include_template('add_templates/adding-post.php', ['content_types' => $content_types, 'validation_errors' => $validation_errors, 'type_id' => $type_id]);
    } else {
        $sql = 'INSERT INTO tags (name) VALUE (?)';
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 's', $tag);
        if (stristr($post['tags'], ' ')) {
            $tags = explode(' ', $post['tags']);
            foreach ($tags as $tag) {
                mysqli_stmt_execute($stmt);
                $tags_id = [];
                $tags_id = mysqli_insert_id($connection);
            }
        } else {
            $tag = $post['tags'];
            mysqli_stmt_execute($stmt);
            $tag_id = mysqli_insert_id($connection);
        }
        unset($post['tags']);


        $sql = 'INSERT INTO posts (title, text, quote_auth, img, video, link, content_type_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, 1)';
        $stmt = db_get_prepare_stmt($connection, $sql, $post);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            $post_id = mysqli_insert_id($connection);
            header('Location: post.php?id=' . $post_id);
        } else {
            $page_content = include_template('error.php', ['error' => $error]);
        }

        $sql = "INSERT INTO posts_tags (post_id, tag_id) VALUES ($post_id, $tag_id)";
        $result = mysqli_query($connection, $sql);
    }
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'is_auth' => $is_auth,
    'user_name' => $user_name]);
print($layout_content);

