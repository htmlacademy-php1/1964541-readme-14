<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

$sql = 'SELECT id, name, type FROM content_type;';
$result = mysqli_query($connection, $sql);
$content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);


$page_content = include_template('add_templates/adding-post.php', ['content_types' => $content_types]);

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
        }
    ];
    $required = ['title', 'tags', 'photo-link'];
    $validation_errors = [];

    $filename = uniqid() . '.jpg';
    $post = filter_input_array(INPUT_POST, [
        'title' => FILTER_DEFAULT,
        'text' => FILTER_DEFAULT,
        'quote_auth' => FILTER_DEFAULT,
        'img' => $filename,
        'video' => FILTER_VALIDATE_URL,
        'photo-link' => FILTER_VALIDATE_URL,
        'link' => FILTER_VALIDATE_URL,
        'tags' => FILTER_DEFAULT,], true);
    move_uploaded_file($_FILES['userpic-file-photo']['tmp_name'], '/uploads' . $filename);

    foreach ($post as $key => $value) {
        var_dump($post);
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
        $page_content = include_template('add_templates/adding-post.php', ['content_types' => $content_types, 'validation_errors' => $validation_errors]);
    } else {
        var_dump($post);
        $sql = 'INSERT INTO posts (title, text, quote_auth, img, video, link, user_id, content_type_id) VALUES (?, ?, ?, ?, ?, ?, 1, 3)';
        $stmt = db_get_prepare_stmt($connection, $sql, $post);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            $post_id = mysqli_insert_id($connection);
            header('Location: post.php?id=' . $post_id);
        } else {
            $page_content = include_template('error.php', ['error' => $error]);
        }
    }
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'is_auth' => $is_auth,
    'user_name' => $user_name]);
print($layout_content);

