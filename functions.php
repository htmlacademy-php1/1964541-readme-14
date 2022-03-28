<?php
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

function show_spent_time($i): string
{
    $post_date = strtotime(generate_random_date($i));
    $cur_date = strtotime('now');
    $diff = $cur_date - $post_date;

    if ($diff < 3600) {
        $diff /= 60;
        $diff = floor($diff);
        $diff .= ' ' . get_noun_plural_form($diff, 'минута', 'минуты', 'минут') . ' назад';
    } else if ($diff < 86400) {
        $diff /= 3600;
        $diff = floor($diff);
        $diff .= ' ' . get_noun_plural_form($diff, 'час', 'часа', 'часов') . ' назад';
    } else if ($diff < 604800) {
        $diff /= 86400;
        $diff = floor($diff);
        $diff .= ' ' . get_noun_plural_form($diff, 'день', 'дня', 'дней') . ' назад';
    } else if ($diff < 2419200) {
        $diff /= 604800;
        $diff = floor($diff);
        $diff .= ' ' . get_noun_plural_form($diff, 'неделя', 'недели', 'недель') . ' назад';
    } else {
        $diff /= 2419200;
        $diff = floor($diff);
        $diff .= ' ' . get_noun_plural_form($diff, 'месяц', 'месяца', 'месяцев') . ' назад';
    }
    return $diff;
}
