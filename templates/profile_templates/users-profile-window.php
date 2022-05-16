<main class="page__main page__main--profile">
    <h1 class="visually-hidden">Профиль</h1>
    <div class="profile profile--default">
        <div class="profile__user-wrapper">
            <div class="profile__user user container">
                <div class="profile__user-info user__info">
                    <div class="profile__avatar user__avatar">
                        <img class="profile__picture user__picture" src="uploads/<?= $this_user['avatar'] ?>"
                             alt="Аватар пользователя">
                    </div>
                    <div class="profile__name-wrapper user__name-wrapper">
                        <span class="profile__name user__name"><?= $this_user['login'] ?></span>
                        <time class="profile__user-time user__time"
                              datetime="2014-03-20"><?= show_past_time($this_user['dt_add']) ?></time>
                    </div>
                </div>
                <div class="profile__rating user__rating">
                    <p class="profile__rating-item user__rating-item user__rating-item--publications">
                        <span class="user__rating-amount"><?= $user_info['posts_count'] ?></span>
                        <span class="profile__rating-text user__rating-text"><?= get_noun_plural_form($user_info['posts_count'], 'публикация', 'публикации', 'публикаций') ?></span>
                    </p>
                    <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="user__rating-amount"><?= $user_info['subscribers_count'] ?></span>
                        <span class="profile__rating-text user__rating-text"><?= get_noun_plural_form($user_info['subscribers_count'], 'подписчик', 'подписчика', 'подписчиков') ?></span>
                    </p>
                </div>
                <?php $classname = $this_user['id'] === $user['user_id'] ? 'visually-hidden' : '';?>
                <div class="profile__user-buttons user__buttons <?= $classname ?>">
                    <?php
                    if ($is_subscribe) {
                        $button['class'] = 'button--main';
                        $button['name'] = 'Подписаться';
                        $button['subscription'] = 'subscribe';
                    } else {
                        $button['class'] = 'button--quartz';
                        $button['name'] = 'Отписаться';
                        $button['subscription'] = 'unsubscribe';
                    }
                    ?>
                    <a href="<?= $button['subscription'] ?>.php?id=<?= $this_user['id'] ?>"
                       class="profile__user-button user__button user__button--subscription button <?= $button['class'] ?>"><?= $button['name'] ?></a>
                    <a class="profile__user-button user__button user__button--writing button button--green" href="messages.php?chat_id=<?= $this_user['id'] ?>">Сообщение</a>
                </div>
            </div>
        </div>
        <div class="profile__tabs-wrapper tabs">
            <div class="container">
                <div class="profile__tabs filters">
                    <b class="profile__tabs-caption filters__caption">Показать:</b>
                    <ul class="profile__tabs-list filters__list tabs__list">
                        <li class="profile__tabs-item filters__item">
                            <?php $classname = $tab === 'posts' ? 'filters__button--active' : ''; ?>
                            <a class="profile__tabs-link filters__button tabs__item <?= $classname ?>"
                               href="users_profile.php?id=<?= $this_user['id'] ?>&tab=posts">Посты</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <?php $classname = $tab === 'likes' ? 'filters__button--active' : ''; ?>
                            <a class="profile__tabs-link filters__button tabs__item button <?= $classname ?>"
                               href="users_profile.php?id=<?= $this_user['id'] ?>&tab=likes">Лайки</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <?php $classname = $tab === 'subscribes' ? 'filters__button--active' : ''; ?>
                            <a class="profile__tabs-link filters__button tabs__item button <?= $classname ?>"
                               href="users_profile.php?id=<?= $this_user['id'] ?>&tab=subscribes">Подписки</a>
                        </li>
                    </ul>
                </div>
                <div class="profile__tab-content">
                    <?php
                    switch ($tab) {
                        case 'posts':
                            echo include_template('profile_templates/users-window-types/users-posts.php', ['posts' => $posts, 'connection' => $connection]);
                            break;
                        case 'likes':
                            echo include_template('profile_templates/users-window-types/users-likes.php', ['posts' => $posts]);
                            break;
                        case 'subscribes':
                            echo include_template('profile_templates/users-window-types/users-subscribes.php', ['posts' => $posts, 'user' => $user, 'connection' => $connection]);
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
