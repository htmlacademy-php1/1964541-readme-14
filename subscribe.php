<?php

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$follow_id = filter_input(INPUT_GET, 'id');
$sql = 'SELECT id
FROM users
WHERE id = ?;';
$stmt = db_get_prepare_stmt($connection, $sql, [$follow_id]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($result) {
    $follower_id = $user['user_id'];
    $sql = 'SELECT *' .
        ' FROM subscribes' .
        ' WHERE follow_id = ? AND follower_id = ?;';
    $stmt = db_get_prepare_stmt($connection, $sql, [$follow_id, $follower_id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($result);

    if (!$result) {
        $sql = 'INSERT INTO subscribes (follow_id, follower_id)' .
            ' VALUES (?, ?)';
        $stmt = db_get_prepare_stmt($connection, $sql, [$follow_id, $follower_id]);
        mysqli_stmt_execute($stmt);
        $this_user = get_user($connection, $follow_id);
        $email = new Email();
        $email->from($email_configuration['from']);
        $email->to($this_user['email']);
        $email->subject('У вас новый подписчик');
        $email->text('Здравствуйте, ' . $this_user['login'] . '. На вас подписался новый пользователь ' . $user['user'] . '. Вот ссылка на его профиль:' . $email_configuration['host_info'] . '/users_profile.php?id=' . $user['user_id']);
        $mailer = new Mailer($transport);
        $mailer->send($email);

        header('Location: users_profile.php?id=' . $follow_id);
        exit;
    }

} else {
    header('Location: error.php?code=404');
    exit;
}

