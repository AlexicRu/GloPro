<div class="row m-b-10">
    <div class="col-sm-6 text-muted">
        <div class="text-right hidden-xs-down">Количество литров:</div>
        <span class="hidden-sm-up">Количество литров:</span>
    </div>
    <div class="col-sm-6">
        <?=number_format($data['SERVICE_AMOUNT'], 2, '.', '&nbsp;')?> л.
    </div>
</div>

<div class="row m-b-10">
    <div class="col-sm-6 text-muted">
        <div class="text-right hidden-xs-down">Выручка:</div>
        <span class="hidden-sm-up">Выручка:</span>
    </div>
    <div class="col-sm-6">
        <?=number_format($data['SUMPRICE_DISCOUNT'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
    </div>
</div>

<?if (Access::allow('view_full_dashboard_clients_summary')) {?>
    <div class="row m-b-10">
        <div class="col-sm-6 text-muted">
            <div class="text-right hidden-xs-down">Стоимость на АЗС:</div>
            <span class="hidden-sm-up">Стоимость на АЗС:</span>
        </div>
        <div class="col-sm-6">
            <?=number_format($data['SERVICE_SUMPRICE'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
        </div>
    </div>
    <div class="row m-b-10">
        <div class="col-sm-6 text-muted">
            <div class="text-right hidden-xs-down">Закупки:</div>
            <span class="hidden-sm-up">Закупки:</span>
        </div>
        <div class="col-sm-6">
            <?=number_format($data['SUMPRICE_BUY'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
        </div>
    </div>
    <div class="row m-b-10">
        <div class="col-sm-6 text-muted">
            <div class="text-right hidden-xs-down">Маржинальный доход:</div>
            <span class="hidden-sm-up">Маржинальный доход:</span>
        </div>
        <div class="col-sm-6">
            <?=number_format($data['MARGINALITY'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 text-muted">
            <div class="text-right hidden-xs-down">Средняя скидка клиенту:</div>
            <span class="hidden-sm-up">Средняя скидка клиенту:</span>
        </div>
        <div class="col-sm-6">
            <?=number_format($data['AVG_DISCOUNT'], 2, '.', '&nbsp;')?>&nbsp;%
        </div>
    </div>
<?}?>