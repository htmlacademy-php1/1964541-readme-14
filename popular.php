<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL & E_NOTICE & E_WARNING);


$tab = filter_input(INPUT_GET, 'tab');
$params = filter_input(INPUT_GET, 'tab');
$is_type = null;
$navigation_link = 'popular';

$get_sort = filter_input(INPUT_GET, 'sort');
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);

$sql = 'SELECT id
FROM posts;';
$result = mysqli_query($connection, $sql);
$posts_count = mysqli_num_rows($result);

if ($page <= 0) {
    $page = 1;
}

if ($get_sort === 'likes' || $get_sort === 'views' || $get_sort === 'dt_add') {
    $sort = $get_sort;
} else {
    $sort = 'views';
}

$offset = ($page - 1) * PAGE_POST_LIMIT;

if ($tab) {
    $sql = 'SELECT posts.id, title, text, quote_auth, img, video, link, views, user_id, posts.dt_add, login, avatar, type,' .
        ' (SELECT COUNT(post_id)' .
        ' FROM likes' .
        ' WHERE likes.post_id = posts.id)' .
        ' AS likes,' .
        ' (SELECT COUNT(content)' .
        ' FROM comments' .
        ' WHERE post_id = posts.id)' .
        ' AS comment_sum' .
        ' FROM posts' .
        ' JOIN users u ON posts.user_id = u.id' .
        ' JOIN content_type ct' .
        ' ON posts.content_type_id = ct.id' .
        ' WHERE ct.type = ?' .
        " ORDER BY $sort DESC" .
        ' LIMIT ' . PAGE_POST_LIMIT . " OFFSET $offset";
    $stmt = db_get_prepare_stmt($connection, $sql, [$tab]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $sql = 'SELECT posts.id, title, text, quote_auth, img, video, link, views, posts.dt_add, login, avatar, user_id, type,' .
        ' (SELECT COUNT(post_id)' .
        ' FROM likes' .
        ' WHERE likes.post_id = posts.id)' .
        ' AS likes,' .
        ' (SELECT COUNT(content)' .
        ' FROM comments' .
        ' WHERE post_id = posts.id)' .
        ' AS comment_sum' .
        ' FROM posts' .
        ' JOIN users u ON posts.user_id = u.id' .
        ' JOIN content_type ct' .
        ' ON posts.content_type_id = ct.id' .
        " ORDER BY $sort DESC" .
        ' LIMIT ' . PAGE_POST_LIMIT . " OFFSET $offset";
    $result = mysqli_query($connection, $sql);
}

if ($result) {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}


$sql = 'SELECT id, name, type
 FROM content_type;';
$result = mysqli_query($connection, $sql);


if ($result) {
    $content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($content_types as $content_type) { //проверка на тип контента
        if ($content_type['type'] === $tab) {
            $is_type = 'Есть тип';
        }
    }
    if (!$is_type && !empty($tab)) {
        header('Location: error.php?code=404');
        exit;
    }
    $page_content = include_template('popular_templates/main.php', [
        'posts' => $posts,
        'content_types' => $content_types,
        'tab' => $tab,
        'sort' => $sort,
        'page' => $page,
        'posts_count' => $posts_count
    ]);
} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user,
    'navigation_link' => $navigation_link,
    'message_notification' => $message_notification
]);
print($layout_content);


?>

