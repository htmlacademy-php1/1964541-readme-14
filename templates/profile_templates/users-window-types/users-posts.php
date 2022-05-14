<section class="profile__posts tabs__content tabs__content--active">
    <h2 class="visually-hidden">Публикации</h2>
    <?php foreach ($posts as $post): ?>
        <article class="profile__post post post-photo">
            <header class="post__header">
                <h2><a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>
            </header>
            <?php switch ($post['type']) {
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
            <footer class="post__footer">
                <div class="post__indicators">
                    <?= include_template('post_buttons.php', ['post' => $post]) ?>
                    <time class="post__time"
                          datetime="2019-01-30T23:41"><?= show_past_time($post['dt_add']) ?></time>
                </div>
                <ul class="post__tags">
                    <?php $tags = get_tags($connection, $post['id']);
                    foreach ($tags as $tag): ?>
                        <li><a href="search.php?search=%23<?= $tag['name'] ?>">#<?= $tag['name'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </footer>
            <div class="comments">
                <a class="comments__button button" href="post.php?id=<?= $post['id'] ?>">Показать комментарии</a>
            </div>
        </article>
    <?php endforeach; ?>
</section>
