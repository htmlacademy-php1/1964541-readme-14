<?php

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';


$navigation_link = 'add';
$sql = 'SELECT id, name, type
FROM content_type;';
$result = mysqli_query($connection, $sql);
$content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);

$tag_id = null;
$form_type = filter_input(INPUT_GET, 'type', FILTER_DEFAULT);

$back = $_SESSION['back'];


$validation_errors = [];
$required = ['title'];
$page_content = include_template('add_templates/adding-post.php', [
    'content_types' => $content_types,
    'validation_errors' => $validation_errors,
    'form_type' => $form_type,
    'form_templates' => $form_templates,
    'back' => $back
]);

if (validate_form_type($form_type, $content_types)) {
    if ($form_type === null) {
        header('Location: add.php?type=text');
        exit;
    }
} else {
    if ($form_type === null) {
        header('Location: error.php?code=500');
        exit;
    }
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
        'content_type_id' => $form_type
    ], true);
    $post['user_id'] = $user['user_id'];

    $required = change_form($form_type, $required);

    if ($form_type === 'photo') {
        if (!empty($_FILES['userpic-file-photo']['name'])) {
            $tmp_name = $_FILES['userpic-file-photo']['tmp_name'];
            $path = $_FILES['userpic-file-photo']['name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);
            $filename = uniqid();
            $post['file'] = $file_type;

            $rules['file'] = function ($value) {
                return validate_file($value);
            };

        } else {
            $required[] = 'photo-link';
            $rules['photo-link'] = function ($value) {
                return validate_photo_link($value);
            };
        }
    }


    $sql = 'SELECT id
    FROM content_type
    WHERE type = ?';
    $stmt = db_get_prepare_stmt($connection, $sql, [$form_type]);
    mysqli_stmt_execute($stmt);
    $type_result = mysqli_stmt_get_result($stmt);
    $type_row = mysqli_fetch_array($type_result, MYSQLI_ASSOC);
    $post['content_type_id'] = $type_row['id'];

    $validation_errors = full_form_validation($post, $rules, $required);

    if (!$validation_errors) {
        if (!empty($post['photo-link'])) {
            $photo = file_get_contents($post['photo-link']);
            $temp_file = tempnam(sys_get_temp_dir(), 'ph');
            file_put_contents($temp_file, $photo);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $temp_file);
            $filename = uniqid();
            $path_parts = pathinfo($file_type);
            $filename .= '.' . $path_parts['basename'];
            file_put_contents('uploads/' . $filename, $photo);
            $post['photo-link'] = $filename;
        }

        if (isset($post['file'])) {
            $path_parts = pathinfo($file_type);
            $filename .= '.' . $path_parts['basename'];
            move_uploaded_file($tmp_name, 'uploads/' . $filename);
            $post['photo-link'] = $filename;
        }



        $sql = 'INSERT INTO posts (title, text, quote_auth, img, video, link, content_type_id, user_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
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
            $email = new Email();
            $mailer = new Mailer($transport);
            send_new_post_email($connection, $post, $email_configuration, $email, $mailer, $user);

            insert_tag($connection, $post['tags'], $post_id);

            header('Location: post.php?id=' . $post_id);
            exit;
        }
        $error = mysqli_error($connection);
        $page_content = include_template('error.php', ['error' => $error]);
    }

    $page_content = include_template('add_templates/adding-post.php', [
        'content_types' => $content_types,
        'validation_errors' => $validation_errors,
        'form_type' => $form_type,
        'form_templates' => $form_templates,
        'back' => $back
    ]);
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user,
    'navigation_link' => $navigation_link,
    'message_notification' => $message_notification
]);
print($layout_content);

