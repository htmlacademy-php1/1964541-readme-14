<?php
$form_status = '';
if ('photo' === $form_type) {
    $form_status = '--active';
}
?>
<section class="adding-post__photo tabs__content tabs__content<?= $form_status ?>">
    <h2 class="visually-hidden">Форма добавления фото</h2>
    <form class="adding-post__form form" action="add.php?type=<?= $form_type ?>" method="post" enctype="multipart/form-data">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <?= include_template('add_templates/add-title-validation.php', ['validation_errors' => $validation_errors]) ?>
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
                    <?php $classname = isset($validation_errors['photo-link']) ? 'form__input-section--error' : ''; ?>
                    <div class="form__input-section <?= $classname ?>">
                        <input class="adding-post__input form__input <?= $classname ?>" id="photo-url" type="text" name="photo-link" value="<?= getPostVal('photo-link')?>" placeholder="Введите ссылку">
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Ошибка</h3>
                            <p class="form__error-desc"><?php  isset($validation_errors['photo-link']) ? print $validation_errors['photo-link'] : '' ?></p>
                        </div>
                    </div>
                </div>
                <?= include_template('add_templates/add_tags.php', ['validation_errors' => $validation_errors]); ?>
            </div>
            <?= include_template('validation_error.php', ['validation_errors' => $validation_errors]); ?>
        </div>
        <input id='userpic-file-photo' type='file'     name='userpic-file-photo' title=' '>
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
            <a class="adding-post__close" href="<?= $back ?>">Закрыть</a>
        </div>
    </form>
</section>
