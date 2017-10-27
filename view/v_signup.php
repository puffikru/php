<form method="post">
    Email<br>
    <input type="text" name="login" placeholder="Введите ваш email"><br>
    Пароль<br>
    <input type="password" name="password" placeholder="Введите пароль"><br>
    Введите пароль еще раз<br>
    <input type="password" name="password_comfirm" placeholder="Введите пароль"><br><br>
    <input type="submit" value="Зарегистрироваться">
</form>
<a href="<?= ROOT ?>">На главную</a><br><br>
<?= $msg; ?>