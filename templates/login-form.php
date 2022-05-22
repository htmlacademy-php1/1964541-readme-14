<main class="page__main page__main--login">
    <div class="container">
        <h1 class="page__title page__title--login">Вход</h1>
    </div>
    <section class="login container">
        <h2 class="visually-hidden">Форма авторизации</h2>
        <form class="login__form form" action="login.php" method="post">
            <div class="form__text-inputs-wrapper">
                <div class="form__text-inputs">
                    <div class="login__input-wrapper form__input-wrapper">
                        <label class="login__label form__label" for="login-email">Электронная почта</label>
                        <?php
                        $classname = isset($validation_errors['email']) ? '--error' : ''; ?>
                        <div class="form__input-section form__input-section<?= $classname ?>">
                            <input class="login__input form__input" id="login-email" type="email" name="email"
                                   value="<?= getPostVal('email') ?>" placeholder="Укажите эл.почту">
                            <button class="form__error-button button" type="button">!<span
                                    class="visually-hidden"></span>
                            </button>
                            <div class="form__error-text">
                                <h3 class="form__error-title">Ошибка</h3>
                                <p class="form__error-desc"><?php
                                    isset($validation_errors['email']) ? print $validation_errors['email'] : '' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="login__input-wrapper form__input-wrapper">
                        <label class="login__label form__label" for="login-password">Пароль</label>
                        <?php
                        $classname = isset($validation_errors['password']) ? '--error' : ''; ?>
                        <div class="form__input-section form__input-section<?= $classname ?>">
                            <input class="login__input form__input" id="login-password" type="password" name="password"
                                   placeholder="Введите пароль">
                            <button class="form__error-button button button--main" type="button">!<span
                                    class="visually-hidden">Информация об ошибке</span></button>
                            <div class="form__error-text">
                                <h3 class="form__error-title">Ошибка</h3>
                                <p class="form__error-desc"><?php
                                    isset($validation_errors['password']) ? print $validation_errors['password'] : '' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?= include_template('validation_error.php', ['validation_errors' => $validation_errors]) ?>
            </div>
            <button class="login__submit button button--main" type="submit">Отправить</button>
        </form>
    </section>
</main>
