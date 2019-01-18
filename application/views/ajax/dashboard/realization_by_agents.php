<?if (!empty($data)) {?>
<table class="table table-sm m-b-0">
    <tr>
        <th>Дистрибьютор</th>
        <th class="text-right">Кол-во<br>литров</th>
        <th class="text-right">Кол-во<br>транзакций</th>
        <th class="text-right">Кол-во<br>клиентов</th>
    </tr>
    <?foreach ($data as $row) {?>
        <tr>
            <td><?=$row['WEB_NAME']?></td>
            <td class="text-right"><?= number_format($row['SERVICE_AMOUNT'], 2, '.', '&nbsp;') ?></td>
            <td class="text-right"><?= number_format($row['COUNT_TRZ'], 0, '.', '&nbsp;') ?></td>
            <td class="text-right"><?= number_format($row['CL_COUNT'], 0, '.', '&nbsp;') ?></td>
        </tr>
    <?}?>
    <tr>
        <td><b>Итого:</b></td>
        <td class="text-right">
            <b><?= number_format(array_sum(array_column($data, 'SERVICE_AMOUNT')), 2, '.', '&nbsp;') ?></b></td>
        <td class="text-right">
            <b><?= number_format(array_sum(array_column($data, 'COUNT_TRZ')), 0, '.', '&nbsp;') ?></b></td>
        <td class="text-right"><b><?= number_format(array_sum(array_column($data, 'CL_COUNT')), 0, '.', '&nbsp;') ?></b>
        </td>
    </tr>
</table>
<?} else {?>
    <div class="text-center">
        <i class="text-muted">Нет данных</i>
    </div>
<?}?>