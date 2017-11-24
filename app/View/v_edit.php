<form <?=$form->method();?> class="add-post">
    <?=$form->inputSign();?>
    <? foreach($form->fields() as $field):?>
        <div class="line">
            <?=$field;?>
        </div>
    <? endforeach;?>
</form>
<a href="<?= ROOT;?>">На главную</a>
