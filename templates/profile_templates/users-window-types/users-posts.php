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
                    <div class="post__buttons">
                        <a class="post__indicator post__indicator--likes button" href="#"
                           title="Лайк">
                            <svg class="post__indicator-icon" width="20" height="17">
                                <use xlink:href="#icon-heart"></use>
                            </svg>
                            <svg class="post__indicator-icon post__indicator-icon--like-active"
                                 width="20" height="17">
                                <use xlink:href="#icon-heart-active"></use>
                            </svg>
                            <span>250</span>
                            <span class="visually-hidden">количество лайков</span>
                        </a>
                        <a class="post__indicator post__indicator--repost button" href="#"
                           title="Репост">
                            <svg class="post__indicator-icon" width="19" height="17">
                                <use xlink:href="#icon-repost"></use>
                            </svg>
                            <span>5</span>
                            <span class="visually-hidden">количество репостов</span>
                        </a>
                    </div>
                    <time class="post__time"
                          datetime="2019-01-30T23:41"><?= show_past_time($post['dt_add']) ?></time>
                </div>
                <ul class="post__tags">
                    <li><a href="#">#nature</a></li>
                    <li><a href="#">#globe</a></li>
                    <li><a href="#">#photooftheday</a></li>
                    <li><a href="#">#canon</a></li>
                    <li><a href="#">#landscape</a></li>
                    <li><a href="#">#щикарныйвид</a></li>
                </ul>
            </footer>
            <div class="comments">
                <a class="comments__button button" href="post.php?id=<?= $post['id'] ?>">Показать комментарии</a>
            </div>
        </article>
    <?php endforeach; ?>
</section>
