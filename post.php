<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'session.php';

$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$validation_errors = [];
$tags = [];
$navigation_link = 'post.php';

$sql = 'SELECT p.id, title, text, quote_auth, img, video, link, views, p.dt_add, user_id, type,' .
    ' (SELECT COUNT(post_id)' .
    ' FROM likes' .
    ' WHERE likes.post_id = p.id)' .
    ' AS likes,' .
    ' (SELECT COUNT(content) FROM comments' .
    ' WHERE post_id = p.id)' .
    ' AS comment_sum' .
    ' FROM posts p' .
    ' JOIN users u ON p.user_id = u.id' .
    ' JOIN content_type ct' .
    ' ON p.content_type_id = ct.id' .
    ' WHERE p.id = ?';

$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, 'i', $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $post = mysqli_fetch_assoc($result);
    $user_info = get_user_info($connection, $post['user_id']);
    $this_user = get_user($connection, $post['user_id']);
    $is_subscribe = check_subscription($connection, $this_user['id'], $user['user_id']);

    $sql = 'SELECT name FROM tags' .
        ' JOIN posts_tags pt on tags.id = pt.tag_id' .
        ' WHERE post_id = ?;';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $tags = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    $sql = 'SELECT content, user_id, c.dt_add, login' .
        ' FROM comments c' .
        ' JOIN users u ON c.user_id = u.id' .
        ' WHERE post_id = ?;';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ['comment', 'post_id'];
        $rules = [
            'comment' => function ($value) {
                return validate_comment($value, COMMENT_MIN_LENGTH);
            },
            'post_id' => function ($value) use ($connection) {
                return validate_post_id($connection, $value);
            }
        ];

        $comment = filter_input_array(INPUT_POST, [
            'comment' => FILTER_DEFAULT,
            'post_id' => FILTER_VALIDATE_INT
        ], true);

        $validation_errors = full_form_validation($comment, $rules, $required);

        if ($validation_errors) {
            $page_content = include_template('post_templates/post-window.php', [
                'post' => $post,
                'user_info' => $user_info,
                'this_user' => $this_user,
                'is_subscribe' => $is_subscribe,
                'user' => $user,
                'validation_errors' => $validation_errors
            ]);
        } else {
            $sql = 'INSERT INTO comments (content, user_id, post_id)' .
                ' VALUES (?, ?, ?)';
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, 'sii', $comment['comment'], $user['user_id'], $comment['post_id']);
            mysqli_stmt_execute($stmt);
            header('Location: users_profile.php?id=' . $this_user['id']);
            exit;
        }
    }

    $page_content = include_template('post_templates/post-window.php', [
        'post' => $post,
        'tags' => $tags,
        'comments' => $comments,
        'user_info' => $user_info,
        'this_user' => $this_user,
        'is_subscribe' => $is_subscribe,
        'user' => $user,
        'validation_errors' => $validation_errors
    ]);

} else {
    $error = mysqli_error($connection);
    $page_content = include_template('error.php', ['error' => $error]);
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'user' => $user,
    'navigation_link' => $navigation_link
]);
print($layout_content);
