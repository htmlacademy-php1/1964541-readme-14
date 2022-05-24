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
        $final_text = '<p>' . implode(
                ' ',
                $text
            ) . '...' . '</p>' . '<a class="post-text__more-link" href="#">Читать далее</a>';
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
    }
    if (SECONDS_IN_HOUR < $diff && $diff < SECONDS_IN_DAY) {
        $divider = SECONDS_IN_HOUR;
        $form = ['час', 'часа', 'часов'];
    }
    if (SECONDS_IN_DAY < $diff && $diff < SECONDS_IN_WEEK) {
        $divider = SECONDS_IN_DAY;
        $form = ['день', 'дня', 'дней'];
    }
    if (SECONDS_IN_WEEK < $diff && $diff < SECONDS_IN_MONTH) {
        $divider = SECONDS_IN_WEEK;
        $form = ['неделя', 'недели', 'недель'];
    }
    if ($diff > SECONDS_IN_MONTH) {
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
    if (trim($value)) {
        if (stristr($value, ' ')) {
            return null;
        }
        return null;
    }
    return null;
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
        if (check_youtube_url($value)) {
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
    return htmlspecialchars($_POST[$name] ?? "");
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
    if ($value) {
        if ($email) {
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
function full_form_validation($form, $rules, $required): array
{
    foreach ($form as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $validation_errors[$key] = $rule($value);
        }
        if (in_array($key, $required) && empty($value)) {
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
function get_user($db_connection, $user_id): array
{
    $sql = 'SELECT id, login, email, avatar, dt_add' .
        ' FROM users u' .
        ' WHERE id = ?;';
    $stmt = db_get_prepare_stmt($db_connection, $sql, [$user_id]);
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
function get_user_info($db_connection, $user_id): array
{
    $sql = 'SELECT' .
        ' (SELECT COUNT(p.id)' .
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
    $stmt = db_get_prepare_stmt($db_connection, $sql, [$user_id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $array = mysqli_fetch_assoc($result);
    if (!mysqli_num_rows($result)) {
        $array = [
            'subscribers_count' => 0,
            'posts_count' => 0
        ];
    }
    return $array;
}

/**
 * Проверяет наличие подписки на пользователя
 * @param array $db_connection Подключение к БД
 * @param integer $follow_id ID на кого подписываются
 * @param integer $follower_id ID подписчика
 *
 * @return bool Есть подписка|Нет подписки
 */
function check_subscription($db_connection, $follow_id, $follower_id): bool
{
    $sql = 'SELECT * ' .
        ' FROM subscribes' .
        ' WHERE follow_id = ? AND follower_id = ?;';
    $stmt = db_get_prepare_stmt($db_connection, $sql, [$follow_id, $follower_id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($result);
    if ($result) {
        return false;
    }
    return true;
}

/**
 * Валидация комментария
 * @param string $value Значение из формы
 * @param integer $min Минимальная длинна комментария
 *
 * @return string|null Ошибка, информация об ошибке|Нет ошибки
 */
function validate_comment($value, $min): ?string
{
    if ($value) {
        $value = trim($value);
        if (mb_strlen($value) < $min) {
            return 'Комментарий должен быть больше 3 символов';
        }
        return null;
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
function validate_message($value, $min): ?string
{
    if ($value) {
        $value = trim($value);
        if (mb_strlen($value) < $min) {
            return 'Сообщение не может быть пустым';
        }
        return null;
    }
    return null;
}

/**
 * Проверка на наличие поста в БД
 * @param array $db_connection Подключение к БД
 * @param integer $post_id ID поста
 * @return string|null Поста не существует|Существует
 */
function validate_post_id($db_connection, $post_id): ?string
{
    $sql = 'SELECT * ' .
        ' FROM posts' .
        ' WHERE id = ?';
    $stmt = db_get_prepare_stmt($db_connection, $sql, [$post_id]);
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
function validate_recipient_id($db_connection, $recipient_id): ?string
{
    $sql = 'SELECT *' .
        ' FROM users' .
        ' WHERE id = ?';
    $stmt = mysqli_prepare($db_connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $recipient_id);
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
function get_tags($db_connection, $post_id): ?array
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

/**
 * Проверяет наличие аватара, если нет, то ставит заглушку
 * @param string $avatar Принимает значение аватара
 *
 * @return string Заглушка|Переданный аватар
 */
function get_user_avatar($avatar): string
{
    if (!$avatar) {
        $avatar = 'img/userpic-medium.jpg';
    }
    return $avatar;
}

/**
 * Проверяет вход на сайт.
 *
 * @param array $db_connection Подключение к БД
 * @param array $user Данные входящего пользователя
 *
 * @return  array Массив с ошибками|Вход и переадресация на ленту пользователя
 */
function validate_login($db_connection, $user): array
{
    $sql = 'SELECT id, email, login, password, avatar, dt_add,' .
        ' (SELECT COUNT(p.id)' .
        ' FROM posts p' .
        ' WHERE p.user_id = u.id)' .
        ' AS posts_count' .
        ' FROM users u WHERE email = ?';
    $stmt = mysqli_prepare($db_connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $user['email']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $db_user = mysqli_fetch_assoc($result);

    if ($db_user) {
        if (password_verify($user['password'], $db_user['password'])) {
            session_start();
            $_SESSION['user_id'] = $db_user['id'];
            $_SESSION['user'] = $db_user['login'];
            $_SESSION['avatar'] = $db_user['avatar'];
            $_SESSION['dt_add'] = $db_user['dt_add'];
            $_SESSION['posts_count'] = $db_user['posts_count'];
            header('Location: feed.php');
            exit;
        }
    }
    $validation_errors['email'] = 'Неверный пользователь и/или пароль';
    $validation_errors['password'] = 'Неверный пользователь и/или пароль';
    return $validation_errors;
}

/**
 * Вносит теги в БД
 * @param array $db_connection Подключение к БД
 * @param array|string $tags Теги добавляемые к посту
 * @param integer $post_id ID поста для добавления связи между тегами и постами
 *
 * @return void
 */
function insert_tag($db_connection, $tags, $post_id)
{
    if ($tags) {
        $tags = trim($tags);
        if (stristr($tags, ' ')) {
            $tags = explode(' ', $tags);
            foreach ($tags as $tag) {
                $sql = 'SELECT id, name
                        FROM tags
                        WHERE name = ?;';
                $stmt = db_get_prepare_stmt($db_connection, $sql, [$tag]);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result)) {
                    $db_tag = mysqli_fetch_assoc($result);
                    $tag_ids[] = $db_tag['id'];
                } else {
                    $sql = 'INSERT INTO tags (name)
                            VALUE (?)';
                    $stmt = db_get_prepare_stmt($db_connection, $sql, [$tag]);
                    mysqli_stmt_execute($stmt);
                    $tag_ids[] = mysqli_insert_id($db_connection);
                }
            }
        } else {
            $tag = $tags;
            $sql = 'SELECT id, name
                    FROM tags
                    WHERE name = ?;';
            $stmt = db_get_prepare_stmt($db_connection, $sql, [$tag]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $db_tag = mysqli_fetch_assoc($result);
            if ($db_tag) {
                $tag_id = $db_tag['id'];
            } else {
                $sql = 'INSERT INTO tags (name)
                        VALUE (?);';
                $stmt = db_get_prepare_stmt($db_connection, $sql, [$tag]);
                mysqli_stmt_execute($stmt);
                $tag_id = mysqli_insert_id($db_connection);
            }
        }
        $sql = 'INSERT INTO posts_tags (post_id, tag_id)
                VALUES (?, ?)';

        if (isset($tag_ids)) {
            foreach ($tag_ids as $tag_id) {
                $stmt = db_get_prepare_stmt($db_connection, $sql, [$post_id, $tag_id]);
                mysqli_stmt_execute($stmt);
            }
        } else {
            $stmt = db_get_prepare_stmt($db_connection, $sql, [$post_id, $tag_id]);
            mysqli_stmt_execute($stmt);
        }
    }
}

/**
 * Оправляет подписанным пользователем уведомление на почту о новом посте
 * @param array $db_connection Связь с БД, для обнаружения подписчиков
 * @param array $post информация о самом посте
 * @param array $email_configuration параметры письма
 * @param object $email Создает письмо
 * @param object $mailer Отправляет письмо
 * @param array $user Пользователь, который публикует
 *
 * @return void
 */
function send_new_post_email($db_connection, $post, $email_configuration, $email, $mailer, $user)
{
    $sql = 'SELECT id, login, email' .
        ' FROM users' .
        ' JOIN subscribes s on users.id = s.follower_id' .
        ' WHERE follow_id = ?;';
    $stmt = db_get_prepare_stmt($db_connection, $sql, [$post['user_id']]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $followers = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($followers as $follower) {
            $email->from($email_configuration['from']);
            $email->to($follower['email']);
            $email->subject('Новая публикация от пользователя' . $user['user']);
            $email->text(
                'Здравствуйте, ' . $follower['login'] . '. Пользователь ' . $user['user'] . ' только что опубликовал новую запись ' . $post['title'] . '. Посмотрите её на странице пользователя: ' . $email_configuration['host_info'] . '/users_profile.php?id=' . $user['user_id']
            );
            $mailer->send($email);
        }
    }
}

/**
 * Выбирает поля необходимые к заполнению
 * @param string $form_type Параметр запроса формы
 * @param array $required Необходимые к валидации поля
 *
 * @return array Возвращает необходимые к валидации поля
 */
function change_form($form_type, $required): array
{
    switch ($form_type) {
        case 'text':
            $required[] = 'text';
            break;
        case 'quote':
            $required[] = 'quote_auth';
            $required[] = 'text';
            break;
        case 'link':
            $required[] = 'link';
            break;
        case 'video':
            $required[] = 'video';
            break;
    }
    return $required;
}



