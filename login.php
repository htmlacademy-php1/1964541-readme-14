<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';

$user = null;
$validation_errors = [];
$navigation_link = 'login';
$page_content = include_template('login-form.php', ['validation_errors' => $validation_errors]);


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user,
    'navigation_link' => $navigation_link
]);
print($layout_content);
