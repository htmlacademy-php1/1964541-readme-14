<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

$sql = 'SELECT id, name, type FROM content_type;';
$result = mysqli_query($connection, $sql);
$content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);






$page_content = include_template('add_templates/adding-post.php', ['content_types' => $content_types]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'is_auth' => $is_auth,
    'user_name' => $user_name]);
print($layout_content);
