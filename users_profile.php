<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';
require_once 'session.php';

$user_id = filter_input(INPUT_GET, 'id');

$this_user = get_user($connection, $user_id);

if ($this_user) {
    $sql = 'SELECT DISTINCT p.id, title, text, quote_auth, img, video, title, text, quote_auth, img, video, link, views, user_id, p.dt_add, login, type, avatar' .
        ' FROM posts p' .
        ' JOIN users u ON u.id = p.user_id' .
        ' JOIN content_type ct ON p.content_type_id = ct.id' .
        ' WHERE u.id = ?;';
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


$page_content = include_template('profile_templates/users-profile-window.php', ['this_user' => $this_user, 'posts' => $posts, 'user_info' => $user_info, 'is_subscribe' => $is_subscribe]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'this_user' => $this_user,
    'user' => $user]);
print($layout_content);
