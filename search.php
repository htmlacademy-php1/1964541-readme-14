<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$request = filter_input(INPUT_GET, 'search');
$posts = [];
$back = $_SERVER['HTTP_REFERER'];
$navigation_link = 'search';

if (str_starts_with($request, '#')) {
    $request = substr($request, 1);
    $sql = 'SELECT post_id FROM posts_tags pt' .
        ' JOIN tags t on pt.tag_id = t.id' .
        ' WHERE name = ?;';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $request);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $post_ids = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $sql = 'SELECT p.id, title, text, quote_auth, img, video, title, text, quote_auth, img, video, link, views, user_id, type, p.dt_add, login, avatar,' .
            ' (SELECT COUNT(post_id)' .
            ' FROM likes' .
            ' WHERE likes.post_id = p.id)' .
            ' AS likes,' .
            ' (SELECT COUNT(content) FROM comments' .
            ' WHERE post_id = p.id)' .
            ' AS comment_sum,' .
            ' (SELECT COUNT(original_id) FROM posts' .
            ' WHERE original_id = p.id)' .
            ' AS reposts_sum' .
            ' FROM posts p' .
            ' JOIN users u ON p.user_id = u.id' .
            ' JOIN content_type ct ON p.content_type_id = ct.id' .
            ' WHERE p.id = ?';
        $stmt = mysqli_prepare($connection, $sql);
        foreach ($post_ids as $post_id) {
            mysqli_stmt_bind_param($stmt, 'i', $post_id['post_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result) {
                $posts[] = mysqli_fetch_assoc($result);
            }
        }
    }
} else {
    $sql = 'SELECT title, text, quote_auth, img, video, title, text, quote_auth, img, video, link, views, user_id, type, p.dt_add, login, avatar FROM posts p' .
        ' JOIN users u ON p.user_id = u.id' .
        ' JOIN content_type ct ON p.content_type_id = ct.id' .
        ' WHERE MATCH (title, text) AGAINST (?);';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $request);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

$page_content = include_template('search_templates/search-result.php',
    ['posts' => $posts, 'request' => $request, 'back' => $back]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user,
    'request' => $request,
    'navigation_link' => $navigation_link,
    'message_notification' => $message_notification
]);
print($layout_content);
