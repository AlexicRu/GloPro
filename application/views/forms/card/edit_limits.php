<div class="modal-body">
<?
$postfix = $card['CARD_ID'];

if(!empty($card['CHANGE_LIMIT_AVAILABLE']) && Access::allow('clients_card-edit-limits')){?>
    <div class="form-horizontal form_card_limits_edit_<?=$postfix?>" limit_form>
        <?foreach($oilRestrictions as $restriction){
            echo Form::buildLimit($card['CARD_ID'], $restriction, $postfix);
        }?>
    </div>
<?}?>
</div>
<div class="modal-footer">
    <?if ($settings['canAddLimit']) {?>
        <button class="<?=Text::BTN?> btn-outline-success" onclick="cardEditAddLimit_<?=$postfix?>($(this))"><i class="fa fa-plus"></i> Добавить<span class="hidden-md-down"> ограничение</span></button>
    <?}?>
    <?if ($settings['canSave']) {?>
        <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), cardEditGo_<?=$postfix?>)"><i class="fa fa-check"></i> Сохранить<span class="hidden-md-down"> лимиты</span></span>
    <?}?>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-sm-down"> Отмена</span></button>
</div>

<script>
    var CARD_LIMIT_PARAM_RUR = <?=Model_Card::CARD_LIMIT_PARAM_RUR?>;
    var SERVICE_GROUP_ITEMS = '<?=Listing::SERVICE_GROUP_ITEMS?>';

    $(function () {
        checkServices_<?=$postfix?>();
    });

    var services_cnt_<?=$postfix?> = <?=count($servicesList)?>;
    var services_<?=$postfix?> = {
        <?foreach($servicesList as $service){?>
            "<?=$service['SERVICE_ID']?>": {
                name: "<?=$service['FOREIGN_DESC']?>",
                group: "<?=$service['SYSTEM_SERVICE_CATEGORY']?>"
            },
        <?}?>
    };

    function cardEditDelService_<?=$postfix?>(t)
    {
        t.closest('[limit_service]').fadeOut();
        setTimeout(function () {
            t.closest('[limit_service]').remove();

            checkServices_<?=$postfix?>();
        }, 300);
    }

    function cardEditAddService_<?=$postfix?>(t)
    {
        var row = t.closest('[limit_group]');

        <?if ($settings['cntServiceForLimit'] != $settings['cntServiceForFirstLimit']) {?>
            if (row.index() == 0) {
                if (row.find('[limit_service]').length == <?=$settings['cntServiceForFirstLimit']?>) {
                    message(0, 'Максимум услуг на первый лимит: <?=$settings['cntServiceForFirstLimit']?>');
                    return false;
                }
            } else {
                if(row.find('[limit_service]').length == <?=$settings['cntServiceForLimit']?>){
                    message(0, 'Максимум услуг на лимит: <?=$settings['cntServiceForLimit']?>');
                    return false;
                }
            }
        <?} else {?>
            if(row.find('[limit_service]').length == <?=$settings['cntServiceForLimit']?>){
                message(0, 'Максимум услуг на лимит: <?=$settings['cntServiceForLimit']?>');
                return false;
            }
        <?}?>

        var params = {
            cardId:     '<?=$card['CARD_ID']?>',
            postfix:    '<?=$postfix?>'
        };

        $.get('/clients/card-limit-service-template/', params, function(tpl){
            tpl = $(tpl);
            var selectFirst = $('.form_card_limits_edit_<?=$postfix?> [name=limit_service]:first');
            var group = selectFirst.find('option:selected').attr('group');
            var disabled = [
                selectFirst.val()
            ];
            $('option', selectFirst).each(function () {
                var t = $(this);
                if (t.is(":disabled") || t.attr('group') != group) {
                    disabled.push(t.attr('value'));
                }
            });

            if (disabled.length == services_cnt_<?=$postfix?>) {
                message(0, 'Доступные услуги закончились');
                return false;
            }

            var flSetSelected = false;
            for (var i in services_<?=$postfix?>) {
                if (disabled.indexOf(i) != -1) {
                    tpl.find('select option[value="'+ i +'"]').prop('disabled', true);
                } else {
                    flSetSelected = true;
                    tpl.find('select option[value="'+ i +'"]').prop('selected', true);
                }
            }

            if (row.find('[limit_service]').length) {
                tpl.insertAfter(row.find('[limit_service]:last'));
            } else {
                tpl.insertBefore(row.find('[limit_group_btns]'));
            }

            checkServices_<?=$postfix?>();
        });
    }

    function cardEditDelLimit_<?=$postfix?>(t)
    {
        if (confirm('Удалить весь лимит?')) {
            t.closest('[limit_group]').fadeOut();
            setTimeout(function () {
                t.closest('[limit_group]').remove();

                checkServices_<?=$postfix?>();
            }, 300);
        }
    }

    function cardEditAddLimit_<?=$postfix?>(t)
    {
        var form = $('.form_card_limits_edit_<?=$postfix?>');

        if ($('[limit_group]', form).length >= <?=$settings['cntLimits']?>) {
            message(0, 'Достигнуто максимальное кол-во лимитов');
            return false;
        }

        var params = {
            cardId:     '<?=$card['CARD_ID']?>',
            postfix:    '<?=$postfix?>'
        };

        $.get('/clients/card-limit-template/', params, function(tpl){
            tpl = $(tpl);
            if (form.find('[limit_group]').length) {
                tpl.insertAfter(form.find('[limit_group]:last'));
            } else {
                form.append(tpl);
            }
        });
    }

    function cardEditGo_<?=$postfix?>(t)
    {
        var form = $('.form_card_limits_edit_<?=$postfix?>');
        var params = {
            contract_id : $('[name=contracts_list]').val(),
            card_id     : $('.tabs_cards .nav-link.active').closest('[tab]').attr('tab'),
            limits      : []
        };

        var canEdit = true;

        /*if($('[limit_group]', form).length == 0){
         canEdit = false;
         }*/

        $('[limit_group]', form).each(function(){
            var group_block = $(this);
            var group = {
                limit_id:       group_block.attr('limit_group'),
                value:          $('[name=limit_value]', group_block).val(),
                unit_type:      $('[name=unit_type]', group_block).val(),
                duration_type:  $('[name=duration_type]', group_block).val(),
                duration_value: $('[name=duration_value]', group_block).val(),
                services:       []
            };

            $('[name=limit_service]', group_block).each(function(){
                group.services.push($(this).val());
            });

            params.limits.push(group);

            if(group.value == '' || $('[name=limit_service]', group_block).length == 0){
                canEdit = false;
            }
        });

        if(canEdit == false){
            message(0, 'Заполните данные корректно');
            endSubmitForm();
            return;
        }

        $.post('/clients/card-edit-limits', params, function (data) {
            if (data.success) {
                message(1, 'Лимиты карты успешно обновлена');
                modalClose();
                cardLoad($('.tabs_cards .nav-link.active').closest('[tab]').attr('tab'), true);
            } else {
                message(0, 'Ошибка обновления лимитов карты');

                if(data.data){
                    message(0, data.data);
                }
            }
            endSubmitForm();
        });
    }

    function checkServices_<?=$postfix?>(selectChanged)
    {
        var form = $('.form_card_limits_edit_<?=$postfix?>');

        var services = [];

        $('[name=limit_service]', form).each(function () {
            services.push($(this).val());
        });

        $('[name=limit_service]', form).each(function () {
            var select = $(this);
            var selectVal = select.val();
            var selected = select.closest('[limit_group]').find('[name=limit_service]:first option:selected');
            var group = selected.attr('group');
            var measure = selected.attr('measure').split(';');
            var cnt = select.closest('[limit_group]').find('[name=limit_service]').length;

            select.find('option').each(function () {
                var option = $(this);
                var optionVal = option.attr('value');
                var optionGroup = option.attr('group');

                if ((services.indexOf(optionVal) == -1 || optionVal == selectVal) && (optionGroup == group || cnt == 1)) {
                    option.prop('disabled', false);
                } else {
                    option.prop('disabled', true);
                }
            });
        });

        if (selectChanged) {
            var row = selectChanged.closest('[limit_group]');

            if (selectChanged.find('option:selected').attr('group') == SERVICE_GROUP_ITEMS) {
                $('[name=unit_type] option', row).each(function () {
                    var option = $(this);

                    if (option.attr('value') == CARD_LIMIT_PARAM_RUR) {
                        option.prop('disabled', false);
                    } else {
                        option.prop('disabled', true);
                        if (option.prop('selected')) {
                            option.prop('selected', false);
                        }
                    }
                });
            } else {
                $('[name=unit_type] option', row).each(function () {
                    $(this).prop('disabled', false);
                });
            }
        }
    }
</script>