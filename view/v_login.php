<form method="post">
    Логин<br>
    <input type="text" name="login" placeholder="Введите логин"><br>
    Пароль<br>
    <input type="password" name="password" placeholder="Введите пароль"><br>
    <input type="checkbox" name="remember">Запомнить<br>
    <input type="submit" value="Войти">
</form>
<a href="<?= ROOT ?>">На главную</a><br><br>
<?= $errors; ?>