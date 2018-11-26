<div class="modal-body">

    <div class="form_contract_limits_edit">
        <?foreach($contractLimits as $key => $limits){
            $limitFirst = reset($limits);
            ?>
            <div class="row m-b-10 border-bottom p-b-10" limit_group="<?$limitFirst['LIMIT_ID']?>">
                <div class="col-lg-5 col-md-12">
                    <?foreach($limits as $limit){?>
                        <div limit_service class="input-group m-b-5">
                            <select name="limit_service" class="custom-select" onchange="checkServices()">
                                <?foreach($servicesList as $service){?>
                                    <option value="<?=$service['SERVICE_ID']?>" <?if($service['SERVICE_ID'] == $limit['SERVICE_ID']){?>selected<?}?>><?=$service['LONG_DESC']?></option>
                                <?}?>
                            </select>
                            <div class="input-group-append">
                                <button class="<?=Text::BTN?> btn-sm btn-danger" onclick="contractLimitsEditDelService($(this))"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    <?}?>
                    <div limit_service_btns>
                        <nobr>
                            <button class="<?=Text::BTN?> btn-sm btn-outline-success m-r-5" onclick="contractLimitsEditAddService($(this))"><i class="fa fa-plus"></i> добавить услугу</button>
                            <button class="<?=Text::BTN?> btn-sm btn-outline-danger" onclick="contractLimitsEditDelLimit($(this))"><i class="fa fa-times"></i> удалить лимит</button>
                        </nobr>
                    </div>
                </div>
                <div class="col-lg-2 col-md-5 with-mt">
                    <input type="text" name="limit_value" value="<?=$limitFirst['LIMIT_VALUE']?>" <?=($limitFirst['INFINITELY'] ? 'disabled' : '')?> placeholder="Объем / сумма" class="form-control">
                </div>
                <div class="col-lg-2 col-md-3 with-mt">
                    <select name="limit_param" class="custom-select">
                        <?
                        $param = Model_Card::$cardLimitsParams[Model_Card::CARD_LIMIT_PARAM_VOLUME];
                        if ($limitFirst['CURRENCY'] == Common::CURRENCY_RUR) {
                            $param = Model_Card::$cardLimitsParams[Model_Card::CARD_LIMIT_PARAM_RUR];
                        }
                        foreach(Model_Card::$cardLimitsParams as $limitParam => $value){?>
                            <option value="<?=$limitParam?>" <?if($limitParam == $param){?>selected<?}?>><?=$value?></option>
                        <?}?>
                    </select>
                </div>
                <div class="col-lg-3 col-md-4 with-mt">
                    <input name="limit_unlim" id="limit_unlim_<?=$key?>" class="filled-in chk-col-purple" type="checkbox" <?=($limitFirst['INFINITELY'] ? 'checked' : '')?> onclick="contractLimitsEditCheckUnlim($(this))">
                    <label for="limit_unlim_<?=$key?>"> Без ограничений</label>
                </div>
            </div>
        <?}?>
    </div>

    <input type="checkbox" name="recalc" id="recalc" checked class="filled-in chk-col-purple">
    <label for="recalc">Пересчет остатков по договору</label>

</div>
<div class="modal-footer">
    <button class="btn waves-effect waves-light btn-outline-success" onclick="contractLimitsEditAddLimit($(this))"><i class="fa fa-plus"></i><span class="hidden-xs-down"> Добавить<span class="hidden-md-down"> ограничение</span></span></button>
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),contractLimitsEditGo)"><i class="fa fa-check"></i> Сохранить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    $(function(){
        checkServices();
    });

    var services_cnt = <?=count($servicesList)?>;

    var services = {
        <?foreach($servicesList as $service){?>
        "<?=$service['SERVICE_ID']?>": "<?=$service['LONG_DESC']?>",
        <?}?>
    };
    var limitParams = {
        <?foreach(Model_Card::$cardLimitsParams as $limitParam => $value){?>
        "<?=$limitParam?>": "<?=$value?>",
        <?}?>
    };

    function contractLimitsEditDelService(t)
    {
        t.closest('[limit_service]').fadeOut();
        setTimeout(function () {
            t.closest('[limit_service]').remove();

            checkServices();
        }, 300);
    }

    function contractLimitsEditAddService(t)
    {
        var row = t.closest('[limit_group]');

        /*if(td.find('[limit_service]').length){
            message(0, 'Максимум один вид услуги');
            return false;
        }*/

        var tpl = $('<div limit_service class="input-group m-b-5">' +
            '  <select name="limit_service" class="custom-select" onchange="checkServices()" />' +
            '  <div class="input-group-append">' +
            '    <button class="'+ BTN +'btn-sm btn-danger" onclick="contractLimitsEditDelService($(this))"><i class="fa fa-times"></i></button>' +
            '  </div>' +
            '</div>');

        var disabled = [
            $('.form_contract_limits_edit [name=limit_service]:first').val()
        ];
        $('.form_contract_limits_edit [name=limit_service]:first option:disabled').each(function () {
            disabled.push($(this).attr('value'));
        });

        if (disabled.length == services_cnt) {
            message(0, 'Доступные услуги закончились');
            return false;
        }

        for (var i in services) {
            tpl.find('select').append('<option value="' + i + '" '+ (disabled.indexOf(i) != -1 ? 'disabled' : '') +'>' + services[i] + '</option>');
        }

        tpl.insertBefore(row.find('[limit_service_btns]'));

        checkServices();
    }

    function contractLimitsEditDelLimit(t)
    {
        if (confirm('Удалить весь лимит?')) {
            t.closest('[limit_group]').fadeOut();
            setTimeout(function () {
                t.closest('[limit_group]').remove();

                checkServices();
            }, 300);
        }
    }

    function contractLimitsEditCheckUnlim(t)
    {
        var row = t.closest('[limit_group]');
        var check = row.find('[type=checkbox]');
        var limitGroup = t.closest('[limit_group]');
        var inputValue = limitGroup.find('[name=limit_value]');

        if (!check.prop('checked')){
            inputValue.prop('disabled', true);
        } else {
            inputValue.prop('disabled', false);
        }
    }

    function contractLimitsEditAddLimit(t)
    {
        var table = $('.form_contract_limits_edit');
        var tpl = $('<div class="row m-b-10 border-bottom p-b-10" limit_group>' +
            '<div class="col-lg-5 col-md-12">'+
                '<div limit_service_btns>'+
                    '<nobr>' +
                        '<button class="'+ BTN +' btn-sm btn-outline-success m-r-5" onclick="contractLimitsEditAddService($(this))"><i class="fa fa-plus"></i> добавить услугу</button>' +
                        '<button class="'+ BTN +' btn-sm btn-outline-danger" onclick="contractLimitsEditDelLimit($(this))"><i class="fa fa-times"></i> удалить лимит</button>' +
                    '</nobr>'+
                '</div>' +
            '</div>' +
            '<div class="col-lg-2 col-md-5 with-mt"><input type="text" name="limit_value" placeholder="Объем / сумма" class="form-control"></div>' +
            '<div class="col-lg-2 col-md-3 with-mt"><select name="limit_param" class="custom-select" /></div>' +
            '<div class="col-lg-3 col-md-4 with-mt">' +
                '<input name="limit_unlim" id="limit_unlim_'+ table.find('[limit_group]').length +'" type="checkbox" class="filled-in chk-col-purple">'+
                '<label for="limit_unlim_'+ table.find('[limit_group]').length +'" onclick="contractLimitsEditCheckUnlim($(this))">Без ограничений</label>' +
            '</div>' +
        '</div>');

        for (var i in limitParams) {
            tpl.find('select[name=limit_param]').append('<option value="' + i + '">' + limitParams[i] + '</option>');
        }

        tpl.appendTo(table);
    }

    function contractLimitsEditGo(t)
    {
        var form = $('.form_contract_limits_edit');
        var limits = [];

        var canEdit = true;

        $('[limit_group]', form).each(function(){
            var group_block = $(this);
            var group = {
                id:         group_block.attr('limit_group'),
                value:      $('[name=limit_value]', group_block).val(),
                param:      $('[name=limit_param]', group_block).val(),
                unlim:      $('[name=limit_unlim]', group_block).is(':checked') ? 1 : 0,
                services:   []
            };

            $('[name=limit_service]', group_block).each(function(){
                group.services.push($(this).val());
            });

            limits.push(group);

            if((group.value == '' && !group.unlim) || $('[name=limit_service]', group_block).length == 0){
                canEdit = false;
            }
        });

        if(canEdit == false){
            message(0, 'Заполните данные корректно');
            endSubmitForm();
            return;
        }

        var params = {
            contract_id : $('[name=contracts_list]').val(),
            limits: limits,
            recalc: $("[name=recalc]", form).is(":checked") ? 1 : 0,
        };

        $.post('/clients/contract-limits-edit', params, function (data) {
            endSubmitForm();
            if (data.success) {
                message(1, 'Ограничения по договору успешно обновлены');
                loadContract('account');
            } else {
                message(0, 'Ошибка обновления ограничений');

                if(data.data){
                    for(var i in data.data){
                        message(0, data.data[i].text);
                    }
                }
            }
        });
    }

    function checkServices()
    {
        var form = $('.form_contract_limits_edit');

        var services = [];

        $('[name=limit_service]', form).each(function () {
            services.push($(this).val());
        });

        $('[name=limit_service]', form).each(function () {
            var select = $(this);
            var selectVal = select.val();

            select.find('option').each(function () {
                var option = $(this);
                var optionVal = option.attr('value');

                if (services.indexOf(optionVal) == -1 || optionVal == selectVal) {
                    option.prop('disabled', false);
                } else {
                    option.prop('disabled', true);
                }
            });
        });
    }
</script>