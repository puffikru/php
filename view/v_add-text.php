<form method="post">
    Название<br>
    <input type="text" name="alias" value="<?= $alias; ?>"><br>
    Контент<br>
    <textarea name="content"><?= $content; ?></textarea><br>
    <a href="<?= ROOT ?>texts" type="button">Отмена</a>
    <input type="submit" value="Добавить"><br>
</form>
<?= $errors[0] ?? ''; ?>