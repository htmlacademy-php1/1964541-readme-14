<?php

require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$follow_id = filter_input(INPUT_GET, 'id');
$sql = 'SELECT id ' .
    ' FROM users ' .
    'WHERE id = ?';
$stmt = db_get_prepare_stmt($connection, $sql, [$follow_id]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($result) {
    $follower_id = $user['user_id'];
    $sql = 'SELECT * FROM subscribes' .
        ' WHERE follow_id = ? AND follower_id = ?;';
    $stmt = db_get_prepare_stmt($connection, $sql, [$follow_id, $follower_id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($result);

    if ($result) {
        $sql = 'DELETE FROM subscribes
        WHERE follow_id = ? AND follower_id = ?;';
    }

    $stmt = db_get_prepare_stmt($connection, $sql, [$follow_id, $follower_id]);
    mysqli_stmt_execute($stmt);
    header('Location: users_profile.php?id=' . $follow_id);
    exit;
}

header('Location: error.php?code=404');
exit;

