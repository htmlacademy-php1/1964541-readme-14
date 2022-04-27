<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';
require_once 'session.php';

$page_content = include_template('profile_templates/profile-window.php', ['user' => $user]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user]);
print($layout_content);
