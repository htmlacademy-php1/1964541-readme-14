<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$user_id = $user['user_id'];
$post_id = filter_input(INPUT_GET, 'id');

$sql = 'SELECT *' .
    ' FROM likes ' .
    ' WHERE user_id = ? AND post_id = ?';
$stmt = db_get_prepare_stmt($connection, $sql, [$user_id, $post_id]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result = mysqli_num_rows($result);
if ($result) {
    $sql = 'DELETE FROM likes' .
        ' WHERE user_id = ? AND post_id = ?;';
    $stmt = db_get_prepare_stmt($connection, $sql, [$user_id, $post_id]);
    mysqli_stmt_execute($stmt);
    $back = $_SERVER['HTTP_REFERER'];
    header('Location:' . $back);
    exit;
} else {
    $sql = 'INSERT INTO likes (user_id, post_id)' .
        ' VALUES (?, ?);';
    $stmt = db_get_prepare_stmt($connection, $sql, [$user_id, $post_id]);
    mysqli_stmt_execute($stmt);
    $back = $_SERVER['HTTP_REFERER'];
    header('Location:' . $back);
    exit;
}
