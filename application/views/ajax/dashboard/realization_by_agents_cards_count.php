<?if (!empty($data)) {?>
<table class="table table-sm m-b-0">
    <tr>
        <th>Дистрибьютор</th>
        <th class="text-right">Всего карт</th>
        <th class="text-right">Из них активных</th>
    </tr>
    <?foreach ($data as $row) {?>
        <tr>
            <td><?=$row['WEB_NAME']?></td>
            <td class="text-right"><?= number_format($row['ALL_CARDS'], 0, '.', '&nbsp;') ?></td>
            <td class="text-right"><?= number_format($row['CARDS_IN_WORK'], 0, '.', '&nbsp;') ?></td>
        </tr>
    <?}?>
    <tr>
        <td><b>Итого:</b></td>
        <td class="text-right">
            <b><?= number_format(array_sum(array_column($data, 'ALL_CARDS')), 0, '.', '&nbsp;') ?></b></td>
        <td class="text-right">
            <b><?= number_format(array_sum(array_column($data, 'CARDS_IN_WORK')), 0, '.', '&nbsp;') ?></b></td>
    </tr>
</table>
<?} else {?>
    <div class="text-center">
        <i class="text-muted">Нет данных</i>
    </div>
<?}?>
