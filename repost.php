<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$post_id = filter_input(INPUT_GET, 'id');

$sql = 'SELECT id, title, text, quote_auth, img, video, link, content_type_id, user_id' .
    ' FROM posts' .
    ' WHERE id = ?;';
$stmt = db_get_prepare_stmt($connection, $sql, [$post_id]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($result) {
    $post = mysqli_fetch_assoc($result);
    $post['original_id'] = $post['id'];
    $post['user_id'] = $user['user_id'];

    $sql = 'INSERT INTO posts (title, text, quote_auth, img, video, link, content_type_id, user_id, original_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($connection, $sql, [
        $post['title'],
        $post['text'],
        $post['quote_auth'],
        $post['img'],
        $post['video'],
        $post['link'],
        $post['content_type_id'],
        $post['user_id'],
        $post['original_id']
    ]);
    $result = mysqli_stmt_execute($stmt);
    $repost_id = mysqli_insert_id($connection);
    header('Location: post.php?id=' . $repost_id);
    exit;
}
