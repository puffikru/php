<form <?=$form->method();?> class="form sign-up">
    <?=$form->inputSign();?>
    <? foreach($form->fields() as $field):?>
            <?=$field;?>
    <? endforeach;?>
</form>
<a href="<?= ROOT;?>">На главную</a><br><br>