<?php

?>
<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <?php foreach ($content_types as $types): ?>
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--<?= $types['type'] ?> filters__button--active tabs__item tabs__item--active button" href="add.php?id=<?= $types['id'] ?>">
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-<?= $types['type'] ?>"></use>
                                </svg>
                                <span><?= $types['name']?></span>
                            </a>
                        </li>
                    </ul>
                    <?php endforeach; ?>
                </div>
                <div class="adding-post__tab-content">
                    <?php
                    switch ($type_id) {
                        case '3':
                            echo include_template('add_templates/add_forms/add-post-photo.php', ['validation_errors' => $validation_errors, 'types' => $types]);
                            break;
                        case '1':
                            echo include_template('add_templates/add_forms/add-post-text.php', ['validation_errors' => $validation_errors]);
                            break;
                        case '4':
                            echo include_template('add_templates/add_forms/add-post-link.php', ['validation_errors' => $validation_errors]);
                            break;
                        case '5':
                            echo include_template('add_templates/add_forms/add-post-video.php', ['validation_errors' => $validation_errors]);
                            break;
                        case '2':
                            echo include_template('add_templates/add_forms/add-post-quote.php', ['validation_errors' => $validation_errors]);
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
