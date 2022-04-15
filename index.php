<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

$is_auth = rand(0, 1);

$user_name = 'Кирилл';

if (!$connection) {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}

$sql = 'SELECT * FROM posts' .
    ' JOIN users u ON posts.user_id = u.id' .
    ' JOIN content_type ct ON posts.content_type_id = ct.id' .
    ' ORDER BY views DESC;';
$result = mysqli_query($connection, $sql);

if ($result) {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}


$sql = 'SELECT name, type FROM content_type;';
$result = mysqli_query($connection, $sql);

if ($result) {
    $content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}


$page_content = include_template('main.php', [
    'posts' => $posts,
    'content_types' => $content_types]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'is_auth' => $is_auth,
    'user_name' => $user_name]);
print($layout_content);

?>

