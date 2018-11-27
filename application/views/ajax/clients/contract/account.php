<div class="webtour-account">
<div class="card-body border-bottom">
    <div class="row font-20 align-items-center">
        <div class="col-md-6">
            <span class="text-muted">Баланс по договору:</span>
            <b class="nowrap"><?=number_format($balance['BALANCE'], 2, ',', ' ')?> <?=Text::RUR?></b>
        </div>
        <div class="col-md-6 text-right with-mt">
            <?if(Access::allow('clients_bill-add')){?>
                <a href="#" data-toggle="modal" data-target="#contract_bill_add" class="<?=Text::BTN?> btn-outline-primary">
                    <i class="fa fa-file-alt"></i>
                    Выставить счет
                </a>
            <?}?>
            <?if(Access::allow('clients_bill-print')){?>
                <a href="#" data-toggle="modal" data-target="#contract_bill_print" class="<?=Text::BTN?> btn-outline-primary"><i class="fa fa-print"></i><span class="hidden-md-down"> Печать счетов</span></a>
            <?}?>
        </div>
    </div>
</div>
<div class="p-20">
    <div class="row">
        <div class="col-md-5 col-xl-4">
            <div class="card-body bg-light m-b-20">
                <?if(Access::allow('view_contract_balances')){?>
                    <?if(Access::allow('clients-contract-limits-edit')){?>
                        <div class="float-right"><a href="#" data-toggle="modal" data-target="#contract_limits_edit" class="<?=Text::BTN?> btn-outline-primary btn-sm"><i class="fa fa-pen"></i></a></div>
                    <?}?>

                    <span class="font-18 font-weight-bold">Остатки по договору:</span>

                    <?if (empty($contractLimits)) {?>
                        <br>Без ограничений<br>
                    <?} else {?>
                        <table class="table">
                            <?foreach($contractLimits as $restrictions){
                                $restrict = reset($restrictions);
                                ?>
                                <tr>
                                    <td class="text-muted text-right">
                                        <?foreach($restrictions as $restriction){?>
                                            <?=$restriction['LONG_DESC']?>:<br>
                                        <?}?>
                                    </td>
                                    <td>
                                        <?if($restrict['INFINITELY']){?>
                                            <i>Неограничено</i>
                                        <?}else{
                                            $param = Model_Card::$cardLimitsParams[Model_Card::CARD_LIMIT_PARAM_VOLUME];
                                            if ($restrict['CURRENCY'] == Common::CURRENCY_RUR) {
                                                $param = Model_Card::$cardLimitsParams[Model_Card::CARD_LIMIT_PARAM_RUR];
                                            }?>
                                            <b><?=$restrict['REST_LIMIT']?> <?=$param?></b> из <?=$restrict['LIMIT_VALUE']?> <?=$param?>
                                        <?}?>

                                        <?if(Access::allow('clients_contract_increase_limit')){?>
                                            <?if(!$restrict['INFINITELY']){?>
                                                <span class="<?=Text::BTN?> btn-sm btn-outline-primary" onclick="openIncreaseLimitPopup(<?=$restrict['LIMIT_ID']?>)"><i class="fa fa-plus"></i></span>
                                            <?}?>
                                        <?}?>
                                    </td>
                                </tr>
                            <?}?>
                        </table>
                    <?}?>
                    <br>
                <?}?>

                <span class="font-weight-bold font-18">Обороты по договору:</span>
                <div class="card-body bg-white m-b-10 m-t-10">
                    <div class="text-muted">за текущий период:</div>
                    <b class="font-20"><?=number_format($turnover['MONTH_REALIZ'], 2, ',', ' ')?> л. / <?=number_format($turnover['MONTH_REALIZ_CUR'], 2, ',', ' ')?> <?=Text::RUR?></b>
                </div>

                <div class="as_white">
                    <div class="text-muted">за прошлый период:</div>
                    <?=number_format($turnover['LAST_MONTH_REALIZ'], 2, ',', ' ')?> л. / <?=number_format($turnover['LAST_MONTH_REALIZ_CUR'], 2, ',', ' ')?> <?=Text::RUR?>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-xl-8">
            <?if(Access::allow('clients_payment-add')){?>
                <div class="float-right">
                    <a href="#" data-toggle="modal" data-target="#contract_payment_add" class="<?=Text::BTN?> btn-outline-primary"><i class="fa fa-plus"></i><span class="hidden-xs-down"> Добавить платеж</span></a>
                </div>
            <?}?>

            <div class="font-18 font-weight-bold">Платежи:</div><br>

            <div class="ajax_block_payments_history_out pr-3 pl-3"></div>
        </div>
    </div>
</div>
</div>

<?if(Access::allow('clients_payment-add')){?>
    <?=$popupContractPaymentAdd?>
<?}?>
<?if(Access::allow('clients_bill-add')){?>
    <?=$popupContractBillAdd?>
<?}?>
<?if(Access::allow('clients_bill-print')){?>
    <?=$popupContractBillPrint?>
<?}?>
<?if(Access::allow('view_contract_balances') && Access::allow('clients_contract-limits-edit')){?>
    <?=$popupContractLimitsEdit?>
<?}?>
<?if(Access::allow('clients_contract-increase-limit')){?>
    <?=$popupContractLimitIncrease?>
<?}?>

<script>
    $(function(){
        paginationAjax('/clients/account-payments-history/' + $('[name=contracts_list]').val(), 'ajax_block_payments_history', renderAjaxPaginationPaymentsHistory);

        <?if(Access::allow('clients_payment-del')){?>
            $(document).off('click', '.link_del_contract_payment').on('click', '.link_del_contract_payment', function(){
                var t = $(this);
                var row = t.closest('[guid]');

                if(!confirm('Удалить платеж ' + row.find('b.line_inner_150').text())){
                    return false;
                }

                var params = {
                    contract_id:    $('[name=contracts_list]').val(),
                    guid:           row.attr('guid')
                };

                $.post('/clients/contract-payment-delete', {params:params}, function(data){
                    if(data.success){
                        message(1, 'Платеж успешно удален');
                        loadContract('account');
                    }else{
                        message(0, 'Ошибка удаления платежа');
                    }
                });

                return false;
            });
        <?}?>
    });

    <?if(Access::allow('clients_contract_increase_limit')){?>
    var increaseLimitId = 0;
    function openIncreaseLimitPopup(limitId)
    {
        increaseLimitId = limitId;

        $('#contract_increase_limit').modal('show');
    }
    <?}?>

    function renderAjaxPaginationPaymentsHistory(data, block)
    {
        for(var i = 0 in data){
            var tpl = $('<div class="row bg-light m-b-5 p-t-10 p-b-10">'+
                '<div class="col-5 col-xl-3 text-muted" row_date />'+
                '<div class="col-7 col-xl-3" row_num />'+
                '<div class="with-mt col-xl-6" row_summ />'+
                '<div class="with-mt col-12" row_comment />'+
            '</div>');

            tpl.attr('guid', data[i].ORDER_GUID);
            tpl.find('[row_date]').text(data[i].ORDER_DATE);
            tpl.find('[row_num]').text('№' + data[i].ORDER_NUM);
            tpl.find('[row_summ]').html('<span class="text-muted">Сумма</span> <b>' + number_format(data[i].SUMPAY, 2, ',', ' ') + ' <?=Text::RUR?></b>');

            if (data[i].DATE_IN) {
                tpl.find('[row_comment]').append('<div class="text-muted"><i>Внесена:</i> '+ data[i].DATE_IN +'</div>');
            }

            if (data[i].PAY_COMMENT) {
                tpl.find('[row_comment]').append('<i>Комментарий:</i> '+ data[i].PAY_COMMENT);
            }

            <?if(Access::allow('clients_payment-del')){?>
            tpl.find('[row_summ]').append('<div class="float-right"><span class="del link_del_contract_payment '+ BTN +' btn-danger btn-sm"><i class="fa fa-trash-alt"></i></span></div>');
            <?}?>

            block.append(tpl);
        }
    }
</script>
