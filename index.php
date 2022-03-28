<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

$is_auth = rand(0, 1);

$user_name = 'Кирилл';

$page_content = include_template('main.php', ['posts' => $posts]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Имя страницы',
    'is_auth' => $is_auth,
    'user_name' => $user_name]);
print($layout_content);

?>

