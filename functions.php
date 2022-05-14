<?php
require_once 'helpers.php';
require_once 'data.php';

/**
 * Обрезает текст и добавляет многоточие в конце
 * @param string $text Строка для обрезания текста
 * @param integer $length Длина строки
 *
 * @return string Обрезанная строка
 */

function cut_text($text, $length = TEXT_PREVIEW_LENGTH): string
{
    if (mb_strlen($text) > $length) {
        $text_words = explode(" ", $text);
        $counter = 0;
        $i = 0;
        while ($counter < $length) {
            $counter += mb_strlen($text_words[$i]);
            $i++;
        }
        $text = array_slice($text_words, 0, $i);
        $final_text = '<p>' . implode(' ', $text) . '...' . '</p>' . '<a class="post-text__more-link" href="#">Читать далее</a>';
    } else {
        $final_text = '<p>' . $text . '</p>';
    }
    return $final_text;
}

/**
 * Режет сообщения для превью // по идее хватило бы и одной функции для обрезки, но в прошлом задании нужно было добавлять "Читать далее"
 * @param string $text текст сообщения
 * @param integer $length длинна
 * @return string Образенное сообщение с точками
 */
function cut_message($text, $length = MESSAGE_PREVIEW_LENGTH): string
{
    if (mb_strlen($text) > $length) {
        $text_words = explode(" ", $text);
        $counter = 0;
        $i = 0;
        while ($counter < $length) {
            $counter += mb_strlen($text_words[$i]);
            $i++;
        }
        $text = array_slice($text_words, 0, $i);
        $final_text = implode(' ', $text) . '...';
    } else {
        $final_text = $text;
    }
    return $final_text;
}

/**
 * Показывает сколько прошло времени с события
 * @param string $time Время события
 *
 * @return string Сколько прошло
 */
function show_past_time($time): string
{
    $post_date = strtotime($time);
    $cur_date = strtotime('now');
    $diff = $cur_date - $post_date;

    if ($diff < SECONDS_IN_HOUR) {
        $divider = SECONDS_IN_MIN;
        $form = ['минута', 'минуты', 'минут'];
    } else if ($diff < SECONDS_IN_DAY) {
        $divider = SECONDS_IN_HOUR;
        $form = ['час', 'часа', 'часов'];
    } else if ($diff < SECONDS_IN_WEEK) {
        $divider = SECONDS_IN_DAY;
        $form = ['день', 'дня', 'дней'];
    } else if ($diff < SECONDS_IN_MONTH) {
        $divider = SECONDS_IN_WEEK;
        $form = ['неделя', 'недели', 'недель'];
    } else {
        $divider = SECONDS_IN_MONTH;
        $form = ['месяц', 'месяца', 'месяцев'];
    }
    $diff /= $divider;
    $diff = floor($diff);

    return $diff . ' ' . get_noun_plural_form($diff, $form[0], $form[1], $form[2]) . ' назад';
}

/**
 * Валидирует тэг
 *
 * @param string|array $value Тэг из формы
 *
 * @return string|null Результат валидации
 */

function validate_tag($value): ?string
{
    if ($value) {
        if (stristr($value, ' ')) {
            return null;
        }
        return null;
    }
    return 'В поле должно быть одно или больше слов';
}

/**
 * Проверяет заполненность поля
 * @param string|null $value значение из поля
 *
 * @return string|null Ошибка, описание ошибки|нет ошибок
 */
function validate_filled($value): ?string
{
    if (empty($value)) {
        return "Это поле должно быть заполнено";
    }
    return null;
}

/**
 * Проверяет ссылку на фото
 * @param string|null $value Значение из формы
 *
 * @return string|null Ошибка|нет ошибок
 */
function validate_photo_link($value): ?string
{
    if ($value) {
        if (file_get_contents($value)) {
            return null;
        }
        return 'Файл загрузить не получилось';
    }
    return null;
}

/**
 * Проверяет ссылку на видео
 * @param string|null $value Значение из формы
 *
 * @return string|null Ошибка, описание ошибки|нет ошибок
 */
function validate_video($value): ?string
{
    if ($value) {
        if (check_youtube_url($value)){
            return null;
        }
        return 'Видео не добавлено';
    }
    return null;
}

/**
 * Сохраняет последнюю запись в форме
 * @param string|null $name Значение из формы
 *
 * @return string|null Сохраненное значение
 */
function getPostVal($name): ?string
{
    return $_POST[$name] ?? "";
}

/**
 * Валидирует длину текста
 * @param string $value Значение из формы
 * @param integer $min Минимальная длинна текста
 * @param integer $max Максимальная длинна текста
 *
 * @return string|null Ошибка, описание ошибки|Ошибок нет
 */
function validate_text($value, $min, $max): ?string
{
        if ($value) {
            $len = mb_strlen($value);
            if ($len < $min or $len > $max) {
                return "Значение должно быть от $min до $max символов";
            }
        }
        return null;
}

/**
 * Проверка существования типа контента
 * @param string $value Тип контента из формы
 * @param array $content_types Типы контента из БД
 *
 * @return bool Существует(true)|Не существует(false)
 */
function validate_form_type($value, $content_types): bool
{
    foreach ($content_types as $type) {
        if ($type['type'] === $value || $value === null) {
            return true;
        }
    }
    return false;
}

/**
 * Валидация email'a при регистрации
 * @param string $value email, введенный пользователем
 * @param string $email email, из БД
 *
 * @return string|null Ошибка, описание ошибка|Ошибок нет
 */
function validate_email($value, $email): ?string
{
    if($value) {
            if($email) {
                return 'Пользователь с таким email уже существует';
            }
        return null;
    }
    return 'Введите корректный email';
}

/**
 * Проверка совпадения паролей
 * @param string $password Пароль
 * @param string $repeat_pass Повтор пароля
 *
 * @return string|null Ошибка, описание ошибки|Ошибки нет
 */
function validate_password($password, $repeat_pass): ?string
{
    if ($password === $repeat_pass) {
        return null;
    }
    return 'Пароли не совпадают';
}

/**
 * Полная проверка всех правил и требуемых значений в отправляемой форме
 * @param array $form Данные полученные из формы
 * @param array $rules Правила валидации
 * @param array $required Поля обязательные к заполнению
 *
 * @return array Массив с ошибками валидации
 */
function full_form_validation ($form, $rules, $required): array
{
    foreach ($form as $key => $value) {
        if(isset($rules[$key])) {
            $rule = $rules[$key];
            $validation_errors[$key] = $rule($value);
        }
        if(in_array($key, $required) && empty($value)) {
            $validation_errors[$key] = 'Поле ' . $key . ' надо заполнить';
        }
    }
    return array_diff($validation_errors, array(''));
}

/**
 * Получает данные юзера
 * @param array $db_connection Подключение к БД
 * @param integer $user_id ID пользователя
 *
 * @return array Логин, пароль и тд.
 */
function get_user ($db_connection, $user_id): array
{
    $sql = 'SELECT id, login, avatar, dt_add' .
        ' FROM users u' .
        ' WHERE id = ?;';
    $stmt = mysqli_prepare($db_connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

/**
 * Получает информацию о пользователе
 * (кол-во подписчиков, кол-во постов)
 * @param array $db_connection Подключение к БД
 * @param integer $user_id ID пользователя
 *
 * @return array Массив с информацией о пользователе
 */
function get_user_info ($db_connection, $user_id): array
{
    $sql = 'SELECT (SELECT COUNT(p.id)' .
        ' FROM posts p' .
        ' WHERE p.user_id = u.id)' .
        ' AS posts_count,' .
        '(SELECT COUNT(follower_id)' .
        ' FROM subscribes s' .
        ' WHERE s.follow_id = u.id)' .
        ' AS subscribers_count' .
        ' FROM posts p' .
        ' JOIN users u ON p.user_id = u.id' .
        ' WHERE u.id = ?' .
        ' GROUP BY posts_count, subscribers_count;';
    $stmt = mysqli_prepare($db_connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

/**
 * Проверяет наличие подписки на пользователя
 * @param array $db_connection Подключение к БД
 * @param integer $follow_id ID на кого подписываются
 * @param integer $follower_id ID подписчика
 *
 * @return bool Есть подписка|Нет подписки
 */
function check_subscription ($db_connection, $follow_id, $follower_id): bool
{
    $sql = 'SELECT * FROM subscribes' .
        ' WHERE follow_id = ? AND follower_id = ?;';
    $stmt = mysqli_prepare($db_connection, $sql);
    mysqli_stmt_bind_param($stmt,'ii', $follow_id, $follower_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($result);
    if ($result) {
        return false;
    } else {
        return true;
    }
}

/**
 * Валидация комментария
 * @param string $value Значение из формы
 * @param integer $min Минимальная длинна комментария
 *
 * @return string|null Ошибка, информация об ошибке|Нет ошибки
 */
function validate_comment ($value, $min): ?string
{
    if ($value) {
        $value = trim($value);
        if (mb_strlen($value) < $min) {
            return 'Комментарий должен быть больше 3 символов';
        } else {
            return null;
        }
    }
    return null;
}

/**
 * Валидация комментария
 * @param string $value Значение из формы
 * @param integer $min Минимальная длинна комментария
 *
 * @return string|null Ошибка, информация об ошибке|Нет ошибки
 */
function validate_message ($value, $min): ?string
{
    if ($value) {
        $value = trim($value);
        if (mb_strlen($value) < $min) {
            return 'Сообщение не может быть пустым';
        } else {
            return null;
        }
    }
    return null;
}

/**
 * Проверка на наличие поста в БД
 * @param array $db_connection Подключение к БД
 * @param integer $post_id ID поста
 * @return string|null Поста не существует|Существует
 */
function validate_post_id ($db_connection, $post_id): ?string
{
    $sql = 'SELECT * FROM posts' .
        ' WHERE id = ?';
    $stmt = mysqli_prepare($db_connection, $sql);
    mysqli_stmt_bind_param($stmt,'i', $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_num_rows($result);
    if ($result) {
        return null;
    }
    return 'Такого поста не существует';
}

/**
 * Проверка наличия получателя сообщения
 * @param array $db_connection Связь с БД
 * @param integer $recipient_id ID получателя сообщения
 * @return string|null Пользователь не найден|Пользователь есть
 */
function validate_recipient_id ($db_connection, $recipient_id): ?string
{
    $sql = 'SELECT * FROM users' .
        ' WHERE id = ?';
    $stmt = mysqli_prepare($db_connection, $sql);
    mysqli_stmt_bind_param($stmt,'i', $recipient_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_num_rows($result);
    if ($result) {
        return null;
    }
    return 'Выберите корректного получателя';
}

/**
 * Извлекает из БД все теги поста
 * @param array $db_connection связь с БД
 * @param integer $post_id ID поста
 * @return array|null Возвращает массив с тегами | возвращает null
 */
function get_tags ($db_connection, $post_id): ?array
{
    $sql = 'SELECT name FROM tags' .
        ' JOIN posts_tags pt on tags.id = pt.tag_id' .
        ' WHERE post_id = ?;';
    $stmt = mysqli_prepare($db_connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return null;
}
