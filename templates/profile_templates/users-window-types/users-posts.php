<section class="profile__posts tabs__content tabs__content--active">
    <h2 class="visually-hidden">Публикации</h2>
    <?php foreach ($posts as $post): ?>
        <article class="profile__post post post-photo">
            <header class="post__header">
                <h2><a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>
            </header>
            <?= include_template('post_types_change.php', ['post' => $post]) ?>
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
