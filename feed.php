<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';

session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
}
$user_id = $_SESSION['user_id'];

$sql = 'SELECT id, name, type FROM content_type;';
$result = mysqli_query($connection, $sql);
$content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = 'SELECT title, text, quote_auth, img, video, title, text, quote_auth, img, video, link, views, user_id, content_type_id, p.dt_add, login, avatar FROM posts p' .
    ' JOIN subscribes s ON p.user_id = s.follow_id' .
    ' JOIN users u on p.user_id = u.id' .
    ' WHERE follower_id = ?' .
    ' ORDER BY dt_add ASC;';
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, 's', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$posts = mysqli_fetch_all($result);
var_dump($posts);


$page_content = include_template('feed_templates/strip.php', ['posts' => $posts, 'content_types' => $content_types]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть']);

print $layout_content;
