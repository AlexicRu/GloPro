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
            show_all_btn:true
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
                '<th class="td_check"><input class="'+ CHECKBOX +'" id="firms_check_all" type="checkbox" onchange="checkAllRows($(this), \'firm_id\')"><label for="firms_check_all" /></th>' +
                '<th><input type="text" name="group_firm_filter_firm_id" placeholder="FIRM ID" class="form-control"></th>' +
                '<th><input type="text" name="group_firm_filter_holder" placeholder="Владелец" class="form-control"></th>' +
                '<th>' +
                '<div class="btn-group">' +
                '<input type="text" name="group_firm_filter_description_ru" placeholder="Описание" class="form-control">' +
                '<button class="'+ BTN +' btn-sm btn-outline-primary" onclick="filterFirms<?=$postfix?>($(this))"><i class="fa fa-search"></i></button>'+
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
            '<td colspan="4" class="center"><i>Данные отсутствуют</i></td>' +
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
                '<input type="checkbox" class="'+ CHECKBOX +'" name="firm_id" id="group_firms_add_firm_'+ data[i].FIRM_ID +'" value="'+ data[i].FIRM_ID +'">' +
                '<label for="group_firms_add_firm_'+ data[i].FIRM_ID +'" />'
            );
            tpl.find('.group_firm_td_FIRM_ID').text(data[i].FIRM_ID);
            tpl.find('.group_firm_td_HOLDER').text(data[i].HOLDER);
            tpl.find('.group_firm_td_DESCRIPTION_RU').text(data[i].DESCRIPTION_RU);
            tpl.find('.td_edit').html('<span class="'+ BTN +' btn-sm btn-outline-success"><i class="fa fa-pencil-alt"></span>');

            subBlock.append(tpl);
        }

        if($('.tabs_firms_groups .action_del', block).is(':visible')){
            $('.td_edit', block).show();
        }
        if($('.tabs_firms_groups .action_del', block).is(':visible') || $('[name=show_checkboxes<?=$postfix?>]').length){
            $('.td_check', block).show();
        }
    }

    function filterFirms<?=$postfix?>(btn)
    {
        var block = btn.closest('.ajax_block_group_firms_list_<?=$postfix?>_out');

        var params = {
            show_all_btn:       true,
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