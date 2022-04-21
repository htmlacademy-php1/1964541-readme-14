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

function validate_text($value, $min, $max): ?int
{
        if ($value) {
            $len = strlen($value);
            if ($len < $min or $len > $max) {
                return "Значение должно быть от $min до $max символов";
            }
        }
        return null;
}

function validate_type_id($value, $content_types): ?int
{
    foreach ($content_types as $type) {
        if ($type['id'] === $value) {
            return 0;
        }
    }
    if ($value === null) {
        return 1;
    }
    return 2;
}
