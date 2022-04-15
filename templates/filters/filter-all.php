<?php
$tab = filter_input(INPUT_GET, 'tab');
if (!$tab) {
    $button_active = 'filters__button--active';
} else {
    $button_active = '';
}
?>
<li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
    <a class="filters__button filters__button--ellipse filters__button--all <?= $button_active ?>"
       href="http://localhost:63342/project/index.php">
        <span>Все</span>
    </a>
</li>
