<section class="profile__subscriptions tabs__content tabs__content--active">
    <h2 class="visually-hidden">Подриски</h2>
    <ul class="profile__subscriptions-list">
        <?php foreach ($posts as $post): ?>
        <li class="post-mini post-mini--photo post user">
            <div class="post-mini__user-info user__info">
                <div class="post-mini__avatar user__avatar">
                    <a class="user__avatar-link" href="#">
                        <img class="post-mini__picture user__picture" src="img/<?= $post['avatar'] ?>" alt="Аватар пользователя">
                    </a>
                </div>
                <div class="post-mini__name-wrapper user__name-wrapper">
                    <a class="post-mini__name user__name" href="#">
                        <span><?= $post['login'] ?></span>
                    </a>
                    <time class="post-mini__time user__additional" datetime="2014-03-20T20:20"><?= show_past_time($post['dt_add']) ?></time>
                </div>
            </div>
            <div class="post-mini__rating user__rating">
                <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                    <span class="post-mini__rating-amount user__rating-amount"><?= $post['posts_count'] ?></span>
                    <span class="post-mini__rating-text user__rating-text"><?= get_noun_plural_form($post['posts_count'], 'публикация', 'публикации', 'публикаций') ?></span>
                </p>
                <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                    <span class="post-mini__rating-amount user__rating-amount"><?= $post['subscribers_count'] ?></span>
                    <span class="post-mini__rating-text user__rating-text"><?= get_noun_plural_form($post['subscribers_count'], 'подписчик', 'подписчика', 'подписчиков') ?></span>
                </p>
            </div>
            <div class="post-mini__user-buttons user__buttons">
                <?php
                $is_subscribe = check_subscription($connection, $post['id'], $user['user_id']);
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
                <a href="<?= $button['subscription'] ?>.php?id=<?= $post['id'] ?>"
                   class="profile__user-button user__button user__button--subscription button <?= $button['class'] ?>"><?= $button['name'] ?></a>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
