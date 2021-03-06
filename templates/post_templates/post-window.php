<main class="page__main page__main--publication">
    <div class="container">
        <h1 class="page__title page__title--publication"><?= htmlspecialchars($post['title']) ?></h1>
        <section class="post-details">
            <h2 class="visually-hidden">Публикация</h2>
            <div class="post-details__wrapper post-photo">
                <div class="post-details__main-block post post--details">
                    <?= include_template('post_types_change.php', ['post' => $post]) ?>
                    <div class="post__indicators">
                        <?= include_template('post_buttons.php', ['post' => $post]) ?>
                        <span class="post__view"><?= $post['views'] ?></span>
                    </div>
                    <ul class="post__tags">
                        <?php
                        foreach ($tags as $tag): ?>
                            <li><a href="search.php?search=%23<?= $tag['name'] ?>">#<?= $tag['name'] ?></a></li>
                        <?php
                        endforeach; ?>
                    </ul>
                    <div class="comments">
                        <form class="comments__form form" action="post.php?id=<?= $post['id'] ?>" method="post">
                            <div class="comments__my-avatar">
                                <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                            </div>
                            <?php
                            $classname = isset($validation_errors['comment']) ? '--error' : ''; ?>
                            <div class="form__input-section form__input-section<?= $classname ?>">
                                <textarea class="comments__textarea form__textarea form__input" name="comment"
                                          value="<?= getPostVal('text') ?>" placeholder="Ваш комментарий"></textarea>
                                <label class="visually-hidden">Ваш комментарий</label>
                                <button class="form__error-button button" type="button">!</button>
                                <div class="form__error-text">
                                    <h3 class="form__error-title">Ошибка валидации</h3>
                                    <p class="form__error-desc"><?= $validation_errors['comment'] ?></p>
                                </div>
                            </div>
                            <input value="<?= $post['id'] ?>" name="post_id" class="visually-hidden">
                            <button class="comments__submit button button--green" type="submit">Отправить</button>
                        </form>
                        <div class="comments__list-wrapper">
                            <ul class="comments__list">
                                <?php
                                foreach ($comments as $comment): ?>
                                    <li class="comments__item user">
                                        <div class="comments__avatar">
                                            <a class="user__avatar-link"
                                               href="users_profile.php?id=<?= $comment['user_id'] ?>">
                                                <img class="comments__picture"
                                                     src="<?= get_user_avatar($comment['avatar']) ?>"
                                                     alt="Аватар пользователя">
                                            </a>
                                        </div>
                                        <div class="comments__info">
                                            <div class="comments__name-wrapper">
                                                <a class="comments__user-name" href="#">
                                                    <span><?= htmlspecialchars($comment['login']) ?></span>
                                                </a>
                                                <time class="comments__time" datetime="2019-03-20"><?= show_past_time(
                                                        $comment['dt_add']
                                                    ) ?></time>
                                            </div>
                                            <p class="comments__text">
                                                <?= htmlspecialchars($comment['content']) ?>
                                            </p>
                                        </div>
                                    </li>
                                <?php
                                endforeach; ?>
                            </ul>
                            <?php
                            $classname = $post['comment_sum'] < COMMENT_OFFSET || $tab === 'comments_all' ? 'visually-hidden' : '' ?>
                            <a class="comments__more-link <?= $classname ?>"
                               href="post.php?id=<?= $post['id'] ?>&tab=comments_all">
                                <span>Показать все комментарии</span>
                                <sup class="comments__amount"><?= $post['comment_sum'] ?></sup>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="post-details__user user">
                    <div class="post-details__user-info user__info">
                        <div class="post-details__avatar user__avatar">
                            <a class="post-details__avatar-link user__avatar-link" href="#">
                                <img class="post-details__picture user__picture"
                                     src="<?= get_user_avatar($this_user['avatar']) ?>" alt="Аватар пользователя">
                            </a>
                        </div>
                        <div class="post-details__name-wrapper user__name-wrapper">
                            <a class="post-details__name user__name"
                               href="users_profile.php?id=<?= get_user_avatar($this_user['id']) ?>">
                                <span><?= htmlspecialchars($this_user['login']) ?></span>
                            </a>
                            <time class="post-details__time user__time" datetime="2014-03-20"><?= show_past_time(
                                    $this_user['dt_add']
                                ) ?></time>
                        </div>
                    </div>
                    <div class="post-details__rating user__rating">
                        <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
                            <span
                                class="post-details__rating-amount user__rating-amount"><?= $user_info['subscribers_count'] ?></span>
                            <span class="post-details__rating-text user__rating-text"><?= get_noun_plural_form(
                                    $user_info['subscribers_count'],
                                    'подписчик',
                                    'подписчика',
                                    'подписчиков'
                                ) ?></span>
                        </p>
                        <p class="post-details__rating-item user__rating-item user__rating-item--publications">
                            <span
                                class="post-details__rating-amount user__rating-amount"><?= $user_info['posts_count'] ?></span>
                            <span class="post-details__rating-text user__rating-text"><?= get_noun_plural_form(
                                    $user_info['posts_count'],
                                    'публикация',
                                    'публикации',
                                    'публикаций'
                                ) ?></span>
                        </p>
                    </div>
                    <?php
                    $classname = $this_user['id'] === $user['user_id'] ? 'visually-hidden' : ''; ?>
                    <div class="post-details__user-buttons user__buttons <?= $classname ?>">
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
                        <a class="user__button user__button--writing button button--green"
                           href="messages.php?chat_id=<?= $this_user['id'] ?>">Сообщение</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
