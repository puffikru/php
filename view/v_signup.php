<form method="post">
    Имя:<br>
    <input type="text" name="name" placeholder="Введите ваш email"><br>
    Email:<br>
    <input type="text" name="login" placeholder="Введите ваш email"><br>
    Пароль:<br>
    <input type="password" name="pass" placeholder="Введите пароль"><br>
    Пароль:<br>
    <input type="password" name="pass_confirm" placeholder="Введите пароль"><br><br>
    <input type="submit" value="Зарегистрироваться">
</form>
<a href="<?= ROOT ?>">На главную</a><br><br>
<?= $errors; ?>