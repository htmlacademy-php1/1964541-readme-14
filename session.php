<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION;

$tab = filter_input(INPUT_GET, 'tab');
if ($tab === 'text') {
    $_SESSION['back'] = $_SERVER['HTTP_REFERER'];
}

$sql = 'SELECT COUNT(is_read)' .
    ' AS unread_messages' .
    ' FROM messages' .
    ' WHERE (recipient_id = ?) AND (is_read = false);';
$stmt = db_get_prepare_stmt($connection, $sql, [$user['user_id']]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($result) {
    $message_notification = mysqli_fetch_assoc($result);
}
