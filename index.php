<?php
require_once 'helpers.php';
$is_auth = rand(0, 1);

$user_name = 'Кирилл';

$posts = [
    [
        'title' => 'цитата',
        'type' => 'post-quote',
        'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'name' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg'
    ],
    [
        'title' => 'Игра престолов',
        'type' => 'post-text',
        'content' => 'Всё, что заключено в фигурные скобки – это инструкции (тело) цикла. Они повторяются до тех пор, пока условие возвращает значение true. В примере, приведенном выше, $i выводится на экран, а затем переменная счётчика увеличивается на 1. Это важно чтобы условие цикла, в конце концов, перестало соблюдаться. Если условие цикла соблюдается всегда, потому что вы забыли увеличить переменную счётчика $i, тогда скрипт войдёт в бесконечный цикл. ',
        'name' => 'Владик',
        'avatar' => 'userpic.jpg'
    ],
    [
        'title' => 'Наконец, обработал фотки!',
        'type' => 'post-photo',
        'content' => 'rock-medium.jpg',
        'name' => 'Виктор',
        'avatar' => 'userpic-mark.jpg'
    ],
    [
        'title' => 'Моя мечта',
        'type' => 'post-photo',
        'content' => 'coast-medium.jpg',
        'name' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg'
    ],
    [
        'title' => 'Лучшие курсы',
        'type' => 'post-link',
        'content' => 'www.htmlacademy.ru/',
        'name' => 'Владик',
        'avatar' => 'userpic.jpg']];

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

$page_content = include_template('main.php', ['posts' => $posts]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Имя страницы',
    'is_auth' => $is_auth,
    'user_name' => $user_name]);
print($layout_content);


?>

