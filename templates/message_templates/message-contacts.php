<div class="messages__contacts">
    <ul class="messages__contacts-list tabs__list">
        <?php foreach ($chats as $chat): ?>
        <li class="messages__contacts-item">
            <a class="messages__contacts-tab messages__contacts-tab--active tabs__item tabs__item--active" href="messages.php?chat_id=<?= $chat['id'] ?>">
                <div class="messages__avatar-wrapper">
                    <img class="messages__avatar" src="img/<?= $chat['avatar'] ?>" alt="Аватар пользователя">
                </div>
                <div class="messages__info">
                  <span class="messages__contact-name">
                    <?= $chat['login'] ?>
                  </span>
                    <div class="messages__preview">
                        <p class="messages__preview-text">
                            <?= cut_message($chat['last_message']) ?>
                        </p>
                        <time class="messages__preview-time" datetime="2019-05-01T14:40">
                            <?= date('H:i', strtotime($chat['last_message_dt_add'])) ?>
                        </time>
                    </div>
                </div>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
