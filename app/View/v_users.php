<h2 class="table-header"><?=$header;?></h2>
<table class="users">
    <tr class="thead">
        <th>Имя</th>
        <th>Логин</th>
        <th>Роль</th>
        <th>Кол-во статей</th>
    </tr>
        <? foreach($all as $item): ?>
        <tr>
            <td><?=$item['username'] ?? null; ?></td>
            <td><?=$item['login'] ?? null; ?></td>
            <td>
                <select name="roles">
                <? foreach($roles as $role): ?>
                    <option value="<?=$role['id_role'];?>"
                        <? if($item['role'] == $role['description']): ?>
                            <?= "selected "?>
                        <? endif; ?>
                    ><?=$role['description'];?></option>
                <? endforeach; ?>
                </select>
            </td>
            <td><?=$item['post_number'] ?? null; ?></td>
        </tr>
        <? endforeach; ?>
</table>