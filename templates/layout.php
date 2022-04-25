<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="page">


<header class="header">
    <div class="header__wrapper container">
        <div class="header__logo-wrapper">
            <a class="header__logo-link" href="main.html">
                <img class="header__logo" src="img/logo.svg" alt="Логотип readme" width="128" height="24">
            </a>
            <p class="header__topic">
                micro blogging
            </p>
        </div>
        <form class="header__search-form form" action="#" method="get">
            <div class="header__search">
                <label class="visually-hidden">Поиск</label>
                <input class="header__search-input form__input" type="search">
                <button class="header__search-button button" type="submit">
                    <svg class="header__search-icon" width="18" height="18">
                        <use xlink:href="#icon-search"></use>
                    </svg>
                    <span class="visually-hidden">Начать поиск</span>
                </button>
            </div>
        </form>
        <div class="header__nav-wrapper">
            <?php
            if ($_SERVER['PHP_SELF'] === '/registration.php'):?>
                <nav class="header__nav">
                    <ul class="header__user-nav">
                        <li class="header__authorization">
                            <a class="header__user-button header__authorization-button button" href="login.html">Вход</a>
                        </li>
                        <li>
                            <a class="header__user-button header__user-button--active header__register-button button">Регистрация</a>
                        </li>
                    </ul>
                    <?php else: ?>
                    <ul class="header__my-nav">
                        <li class="header__my-page header__my-page--popular">
                            <a class="header__page-link header__page-link--active" title="Популярный контент">
                                <span class="visually-hidden">Популярный контент</span>
                            </a>
                        </li>
                        <li class="header__my-page header__my-page--feed">
                            <a class="header__page-link" href="feed.html" title="Моя лента">
                                <span class="visually-hidden">Моя лента</span>
                            </a>
                        </li>
                        <li class="header__my-page header__my-page--messages">
                            <a class="header__page-link" href="messages.html" title="Личные сообщения">
                                <span class="visually-hidden">Личные сообщения</span>
                            </a>
                        </li>
                    </ul>
                    <!-- здесь должен быть PHP код, который показывает следующий тег по условию -->
                    <ul class="header__user-nav">
                        <li class="header__profile">
                            <a class="header__profile-link" href="#">
                                <div class="header__avatar-wrapper">
                                    <img class="header__profile-avatar" src="img/userpic-medium.jpg"
                                         alt="Аватар профиля">
                                </div>
                                <div class="header__profile-name">
                                <span>
                                    <?= $user_name ?>
                                </span>
                                    <svg class="header__link-arrow" width="10" height="6">
                                        <use xlink:href="#icon-arrow-right-ad"></use>
                                    </svg>
                                </div>
                            </a>
                            <div class="header__tooltip-wrapper">
                                <div class="header__profile-tooltip">
                                    <ul class="header__profile-nav">
                                        <li class="header__profile-nav-item">
                                            <a class="header__profile-nav-link" href="#">
                          <span class="header__profile-nav-text">
                            Мой профиль
                          </span>
                                            </a>
                                        </li>
                                        <li class="header__profile-nav-item">
                                            <a class="header__profile-nav-link" href="#">
                          <span class="header__profile-nav-text">
                            Сообщения
                            <i class="header__profile-indicator">2</i>
                          </span>
                                            </a>
                                        </li>

                                        <li class="header__profile-nav-item">
                                            <a class="header__profile-nav-link" href="#">
                          <span class="header__profile-nav-text">
                            Выход
                          </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="header__post-button button button--transparent" href="adding-post.html">Пост</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</header>

<?= $content ?>

<footer class="footer">
    <div class="footer__wrapper">
        <div class="footer__container container">
            <div class="footer__site-info">
                <div class="footer__site-nav">
                    <ul class="footer__info-pages">
                        <li class="footer__info-page">
                            <a class="footer__page-link" href="#">О проекте</a>
                        </li>
                        <li class="footer__info-page">
                            <a class="footer__page-link" href="#">Реклама</a>
                        </li>
                        <li class="footer__info-page">
                            <a class="footer__page-link" href="#">О разработчиках</a>
                        </li>
                        <li class="footer__info-page">
                            <a class="footer__page-link" href="#">Работа в Readme</a>
                        </li>
                        <li class="footer__info-page">
                            <a class="footer__page-link" href="#">Соглашение пользователя</a>
                        </li>
                        <li class="footer__info-page">
                            <a class="footer__page-link" href="#">Политика конфиденциальности</a>
                        </li>
                    </ul>
                </div>
                <p class="footer__license">
                    При использовании любых материалов с сайта обязательно указание Readme в качестве источника. Все
                    авторские и исключительные права в рамках проекта защищены в соответствии с положениями 4 части
                    Гражданского Кодекса Российской Федерации.
                </p>
            </div>
            <div class="footer__my-info">
                <ul class="footer__my-pages">
                    <li class="footer__my-page footer__my-page--feed">
                        <a class="footer__page-link" href="feed.html">Моя лента</a>
                    </li>
                    <li class="footer__my-page footer__my-page--popular">
                        <a class="footer__page-link" href="popular.html">Популярный контент</a>
                    </li>
                    <li class="footer__my-page footer__my-page--messages">
                        <a class="footer__page-link" href="messages.html">Личные сообщения</a>
                    </li>
                </ul>
                <div class="footer__copyright">
                    <a class="footer__copyright-link" href="#">
                        <span>Разработано HTML Academy</span>
                        <svg class="footer__copyright-logo" width="27" height="34">
                            <use xlink:href="#icon-htmlacademy"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="libs/dropzone.js"></script>
<script src="js/dropzone-settings.js"></script>
<script src="js/main.js"></script>
</body>
</html>
