<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';


if (!$connection) {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}

$tab = filter_input(INPUT_GET, 'tab');
$params = filter_input(INPUT_GET, 'tab');
$get_sort = filter_input(INPUT_GET, 'sort');

if ($get_sort === 'likes' || $get_sort === 'views' || $get_sort === 'dt_add') {
    $sort = $get_sort;
} else {
    $sort = 'views';
}

if ($tab) {
    $sql = 'SELECT posts.id, title, text, quote_auth, img, video, link, views, user_id, posts.dt_add, login, avatar, type,' .
        ' (SELECT COUNT(post_id)' .
        ' FROM likes' .
        ' WHERE likes.post_id = posts.id)' .
        ' AS likes' .
        ' FROM posts' .
        ' JOIN users u ON posts.user_id = u.id' .
        ' JOIN content_type ct' .
        ' ON posts.content_type_id = ct.id' .
        ' WHERE ct.type = ?' .
        " ORDER BY $sort DESC;";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $tab);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $sql = 'SELECT posts.id, title, text, quote_auth, img, video, link, views, posts.dt_add, login, avatar, user_id, type,' .
        ' (SELECT COUNT(post_id)' .
        ' FROM likes' .
        ' WHERE likes.post_id = posts.id)' .
        ' AS likes' .
        ' FROM posts' .
        ' JOIN users u ON posts.user_id = u.id' .
        ' JOIN content_type ct' .
        ' ON posts.content_type_id = ct.id' .
        " ORDER BY $sort DESC;";
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


if ($result) {
    $content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $page_content = include_template('popular_templates/main.php', [
        'posts' => $posts,
        'content_types' => $content_types,
        'tab' => $tab,
        'sort' => $sort]);
} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user]);
print($layout_content);


?>

