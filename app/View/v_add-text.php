<form <?=$form->method();?> class="add-text">
    <?=$form->inputSign();?>
    <? foreach($form->fields() as $field):?>
        <div class="line">
            <?=$field;?>
        </div>
    <? endforeach;?>
</form>
<a href="<?= ROOT ?>texts" type="button">Отмена</a>
<a href="<?= ROOT;?>">На главную</a>
