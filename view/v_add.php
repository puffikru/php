<form method="post">
    Название<br>
    <input type="text" name="title" value="<?= $title; ?>"><br>
    Контент<br>
    <textarea name="content"><?= $content; ?></textarea><br>
    <a href="<?= ROOT ?>" type="button">Отмена</a>
    <a href="<?= ROOT ?>home?auth=off" type="button">Выйти</a>
    <input type="submit" value="Отправить"><br>
</form>
<a href="<?= ROOT ?>">На главную</a><br><br>
<?=$error; ?>
