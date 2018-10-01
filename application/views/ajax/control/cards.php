<?if(!empty($showCheckbox)){?>
    <input type="hidden" name="show_checkboxes<?=$postfix?>" value="1">
<?}?>
<?if(!empty($groupId)){?>
    <input type="hidden" name="group_id_<?=$postfix?>" value="<?=$groupId?>">
<?}?>
<div class="ajax_block_group_cards_list_<?=$postfix?>_out">

</div>

<script>
    $(function(){
        var params = {
            show_all_btn:true
        };

        if($('[name=group_id_<?=$postfix?>]').length){
            params.group_id = $('[name=group_id_<?=$postfix?>]').val();
        }

        paginationAjax('/control/load-cards/', 'ajax_block_group_cards_list_<?=$postfix?>', renderAjaxPaginationGroupCardsList<?=$postfix?>, params);
    });

    function renderFilterGroupCardsList<?=$postfix?>(block, params)
    {
        if(block.find('> table').length == 0){
            block.append('<table class="table table_small table_fullscreen check_all_block"></table>');
            block = block.find('table');

            block.append('<tr>' +
                '<th class="td_check"><input type="checkbox" onchange="checkAllRows($(this), \'card_id\')" style="display: none;"></th>' +
                '<th><input type="text" name="group_card_filter_card_id" placeholder="CARD ID" class="form-control"></th>' +
                '<th><input type="text" name="group_card_filter_holder" placeholder="Владелец" class="form-control"></th>' +
                '<th>' +
                    '<div class="btn-group">' +
                        '<input type="text" name="group_card_filter_description_ru" placeholder="Описание" class="form-control">' +
                        '<button class="'+ BTN +' btn-sm btn-outline-primary" onclick="filterGroupCards<?=$postfix?>($(this))"><i class="fa fa-search"></i></button>'+
                    '</div>' +
                '</th>' +
                '<th class="td_edit" />' +
            '</tr>');
        }

        if(params.CARD_ID){
            block.find('[name=group_card_filter_card_id]').val(params.CARD_ID);
        }
        if(params.HOLDER){
            block.find('[name=group_card_filter_holder]').val(params.HOLDER);
        }
        if(params.DESCRIPTION_RU){
            block.find('[name=group_card_filter_description_ru]').val(params.DESCRIPTION_RU);
        }
    }

    function renderAjaxPaginationGroupCardsListError<?=$postfix?>(block, params)
    {
        renderFilterGroupCardsList<?=$postfix?>(block, params);

        var subBlock = block.find('.table');

        var tpl = $('<tr>' +
            '<td colspan="4" class="center"><i>Данные отсутствуют</i></td>' +
            '</tr>');

        subBlock.append(tpl);
    }

    function renderAjaxPaginationGroupCardsList<?=$postfix?>(data, block, params)
    {
        renderFilterGroupCardsList<?=$postfix?>(block, params);

        var subBlock = block.find('.table');

        for(var i in data){
            var tpl = $('<tr>' +
                '<td class="td_check" />' +
                '<td class="group_card_td_CARD_ID" />' +
                '<td class="group_card_td_HOLDER" />' +
                '<td class="group_card_td_DESCRIPTION_RU" />' +
                '<td class="td_edit"/>' +
            '</tr>');

            tpl.find('.td_check').html(
                '<input type="checkbox" class="'+ CHECKBOX +'" name="card_id" id="group_cards_add_card_'+ data[i].CARD_ID +'" value="'+ data[i].CARD_ID +'">' +
                '<label for="group_cards_add_card_'+ data[i].CARD_ID +'" />'
            );
            tpl.find('.group_card_td_CARD_ID').text(data[i].CARD_ID);
            tpl.find('.group_card_td_HOLDER').text(data[i].HOLDER);
            tpl.find('.group_card_td_DESCRIPTION_RU').text(data[i].DESCRIPTION_RU);
            tpl.find('.td_edit').html('<span class="'+ BTN +' btn-sm btn-outline-success"><i class="fa fa-pencil-alt"></span>');

            subBlock.append(tpl);
        }

        if($('.tabs_cards_groups .action_del', block).is(':visible')){
            $('.td_edit', block).show();
        }
        if($('.tabs_cards_groups .action_del', block).is(':visible') || $('[name=show_checkboxes<?=$postfix?>]').length){
            $('.td_check', block).show();
        }
    }
    
    function filterGroupCards<?=$postfix?>(btn)
    {
        var block = btn.closest('.ajax_block_group_cards_list_<?=$postfix?>_out');

        var params = {
            show_all_btn:       true,
            CARD_ID:            $('[name=group_card_filter_card_id]', block).val(),
            HOLDER:             $('[name=group_card_filter_holder]', block).val(),
            DESCRIPTION_RU:     $('[name=group_card_filter_description_ru]', block).val(),
            onError:            renderAjaxPaginationGroupCardsListError<?=$postfix?>
        };

        if($('[name=group_id_<?=$postfix?>]').length){
            params.group_id = $('[name=group_id_<?=$postfix?>]').val();
        }

        block.empty();

        paginationAjax('/control/load-cards/', 'ajax_block_group_cards_list_<?=$postfix?>', renderAjaxPaginationGroupCardsList<?=$postfix?>, params);
    }
</script>