<?php

require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$navigation_link = 'error';
$code = filter_input(INPUT_GET, 'code');

switch ($code) {
    case '404':
        $error = 'Ошибка 404';
        break;
    case '500':
        $error = 'Ошибка 500: Добавьте категории из queries.sql';
        break;
}

$page_content = include_template('error.php', ['error' => $error]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user,
    'navigation_link' => $navigation_link,
    'message_notification' => $message_notification
]);
print $layout_content;
