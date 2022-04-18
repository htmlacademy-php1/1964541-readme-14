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
