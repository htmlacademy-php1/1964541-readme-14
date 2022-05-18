<?php $classname = isset($validation_errors['text']) ? 'form__input-section--error' : ''; ?>
<div class="adding-post__textarea-wrapper form__textarea-wrapper <?= $classname ?>">
    <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
    <div class="form__input-section">
        <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="text" placeholder="Введите текст публикации"><?= getPostVal('text')?></textarea>
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Ошибка</h3>
            <p class="form__error-desc"><?php  isset($validation_errors['text']) ? print $validation_errors['text'] : '' ?></p>
        </div>
    </div>
</div>
