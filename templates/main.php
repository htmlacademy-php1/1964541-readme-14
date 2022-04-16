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
                    print include_template('/filters/filter-all.php');
                    foreach ($content_types as $type) {
                        $params = $_GET;
                        $params['tab'] = $type['id'];
                        $query = http_build_query($params);
                        $url = '/' . 'project/index.php' . '?' . $query;
                        $tab = filter_input(INPUT_GET, 'tab');
                        if ($tab === $type['id']) {
                            $button_active = 'filters__button--active';
                        } else {
                            $button_active = '';
                        }
                        switch ($type['type']) {
                            case 'post-text':
                                echo include_template('filters/filter-text.php', ['type' => $type, 'button_active' => $button_active, 'url' => $url]);
                                break;
                            case 'post-quote':
                                echo include_template('filters/filter-quote.php', ['type' => $type, 'button_active' => $button_active, 'url' => $url]);
                                break;
                            case 'post-photo':
                                echo include_template('filters/filter-photo.php', ['type' => $type, 'button_active' => $button_active, 'url' => $url]);
                                break;
                            case 'post-link':
                                echo include_template('filters/filter-link.php', ['type' => $type, 'button_active' => $button_active, 'url' => $url]);
                                break;
                            case 'post-video':
                                echo include_template('filters/filter-video.php', ['type' => $type, 'button_active' => $button_active, 'url' => $url]);
                                break;
                        }
                    } ?>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach ($posts as $post): ?>
                <?= include_template('popular.php', ['post' => $post]); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
