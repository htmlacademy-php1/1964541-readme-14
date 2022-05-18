<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';

$user = null;
$validation_errors = [];
$navigation_link = 'login';
$message_notification = null;
$page_content = include_template('login-form.php', ['validation_errors' => $validation_errors]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = filter_input_array(INPUT_POST, [
        'email' => FILTER_DEFAULT,
        'password' => FILTER_DEFAULT
    ]);

    $validation_errors = validate_login($connection, $user);

    $user = null;
    $page_content = include_template('login-form.php', ['validation_errors' => $validation_errors]);
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user,
    'navigation_link' => $navigation_link
]);
print($layout_content);
