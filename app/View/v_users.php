<h2 class="table-header"><?=$header;?></h2>
<table class="users">
    <tr class="thead">
        <th>Имя</th>
        <th>Логин</th>
        <th>Роль</th>
    </tr>
    <? foreach($users as $user): ?>
        <tr>
            <td><?=$user['name']?></td>
            <td><?=$user['login']?></td>
            <td><?=$user['id_role']?></td>
        </tr>
    <? endforeach; ?>
</table>