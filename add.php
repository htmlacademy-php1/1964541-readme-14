<?php

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$navigation_link = 'add';
$sql = 'SELECT id, name, type FROM content_type;';
$result = mysqli_query($connection, $sql);
$content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);

$form_type = filter_input(INPUT_GET, 'type', FILTER_DEFAULT);

$validation_errors = [];
$required = ['title'];
$page_content = include_template('add_templates/adding-post.php', [
    'content_types' => $content_types,
    'validation_errors' => $validation_errors,
    'form_type' => $form_type,
    'form_templates' => $form_templates
]);

if (validate_form_type($form_type, $content_types)) {
    if ($form_type === null) {
        header('Location: add.php?type=text');
        exit;
    }
} else {
    header('Location: error.php?code=404');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rules = [
        'title' => function ($value) {
            return validate_filled($value);
        },
        'tags' => function ($value) {
            return validate_tag($value);
        },
        'video' => function ($value) {
            return validate_video($value);
        },
        'quote_auth' => function ($value) {
            return validate_text($value, QUOTE_AUTHOR_MIN_LENGTH, QUOTE_AUTHOR_MAX_LENGTH);
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
        'content_type_id' => $form_type,
    ], true);
    $post['user_id'] = $user['user_id'];


    switch ($form_type) {
        case 'text':
            $required[] = 'text';
            break;
        case 'quote':
            $required[] = 'quote_auth';
            $required[] = 'text';
            break;
        case 'photo':
            if (!empty($_FILES['userpic-file-photo']['name'])) {
                $tmp_name = $_FILES['userpic-file-photo']['tmp_name'];
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
                        break;
                }

                if ($file_type === 'image/gif' || $file_type === 'image/jpeg' || $file_type === 'image/png') {
                    move_uploaded_file($tmp_name, 'uploads/' . $filename);
                    $post['photo-link'] = $filename;
                } else {
                    $validation_errors['file'] = 'Загрузите файл формата gif, jpeg или png';
                }
            } else {
                if (empty($post['photo-link'])) {
                    $validation_errors['file'] = 'Вы не загрузили файл и не добавили ссылку';
                }
            }

            if (!isset($_FILES['userpic-file-photo']['name'])) {
                $required[] = 'photo-link';
                $rules['photo-link'] = function ($value) {
                    return validate_photo_link($value);
                };
            }
            break;
        case 'link':
            $required[] = 'link';
            $required['link'] = function ($value) {
                if ($value) {
                    return null;
                }
                return 'Введите верный URL';
            };
            break;
        case 'video':
            $required[] = 'video';
            break;
    }

    $sql = 'SELECT id FROM content_type WHERE type = ?';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $form_type);
    mysqli_stmt_execute($stmt);
    $type_result = mysqli_stmt_get_result($stmt);
    $type_row = mysqli_fetch_array($type_result, MYSQLI_ASSOC);
    $post['content_type_id'] = $type_row['id'];

    $validation_errors = full_form_validation($post, $rules, $required);

    if ($validation_errors) {
        $page_content = include_template('add_templates/adding-post.php', [
            'content_types' => $content_types,
            'validation_errors' => $validation_errors,
            'form_type' => $form_type,
            'form_templates' => $form_templates
        ]);
    } else {
        $sql = 'INSERT INTO posts (title, text, quote_auth, img, video, link, content_type_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($connection, $sql, [
            $post['title'],
            $post['text'],
            $post['quote_auth'],
            $post['photo-link'],
            $post['video'],
            $post['link'],
            $post['content_type_id'],
            $post['user_id']
        ]);
        $result = mysqli_stmt_execute($stmt);
        $post_id = mysqli_insert_id($connection);
        if ($result) {
            $sql = 'SELECT id, login, email FROM users' .
                ' JOIN subscribes s on users.id = s.follower_id' .
                ' WHERE follow_id = ?;';
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $post['user_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result) {
                $followers = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($followers as $follower) {
                    $email = new Email();
                    $email->from('readmeproject2022@gmail.com');
                    $email->to($follower['email']);
                    $email->subject('Новая публикация от пользователя' . $user['user']);
                    $email->text('Здравствуйте, ' . $follower['login'] . '. Пользователь ' . $user['user'] . ' только что опубликовал новую запись ' . $post['title'] . '. Посмотрите её на странице пользователя: http://localhost:8080/users_profile.php?id=' . $user['user_id']);
                    $mailer = new Mailer($transport);
                    $mailer->send($email);
                }
            }
            if ($post['tags']) {
                $post['tags'] = trim($post['tags']);

                if (stristr($post['tags'], ' ')) {
                    $tags = explode(' ', $post['tags']);
                    foreach ($tags as $tag) {
                        $sql = 'SELECT id, name FROM tags WHERE name = ?;';
                        $stmt = mysqli_prepare($connection, $sql);
                        mysqli_stmt_bind_param($stmt, 's', $tag);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if (mysqli_num_rows($result)) {
                            $db_tag = mysqli_fetch_assoc($result);
                            $tag_id[] = $db_tag['id'];
                        } else {
                            $sql = 'INSERT INTO tags (name) VALUE (?)';
                            $stmt = mysqli_prepare($connection, $sql);
                            mysqli_stmt_bind_param($stmt, 's', $tag);
                            mysqli_stmt_execute($stmt);
                            $tag_id[] = mysqli_insert_id($connection);
                        }
                    }
                } else {
                    $tag = $post['tags'];
                    $sql = 'SELECT id, name FROM tags WHERE name = ?;';
                    $stmt = mysqli_prepare($connection, $sql);
                    mysqli_stmt_bind_param($stmt, 's', $tag);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $db_tag = mysqli_fetch_assoc($result);
                    if ($db_tag) {
                        $tag_id = $db_tag['id'];
                    } else {
                        $sql = 'INSERT INTO tags (name) VALUE (?);';
                        $stmt = mysqli_prepare($connection, $sql);
                        mysqli_stmt_bind_param($stmt, 's', $tag);
                        mysqli_stmt_execute($stmt);
                        $tag_id = mysqli_insert_id($connection);
                    }
                }
                $sql = 'INSERT INTO posts_tags (post_id, tag_id) VALUES (?, ?)';
                $stmt = mysqli_prepare($connection, $sql);

                if (is_array($tag_id)) {
                    foreach ($tag_id as $item) {
                        mysqli_stmt_bind_param($stmt, 'ii', $post_id, $item);
                        mysqli_stmt_execute($stmt);
                    }
                } else {
                    mysqli_stmt_bind_param($stmt, 'ii', $post_id, $tag_id);
                    mysqli_stmt_execute($stmt);
                }

            }
            header('Location: post.php?id=' . $post_id);
            exit;
        } else {
            $page_content = include_template('error.php', ['error' => $error]);
        }

    }
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user,
    'navigation_link' => $navigation_link
]);
print($layout_content);

