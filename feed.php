<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';
require_once 'session.php';

$navigation_link = 'feed';

$sql = 'SELECT id, name, type FROM content_type;';
$result = mysqli_query($connection, $sql);
$content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);

$tab = filter_input(INPUT_GET, 'tab');
$is_type = null;

foreach ($content_types as $content_type) { //проверка на тип контента
    if ($content_type['type'] === $tab) {
        $is_type = 'Есть тип';
    }
}
if (!$is_type && !empty($tab)) {
    header('Location: error.php?code=404');
    exit;
}

if ($tab) {
    $sql = 'SELECT p.id, title, text, quote_auth, img, video, title, text, quote_auth, img, video, link, views, user_id, type, p.dt_add, login, avatar,' .
        ' (SELECT COUNT(post_id)' .
        ' FROM likes' .
        ' WHERE likes.post_id = p.id)' .
        ' AS likes,' .
        ' (SELECT COUNT(content) FROM comments' .
        ' WHERE post_id = p.id)' .
        ' AS comment_sum' .
        ' FROM posts p' .
        ' JOIN subscribes s ON p.user_id = s.follow_id' .
        ' JOIN users u ON p.user_id = u.id' .
        ' JOIN content_type ct ON p.content_type_id = ct.id' .
        ' WHERE follower_id = ? && type = ?' .
        ' ORDER BY dt_add ASC;';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'is', $user['user_id'], $tab);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

} else {
    $sql = 'SELECT p.id, title, text, quote_auth, img, video, title, text, quote_auth, img, video, link, views, user_id, type, p.dt_add, login, avatar,' .
        ' (SELECT COUNT(post_id)' .
        ' FROM likes' .
        ' WHERE likes.post_id = p.id)' .
        ' AS likes,' .
        ' (SELECT COUNT(content) FROM comments' .
        ' WHERE post_id = p.id)' .
        ' AS comment_sum' .
        ' FROM posts p' .
        ' JOIN subscribes s ON p.user_id = s.follow_id' .
        ' JOIN users u ON p.user_id = u.id' .
        ' JOIN content_type ct ON p.content_type_id = ct.id' .
        ' WHERE follower_id = ?' .
        ' ORDER BY dt_add ASC;';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}


$page_content = include_template('feed_templates/strip.php',
    ['posts' => $posts, 'content_types' => $content_types, 'tab' => $tab]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user,
    'navigation_link' => $navigation_link
]);
print($layout_content);

