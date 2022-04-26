<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';


$validation_errors = [];
$anon_layout_content = include_template('anon_layout.php', ['validation_errors' => $validation_errors]);

if (isset($_SESSION['user'])) {
    header('Location: feed.php');
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = filter_input_array(INPUT_POST, [
            'email' => FILTER_DEFAULT,
            'password' => FILTER_DEFAULT]);

        $sql = 'SELECT id, email, login, password, avatar FROM users WHERE email = ?';
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 's', $user['email']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $db_user = mysqli_fetch_assoc($result);

        if ($db_user) {
            if (password_verify($user['password'], $db_user['password'])) {
                session_start();
                $_SESSION['user_id'] = $db_user['id'];
                $_SESSION['user'] = $db_user['login'];
                $_SESSION['avatar'] = $db_user['avatar'];
                header('Location: feed.php');
            } else {
                $validation_errors['password'] = 'Пароли не совпадают';
            }
        } else {
            $validation_errors['email'] = 'Неверный пользователь и/или пароль';
        }
        $anon_layout_content = include_template('anon_layout.php', ['validation_errors' => $validation_errors]);
    }
}
print $anon_layout_content;
