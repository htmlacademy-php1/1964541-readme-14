<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$validation_errors = [];

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

$chat_id = filter_input(INPUT_GET, 'chat_id', FILTER_VALIDATE_INT);

$sql = 'SELECT u.id, content, m.dt_add, login, avatar FROM messages m' .
    ' JOIN users u ON m.sender_id = u.id' .
    ' WHERE (sender_id = ? AND recipient_id = ?) OR (recipient_id = ? AND sender_id = ? )' .
    ' ORDER BY m.dt_add ASC;';
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, 'iiii', $chat_id, $user['user_id'], $chat_id, $user['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$messages = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['content'];
    $rules = [
        'content' => function ($value) {
            return validate_message($value, MESSAGE_MIN_LENGTH);
        },
        'recipient_id' => function ($value) use ($connection) {
            return validate_recipient_id($connection, $value);
        }
    ];

    $message = filter_input_array(INPUT_POST, [
        'content' => FILTER_DEFAULT,
    ], true);
    $message['recipient_id'] = $chat_id;

    $validation_errors = full_form_validation($message, $rules, $required);

    if ($validation_errors) {
        $page_content = include_template('message_templates/message-page.php', [
            'messages' => $messages,
            'chats' => $chats,
            'chat_id' => $chat_id,
            'user' => $user,
            'validation_errors' => $validation_errors
        ]);

    } else {
        $sql = 'INSERT INTO messages (content, recipient_id, sender_id)' .
            ' VALUES (?, ?, ?)';
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 'sii', $message['content'], $chat_id, $user['user_id']);
        mysqli_stmt_execute($stmt);
        header('Location: messages.php?chat_id=' . $chat_id);
        exit;
    }
}


$page_content = include_template('message_templates/message-page.php',
    ['messages' => $messages, 'chats' => $chats, 'chat_id' => $chat_id, 'user' => $user, 'validation_errors' => $validation_errors]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user
]);
print($layout_content);
