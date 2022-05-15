<?php
require_once 'vendor/autoload.php';

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$dsn = 'smtp://readmeproject2022@gmail.com:RUS220kc@smtp.gmail.com:465?encryption=tls';
$transport = Transport::fromDSN($dsn);


$connection = mysqli_connect('localhost', 'root', '', 'readme');
mysqli_set_charset($connection, 'utf8');

if (!$connection) {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}

const SECONDS_IN_MIN = 60;
const SECONDS_IN_HOUR = 3600;
const SECONDS_IN_DAY = 86400;
const SECONDS_IN_WEEK = 604800;
const SECONDS_IN_MONTH = 2419200;
const QUOTE_AUTHOR_MIN_LENGTH = 5;
const QUOTE_AUTHOR_MAX_LENGTH = 128;
const COMMENT_MIN_LENGTH = 4;
const LOGIN_MIN_LENGTH = 3;
const LOGIN_MAX_LENGTH = 320;
const PAGE_POST_LIMIT = 6;
const MESSAGE_PREVIEW_LENGTH = 4;
const TEXT_PREVIEW_LENGTH = 300;
const MESSAGE_MIN_LENGTH = 1;

$form_templates = [
    'photo' => 'add_templates/add_forms/add-post-photo.php',
    'text' => 'add_templates/add_forms/add-post-text.php',
    'link' => 'add_templates/add_forms/add-post-link.php',
    'video' => 'add_templates/add_forms/add-post-video.php',
    'quote' => 'add_templates/add_forms/add-post-quote.php'
];



?>
