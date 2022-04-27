<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql = 'SELECT p.id, title, text, quote_auth, img, video, link, views, p.dt_add, user_id, login, avatar, type FROM posts p' .
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
    $page_content = include_template('post_templates/post-window.php', ['post' => $post]);
} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}



$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user]);
print($layout_content);
