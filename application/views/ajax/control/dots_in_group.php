<div class="ajax_block_dots_group_<?=$groupId?>_out"></div>

<script>
    $(function(){
        paginationAjax('/control/load-group-dots/', 'ajax_block_dots_group_<?=$groupId?>', renderAjaxPaginationDotsGroup<?=$groupId?>, {group_id: <?=$groupId?>, can_edit:<?=(int)$canEdit?>});
    });

    function renderAjaxPaginationDotsGroup<?=$groupId?>(data, block, params)
    {
        var canEdit = false;

        if(params.can_edit){
            canEdit = true;
        }

        if(block.find('table').length == 0){
            block.append('<div class="table-responsive"><table class="table table_small table_fullscreen check_all_block"></table></div>');
            block = block.find('table');

            block.append('<tr>' +
                (
                    canEdit ?
                        '<th class="td_check"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" onchange="checkAllRows($(this), \'pos_id\')"><span class="custom-control-label"></span></label></th>' :
                        ''
                ) +
                '<th><nobr>Шаблон ТО</nobr></th>' +
                '<th><nobr>Эмитент</nobr></th>' +
                '<th><nobr>Номер ТО</nobr></th>' +
                '<th><nobr>Название</nobr></th>' +
                '<th>Владелец</th>' +
                '<th>Адрес</th>' +
                (canEdit ? '<th class="td_edit"></th>' : '') +
                '</tr>');
        }else{
            block = block.find('table');
        }

        for(var i in data){
            var tpl = $('<tr class="dot_row">' +
                (canEdit ? '<td class="td_check" />' : '') +
                '<td class="dot_td_project_name" />' +
                '<td class="dot_td_id_emi" />' +
                '<td class="dot_td_id_to" />' +
                '<td class="dot_td_pos_name"/>' +
                '<td class="dot_td_owner"/>' +
                '<td class="dot_td_address"/>' +
                (canEdit ? '<td class="td_edit"/>' : '') +
                '</tr>');

            tpl.attr('id', data[i].POS_ID);
            tpl.find('.td_check').html('<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="pos_id" value="'+ data[i].POS_ID +'"><span class="custom-control-label"></span></label>');
            tpl.find('.dot_td_project_name').text(data[i].PROJECT_NAME);
            tpl.find('.dot_td_id_emi').text(data[i].ID_EMITENT);
            tpl.find('.dot_td_id_to').text(data[i].ID_TO);
            tpl.find('.dot_td_pos_name').text(data[i].POS_NAME);
            tpl.find('.dot_td_owner').text(data[i].OWNER);
            tpl.find('.dot_td_address').text(data[i].POS_ADDRESS);
            tpl.find('.td_edit').html('<span class="'+ BTN +' btn-outline-primary btn-sm"><i class="icon-pen"></span>');

            block.append(tpl);
        }

        if($('.tabs_dots_groups .action_del').is(':visible')){
            $('.td_check, .td_edit').show();
        }

        renderVerticalTabsScroll($('.tabs_dots_groups .v-scroll'));
    }
</script>