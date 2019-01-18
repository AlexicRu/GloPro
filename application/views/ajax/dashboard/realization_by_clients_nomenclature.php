<?if (!empty($data)) {?>
<table class="table table-sm m-b-0">
    <tr>
        <th>Наименование</th>
        <th class="text-right">
            <nobr>Кол-во, л.</nobr>
        </th>
        <th class="text-right">Сумма<br>продажи</th>
    </tr>
    <?foreach ($data as $row) {?>
        <tr>
            <td><?=$row['LONG_DESC']?></td>
            <td class="text-right"><?= number_format($row['SERVICE_AMOUNT'], 2, '.', '&nbsp;') ?></td>
            <td class="text-right"><?= number_format($row['SUMPRICE_DISCOUNT'], 2, '.', '&nbsp;') ?></td>
        </tr>
    <?}?>
</table>
<?} else {?>
    <div class="text-center">
        <i class="text-muted">Нет данных</i>
    </div>
<?}?>