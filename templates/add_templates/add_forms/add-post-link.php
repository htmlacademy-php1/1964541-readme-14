<section class="adding-post__link tabs__content">
    <h2 class="visually-hidden">Форма добавления ссылки</h2>
    <form class="adding-post__form form" action="add.php" method="post">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="link-heading">Заголовок <span class="form__input-required">*</span></label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="link-heading" type="text" name="title" placeholder="Введите заголовок">
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                        </div>
                    </div>
                </div>
                <div class="adding-post__textarea-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="post-link">Ссылка <span class="form__input-required">*</span></label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="post-link" type="text" name="link">
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
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
            <a class="adding-post__close" href="#">Закрыть</a>
        </div>
    </form>
</section>
