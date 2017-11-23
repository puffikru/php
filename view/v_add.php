<!--<form method="post">
    Название<br>
    <input type="text" name="title" value="<?/*= $title; */?>"><br>
    Контент<br>
    <textarea name="content"><?/*= $content; */?></textarea><br>
    <input type="submit" value="Отправить"><br>
</form>
<a href="<?/*= ROOT */?>" type="button">Отмена</a>
<a href="<?/*= ROOT */?>home?auth=off" type="button">Выйти</a>
<a href="<?/*= ROOT */?>">На главную</a><br><br>
--><?/*
if(!empty($error)):
    foreach($error as $item):
        echo $item . "<br>";
    endforeach;
endif;
*/?>

<form <?=$form->method();?> class="add-post">
    <?=$form->inputSign();?>
    <? foreach($form->fields() as $field):?>
        <div class="line">
            <?=$field;?>
        </div>
    <? endforeach;?>
</form>
<a href="<?= ROOT;?>">На главную</a>
