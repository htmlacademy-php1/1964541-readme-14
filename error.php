<?php
$code = filter_input(INPUT_GET, 'code');
if ($code === '404') {
    $code = '<main>
    <h1>Ошибка: 404</h1>
</main>';
    print $code;
}
?>

