<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="video-heading">Заголовок <span class="form__input-required">*</span></label>
    <?php $classname = isset($validation_errors['title']) ? 'form__input-section--error' : ''; ?>
    <div class="form__input-section <?= $classname ?>">
        <input class="adding-post__input form__input" id="video-heading" type="text" name="title" value="<?= getPostVal('title')?>" placeholder="Введите заголовок">
        <input type="hidden" name="content_type_id" value="5">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Ошибка</h3>
            <p class="form__error-desc"><?php isset($validation_errors['title']) ? print $validation_errors['title'] : '' ?></p>
        </div>
    </div>
</div>
