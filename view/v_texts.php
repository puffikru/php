<table class="texts">
    <tr>
        <th>
            Алиас
        </th>
        <th>
            Контент
        </th>
        <th>
            Действия
        </th>
    </tr>
    <? foreach($texts as $text): ?>
        <tr>
            <td><?= $text['alias']; ?></td>
            <td><?= $text['content']; ?></td>
            <td>
                <a href="<?= ROOT ?>texts/edit/<?= $text['id_text']; ?>"><i class="fa fa-pencil-square-o"></i></a>
                &nbsp; <a href="<?= ROOT ?>texts/delete/<?= $text['id_text']; ?>" class="delete"><i
                            class="fa fa-times"></i></a>
            </td>
        </tr>
    <? endforeach; ?>
</table>
<a href="<?= ROOT; ?>texts/add">Добавить</a>
