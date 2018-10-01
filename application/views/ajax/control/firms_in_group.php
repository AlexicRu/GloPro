<div class="ajax_block_firms_group_<?=$groupId?>_out">

</div>

<script>
    $(function(){
        paginationAjax('/control/load-group-firms/', 'ajax_block_firms_group_<?=$groupId?>', renderAjaxPaginationFirmsGroup<?=$groupId?>, {group_id: <?=$groupId?>, can_edit:<?=(int)$canEdit?>});
    });

    function renderAjaxPaginationFirmsGroup<?=$groupId?>(data, block, params)
    {
        var canEdit = false;

        if(params.can_edit){
            canEdit = true;
        }

        if(block.find('table').length == 0){
            block.append('<div class="table-responsive"><table class="table table_small table_fullscreen check_all_block"></table></div>');
            block = block.find('table');

            block.append('<tr>' +
                (canEdit ? '<th class="td_check"><input type="checkbox" class="'+ CHECKBOX +'" id="cig_all<?=$groupId?>" onchange="checkAllRows($(this), \'firm_id\')"><label for="cig_all<?=$groupId?>"/></th>' : '') +
                '<th><nobr>FIRM ID</nobr></th>' +
                '<th>Владелец</th>' +
                '<th>Описание</th>' +
                (canEdit ? '<th class="td_edit"></th>' : '') +
                '</tr>');
        }else{
            block = block.find('table');
        }

        for(var i in data){
            var tpl = $('<tr class="firm_row">' +
                (canEdit ? '<td class="td_check" />' : '') +
                '<td class="group_firm_td_FIRM_ID" />' +
                '<td class="group_firm_td_HOLDER" />' +
                '<td class="group_firm_td_DESCRIPTION_RU" />' +
                (canEdit ? '<td class="td_edit"/>' : '') +
                '</tr>');

            tpl.attr('id', data[i].FIRM_ID);
            tpl.find('.td_check').html('<input type="checkbox" class="'+ CHECKBOX +'" name="firm_id" id="cig_'+ data[i].FIRM_ID +'" value="'+ data[i].FIRM_ID +'"><label for="cig_'+ data[i].FIRM_ID +'" />');
            tpl.find('.group_firm_td_FIRM_ID').text(data[i].FIRM_ID);
            tpl.find('.group_firm_td_HOLDER').text(data[i].HOLDER);
            tpl.find('.group_firm_td_DESCRIPTION_RU').text(data[i].DESCRIPTION_RU);
            tpl.find('.td_edit').html('<span class="'+ BTN +' btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></span>');

            block.append(tpl);
        }

        if($('.tabs_firms_groups .action_del').is(':visible')){
            $('.td_check, .td_edit').show();
        }

        renderVerticalTabsScroll($('.tabs_firms_groups .v-scroll'));
    }
</script>