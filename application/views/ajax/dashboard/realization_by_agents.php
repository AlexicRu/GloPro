<?if (!empty($data)) {?>
<table class="table table-sm m-b-0">
    <tr>
        <th class="font-14">Дистрибьютор</th>
        <th class="text-right font-14">
            <nobr>Кол-во</nobr>
            <br>литров
        </th>
        <th class="text-right font-14">
            <nobr>Кол-во</nobr>
            <br>транз.
        </th>
        <th class="text-right font-14">
            <nobr>Кол-во</nobr>
            <br>клиентов
        </th>
        <th class="text-right font-14">
            <nobr>Кол-во</nobr>
            <br>польз.
        </th>
    </tr>
    <?foreach ($data as $row) {?>
        <tr>
            <td class="font-14"><?= $row['WEB_NAME'] ?></td>
            <td class="text-right"><?= number_format($row['SERVICE_AMOUNT'], 2, '.', '&nbsp;') ?></td>
            <td class="text-right"><?= number_format($row['COUNT_TRZ'], 0, '.', '&nbsp;') ?></td>
            <td class="text-right"><?= number_format($row['CL_COUNT'], 0, '.', '&nbsp;') ?></td>
            <td class="text-right"><?= number_format($row['USERS_COUNT'], 0, '.', '&nbsp;') ?></td>
        </tr>
    <?}?>
    <tr>
        <td><b>Итого:</b></td>
        <td class="text-right">
            <b><?= number_format(array_sum(array_column($data, 'SERVICE_AMOUNT')), 2, '.', '&nbsp;') ?></b>
        </td>
        <td class="text-right">
            <b><?= number_format(array_sum(array_column($data, 'COUNT_TRZ')), 0, '.', '&nbsp;') ?></b>
        </td>
        <td class="text-right">
            <b><?= number_format(array_sum(array_column($data, 'CL_COUNT')), 0, '.', '&nbsp;') ?></b>
        </td>
        <td class="text-right">
            <b><?= number_format(array_sum(array_column($data, 'USERS_COUNT')), 0, '.', '&nbsp;') ?></b>
        </td>
    </tr>
</table>
<?} else {?>
    <div class="text-center">
        <i class="text-muted">Нет данных</i>
    </div>
<?}?>