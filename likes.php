<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$user_id = $user['id'];
$post_id = filter_input(INPUT_GET, 'id');

$sql = 'SELECT ? FROM posts;';
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt,'i', $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $sql = 'INSERT INTO likes (user_id, post_id) VALUES (?, ?);';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $post_id);
    mysqli_stmt_execute($stmt);

}
