<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

$sql = 'SELECT id, name, type FROM content_type;';
$result = mysqli_query($connection, $sql);
$content_types = mysqli_fetch_all($result, MYSQLI_ASSOC);


$page_content = include_template('add_templates/adding-post.php', ['content_types' => $content_types]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_photo = $_POST;
    $filename = uniqid() . '.jpg';
    $post_photo['path'] = $filename;
    move_uploaded_file($_FILES['userpic-file-photo']['tmp_name'], '/uploads' . $filename);

    $sql = 'INSERT INTO posts (title, img, user_id, content_type_id) VALUES (?, ?, 1, 3)';
    $stmt = db_get_prepare_stmt($connection, $sql, $post_photo);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $post_id = mysqli_insert_id($connection);
        header('Location: post.php?id=' . $post_id);
    } else {
        $page_content = include_template('error.php', ['error' => $error]);
    }
}



$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'readme: блог, каким он должен быть',
    'is_auth' => $is_auth,
    'user_name' => $user_name]);
print($layout_content);
