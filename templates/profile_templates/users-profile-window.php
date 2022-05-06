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
                        <span class="profile__rating-text user__rating-text">публикаций</span>
                    </p>
                    <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="user__rating-amount"><?= $user_info['subscribers_count'] ?></span>
                        <span class="profile__rating-text user__rating-text">подписчиков</span>
                    </p>
                </div>
                <div class="profile__user-buttons user__buttons">
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
                    <a class="profile__user-button user__button user__button--writing button button--green" href="#">Сообщение</a>
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
                    if ($tab === 'posts' || $tab === 'likes') {
                        echo include_template('profile_templates/users-window-types/users-posts.php', ['posts' => $posts]);
                    } else {
                        echo include_template('profile_templates/users-window-types/users-subscribes.php', ['posts' => $posts]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
