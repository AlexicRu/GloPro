<div class="row m-b-10">
    <div class="col-sm-6 text-muted form__row__title">
        Количество клиентов:
    </div>
    <div class="col-sm-6">
        <?=$data['CNT_CLIENTS']?>
    </div>
</div>

<div class="row m-b-10">
    <div class="col-sm-6 text-muted form__row__title">
        Количество договоров:
    </div>
    <div class="col-sm-6">
        <?=$data['CNT_CONTRACTS']?>
    </div>
</div>

<div class="row m-b-10">
    <div class="col-sm-6 text-muted form__row__title">
        Объем выборки за период:
    </div>
    <div class="col-sm-6">
        <?=number_format($data['SERVICE_AMOUNT'], 2, '.', '&nbsp;')?>&nbsp;л.
    </div>
</div>

<div class="row">
    <div class="col-sm-6 text-muted form__row__title">
        Продажа за период:
    </div>
    <div class="col-sm-6">
        <?=number_format($data['SUMPRICE_DISCOUNT'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
    </div>
</div>