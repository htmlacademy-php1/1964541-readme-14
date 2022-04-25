<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';

session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
}



$page_content = include_template('feed_templates/strip.php');
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть']);

print $layout_content;
