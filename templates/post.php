<article class="popular__post post <?= $post['type'] ?>">
    <header class="post__header">
        <h2><?= htmlspecialchars($post['title']) ?></h2>
    </header>
    <div class="post__main">
        <?php if ($post['type'] === 'post-photo'): ?>
            <?= include_template('post-photo.php', ['post' => $post]); ?>
        <?php elseif ($post['type'] === 'post-video'): ?>
            <?= include_template('post-video.php', ['post' => $post]) ?>
        <?php elseif ($post['type'] === 'post-quote'): ?>
            <?= include_template('post-quote.php', ['post' => $post]) ?>
        <?php elseif ($post['type'] === 'post-text'): ?>
            <?= cut_text(htmlspecialchars($post['text'])) ?>
        <?php elseif ($post['type'] === 'post-link'): ?>
            <?= include_template('post-link.php', ['post' => $post]) ?>
        <?php endif; ?>
    </div>
    <footer class="post__footer">
        <div class="post__author">
            <a class="post__author-link" href="#" title="Автор">
                <div class="post__avatar-wrapper">
                    <img class="post__author-avatar" src="img/<?= $post['avatar'] ?>"
                         alt="Аватар пользователя">
                </div>
                <div class="post__info">
                    <b class="post__author-name"><?= $post['login'] ?></b>
                    <time class="post__time" title="<?= date("d.m.y H:i", strtotime($post['dt_add'])) ?>"
                          datetime="<?= $post['dt_add'] ?>"><?= show_past_time($post['dt_add']) ?></time>
                </div>
            </a>
        </div>
        <div class="post__indicators">
            <div class="post__buttons">
                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                    <svg class="post__indicator-icon" width="20" height="17">
                        <use xlink:href="#icon-heart"></use>
                    </svg>
                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20"
                         height="17">
                        <use xlink:href="#icon-heart-active"></use>
                    </svg>
                    <span>0</span>
                    <span class="visually-hidden">количество лайков</span>
                </a>
                <a class="post__indicator post__indicator--comments button" href="#"
                   title="Комментарии">
                    <svg class="post__indicator-icon" width="19" height="17">
                        <use xlink:href="#icon-comment"></use>
                    </svg>
                    <span>0</span>
                    <span class="visually-hidden">количество комментариев</span>
                </a>
            </div>
        </div>
    </footer>
</article>


