<div class="messages__chat">
    <div class="messages__chat-wrapper">
        <ul class="messages__list tabs__content tabs__content--active">
            <?php foreach ($messages as $message): ?>
                <?php $classname = $message['id'] === $user['user_id'] ? 'messages__item--my' : ''; ?>
                <li class="messages__item <?= $classname ?>">
                    <div class="messages__info-wrapper">
                        <div class="messages__item-avatar">
                            <a class="messages__author-link" href="users_profile.php?id=<?= $message['id'] ?>">
                                <img class="messages__avatar" src="<?= get_user_avatar($message['avatar']) ?>" alt="Аватар пользователя">
                            </a>
                        </div>
                        <div class="messages__item-info">
                            <a class="messages__author" href="users_profile.php?id=<?= $message['id'] ?>">
                                <?= htmlspecialchars($message['login']) ?>
                            </a>
                            <time class="messages__time" datetime="2019-05-01T14:40">
                                <?= show_past_time($message['dt_add']) ?>
                            </time>
                        </div>
                    </div>
                    <p class="messages__text">
                        <?= htmlspecialchars($message['content']) ?>
                    </p>
                </li>
            <?php endforeach; ?>
    </div>
