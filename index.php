<?php

require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';
require_once 'session_unlog.php';

$validation_errors = [];
$anon_layout_content = include_template('anon_layout.php', ['validation_errors' => $validation_errors]);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = filter_input_array(INPUT_POST, [
        'email' => FILTER_DEFAULT,
        'password' => FILTER_DEFAULT
    ]);

    $validation_errors = validate_login($connection, $user);

    $anon_layout_content = include_template('anon_layout.php', ['validation_errors' => $validation_errors]);
}
print $anon_layout_content;
