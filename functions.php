<?php
require_once 'helpers.php';
require_once 'data.php';

function cut_text($text, $length = 300): string
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

function validate_filled($value): ?string
{
    if (empty($value)) {
        return "Это поле должно быть заполнено";
    }
    return null;
}

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

function getPostVal($name): ?string
{
    return $_POST[$name] ?? "";
}

function validate_text($value, $min, $max): ?string
{
        if ($value) {
            $len = strlen($value);
            if ($len < $min or $len > $max) {
                return "Значение должно быть от $min до $max символов";
            }
        }
        return null;
}

function validate_form_type($value, $content_types): bool
{
    foreach ($content_types as $type) {
        if ($type['type'] === $value || $value === null) {
            return true;
        }
    }
    return false;
}

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

function validate_password($password, $repeat_pass): ?string
{
    if ($password === $repeat_pass) {
        return null;
    }
    return 'Пароли не совпадают';
}

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
