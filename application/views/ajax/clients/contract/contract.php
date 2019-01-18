<div class="p-3">
    <div class="row border-bottom pb-3">
        <div class="col-12">
    <div toggle_block="block2" class="font-20 align-items-center">
        <b><?=$contract['CONTRACT_NAME']?></b>
        <span class="nowrap"><span class="text-muted">от</span> <?=$contract['DATE_BEGIN']?></span>
        <?if($contract['DATE_END'] != Date::DATE_MAX){?><span class="nowrap"><span class="text-muted">до</span> <?=$contract['DATE_END']?></span><?}?> &nbsp;
        <span class="badge badge-<?=Model_Contract::$statusContractClasses[$contract['STATE_ID']]?>"><?=Model_Contract::$statusContractNames[$contract['STATE_ID']]?></span>
        <span class="badge badge-light">ID <?=$contract['CONTRACT_ID']?></span>
    </div>

    <div class="dn" toggle_block="block2">

        <div class="form-group">
            <div class="input-group">
                <input type="text" name="CONTRACT_NAME" value="<?=Text::quotesForForms($contract['CONTRACT_NAME'])?>" class="form-control form-control-lg" placeholder="Название">
                <div class="input-group-append">
                    <span class="input-group-text"><?=$contract['CONTRACT_ID']?></span>
                </div>
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-4 p-b-5">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">от</div>
                    </div>
                    <input type="date" name="DATE_BEGIN" value="<?=Date::formatToDefault($contract['DATE_BEGIN'])?>" class="form-control">
                </div>
            </div>

            <div class="col-md-4 p-b-5">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">до</div>
                    </div>
                    <input type="date" name="DATE_END" value="<?=($contract['DATE_END'] == Date::DATE_MAX ? '' : Date::formatToDefault($contract['DATE_END']))?>" class="form-control"
                           min="<?=Date::formatToDefault($contract['DATE_BEGIN'])?>"
                    >
                </div>
            </div>

            <div class="col-md-4 p-b-5">
                <select class="custom-select" name="STATE_ID">
                    <?
                    $user = User::current();
                    foreach(Model_Contract::$statusContractNames as $id => $name){
                        if ($id == Model_Contract::STATE_CONTRACT_DELETED && !in_array($user['ROLE_ID'], Model_Contract::$stateContractDeletedRolesAccess)) {
                            continue;
                        }
                        ?><option value="<?=$id?>" <?if($id == $contract['STATE_ID']){echo 'selected';}?>><?=$name?></option><?
                    }
                    ?>
                </select>
            </div>
        </div>

    </div>
        </div>
</div>

    <div class="row pt-3 pb-3 border-bottom">
    <div class="col-2">
        <?if(Access::allow('clients_contract-edit')){?>
            <span class="dn" toggle_block="block2"><button class="<?=Text::BTN?> btn-success" onclick="saveContract()"><i class="fa fa-check"></i> Сохранить</button></span>
        <?}?>
    </div>

    <div class="col-10 text-right">
        <a href="#" class="<?=Text::BTN?> btn-outline-primary" data-toggle="modal" data-target="#contract_history"><i class="fa fa-history"></i> <span class="hidden-md-down">История по договору</span></a>

        <a href="#" class="<?=Text::BTN?> btn-outline-primary" data-toggle="modal" data-target="#contract_notice_settings"><i class="fa fa-cog"></i> <span class="hidden-md-down">Настройка уведомлений</span></a>

        <?if(Access::allow('clients_contract-edit')){?>
            <span class="<?=Text::BTN?> btn-outline-primary" toggle="block2" toggle_block="block2"><i class="fa fa-pen"></i> <span class="hidden-md-down"> Редактировать</span></span>

            <span class="dn" toggle_block="block2"><span class="<?=Text::BTN?> btn-danger" toggle="block2"><i class="fa fa-times"></i> <span class="hidden-xs-down"> Отмена</span></span></span>
        <?}?>
    </div>
</div>

    <div class="row pt-3">
    <div class="col-lg-6">
        <?if(Access::allow('view_payment_block')){?>
            <div class="font-18 font-weight-bold m-b-10">Оплата:</div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted form__row__title">
                    Схема оплаты:
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

            <div class="row m-b-10 contract-payment-scheme-limit-row" <?/*if($contractSettings['scheme'] != Model_Contract::PAYMENT_SCHEME_LIMIT){?>style="display: none"<?}*/?>>
                <div class="col-sm-5 text-muted form__row__title">
                    Действует до:
                </div>
                <div class="col-sm-7">
                    <span toggle_block="block2">
                        <?if ($contractSettings['AUTOBLOCK_FLAG_DATE'] == Date::DATE_MAX) {?>
                            Бессрочно
                        <?} else {?>
                            <?=$contractSettings['AUTOBLOCK_FLAG_DATE']?>
                        <?}?>
                    </span>
                    <span toggle_block="block2" class="dn">
                        <input type="date" name="AUTOBLOCK_FLAG_DATE" class="form-control"
                               min="<?=date(Date::$dateFormatDefault)?>"
                               value="<?=($contractSettings['AUTOBLOCK_FLAG_DATE'] == Date::DATE_MAX ? '' : Date::formatToDefault($contractSettings['AUTOBLOCK_FLAG_DATE']))?>"
                        >

                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input autoblock_flag_date_checkbox" onchange="checkAutoblockFlagDateIndefinitely($(this))">
                            <span class="custom-control-label">Бессрочно</span>
                        </label>
                    </span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted form__row__title">
                    Блокировка:
                </div>
                <div class="col-sm-7">

                    <span toggle_block="block2">
                        <?if($contractSettings['scheme'] == Model_Contract::PAYMENT_SCHEME_UNLIMITED){?>
                            Отсутствует
                        <?}else{?>
                            <?=$contractSettings['AUTOBLOCK_LIMIT']?>
                        <?}?>

                        <?if($contractSettings['scheme'] != Model_Contract::PAYMENT_SCHEME_UNLIMITED){?>
                            <?=Text::RUR?>
                        <?}?>
                    </span>
                    <span toggle_block="block2" class="dn">
                        <div class="input-group">
                            <input type="number" name="AUTOBLOCK_LIMIT" class="form-control" value="<?=$contractSettings['AUTOBLOCK_LIMIT']?>" <?if ($contractSettings['scheme'] != Model_Contract::PAYMENT_SCHEME_LIMIT){echo 'disabled';}?>>

                            <?if($contractSettings['scheme'] != Model_Contract::PAYMENT_SCHEME_UNLIMITED){?>
                                <div class="input-group-append">
                                    <span class="input-group-text"><?=Text::RUR?></span>
                                </div>
                            <?}?>
                        </div>
                    </span>

                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted form__row__title">
                    Периодичность выставления счетов:
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
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted form__row__title">
                    Валюта:
                </div>
                <div class="col-sm-7">
                    Российский Рубль – <?=Text::RUR?>
                </div>
            </div>
        <?}?>

        <?if(Access::allow('view_goods_receiver')){?>
            <div class="font-18 font-weight-bold m-b-10 m-t-20">Грузополучатель:</div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted form__row__title">
                    Грузополучатель:
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
                <div class="col-sm-5 text-muted form__row__title">
                    Комментарий к договору:
                </div>
                <div class="col-sm-7">
                    <span toggle_block="block2"><?=($contractSettings['CONTRACT_COMMENT'] ?
                            Text::parseUrl($contractSettings['CONTRACT_COMMENT'])
                            : '<i class="text-muted">отсутствует</i>') ?></span>
                    <span toggle_block="block2" class="dn">
                        <textarea class="form-control" name="CONTRACT_COMMENT"><?=$contractSettings['CONTRACT_COMMENT']?></textarea>
                    </span>
                </div>
            </div>
        <?}?>

        <?if(Access::allow('view_penalties')){?>
            <div class="font-18 font-weight-bold m-b-10 m-t-20">Штрафы по счету:</div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted form__row__title">
                    Пени:
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
                <div class="col-sm-5 text-muted form__row__title">
                    Овердрафт:
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
                    <div class="col-sm-5 text-muted form__row__title">
                        Online тариф:
                    </div>
                    <div class="col-sm-7">
                        <span toggle_block="block2">
                            <?=$contractSettings['TARIF_NAME_ONLINE']?>
                            <span class="badge badge-secondary ml-1">ID <?=$contractSettings['TARIF_ONLINE']?></span>
                        </span>
                        <span toggle_block="block2" class="dn">
                            <?=Form::buildField('contract_tariffs', 'TARIF_ONLINE', $contractSettings['TARIF_ONLINE'])?>
                        </span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-5 text-muted form__row__title">
                        Тариф договора:
                    </div>
                    <div class="col-sm-7">
                        <?=$contractSettings['TARIF_NAME_OFFLINE']?>
                        <span class="badge badge-secondary ml-1">ID <?=$contractSettings['TARIF_OFFLINE']?></span>

                        <a href="#" data-toggle="modal" data-target="#contract_tariff_edit" class="<?=Text::BTN?> btn-outline-primary btn-sm"><i class="fa fa-pen"></i></a>
                    </div>
                </div>

                <div class="font-18 font-weight-bold m-b-10">История изменения тарифов</div>
                <div class="ajax_block_contract_tariff_history_out"></div>
            <?}?>

            <?if(Access::allow('view_contract_managers')){?>
                <div class="font-18 font-weight-bold m-b-10 m-t-20">Менеджеры:</div>

                <div class="row m-b-10">
                    <div class="col-sm-5 text-muted form__row__title">
                        Менеджер по продажам:
                    </div>
                    <div class="col-sm-7">
                        <?
                        $managers = [];
                        foreach ($contractManagers as $manager) {
                            if (in_array($manager['ROLE'], [Access::ROLE_MANAGER_SALE, Access::ROLE_MANAGER_SALE_SUPPORT])) {
                                $managers[] = $manager['MANAGER_NAME'];
                            }
                        }
                        if (empty($managers)) {
                            echo '<i class="text-muted">Не закреплен</i>';
                        } else {
                            echo implode(', ', $managers);
                        }?>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-5 text-muted form__row__title">
                        Менеджер по сопровождению:
                    </div>
                    <div class="col-sm-7">
                        <?
                        $managers = [];
                        foreach ($contractManagers as $manager) {
                            if (in_array($manager['ROLE'], [Access::ROLE_MANAGER, Access::ROLE_MANAGER_SALE_SUPPORT])) {
                                $managers[] = $manager['MANAGER_NAME'];
                            }
                        }
                        if (empty($managers)) {
                            echo '<i class="text-muted">Не закреплен</i>';
                        } else {
                            echo implode(', ', $managers);
                        }?>
                    </div>
                </div>
            <?}?>
        </div>
    </div>
</div>
</div>

<?=$popupContractHistory?>
<?=$popupContractNoticeSettings?>
<?=$popupContractTariffEdit?>

<script>
    $(function(){
        renderElements();

        <?if(Access::allow('view_tariffs')){?>
        paginationAjax('/clients/get-contract-tariff-change-history/', 'ajax_block_contract_tariff_history', renderAjaxPaginationContractTariffHistory, {
            contract_id: <?=$contract['CONTRACT_ID']?>,
            emptyMessage: '<span class="text-muted">История изменения тарифа отсутствует</span>'
        });
        <?}?>

        <?if ($contractSettings['AUTOBLOCK_FLAG_DATE'] == Date::DATE_MAX) {?>
        $('.autoblock_flag_date_checkbox').prop('checked', true).trigger('change');
        <?}?>

        $("select[name=scheme]").on('change', function(){
            var t = $(this);
            var row = $('.contract-payment-scheme-limit-row');

            //row.hide();

            if(t.val() == 1){ //безлимит
                $("[name=AUTOBLOCK_LIMIT]").val(0).prop('disabled', true);
            }else if(t.val() == 2){ //предоплата
                $("[name=AUTOBLOCK_LIMIT]").val(0).prop('disabled', true);
            }else{ //порог отключения
                $("[name=AUTOBLOCK_LIMIT]").prop('disabled', false);

                //row.show();
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
                AUTOBLOCK_LIMIT:        $("[name=AUTOBLOCK_LIMIT]").val(),
                AUTOBLOCK_FLAG_DATE:    $("[name=AUTOBLOCK_FLAG_DATE]").prop('disabled') ? '<?=Date::DATE_MAX_DEFAULT?>' : $("[name=AUTOBLOCK_FLAG_DATE]").val(),
                PENALTIES:              $("[name=PENALTIES]").val(),
                OVERDRAFT:              $("[name=OVERDRAFT]").val(),
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

                    var contractFullName = "Договор: " + params.contract.CONTRACT_NAME + " от " + params.contract.DATE_BEGIN + (params.contract.DATE_END != '31.12.2099' ? " до " + params.contract.DATE_END : '') + " [<?=$contractSettings['CONTRACT_ID']?>]";

                    $("[name=contracts_list] option:selected").text(contractFullName);

                    loadContract('contract');
                }
            }else{
                message(0, 'Сохранение не удалось');
            }
        });
    }
    <?}?>

    function checkAutoblockFlagDateIndefinitely(checkbox)
    {
        if (checkbox.is(':checked')) {
            $('[name=AUTOBLOCK_FLAG_DATE]').prop('disabled', true).parent().find('img').hide();
        } else {
            $('[name=AUTOBLOCK_FLAG_DATE]').prop('disabled', false).parent().find('img').show();
        }
    }

    function renderAjaxPaginationContractTariffHistory(data, block)
    {
        if (block.is(':empty')) {
            block.append('<table class="table bg-white table-sm m-b-0" />');
        }

        var block = block.find('.table');

        for(var i in data){
            var tpl = $('<tr>' +
                '<td class=" text-muted">' +
                    '<nobr class="th_data_from">c <span /></nobr>' +
                    '<nobr class="th_data_to"><br>до <span /></nobr>' +
                '</td>' +
                '<td class=" th_name" />' +
            '</tr>');

            tpl.find('.th_data_from span').text(data[i].DATE_FROM_STR);
            if (data[i].DATE_TO_STR != '<?=Date::DATE_MAX?>') {
                tpl.find('.th_data_to span').text(data[i].DATE_TO_STR);
            } else {
                tpl.find('.th_data_to').text('');
            }
            tpl.find('.th_name').text(data[i].TARIF_NAME);

            block.append(tpl);
        }
    }
</script>