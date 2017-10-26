<form method="post">
    Название<br>
    <input type="text" name="alias" value="<?= $text['alias']; ?>"><br>
    Контент<br>
    <textarea name="content"><?= $text['content']; ?></textarea><br>
    <a href="<?= ROOT ?>texts" type="button">Отмена</a>
    <input type="submit" value="Сохранить"><br>
</form>
<?= $errors[0] ?? ''; ?>