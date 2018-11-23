<input type="hidden" name="card_id" value="<?=$card['CARD_ID']?>">

<div class="border-bottom m-b-20 p-b-10">
    <div class="row">
        <div class="col-sm-5">
            <span class="font-20">Карта: <b><?=$card['CARD_ID']?></b></span>
        </div>
        <div class="col-sm-7 text-right">
            <?if(Access::allow('view_card_info')){?>
                <span class="<?=Text::BTN?> btn-outline-secondary m-b-5" toggle="card_info_block">
                    <i class="fa fa-info fa-fw"></i>
                    <span class="d-none d-xl-inline-block">Инфо</span>
                </span>
            <?}?>
            <?if(Access::allow('clients_card_toggle_full')){?>
                <?if(in_array($card['BLOCK_AVAILABLE'], [1,2]) || Access::allow('clients_card-toggle')){?>
                    <?if($card['CARD_STATE'] == Model_Card::CARD_STATE_BLOCKED){?>
                        <button class="btn btn-outline-success waves-effect waves-light m-b-5" onclick="cardToggle($(this))" block_available="<?=$card['BLOCK_AVAILABLE']?>">
                            <span style="display: none"><i class="fa fa-lock"></i> <span class="d-none d-lg-inline-block">Заблокировать</span></span>
                            <span><i class="fa fa-unlock"></i> <span class="d-none d-lg-inline-block">Разблокировать</span></span>
                        </button>
                    <?}else{?>
                        <button class="btn btn-outline-danger waves-effect waves-light m-b-5" onclick="cardToggle($(this))" block_available="<?=$card['BLOCK_AVAILABLE']?>">
                            <span><i class="fa fa-lock"></i> <span class="d-none d-lg-inline-block">Заблокировать</span></span>
                            <span style="display: none"><i class="fa fa-unlock"></i> <span class="d-none d-lg-inline-block">Разблокировать</span></span>
                        </button>
                    <?}?>
                <?}?>
            <?}?>
            <?if(Access::allow('clients_card-withdraw')){?>
                <span class="btn btn-outline-warning waves-effect waves-light m-b-5" onclick="cardWithdraw('<?=$card['CARD_ID']?>', <?=$card['BLOCK_AVAILABLE']?>)">
                    <i class="fa fa-times"></i>
                    <span class="d-none d-xl-inline-block">Изъять</span>
                </span>
            <?}?>
            <?if(Access::allow('clients_card_edit')){?>
                <a href="#" data-toggle="modal" data-target="#card_edit_holder_<?=$card['CARD_ID']?>" class="btn btn-outline-primary waves-effect waves-light m-b-5"><i class="fa fa-pen"></i></a>
            <?}?>
        </div>
    </div>
</div>

<?if(Access::allow('view_card_info')){?>
<div class="dn border-bottom m-b-20 p-b-10" toggle_block="card_info_block">
    <div class="row m-b-10">
        <div class="col-sm-5 text-muted form__row__title">
            Тип источника карты:
        </div>
        <div class="col-sm-7">
            <?=$cardInfo['CARD_FROM']?>
        </div>
    </div>

    <div class="row m-b-10">
        <div class="col-sm-5 text-muted form__row__title">
            Источник карты:
        </div>
        <div class="col-sm-7">
            <?=$cardInfo['SOURCE_NAME']?>
        </div>
    </div>

    <div class="row m-b-10">
        <div class="col-sm-5 text-muted form__row__title">
            Дата последнего изменения лимита:
        </div>
        <div class="col-sm-7">
            <?=$cardInfo['RECORD_LIMIT_DATE']?>
        </div>
    </div>

    <div class="row m-b-10">
        <div class="col-sm-5 text-muted form__row__title">
            Статус применения лимита в источнике:
        </div>
        <div class="col-sm-7">
            <?=$cardInfo['LIMIT_SOURCE_STATUS']?>
        </div>
    </div>

    <div class="row m-b-10">
        <div class="col-sm-5 text-muted form__row__title">
            Дата последнего изменения состояния:
        </div>
        <div class="col-sm-7">
            <?=$cardInfo['RECORD_STATE_DATE']?>
        </div>
    </div>

    <div class="row m-b-10">
        <div class="col-sm-5 text-muted form__row__title">
            Статус применения состояния в источнике:
        </div>
        <div class="col-sm-7">
            <?=$cardInfo['STATE_SOURCE_STATUS']?>
        </div>
    </div>

</div>
<?}?>

<span class="font-18 font-weight-bold">Обороты за текущий период:</span><br>
<?=number_format($card['REALIZ_LITRES'], 2, ',', ' ')?> л. / <?=number_format($card['REALIZ_CUR'], 2, ',', ' ')?> <?=Text::RUR?><br><br>

<?if (!empty($transactions)) {?>
    <div class="row">
        <div class="col-10">
            <b class="font-18 font-weight-bold">Последние заправки:</b>
        </div>
        <div class="col-2 text-right">
            <?if (count($transactions) > 1) {?>
                <span class="btn btn-sm btn-outline-info waves-effect waves-light" toggle="last_transactions">
                    <span toggle_block="last_transactions"><i class="fa fa-chevron-down"></i></span>
                    <span toggle_block="last_transactions" style="display: none"><i class="fa fa-chevron-up"></i></span>
                </span>
            <?}?>
        </div>
    </div>

    <div class="p-3">
    <?foreach ($transactions as $index => $transaction) {?>
        <div class="row m-b-5 bg-light p-t-10 p-b-10" <?=($index ? 'toggle_block="last_transactions" style="display:none"' : '')?>>
            <div class="col-md-2 text-muted"><?=$transaction['DATE_TRN_FORMATTED']?> <?=$transaction['TIME_TRN']?></div>
            <div class="col-md-6">
                <b><?=$transaction['POS_PETROL_NAME']?></b>
                <br>
                <?=$transaction['POS_ADDRESS']?>
            </div>
            <div class="col-md-4">
                <b><?=$transaction['LONG_DESC']?></b>
                <span class="nowrap">
                    <?=number_format($transaction['SERVICE_AMOUNT'], 2, ',', ' ')?> л. / <?=number_format($transaction['SUMPRICE_DISCOUNT'], 2, ',', ' ')?> <?=Text::RUR?>
                </span>
            </div>
        </div>
    <?}?>
    </div>
<?}?>

<br>

<?if(Access::allow('clients_card_edit')){?>
    <div class="float-right">
        <?if(!empty($card['CHANGE_LIMIT_AVAILABLE']) && Access::allow('clients_card-edit-limits')){?>
            <a href="#" data-toggle="modal" data-target="#card_edit_limits_<?=$card['CARD_ID']?>" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-pen"></i></a>
        <?}?>
    </div>
<?}?>

<span class="font-18 font-weight-bold">Ограничения по топливу:</span>
<div class="clearfix"></div>
<?if(!empty($oilRestrictions)){
    $systemId = $card['SYSTEM_ID'];

    switch ($systemId){
        case Model_Card::CARD_SYSTEM_GPN:
            $limitTypes = Model_Card::$cardLimitsTypesFull;
            break;
        default:
            $limitTypes = Model_Card::$cardLimitsTypes;
    }

    ?>
    <table class="table m-t-10 table-width-auto">
        <tr>
            <td></td>
            <td>Лимит</td>
            <td>Остаток</td>
        </tr>
        <?foreach($oilRestrictions as $restriction){?>
            <tr>
                <td class="text-right text-muted">
                    <?foreach($restriction['services'] as $service){?>
                        <?=$service['name']?>:<br>
                    <?}?>
                </td>
                <td class="bg-light">
                    <?if ($systemId == 5) {?>
                        <?=$restriction['LIMIT_VALUE']?>
                        <?=Model_Card::$cardLimitsParams[$restriction['UNIT_TYPE']]?>,
                        <?=$limitTypes[$restriction['DURATION_TYPE']]?>: <?=$restriction['DURATION_VALUE']?>
                    <?}else{?>
                        <?=$restriction['LIMIT_VALUE']?>
                        <?=Model_Card::$cardLimitsParams[$restriction['UNIT_TYPE']]?>
                        <?=$limitTypes[$restriction['DURATION_TYPE']]?>
                    <?}?>
                </td>
                <td class="bg-light">
                    <?=$restriction['REST_LIMIT']?>
                    <?=Model_Card::$cardLimitsParams[$restriction['UNIT_TYPE']]?>
                </td>
            </tr>
        <?}?>
    </table>
<?}else{?>
    <div class="text-muted"><i>Не указаны</i></div>
<?}?>


<br>

<div class="ajax_block_operations_history_<?=$card['CARD_ID']?>_out">
    <div class="font-weight-bold font-18 m-b-10">История операций:</div>
</div>

<?if(Access::allow('clients_card_edit')){?>
    <?=$popupCardHolderEdit?>
    <?=$popupCardLimitsEdit?>
<?}?>

<script>
    $(function(){
        paginationAjax('/clients/card-operations-history/<?=$card['CARD_ID']?>?contract_id=' + $('[name=contracts_list]').val(), 'ajax_block_operations_history_<?=$card['CARD_ID']?>', renderAjaxPaginationOperationsHistory);
    });
</script>
