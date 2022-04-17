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
                            <a class="adding-post__tabs-link filters__button filters__button--photo filters__button--active tabs__item tabs__item--active button">
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-photo"></use>
                                </svg>
                                <span><?= $types['name']?></span>
                            </a>
                        </li>
                    </ul>
                    <?php endforeach; ?>
                </div>
                <div class="adding-post__tab-content">
                    <?php

                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
