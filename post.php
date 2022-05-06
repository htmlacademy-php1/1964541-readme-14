<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$validation_errors = [];

$sql = 'SELECT p.id, title, text, quote_auth, img, video, link, views, p.dt_add, user_id, type,' .
    ' (SELECT COUNT(post_id)' .
    ' FROM likes' .
    ' WHERE likes.post_id = p.id)' .
    ' AS likes' .
    ' FROM posts p' .
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
    $user_info = get_user_info($connection, $post['user_id']);
    $this_user = get_user($connection, $post['user_id']);
    $is_subscribe = check_subscription($connection, $this_user['id'], $user['user_id']);

    $sql = 'SELECT content, user_id, c.dt_add, login FROM comments c' .
        ' JOIN users u ON c.user_id = u.id' .
        ' WHERE post_id = ?;';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $page_content = include_template('post_templates/post-window.php', ['post' => $post, 'comments' => $comments, 'user_info' => $user_info, 'this_user' => $this_user, 'is_subscribe' => $is_subscribe, 'user' => $user, 'validation_errors' => $validation_errors]);

} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user]);
print($layout_content);
