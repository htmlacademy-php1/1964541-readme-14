<main class="page__main page__main--messages">
    <h1 class="visually-hidden">Личные сообщения</h1>
    <section class="messages tabs">
        <h2 class="visually-hidden">Сообщения</h2>
        <?= include_template('message_templates/message-chats.php', ['chats' => $chats, 'chat_id' => $chat_id]); ?>
        <?= include_template('message_templates/message-content.php', ['messages' => $messages]); ?>
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
