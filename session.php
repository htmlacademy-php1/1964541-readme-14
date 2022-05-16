<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
} else {
    $user = $_SESSION;
}

$sql = 'SELECT COUNT(is_read) AS unread_messages FROM messages' .
    ' WHERE (recipient_id = ?) AND (is_read = false);';
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($result) {
    $message_notification = mysqli_fetch_assoc($result);
}
