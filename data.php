<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$connection = mysqli_connect('localhost', 'root', '', 'readme');
mysqli_set_charset($connection, 'utf8');

const SECONDS_IN_MIN = 60;
const SECONDS_IN_HOUR = 3600;
const SECONDS_IN_DAY = 86400;
const SECONDS_IN_WEEK = 604800;
const SECONDS_IN_MONTH = 2419200;
const QUOTE_AUTHOR_MIN_LENGTH = 10;
const QUOTE_AUTHOR_MAX_LENGTH = 128;
const LOGIN_MIN_LENGTH = 6;
const LOGIN_MAX_LENGTH = 320;
$form_templates = [
    'photo' => 'add_templates/add_forms/add-post-photo.php',
    'text' => 'add_templates/add_forms/add-post-text.php',
    'link' => 'add_templates/add_forms/add-post-link.php',
    'video' => 'add_templates/add_forms/add-post-video.php',
    'quote' => 'add_templates/add_forms/add-post-quote.php'
];

$is_auth = rand(0, 1);

$user_name = 'Кирилл';

?>
