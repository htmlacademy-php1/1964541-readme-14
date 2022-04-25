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
            'login' => FILTER_DEFAULT,
            'password' => FILTER_DEFAULT]);

        $sql = 'SELECT login, password FROM users WHERE login = ?';
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, 's', $user['login']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $db_user = mysqli_fetch_assoc($result);

        if ($db_user) {
            if (password_verify($user['password'], $db_user['password'])) {
                header('Location: popular.php');
                // здесь будет открытие сессии
            } else {
                $validation_errors['password'] = 'Пароли не совпадают';
            }
        } else {
            $validation_errors['login'] = 'Пользователь не существует';
        }
        $anon_layout_content = include_template('anon_layout.php', ['validation_errors' => $validation_errors]);
    }
}
print $anon_layout_content;
