<main class="page__main page__main--messages">
    <h1 class="visually-hidden">Личные сообщения</h1>
    <section class="messages tabs">
        <h2 class="visually-hidden">Сообщения</h2>
        <?= include_template('message_templates/message-contacts.php', ['chats' => $chats]); ?>
        <div class="messages__chat">
            <div class="messages__chat-wrapper">
                <ul class="messages__list tabs__content tabs__content--active">
                    <?php foreach ($messages as $message): ?>
                    <li class="messages__item">
                        <div class="messages__info-wrapper">
                            <div class="messages__item-avatar">
                                <a class="messages__author-link" href="users_profile.php?id=<?= $message['id'] ?>">
                                    <img class="messages__avatar" src="img/<?= $message['avatar'] ?>" alt="Аватар пользователя">
                                </a>
                            </div>
                            <div class="messages__item-info">
                                <a class="messages__author" href="users_profile.php?id=<?= $message['id'] ?>">
                                    <?= $message['login'] ?>
                                </a>
                                <time class="messages__time" datetime="2019-05-01T14:40">
                                    <?= show_past_time($message['dt_add']) ?>
                                </time>
                            </div>
                        </div>
                        <p class="messages__text">
                            <?= $message['content'] ?>
                        </p>
                    </li>
                    <?php endforeach; ?>
            </div>
            <div class="comments">
                <form class="comments__form form" action="#" method="post">
                    <div class="comments__my-avatar">
                        <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                    </div>
                    <div class="form__input-section form__input-section--error">
                <textarea class="comments__textarea form__textarea form__input" name="message"
                          placeholder="Ваше сообщение"></textarea>
                        <label class="visually-hidden">Ваше сообщение</label>
                        <button class="form__error-button button" type="button">!</button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Ошибка валидации</h3>
                            <p class="form__error-desc">Это поле обязательно к заполнению</p>
                        </div>
                    </div>
                    <button class="comments__submit button button--green" type="submit">Отправить</button>
                </form>
            </div>
        </div>
    </section>
</main>
