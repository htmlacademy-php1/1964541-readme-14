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
                                <?php $classname = $types['type'] === $form_type ? 'filters__button--active' : '' ?>
                                <a class="adding-post__tabs-link filters__button filters__button--<?= $types['type'] ?> <?= $classname ?> tabs__item tabs__item--active button"
                                   href="add.php?type=<?= $types['type'] ?>">
                                    <svg class="filters__icon" width="22" height="18">
                                        <use xlink:href="#icon-filter-<?= $types['type'] ?>"></use>
                                    </svg>
                                    <span><?= $types['name'] ?></span>
                                </a>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </div>
                <div class="adding-post__tab-content">
                    <?php
                    foreach ($form_templates as $form_template) {
                        echo include_template($form_template, ['validation_errors' => $validation_errors, 'form_type' => $form_type, 'content_types' => $content_types]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
