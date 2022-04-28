<main class="page__main page__main--feed">
    <div class="container">
        <h1 class="page__title page__title--feed">Моя лента</h1>
    </div>
    <div class="page__main-wrapper container">
        <section class="feed">
            <h2 class="visually-hidden">Лента</h2>
            <div class="feed__main-wrapper">
                <div class="feed__wrapper">
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
                            case null:
                                print ('<div class="feed__wrapper"></div>');
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
                    <?php endforeach; ?>
                </div>
            </div>
            <ul class="feed__filters filters">
                <?php
                if (!$tab) {
                    $button_active = 'filters__button--active';
                } else {
                    $button_active = '';
                }
                ?>
                <li class="feed__filters-item filters__item">
                    <a class="filters__button <?= $button_active ?>" href="feed.php">
                        <span>Все</span>
                    </a>
                </li>
                <?php foreach($content_types as $content_type):
                    $params['tab'] = $content_type['type'];
                    $query = http_build_query($params);
                    $url = 'feed.php?' . $query;
                    if ($tab === $content_type['type']) {
                        $button_active = 'filters__button--active';
                    } else {
                        $button_active = '';
                    }?>
                <li class="feed__filters-item filters__item">
                    <a class="filters__button filters__button--<?= $content_type['type'] ?> <?= $button_active ?>" href="<?= $url ?>">
                        <span class="visually-hidden"><?= $content_type['name'] ?> </span>
                        <svg class="filters__icon" width="22" height="18">
                            <use xlink:href="#icon-filter-<?= $content_type['type'] ?>"></use>
                        </svg>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?= include_template('feed_templates/commercial.php') ?>
    </div>
</main>
