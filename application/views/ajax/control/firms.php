<?if(!empty($showCheckbox)){?>
    <input type="hidden" name="show_checkboxes<?=$postfix?>" value="1">
<?}?>
<?if(!empty($groupId)){?>
    <input type="hidden" name="group_id_<?=$postfix?>" value="<?=$groupId?>">
<?}?>
<div class="ajax_block_group_firms_list_<?=$postfix?>_out">

</div>

<script>
    $(function(){
        var params = {
            show_all_btn:   <?=(!empty($showAllBtn) ? 1 : 0)?>,
            show_available_firms:     <?=(!empty($showAvailableFirms) ? 1 : 0)?>,
        };

        if($('[name=group_id_<?=$postfix?>]').length){
            params.group_id = $('[name=group_id_<?=$postfix?>]').val();
        }

        paginationAjax('/control/load-firms/', 'ajax_block_group_firms_list_<?=$postfix?>', renderAjaxPaginationFirmsList<?=$postfix?>, params);
    });

    function renderFilterFirmsList<?=$postfix?>(block, params)
    {
        if(block.find('> table').length == 0){
            block.append('<table class="table table_small table_fullscreen check_all_block"></table>');
            block = block.find('table');

            block.append('<tr>' +
                '<th class="td_check"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" onchange="checkAllRows($(this), \'firm_id\')"><span class="custom-control-label"></span></label></th>' +
                '<th><input type="text" name="group_firm_filter_firm_id" placeholder="FIRM ID" class="form-control"></th>' +
                '<th><input type="text" name="group_firm_filter_holder" placeholder="Владелец" class="form-control"></th>' +
                '<th>' +
                '<div class="btn-group">' +
                '<input type="text" name="group_firm_filter_description_ru" placeholder="Описание" class="form-control">' +
                '<button class="'+ BTN +' btn-sm btn-primary" onclick="filterFirms<?=$postfix?>($(this))"><i class="fa fa-search"></i></button>'+
                '</div>' +
                '</th>' +
                '<th class="td_edit" />' +
                '</tr>');
        }

        if(params.FIRM_ID){
            block.find('[name=group_firm_filter_firm_id]').val(params.FIRM_ID);
        }
        if(params.HOLDER){
            block.find('[name=group_firm_filter_holder]').val(params.HOLDER);
        }
        if(params.DESCRIPTION_RU){
            block.find('[name=group_firm_filter_description_ru]').val(params.DESCRIPTION_RU);
        }
    }

    function renderAjaxPaginationFirmsListError<?=$postfix?>(block, params)
    {
        renderFilterFirmsList<?=$postfix?>(block, params);

        var subBlock = block.find('.table');

        var tpl = $('<tr>' +
            '<td colspan="4" class="text-center"><i class="text-muted">Данные отсутствуют</i></td>' +
            '</tr>');

        subBlock.append(tpl);
    }

    function renderAjaxPaginationFirmsList<?=$postfix?>(data, block, params)
    {
        renderFilterFirmsList<?=$postfix?>(block, params);

        var subBlock = block.find('.table');

        for(var i in data){
            var tpl = $('<tr>' +
                '<td class="td_check" />' +
                '<td class="group_firm_td_FIRM_ID" />' +
                '<td class="group_firm_td_HOLDER" />' +
                '<td class="group_firm_td_DESCRIPTION_RU" />' +
                '<td class="td_edit"/>' +
                '</tr>');

            tpl.find('.td_check').html(
                '<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="firm_id" value="'+ data[i].FIRM_ID +'"><span class="custom-control-label"></span></label>'
            );
            tpl.find('.group_firm_td_FIRM_ID').text(data[i].FIRM_ID);
            tpl.find('.group_firm_td_HOLDER').text(data[i].HOLDER);
            tpl.find('.group_firm_td_DESCRIPTION_RU').text(data[i].DESCRIPTION_RU);
            tpl.find('.td_edit').html('<span class="'+ BTN +' btn-sm btn-outline-primary"><i class="fa fa-pen"></span>');

            subBlock.append(tpl);
        }

        if($('.action_del').is(':visible')){
            $('.td_edit', block).show();
        }
        if($('.action_del').is(':visible') || $('[name=show_checkboxes<?=$postfix?>]').length){
            $('.td_check', block).show();
        }

        <?if(!empty($renderVerticalScroll)) {?>
        renderVerticalTabsScroll($('.tabs_firms_groups .v-scroll'));
        <?}?>
    }

    function filterFirms<?=$postfix?>(btn)
    {
        var block = btn.closest('.ajax_block_group_firms_list_<?=$postfix?>_out');

        var params = {
            show_all_btn:       <?=(!empty($showAllBtn) ? 1 : 0)?>,
            show_available_firms:     <?=(!empty($showAvailableFirms) ? 1 : 0)?>,
            FIRM_ID:            $('[name=group_firm_filter_firm_id]', block).val(),
            HOLDER:             $('[name=group_firm_filter_holder]', block).val(),
            DESCRIPTION_RU:     $('[name=group_firm_filter_description_ru]', block).val(),
            onError:            renderAjaxPaginationFirmsListError<?=$postfix?>
        };

        if($('[name=group_id_<?=$postfix?>]').length){
            params.group_id = $('[name=group_id_<?=$postfix?>]').val();
        }

        block.empty();

        paginationAjax('/control/load-firms/', 'ajax_block_group_firms_list_<?=$postfix?>', renderAjaxPaginationFirmsList<?=$postfix?>, params);
    }
</script>