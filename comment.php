<?php

require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['text', 'post_id'];
    $rules = [
        'text' => function ($value) {
            return validate_comment($value, COMMENT_MIN_LENGTH);
        },
        'post_id' => function ($value) use ($connection) {
            return validate_post_id($connection, $value);
        }
    ];

    $comment = filter_input_array(INPUT_POST, [
        'text' => FILTER_DEFAULT,
        'post_id' => FILTER_VALIDATE_INT
    ], true);

    $validation_errors = full_form_validation($comment, $rules, $required);

    if (!$validation_errors) {
        $sql = 'INSERT INTO comments (content, user_id, post_id)' .
            ' VALUES (?, ?, ?)';
        $stmt = db_get_prepare_stmt($connection, $sql, [$comment['text'], $user['user_id'], $comment['post_id']]);
        mysqli_stmt_execute($stmt);
        header('Location: users_profile.php?id=' . $this_user['id']);
        exit;
    }

    $page_content = include_template('post_templates/post-window.php', [
        'post' => $post,
        'user_info' => $user_info,
        'this_user' => $this_user,
        'is_subscribe' => $is_subscribe,
        'user' => $user,
        'validation_errors' => $validation_errors
    ]);
}
