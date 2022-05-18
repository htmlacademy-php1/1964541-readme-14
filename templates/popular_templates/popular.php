<article class="popular__post post post-<?= $post['type'] ?>">
    <header class="post__header">
        <h2><a href="post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
    </header>
    <div class="post__main">
        <?= include_template('post_types_change.php', ['post' => $post]) ?>
    </div>
    <footer class="post__footer">
        <div class="post__author">
            <a class="post__author-link" href="users_profile.php?id=<?= $post['user_id'] ?>" title="Автор">
                <div class="post__avatar-wrapper">
                    <img class="post__author-avatar" src="<?= get_user_avatar($post['avatar']) ?>"
                         alt="Аватар пользователя">
                </div>
                <div class="post__info">
                    <b class="post__author-name"><?= htmlspecialchars($post['login']) ?></b>
                    <time class="post__time" title="<?= date("d.m.y H:i", strtotime($post['dt_add'])) ?>"
                          datetime="<?= $post['dt_add'] ?>"><?= show_past_time($post['dt_add']) ?></time>
                </div>
            </a>
        </div>
        <div class="post__indicators">
            <div class="post__buttons">
                <a class="post__indicator post__indicator--likes button" href="likes.php?id=<?= $post['id']?>" title="Лайк">
                    <svg class="post__indicator-icon" width="20" height="17">
                        <use xlink:href="#icon-heart"></use>
                    </svg>
                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20"
                         height="17">
                        <use xlink:href="#icon-heart-active"></use>
                    </svg>
                    <span><?= $post['likes'] ?></span>
                    <span class="visually-hidden">количество лайков</span>
                </a>
                <a class="post__indicator post__indicator--comments button" href="post.php?id=<?= $post['id'] ?>"
                   title="Комментарии">
                    <svg class="post__indicator-icon" width="19" height="17">
                        <use xlink:href="#icon-comment"></use>
                    </svg>
                    <span><?= $post['comment_sum'] ?></span>
                    <span class="visually-hidden">количество комментариев</span>
                </a>
            </div>
        </div>
    </footer>
</article>


