<article class="popular__post post <?= $post['content_type'] ?>">
    <header class="post__header">
        <h2><?= htmlspecialchars($post['title']) ?></h2>
    </header>
    <div class="post__main">
        <?php if ($post['content_type'] === 'post-photo'): ?>
            <div class="post-photo__image-wrapper">
                <img src="img/<?= htmlspecialchars($post['img']) ?>" alt="Фото от пользователя" width="360"
                     height="240">
            </div>
        <?php elseif ($post['content_type'] === 'post-video'): ?>
            <div class="post-video__block">
                <div class="post-video__preview">
                    <?= embed_youtube_cover(htmlspecialchars($post['video'])); ?>
                    <img src="img/coast-medium.jpg" alt="Превью к видео" width="360" height="188">
                </div>
                <a href="post-details.html" class="post-video__play-big button">
                    <svg class="post-video__play-big-icon" width="14" height="14">
                        <use xlink:href="#icon-video-play-big"></use>
                    </svg>
                    <span class="visually-hidden">Запустить проигрыватель</span>
                </a>
            </div>
        <?php elseif ($post['content_type'] === 'post-quote'): ?>
            <blockquote>
                <p>
                    <?= htmlspecialchars($post['text']) ?>
                </p>
                <cite><?= $post['quote_auth']?></cite>
            </blockquote>
        <?php elseif ($post['content_type'] === 'post-text'): ?>
            <?= cut_text(htmlspecialchars($post['text'])) ?>
        <?php elseif ($post['content_type'] === 'post-link'): ?>
            <div class="post-link__wrapper">
                <a class="post-link__external" href="http://<?= htmlspecialchars($post['link']) ?>"
                   title="Перейти по ссылке">
                    <div class="post-link__info-wrapper">
                        <div class="post-link__icon-wrapper">
                            <img src="https://www.google.com/s2/favicons?domain=vitadental.ru"
                                 alt="Иконка">
                        </div>
                        <div class="post-link__info">
                            <h3><?= htmlspecialchars($post['title']) ?></h3>
                        </div>
                    </div>
                    <span><?= htmlspecialchars($post['link']) ?></span>
                </a>
            </div>
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


