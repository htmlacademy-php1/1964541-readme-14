<?php
$error_class = 'visually-hidden';
if ($validation_errors):
    $error_class = 'form__invalid-block';
    ?>
    <div class="<?= $error_class ?>">
        <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
        <ul class="form__invalid-list">
            <?php
            foreach ($validation_errors as $value): ?>
                <li class="form__invalid-item"><?= $value ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
