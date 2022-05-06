<main class="page__main page__main--search-results">
    <h1 class="visually-hidden">Страница результатов поиска</h1>
    <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
            <div class="search__query container">
                <span>Вы искали:</span>
                <span class="search__query-text"><?= htmlspecialchars($request); ?></span>
            </div>
        </div>
        <div class="search__results-wrapper">
            <div class="container">
                <div class="search__content">
                    <?php if (!empty($posts)): ?>
                    <?php foreach($posts as $post): ?>
                        <article class="feed__post post post-<?= $post['type'] ?>">
                            <header class="post__header post__author">
                                <a class="post__author-link" href="#" title="<?= $post['login'] ?>">
                                    <div class="post__avatar-wrapper">
                                        <img class="post__author-avatar" src="uploads/<?= $post['avatar'] ?>" alt="Аватар пользователя" width="60" height="60">
                                    </div>
                                    <div class="post__info">
                                        <b class="post__author-name"><?= $post['login'] ?></b>
                                        <span class="post__time"><?= show_past_time($post['dt_add'])?></span>
                                    </div>
                                </a>
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
                            }
                            ?>
                            <footer class="post__footer post__indicators">
                                <div class="post__buttons">
                                    <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                        <svg class="post__indicator-icon" width="20" height="17">
                                            <use xlink:href="#icon-heart"></use>
                                        </svg>
                                        <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                            <use xlink:href="#icon-heart-active"></use>
                                        </svg>
                                        <span>250</span>
                                        <span class="visually-hidden">количество лайков</span>
                                    </a>
                                    <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                        <svg class="post__indicator-icon" width="19" height="17">
                                            <use xlink:href="#icon-comment"></use>
                                        </svg>
                                        <span>25</span>
                                        <span class="visually-hidden">количество комментариев</span>
                                    </a>
                                    <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                                        <svg class="post__indicator-icon" width="19" height="17">
                                            <use xlink:href="#icon-repost"></use>
                                        </svg>
                                        <span>5</span>
                                        <span class="visually-hidden">количество репостов</span>
                                    </a>
                                </div>
                            </footer>
                        </article>
                    <?php endforeach;
                    else:
                        echo include_template('search_templates/no-results.php', ['request' => $request, 'back' => $back]);
                    endif; ?>

                </div>
            </div>
        </div>
    </section>
</main>