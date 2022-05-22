<main class="page__main page__main--search-results">
    <h1 class="visually-hidden">Страница результатов поиска</h1>
    <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
            <div class="search__query container">
                <span>Вы искали:</span>
                <span class="search__query-text"><?= htmlspecialchars($request); ?></span>
            </div>
        </div>
        <div class="search__results-wrapper">
            <div class="container">
                <div class="search__content">
                    <?php
                    if (!empty($posts)): ?>
                        <?php
                        foreach ($posts as $post): ?>
                            <article class="feed__post post post-<?= $post['type'] ?>">
                                <header class="post__header post__author">
                                    <a class="post__author-link" href="#"
                                       title="<?= htmlspecialchars($post['login']) ?>">
                                        <div class="post__avatar-wrapper">
                                            <img class="post__author-avatar"
                                                 src="<?= get_user_avatar($post['avatar']) ?>" alt="Аватар пользователя"
                                                 width="60" height="60">
                                        </div>
                                        <div class="post__info">
                                            <b class="post__author-name"><?= htmlspecialchars($post['login']) ?></b>
                                            <span class="post__time"><?= show_past_time($post['dt_add']) ?></span>
                                        </div>
                                    </a>
                                </header>
                                <?= include_template('post_types_change.php', ['post' => $post]) ?>
                                <footer class="post__footer post__indicators">
                                    <?= include_template('post_buttons.php', ['post' => $post]) ?>
                                </footer>
                            </article>
                        <?php
                        endforeach;
                    else:
                        echo include_template(
                            'search_templates/no-results.php',
                            ['request' => $request, 'back' => $back]
                        );
                    endif; ?>

                </div>
            </div>
        </div>
    </section>
</main>
