<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

if (!$connection) {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}

$tab  = filter_input(INPUT_GET, 'tab');

if ($tab) {
    $sql = 'SELECT posts.id, title, text, quote_auth, img, video, link, views, posts.dt_add, login, avatar, type FROM posts' .
        ' JOIN users u ON posts.user_id = u.id' .
        ' JOIN content_type ct' .
        ' ON posts.content_type_id = ct.id' .
        ' WHERE ct.id = ?' .
        ' ORDER BY views DESC;';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $tab);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $sql = 'SELECT posts.id, title, text, quote_auth, img, video, link, views, posts.dt_add, login, avatar, type FROM posts' .
        ' JOIN users u ON posts.user_id = u.id' .
        ' JOIN content_type ct' .
        ' ON posts.content_type_id = ct.id' .
        ' ORDER BY views DESC;';
    $result = mysqli_query($connection, $sql);
}

if ($result) {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}


$sql = 'SELECT id, name, type FROM content_type;';
$result = mysqli_query($connection, $sql);

$params = filter_input(INPUT_GET, 'id');

if ($result) {
    $content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $page_content = include_template('index_templates/main.php', [
        'posts' => $posts,
        'content_types' => $content_types,
        'tab' => $tab,
        'params' => $params]);
} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}



$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'is_auth' => $is_auth,
    'user_name' => $user_name]);
print($layout_content);


?>

