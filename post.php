<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
$is_auth = rand(0, 1);

$user_name = 'Кирилл';

$post_id = filter_input(INPUT_GET, 'id');

$sql = 'SELECT * FROM posts p' .
    ' JOIN users u ON p.user_id = u.id' .
    ' JOIN content_type ct' .
    ' ON p.content_type_id = ct.id' .
    ' WHERE p.id = ?';

$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, 'i', $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $post = mysqli_fetch_assoc($result);
} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}



$page_content = include_template('post-window.php', ['post' => $post]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'is_auth' => $is_auth,
    'user_name' => $user_name]);
print($layout_content);
