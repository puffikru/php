<form <?= $form->method(); ?> class="sign-up">
    <?= $form->inputSign(); ?>
    <? foreach($form->fields() as $field): ?>
        <div class="line">
            <?= $field; ?>
        </div>
    <? endforeach; ?>
</form>
<a href="<?= ROOT; ?>">На главную</a>