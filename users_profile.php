<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';
require_once 'session.php';

$navigation_link = 'users_profile';
$user_id = filter_input(INPUT_GET, 'id');
$subscribes = null;

$this_user = get_user($connection, $user_id);
$get_tab = filter_input(INPUT_GET, 'tab');

if ($get_tab === 'posts' || $get_tab === 'likes' || $get_tab === 'subscribes') {
    $tab = $get_tab;
} else {
    $tab = 'posts';
}

if ($this_user) {
    switch ($tab) {
        case 'posts':
            $sql = 'SELECT DISTINCT p.id, title, text, quote_auth, img, video, title, text, quote_auth, img, video, link, views, user_id, p.dt_add, type,' .
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
                ' JOIN users u ON u.id = p.user_id' .
                ' JOIN content_type ct ON p.content_type_id = ct.id' .
                ' WHERE u.id = ?' .
                ' ORDER BY p.dt_add ASC;';
            break;
        case 'likes':
            $sql = 'SELECT DISTINCT p.id, img, likes.dt_add, likes.user_id, login, type, ct.name, avatar' .
                ' FROM posts p' .
                ' JOIN likes' .
                ' JOIN users u ON u.id = likes.user_id' .
                ' JOIN content_type ct ON p.content_type_id = ct.id' .
                ' WHERE p.user_id = ? AND p.id = likes.post_id' .
                ' ORDER BY likes.dt_add ASC';
            break;
        case 'subscribes':
            $sql = 'SELECT id, login, avatar, dt_add, follow_id, follower_id,' .
                ' (SELECT COUNT(p.id) FROM posts p' .
                ' WHERE p.user_id = u.id) AS posts_count,' .
                ' (SELECT COUNT(follower_id) FROM subscribes s' .
                ' WHERE s.follow_id = u.id) AS subscribers_count' .
                ' FROM users u' .
                ' JOIN subscribes s ON u.id = follow_id' .
                ' WHERE follower_id = ?';
    }
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $is_subscribe = check_subscription($connection, $this_user['id'], $user['user_id']);
    $user_info = get_user_info($connection, $user_id);

} else {
    header('Location: error.php?code=404');
    exit;
}


$page_content = include_template('profile_templates/users-profile-window.php', [
    'this_user' => $this_user,
    'tab' => $tab,
    'posts' => $posts,
    'user_info' => $user_info,
    'is_subscribe' => $is_subscribe,
    'user' => $user,
    'connection' => $connection
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'this_user' => $this_user,
    'user' => $user,
    'navigation_link' => $navigation_link,
    'message_notification' => $message_notification
]);
print($layout_content);
