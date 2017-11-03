<div id="templatemo_menu">
    <ul>
        <li><a href="<?= ROOT ?>" class="current">Главная</a></li>
        <? if($isAuth ?? null): ?>
            <li><a href="<?= ROOT ?>post/add">Добавить</a></li>
            <li><a href="<?= ROOT ?>texts">Тексты</a></li>
            <li><a href="<?= ROOT ?>user/logout" type="button">Выйти</a></li>
            <li class="current_user"><i class="fa fa-user" aria-hidden="true"></i><?=$user?></li>
        <? else: ?>
            <li><a href="<?= ROOT ?>user/login">Войти</a></li>
            <li><a href="<?= ROOT ?>user/sign-up">Регистрация</a></li>
        <? endif; ?>
    </ul>
</div>