<div class="p-20 border-bottom">
    <div toggle_block="block2">
        <div class="row font-20 align-items-center">
            <div class="col-9">
                [<?=$contract['CONTRACT_ID']?>]
                <b><?=$contract['CONTRACT_NAME']?></b>
                <span class="nowrap"><span class="text-muted">от</span> <?=$contract['DATE_BEGIN']?></span>
                <?if($contract['DATE_END'] != '31.12.2099'){?><span class="nowrap"><span class="text-muted">до</span> <?=$contract['DATE_END']?></span><?}?> &nbsp;
                <span class="label label-<?=Model_Contract::$statusContractClasses[$contract['STATE_ID']]?>"><?=Model_Contract::$statusContractNames[$contract['STATE_ID']]?></span>
            </div>
            <div class="col-3 text-right">
                <?if(Access::allow('clients_contract-edit')){?>
                    <div class="float-right">
                        <button class="btn waves-effect waves-light btn-outline-primary" toggle="block2"><i class="fa fa-pencil-alt"></i><span class="hidden-md-down"> Редактировать</span></button>
                    </div>
                <?}?>
            </div>
        </div>
    </div>

    <div class="dn" toggle_block="block2">
        <div class="form-group row font-20">
            <label class="col-sm-2 col-form-label">[<?=$contract['CONTRACT_ID']?>]</label>
            <div class="col-sm-10">
                <input type="text" name="CONTRACT_NAME" value="<?=Text::quotesForForms($contract['CONTRACT_NAME'])?>" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 m-b-20 p-b-5">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">от</div>
                    </div>
                    <input type="date" name="DATE_BEGIN" value="<?=Date::formatToDefault($contract['DATE_BEGIN'])?>" class="form-control">
                </div>
            </div>

            <div class="col-md-4 m-b-20 p-b-5">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">до</div>
                    </div>
                    <input type="date" name="DATE_END" value="<?=Date::formatToDefault($contract['DATE_END'])?>" class="form-control">
                </div>
            </div>

            <div class="col-md-4 m-b-20 p-b-5">
                <select class="custom-select" name="STATE_ID">
                    <?
                    foreach(Model_Contract::$statusContractNames as $id => $name){
                        ?><option value="<?=$id?>" <?if($id == $contract['STATE_ID']){echo 'selected';}?>><?=$name?></option><?
                    }
                    ?>
                </select>
            </div>
        </div>

        <?if(Access::allow('clients_contract-edit')){?>
        <div class="form-group row m-b-0">
            <div class="col-sm-12">
                <button class="btn waves-effect waves-light btn-success btn_reverse" onclick="saveContract()"><i class="fa fa-check"></i> Сохранить</button>
                <button class="btn waves-effect waves-light btn-danger" toggle="block2"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
            </div>
        </div>
        <?}?>

    </div>
</div>

<div class="row p-20">
    <div class="col-lg-6">
        <?if(Access::allow('view_payment_block')){?>
            <div class="font-18 font-weight-bold m-b-10">Оплата:</div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted">
                    <div class="text-right d-none d-sm-block">Схема оплаты:</div>
                    <div class="d-block d-sm-none">Схема оплаты:</div>
                </div>
                <div class="col-sm-7">
                    <span toggle_block="block2"><?=Model_Contract::$paymentSchemes[$contractSettings['scheme']]?></span>
                    <span toggle_block="block2" class="dn">
                        <select name="scheme" class="custom-select">
                            <?
                            foreach(Model_Contract::$paymentSchemes as $id => $name){
                                ?><option value="<?=$id?>" <?if($id == $contractSettings['scheme']){echo 'selected';}?>><?=$name?></option><?
                            }
                            ?>
                        </select>
                    </span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted">
                    <div class="text-right d-none d-sm-block">Блокировка:</div>
                    <div class="d-block d-sm-none">Блокировка:</div>
                </div>
                <div class="col-sm-7">
                    <span toggle_block="block2">
                        <?if($contractSettings['scheme'] == Model_Contract::PAYMENT_SCHEME_UNLIMITED){?>
                            Отсутствует
                        <?}else{?>
                            <?=$contractSettings['AUTOBLOCK_LIMIT']?>
                        <?}?>
                    </span>
                    <span toggle_block="block2" class="dn"><input type="number" name="AUTOBLOCK_LIMIT" class="form-control" value="<?=$contractSettings['AUTOBLOCK_LIMIT']?>" <?if ($contractSettings['scheme'] != Model_Contract::PAYMENT_SCHEME_LIMIT){echo 'disabled';}?>></span>
                    <?if($contractSettings['scheme'] != Model_Contract::PAYMENT_SCHEME_UNLIMITED){?>
                        <?=Text::RUR?>
                    <?}?>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted">
                    <div class="text-right d-none d-sm-block">Периодичность выставления счетов:</div>
                    <div class="d-block d-sm-none">Периодичность выставления счетов:</div>
                </div>
                <div class="col-sm-7">
                    <?
                    if($contractSettings['INVOICE_PERIOD_TYPE'] == Model_Contract::INVOICE_PERIOD_TYPE_DAY){
                        $period = Text::plural($contractSettings['INVOICE_PERIOD_VALUE'], ['день', 'дня', 'дней']);
                    }else{
                        $period = Text::plural($contractSettings['INVOICE_PERIOD_VALUE'], ['месяц', 'месяца', 'месяцев']);
                    }
                    ?>
                    <?=$contractSettings['INVOICE_PERIOD_VALUE'].' '.$period?>
                    <?/*<span toggle_block="block2"><?=$contractSettings['INVOICE_PERIOD_VALUE'].' '.$period?></span>
                    <span toggle_block="block2" class="dn">
                        <select name="INVOICE_PERIOD_TYPE">
                            <?
                            foreach(Model_Contract::$invoicePeriods as $id => $value){
                                ?><option value="<?=$id?>" <?if($contractSettings['INVOICE_PERIOD_TYPE'] == $id){echo 'selected';}?>><?=$value?></option><?
                            }
                            ?>
                        </select>
                        <input type="text" name="INVOICE_PERIOD_VALUE" value="<?=$contractSettings['INVOICE_PERIOD_VALUE']?>">
                    </span>*/?>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted">
                    <div class="text-right d-none d-sm-block">Валюта:</div>
                    <div class="d-block d-sm-none">Валюта:</div>
                </div>
                <div class="col-sm-7">
                    Российский Рубль – <?=Text::RUR?>
                </div>
            </div>
        <?}?>

        <?if(Access::allow('view_goods_receiver')){?>
            <div class="font-18 font-weight-bold m-b-10 m-t-20">Грузополучатель:</div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted">
                    <div class="text-right d-none d-sm-block">Грузополучатель:</div>
                    <div class="d-block d-sm-none">Грузополучатель:</div>
                </div>
                <div class="col-sm-7">
                    <span toggle_block="block2" class="goods_reciever_span"></span>
                    <span toggle_block="block2" class="dn">
                        <?=Form::buildField('client_choose_single', 'GOODS_RECIEVER', $contractSettings['GOODS_RECIEVER'], [
                            'render_value_to' => '.goods_reciever_span',
                        ])?>
                    </span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted">
                    <div class="text-right d-none d-sm-block">Комментарий к договору:</div>
                    <div class="d-block d-sm-none">Комментарий к договору:</div>
                </div>
                <div class="col-sm-7">
                    <span toggle_block="block2"><?=($contractSettings['CONTRACT_COMMENT'] ?
                            Text::parseUrl($contractSettings['CONTRACT_COMMENT'])
                            : '<i class="gray">отсутствует</i>')?></span>
                    <span toggle_block="block2" class="dn">
                        <textarea class="form-control" name="CONTRACT_COMMENT"><?=$contractSettings['CONTRACT_COMMENT']?></textarea>
                    </span>
                </div>
            </div>
        <?}?>

        <?if(Access::allow('view_penalties')){?>
            <div class="font-18 font-weight-bold m-b-10 m-t-20">Штрафы по счету:</div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted">
                    <div class="text-right d-none d-sm-block">Пени:</div>
                    <div class="d-block d-sm-none">Пени:</div>
                </div>
                <div class="col-sm-7">
                    <span toggle_block="block2"><?=$contractSettings['PENALTIES']?> %</span>
                    <span toggle_block="block2" class="dn">
                        <div class="input-group">
                            <input type="text" name="PENALTIES" class="form-control" value="<?=$contractSettings['PENALTIES']?>">
                            <div class="input-group-append">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                    </span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted">
                    <div class="text-right d-none d-sm-block">Овердрафт:</div>
                    <div class="d-block d-sm-none">Овердрафт:</div>
                </div>
                <div class="col-sm-7">
                    <span toggle_block="block2"><?=$contractSettings['OVERDRAFT']?> <?=Text::RUR?></span>
                    <span toggle_block="block2" class="dn">
                        <div class="input-group">
                            <input type="number" name="OVERDRAFT" class="form-control" min="0" value="<?=$contractSettings['OVERDRAFT']?>">
                            <div class="input-group-append">
                                <div class="input-group-text"><?=Text::RUR?></div>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
        <?}?>
    </div>
    <div class="col-lg-6">
        <div class="card-body bg-light">
            <?if(Access::allow('view_tariffs')){?>
                <div class="font-18 font-weight-bold m-b-10">Тарификация:</div>

                <div class="row m-b-10">
                    <div class="col-sm-5 text-muted">
                        <div class="text-right d-none d-sm-block">Online тариф:</div>
                        <div class="d-block d-sm-none">Online тариф:</div>
                    </div>
                    <div class="col-sm-7">
                        <span toggle_block="block2">[<?=$contractSettings['TARIF_ONLINE']?>] <?=$contractSettings['TARIF_NAME_ONLINE']?></span>
                        <span toggle_block="block2" class="dn">
                            <?=Form::buildField('contract_tariffs', 'TARIF_ONLINE', $contractSettings['TARIF_ONLINE'])?>
                        </span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-5 text-muted">
                        <div class="text-right d-none d-sm-block">Тариф по договору:</div>
                        <div class="d-block d-sm-none">Тариф по договору:</div>
                    </div>
                    <div class="col-sm-7">
                        <span toggle_block="block2">[<?=$contractSettings['TARIF_OFFLINE']?>] <?=$contractSettings['TARIF_NAME_OFFLINE']?></span>
                        <span toggle_block="block2" class="dn">
                            <?=Form::buildField('contract_tariffs', 'TARIF_OFFLINE', $contractSettings['TARIF_OFFLINE'])?>
                        </span>
                    </div>
                </div>
            <?}?>

            <a href="#" class="btn waves-effect waves-light btn-outline-primary m-t-10" data-toggle="modal" data-target="#contract_history">История по договору</a>

            <?=$popupContractHistory?>

            <a href="#" class="btn waves-effect waves-light btn-outline-primary m-t-10" data-toggle="modal" data-target="#contract_notice_settings">Настройка уведомлений</a>

            <?=$popupContractNoticeSettings?>
        </div>
    </div>
</div>


<script>
    $(function(){
        renderElements();

        $("select[name=scheme]").on('change', function(){
            var t = $(this);

            if(t.val() == 1){ //безлимит
                $("[name=AUTOBLOCK_LIMIT]").val(0).prop('disabled', true);
            }else if(t.val() == 2){ //предоплата
                $("[name=AUTOBLOCK_LIMIT]").val(0).prop('disabled', true);
            }else{ //порог отключения
                $("[name=AUTOBLOCK_LIMIT]").prop('disabled', false);
            }
        });
    });

    <?if(Access::allow('clients_contract-edit')){?>
    function saveContract()
    {
        var params = {
            contract:{
                CONTRACT_NAME:  $("[name=CONTRACT_NAME]").val(),
                DATE_BEGIN:     $("[name=DATE_BEGIN]").val(),
                DATE_END:       $("[name=DATE_END]").val(),
                STATE_ID:       $("[name=STATE_ID]").val()
            },
            settings:{
                TARIF_ONLINE:           getComboBoxValue($('[name=TARIF_ONLINE].combobox')),
                TARIF_OFFLINE:          getComboBoxValue($('[name=TARIF_OFFLINE].combobox')),
                AUTOBLOCK_LIMIT:        $("[name=AUTOBLOCK_LIMIT]").val(),
                PENALTIES:              $("[name=PENALTIES]").val(),
                OVERDRAFT:              $("[name=OVERDRAFT]").val(),
                //INVOICE_PERIOD_TYPE:    $("[name=INVOICE_PERIOD_TYPE]").val(),
                //INVOICE_PERIOD_VALUE:   $("[name=INVOICE_PERIOD_VALUE]").val(),
                GOODS_RECIEVER:         getComboBoxValue($("[name=GOODS_RECIEVER].combobox")),
                CONTRACT_COMMENT:       $("[name=CONTRACT_COMMENT]").val(),
                scheme:                 $("[name=scheme]").val()
            }
        };

        if (params.contract.STATE_ID == <?=Model_Contract::STATE_CONTRACT_DELETED?> && !confirm('Вы уверены, что хотите удалить договор?')) {
            return false;
        }

        if(params.settings.TARIF_ONLINE == '' || params.settings.TARIF_OFFLINE == ''){
            message(0, 'Заполните тарификацию');
            return false;
        }

        if(params.contract.CONTRACT_NAME == ''){
            message(0, 'Введите название');
            return false;
        }

        $.post('/clients/contract-edit/<?=$contractSettings['CONTRACT_ID']?>', {params:params}, function(data){
            if(data.success){
                message(1, 'Контракт обновлен');

                if (data.data.full_reload) {
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else {
                    var contractFullName = "Договор: [<?=$contractSettings['CONTRACT_ID']?>] " + params.contract.CONTRACT_NAME + " от " + params.contract.DATE_BEGIN + (params.contract.DATE_END != '31.12.2099' ? " до " + params.contract.DATE_END : '');

                $("[name=contracts_list] option:selected").text(contractFullName);

                loadContract('contract');
            }else{
                message(0, 'Сохранение не удалось');
            }
        });
    }
    <?}?>
    });
</script>