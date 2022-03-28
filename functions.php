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
