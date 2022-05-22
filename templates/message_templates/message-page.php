<main class="page__main page__main--messages">
    <h1 class="visually-hidden">Личные сообщения</h1>
    <section class="messages tabs">
        <h2 class="visually-hidden">Сообщения</h2>
        <?= include_template('message_templates/message-chats.php', ['chats' => $chats, 'chat_id' => $chat_id]); ?>
        <?= include_template('message_templates/message-content.php', ['messages' => $messages, 'user' => $user]); ?>
        <div class="comments">
            <?php
            $classname = empty($chat_id) ? 'visually-hidden' : '' ?>
            <form class="comments__form form <?= $classname ?>" action="messages.php?chat_id=<?= $chat_id ?>"
                  method="post">
                <div class="comments__my-avatar">
                    <img class="comments__picture" src="<?= get_user_avatar($user['avatar']) ?>"
                         alt="Аватар пользователя">
                </div>
                <?php
                $classname = isset($validation_errors['content']) ? 'form__input-section--error' : ''; ?>
                <div class="form__input-section <?= $classname ?> ">
                <textarea class="comments__textarea form__textarea form__input" name="content"
                          placeholder="Ваше сообщение"></textarea>
                    <label class="visually-hidden">Ваше сообщение</label>
                    <button class="form__error-button button" type="button">!</button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Ошибка валидации</h3>
                        <?php
                        foreach ($validation_errors as $error): ?>
                            <p class="form__error-desc"><?= $error ?></p>
                        <?php
                        endforeach; ?>
                    </div>
                </div>
                <button class="comments__submit button button--green" type="submit">Отправить</button>
            </form>
        </div>
        </div>
    </section>
</main>
