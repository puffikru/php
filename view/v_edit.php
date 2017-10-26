<form method="post">
    Название<br>
    <input type="text" name="title" value="<?= $text['title']; ?>"><br>
    Контент<br>
    <textarea name="content"><?= $text['content']; ?></textarea><br>
    <a href="<?= ROOT ?>" type="button">Отмена</a>
    <a href="<?= ROOT ?>home?auth=off" type="button">Выйти</a>
    <input type="submit" value="Сохранить"><br>
</form>
<a href="<?= ROOT ?>">На главную</a><br><br>
<?
if(!empty($error)):
    foreach($error as $item):
        echo $item . "<br>";
    endforeach;
endif;
?>