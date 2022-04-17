<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link--active" href="#">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <?php
                    if (!$tab) {
                        $button_active = 'filters__button--active';
                    } else {
                        $button_active = '';
                    }
                    ?>
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all <?= $button_active ?>"
                           href="index.php">
                            <span>Все</span>
                        </a>
                    </li>
                    <?php foreach ($content_types as $type):
                    $params['tab'] = $type['id'];
                    $query = http_build_query($params);
                    $url = 'index.php?' . $query;
                    if ($tab === $type['id']) {
                        $button_active = 'filters__button--active';
                    } else {
                        $button_active = '';
                    }
                    ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--<?= $type['type'] ?> <?= $button_active ?>"
                           href="<?= $url ?>">
                            <span class="visually-hidden"><?= $type['name'] ?></span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-<?= $type['type'] ?>"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach ($posts as $post): ?>
                <?= include_template('index_templates/popular.php', ['post' => $post]); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
