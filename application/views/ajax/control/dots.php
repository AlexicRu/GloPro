<?if(!empty($showCheckbox)){?>
    <input type="hidden" name="show_checkboxes<?=$postfix?>" value="1">
<?}?>
<?if(!empty($groupId)){?>
    <input type="hidden" name="group_id_<?=$postfix?>" value="<?=$groupId?>">
<?}?>
<div class="ajax_block_group_dots_list_<?=$postfix?>_out"></div>

<script>
    $(function(){
        var params = {
            show_all_btn: <?=(!empty($showAllBtn) ? 1 : 0)?>,
            show_available_dots:     <?=(!empty($showAvailableDots) ? 1 : 0)?>,
        };

        if($('[name=group_id_<?=$postfix?>]').length){
            params.group_id = $('[name=group_id_<?=$postfix?>]').val();
        }

        paginationAjax('/control/load-dots/', 'ajax_block_group_dots_list_<?=$postfix?>', renderAjaxPaginationDotsList<?=$postfix?>, params);
    });

    function renderFilterDotsList<?=$postfix?>(block, params)
    {
        if(block.find('> table').length == 0){
            block.append('<table class="table table_small table_fullscreen check_all_block"></table>');
            block = block.find('table');

            block.append('<tr>' +
                '<th class="td_check"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" onchange="checkAllRows($(this), \'pos_id\')"><span class="custom-control-label"></span></label></th>' +
                '<th><input type="text" name="dots_filter_project_name" placeholder="Шаблон ТО" class="form-control"></th>' +
                '<th><input type="text" name="dots_filter_id_emi" placeholder="Эмитент" class="form-control"></th>' +
                '<th><input type="text" name="dots_filter_id_to" placeholder="Номер ТО" class="form-control"></th>' +
                '<th><input type="text" name="dots_filter_pos_name" placeholder="Название" class="form-control"></th>' +
                '<th><input type="text" name="dots_filter_owner" placeholder="Владелец" class="form-control"></th>' +
                '<th style="width:300px;">' +
                    '<div class="btn-group">' +
                        '<input type="text" name="dots_filter_address" placeholder="Адрес" class="form-control">'+
                        '<button class="'+ BTN +' btn-sm btn-primary" onclick="filterDots<?=$postfix?>($(this))"><i class="fa fa-search"></i></button>'+
                    '</div>' +
                '</th>' +
                '<th class="td_edit"></th>' +
                '</tr>');
        }

        if(params.ID_EMITENT){
            block.find('[name=dots_filter_id_emi]').val(params.ID_EMITENT);
        }
        if(params.ID_TO){
            block.find('[name=dots_filter_id_to]').val(params.ID_TO);
        }
        if(params.OWNER){
            block.find('[name=dots_filter_owner]').val(params.OWNER);
        }
        if(params.POS_ADDRESS){
            block.find('[name=dots_filter_address]').val(params.POS_ADDRESS);
        }
        if(params.POS_NAME){
            block.find('[name=dots_filter_pos_name]').val(params.POS_NAME);
        }
        if(params.PROJECT_NAME){
            block.find('[name=dots_filter_project_name]').val(params.PROJECT_NAME);
        }
    }

    function renderAjaxPaginationDotsListError<?=$postfix?>(block, params)
    {
        renderFilterDotsList<?=$postfix?>(block, params);

        var subBlock = block.find('table');

        var tpl = $('<tr>' +
            '<td colspan="8" class="text-center"><i class="text-muted">Данные отсутствуют</i></td>' +
            '</tr>');

        subBlock.append(tpl);
    }

    function renderAjaxPaginationDotsList<?=$postfix?>(data, block, params)
    {
        renderFilterDotsList<?=$postfix?>(block, params);

        var subBlock = block.find('table');

        for(var i in data){
            var tpl = $('<tr>' +
                '<td class="td_check" />' +
                '<td class="dot_td_project_name" />' +
                '<td class="dot_td_id_emi" />' +
                '<td class="dot_td_id_to" />' +
                '<td class="dot_td_pos_name"/>' +
                '<td class="dot_td_owner"/>' +
                '<td class="dot_td_address"/>' +
                '<td class="td_edit"/>' +
                '</tr>');

            tpl.attr('pos_id', data[i].POS_ID);
            tpl.find('.td_check').html(
                '<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="pos_id" value="'+ data[i].POS_ID +'"><span class="custom-control-label"></span></label>'
            );

            tpl.find('.dot_td_project_name').text(data[i].PROJECT_NAME);
            tpl.find('.dot_td_id_emi').text(data[i].ID_EMITENT);
            tpl.find('.dot_td_id_to').text(data[i].ID_TO);
            tpl.find('.dot_td_pos_name').text(data[i].POS_NAME);
            tpl.find('.dot_td_owner').text(data[i].OWNER);
            tpl.find('.dot_td_address').text(data[i].POS_ADDRESS);
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
        renderVerticalTabsScroll($('.tabs_dots_groups .v-scroll'));
        <?}?>
    }

    function filterDots<?=$postfix?>(btn)
    {
        var block = btn.closest('.ajax_block_group_dots_list_<?=$postfix?>_out');

        var params = {
            PROJECT_NAME:   $('[name=dots_filter_project_name]', block).val(),
            ID_EMITENT:     $('[name=dots_filter_id_emi]', block).val(),
            ID_TO:          $('[name=dots_filter_id_to]', block).val(),
            POS_NAME:       $('[name=dots_filter_pos_name]', block).val(),
            OWNER:          $('[name=dots_filter_owner]', block).val(),
            POS_ADDRESS:    $('[name=dots_filter_address]', block).val(),
            show_all_btn:   <?=(!empty($showAllBtn) ? 1 : 0)?>,
            show_available_dots:     <?=(!empty($showAvailableDots) ? 1 : 0)?>,
            onError: renderAjaxPaginationDotsListError<?=$postfix?>,
        };

        if($('[name=group_id_<?=$postfix?>]').length){
            params.group_id = $('[name=group_id_<?=$postfix?>]').val();
        }

        block.empty();

        paginationAjax('/control/load-dots/', 'ajax_block_group_dots_list_<?=$postfix?>', renderAjaxPaginationDotsList<?=$postfix?>, params);
    }
</script>