<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';

$user = null;
$validation_errors = [];
$page_content = include_template('login-form.php', ['validation_errors' => $validation_errors]);






$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user]);
print($layout_content);
