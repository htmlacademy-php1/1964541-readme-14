<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$sql = 'SELECT u.id, login, avatar,' .
    ' (SELECT content FROM messages m' .
    ' WHERE u.id = m.sender_id OR u.id = m.recipient_id' .
    ' ORDER BY m.dt_add DESC LIMIT 1) AS last_message,' .
    ' (SELECT m.dt_add FROM messages m' .
    ' WHERE u.id = m.sender_id OR u.id = m.recipient_id' .
    ' ORDER BY m.dt_add DESC LIMIT 1) AS last_message_dt_add' .
    ' FROM users u JOIN messages m ON u.id = m.recipient_id OR u.id = m.sender_id' .
    ' WHERE (sender_id OR recipient_id = ?) AND u.id != ?' .
    ' GROUP BY u.id;';
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $user['user_id'], $user['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$chats = mysqli_fetch_all($result, MYSQLI_ASSOC);


// тут извлекаются все сообщения
$sql = 'SELECT u.id, content, m.dt_add, sender_id, recipient_id, login, avatar FROM messages m JOIN users u ON m.recipient_id = u.id WHERE sender_id OR recipient_id = ?';
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$messages = mysqli_fetch_all($result, MYSQLI_ASSOC);


$page_content = include_template('message_templates/message-page.php', ['messages' => $messages, 'chats' => $chats]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user
]);
print($layout_content);
