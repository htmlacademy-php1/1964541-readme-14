<?php if (isset($validation_errors)): ?>
    <div class="form__invalid-block">
        <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
        <ul class="form__invalid-list">
            <?php
            foreach ($validation_errors as $value): ?>
                <li class="form__invalid-item"><?= $value ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
