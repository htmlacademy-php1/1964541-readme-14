<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

$sql = 'SELECT email, login, password FROM users';
$result = mysqli_query($connection, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

$validation_errors = [];
$required = ['email', 'login', 'password', 'password-repeat'];
$page_content = include_template('registration_templates/reg-form.php', ['validation_errors' => $validation_errors]);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = filter_input_array(INPUT_POST, [
        'email' => FILTER_VALIDATE_EMAIL,
        'login' => FILTER_DEFAULT,
        'password' => FILTER_DEFAULT,
        'password-repeat' => FILTER_DEFAULT
    ], true);
    $repeat_pass = $user['password-repeat'];

    $rules = [
        'email' => function ($value) use ($users) {
            return validate_email($value, $users);
        },
        'login' => function ($value) {
            return validate_text($value, LOGIN_MIN_LENGTH, LOGIN_MAX_LENGTH);
        },
        'password' => function ($value) use ($repeat_pass) {
            return validate_password($value, $repeat_pass);
        }
    ];

    if (!empty($_FILES['userpic-file']['name'])) {
        $tmp_name = $_FILES['userpic-file']['tmp_name'];
        $path = $_FILES['userpic-file']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        $filename = uniqid();

        switch ($file_type) {
            case 'image/gif':
                $filename .= '.gif';
                break;
            case 'image/jpeg':
                $filename .= '.jpg';
                break;
            case 'image/png':
                $filename .= '.png';
        }

        if ($file_type === 'image/gif' || $file_type === 'image/jpeg' || $file_type === 'image/png') {
            move_uploaded_file($tmp_name, 'uploads/' . $filename);
            $user['avatar'] = $filename;
        } else {
            $validation_errors['file'] = 'Загрузите файл формата gif, jpeg или png';
        }
    }

    $validation_errors = full_form_validation($user, $rules, $required);

    if ($validation_errors) {
        $page_content = include_template('registration_templates/reg-form.php', ['validation_errors' => $validation_errors]);
    } else {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (email, password, login, avatar) VALUES (?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($connection, $sql, [$user['email'], $user['password'], $user['login'], $user['avatar']]);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            header('Location: popular.php');
        } else {
            $page_content = include_template('error.php', ['error' => $error]);
        }
    }
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'is_auth' => $is_auth,
    'user_name' => $user_name]);
print($layout_content);
