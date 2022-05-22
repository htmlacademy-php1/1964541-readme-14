<?php

$form_status = '';
if ('text' === $form_type) {
    $form_status = '--active';
}
?>
<section class="adding-post__text tabs__content<?= $form_status ?>">
    <h2 class="visually-hidden">Форма добавления текста</h2>
    <form class="adding-post__form form" action="add.php?type=<?= $form_type ?>" method="post">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <?= include_template(
                    'add_templates/add-title-validation.php',
                    ['validation_errors' => $validation_errors]
                ) ?>
                <?= include_template(
                    'add_templates/add-text-validation.php',
                    ['validation_errors' => $validation_errors]
                ) ?>
                <?= include_template('add_templates/add_tags.php', ['validation_errors' => $validation_errors]); ?>
            </div>
            <?= include_template('validation_error.php', ['validation_errors' => $validation_errors]); ?>
        </div>
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
            <a class="adding-post__close" href="<?= $back ?>">Закрыть</a>
        </div>
    </form>
</section>
