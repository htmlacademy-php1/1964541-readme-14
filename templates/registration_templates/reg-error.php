<?php
$error_class = 'visually-hidden';
if ($validation_errors):
$error_class = 'form__invalid-block';
?>
<div class="<?= $error_class ?>">
    <?php endif; ?>
    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
    <ul class="form__invalid-list">
        <?php foreach ($validation_errors as $error): ?>
        <li class="form__invalid-item">Заголовок. Это поле должно быть заполнено.</li>
        <?php endforeach; ?>
    </ul>
</div>
