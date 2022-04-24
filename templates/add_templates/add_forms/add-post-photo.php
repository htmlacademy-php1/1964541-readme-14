<?php
$form_status = '';
if ($content_types['2']['type'] === $form_type) {
    $form_status = '--active';
}
?>
<section class="adding-post__photo tabs__content tabs__content<?= $form_status ?>">
    <h2 class="visually-hidden">Форма добавления фото</h2>
    <form class="adding-post__form form" action="add.php?type=<?= $form_type ?>" method="post" enctype="multipart/form-data">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="photo-heading">Заголовок <span class="form__input-required">*</span></label>
                    <div class="form__input-section">
                        <?php $classname = isset($validation_errors['title']) ? 'form__input-section--error' : ''; ?>
                        <input class="adding-post__input form__input <?= $classname ?>" id="photo-heading" type="text" name="title" value="<?= getPostVal('title') ?>" placeholder="Введите заголовок">
                        <input type="hidden" name="content_type_id" value="3">
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                        </div>
                    </div>
                </div>
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
                    <div class="form__input-section">
                        <?php $classname = isset($validation_errors['photo-link']) ? 'form__input-section--error' : ''; ?>
                        <input class="adding-post__input form__input <?= $classname ?>" id="photo-url" type="text" name="photo-link" value="<?= getPostVal('photo-link')?>" placeholder="Введите ссылку">
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                        </div>
                    </div>
                </div>
                <?= include_template('add_templates/add_tags.php', ['validation_errors' => $validation_errors]); ?>
            </div>
            <?= include_template('add_templates/add_error.php', ['validation_errors' => $validation_errors]); ?>
        </div>
        <input id='userpic-file-photo' type='file'     name='userpic-file-photo' title=' '>
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
            <a class="adding-post__close" href="#">Закрыть</a>
        </div>
    </form>
</section>
