<main class="page__main page__main--feed">
    <div class="container">
        <h1 class="page__title page__title--feed">Моя лента</h1>
    </div>
    <div class="page__main-wrapper container">
        <section class="feed">
            <h2 class="visually-hidden">Лента</h2>
            <div class="feed__main-wrapper">
                <div class="feed__wrapper">
                    <?php
                    foreach ($posts as $post): ?>
                        <article class="feed__post post post-<?= $post['type'] ?>">
                            <header class="post__header post__author">
                                <a class="post__author-link" href="users_profile.php?id=<?= $post['user_id'] ?>"
                                   title="<?= $post['login'] ?>">
                                    <div class="post__avatar-wrapper">
                                        <img class="post__author-avatar" src="<?= get_user_avatar($post['avatar']) ?>"
                                             alt="Аватар пользователя" width="60" height="60">
                                    </div>
                                    <div class="post__info">
                                        <b class="post__author-name"><?= htmlspecialchars($post['login']) ?></b>
                                        <span class="post__time"><?= show_past_time($post['dt_add']) ?></span>
                                    </div>
                                </a>
                            </header>
                            <?= include_template('post_types_change.php', ['post' => $post]) ?>
                            <footer class="post__footer post__indicators">
                                <?= include_template('post_buttons.php', ['post' => $post]) ?>
                            </footer>
                        </article>
                    <?php
                    endforeach; ?>
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
                <?php
                foreach ($content_types as $content_type):
                    $params['tab'] = $content_type['type'];
                    $query = http_build_query($params);
                    $url = 'feed.php?' . $query;
                    if ($tab === $content_type['type']) {
                        $button_active = 'filters__button--active';
                    } else {
                        $button_active = '';
                    } ?>
                    <li class="feed__filters-item filters__item">
                        <a class="filters__button filters__button--<?= $content_type['type'] ?> <?= $button_active ?>"
                           href="<?= $url ?>">
                            <span class="visually-hidden"><?= $content_type['name'] ?> </span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-<?= $content_type['type'] ?>"></use>
                            </svg>
                        </a>
                    </li>
                <?php
                endforeach; ?>
            </ul>
        </section>
        <?= include_template('feed_templates/commercial.php') ?>
    </div>
</main>
