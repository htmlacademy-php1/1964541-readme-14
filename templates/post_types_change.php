<?php

switch ($post['type']) {
    case 'photo':
        echo include_template('post_templates/post_window_types/post-photo.php', ['post' => $post]);
        break;
    case 'video':
        echo include_template('post_templates/post_window_types/post-video.php', ['post' => $post]);
        break;
    case 'quote':
        echo include_template('post_templates/post_window_types/post-quote.php', ['post' => $post]);
        break;
    case 'text':
        echo include_template('post_templates/post_window_types/post-text.php', ['post' => $post]);
        break;
    case 'link':
        echo include_template('post_templates/post_window_types/post-link.php', ['post' => $post]);
        break;
    case null:
        print ('<div class="feed__wrapper"></div>');
}
?>
