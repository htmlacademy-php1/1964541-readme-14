<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$request = filter_input(INPUT_GET, 'search');
var_dump($request);






$page_content = include_template('search_templates/search-result.php');
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user_name' => $user_name,
    'request' => $request]);
print($layout_content);
