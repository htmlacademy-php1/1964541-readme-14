<section class="profile__likes tabs__content tabs__content--active">
    <h2 class="visually-hidden">Лайки</h2>
    <ul class="profile__likes-list">
        <?php foreach ($posts as $post): ?>
        <li class="post-mini post-mini<?= $post['type'] ?> post user">
            <div class="post-mini__user-info user__info">
                <div class="post-mini__avatar user__avatar">
                    <a class="user__avatar-link" href="users_profile.php?id=<?= $post['user_id'] ?>">
                        <img class="post-mini__picture user__picture" src="<?= get_user_avatar($post['avatar']) ?>" alt="Аватар пользователя">
                    </a>
                </div>
                <div class="post-mini__name-wrapper user__name-wrapper">
                    <a class="post-mini__name user__name" href="users_profile.php?id=<?= $post['user_id'] ?>">
                        <span><?= htmlspecialchars($post['login']) ?></span>
                    </a>
                    <div class="post-mini__action">
                        <span class="post-mini__activity user__additional">Лайкнул публикацию</span>
                        <time class="post-mini__time user__additional" datetime="<?= $post['dt_add'] ?>"><?= show_past_time($post['dt_add']) ?></time>
                    </div>
                </div>
            </div>
            <div class="post-mini__preview">
                <a class="post-mini__link" href="post.php?id=<?= $post['id'] ?>" title="Перейти на публикацию">
                    <span class="visually-hidden"><?= $post['name'] ?></span>
                    <?php if ($post['type'] === 'photo'): ?>
                    <div class="post-mini__image-wrapper">
                        <img class="post-mini__image" src="img/<?= $post['img'] ?>" width="109" height="109" alt="Превью публикации">
                    </div>
                    <?php else: ?>
                    <svg class="post-mini__preview-icon" width="21" height="18">
                        <use xlink:href="#icon-filter-<?= $post['type'] ?>"></use>
                    </svg>
                    <?php endif; ?>
                </a>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
