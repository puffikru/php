<div id="templatemo_menu">
    <ul>
        <li><a href="<?= ROOT ?>" class="current">Главная</a></li>
        <? if(Model\Auth::isAuth()): ?>
            <li><a href="<?= ROOT ?>post/add">Добавить</a></li>
            <li><a href="<?= ROOT ?>texts">Тексты</a></li>
            <li><a href="<?= ROOT ?>?auth=off" type="button">Выйти</a></li>
        <? else: ?>
            <li><a href="<?= ROOT ?>login">Войти</a></li>
        <? endif; ?>
    </ul>
</div>