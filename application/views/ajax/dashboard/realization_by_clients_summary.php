<div class="row m-b-10">
    <div class="col-sm-6 text-muted form__row__title">
        Количество литров:
    </div>
    <div class="col-sm-6">
        <?=number_format($data['SERVICE_AMOUNT'], 2, '.', '&nbsp;')?> л.
    </div>
</div>

<div class="row m-b-10">
    <div class="col-sm-6 text-muted form__row__title">
        Выручка:
    </div>
    <div class="col-sm-6">
        <?=number_format($data['SUMPRICE_DISCOUNT'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
    </div>
</div>

<? if (Access::allow('view_full_dashboard_clients_summary', true)) { ?>
    <div class="row m-b-10">
        <div class="col-sm-6 text-muted form__row__title">
            Стоимость на АЗС:
        </div>
        <div class="col-sm-6">
            <?=number_format($data['SERVICE_SUMPRICE'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
        </div>
    </div>
    <div class="row m-b-10">
        <div class="col-sm-6 text-muted form__row__title">
            Закупки:
        </div>
        <div class="col-sm-6">
            <?=number_format($data['SUMPRICE_BUY'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
        </div>
    </div>
    <div class="row m-b-10">
        <div class="col-sm-6 text-muted form__row__title">
            Маржинальный доход:
        </div>
        <div class="col-sm-6">
            <?=number_format($data['MARGINALITY'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 text-muted form__row__title">
            Средняя скидка клиенту:
        </div>
        <div class="col-sm-6">
            <?=number_format($data['AVG_DISCOUNT'], 2, '.', '&nbsp;')?>&nbsp;%
        </div>
    </div>
<?}?>