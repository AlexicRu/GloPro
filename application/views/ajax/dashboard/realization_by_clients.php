<div class="row m-b-10">
    <div class="col-sm-6 text-muted">
        <div class="text-right hidden-xs-down">Количество клиентов:</div>
        <span class="hidden-sm-up">Количество клиентов:</span>
    </div>
    <div class="col-sm-6">
        <?=$data['CNT_CLIENTS']?>
    </div>
</div>

<div class="row m-b-10">
    <div class="col-sm-6 text-muted">
        <div class="text-right hidden-xs-down">Количество договоров:</div>
        <span class="hidden-sm-up">Количество договоров:</span>
    </div>
    <div class="col-sm-6">
        <?=$data['CNT_CONTRACTS']?>
    </div>
</div>

<div class="row m-b-10">
    <div class="col-sm-6 text-muted">
        <div class="text-right hidden-xs-down">Объем выборки за период:</div>
        <span class="hidden-sm-up">Объем выборки за период:</span>
    </div>
    <div class="col-sm-6">
        <?=number_format($data['SERVICE_AMOUNT'], 2, '.', '&nbsp;')?>&nbsp;л.
    </div>
</div>

<div class="row">
    <div class="col-sm-6 text-muted">
        <div class="text-right hidden-xs-down">Продажа за период:</div>
        <span class="hidden-sm-up">Продажа за период:</span>
    </div>
    <div class="col-sm-6">
        <?=number_format($data['SUMPRICE_DISCOUNT'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
    </div>
</div>