<div class="card border-bottom m-b-0">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <form class="input-group form_cards_groups" onsubmit="return collectForms($(this), 'form_cards_groups')">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" name="filter[search]" class="form-control input_messages" placeholder="Поиск..." value="<?=(!empty($filter['search']) ? $filter['search'] : '')?>">
                </form>
            </div>
            <div class="col-sm-8 text-right with-mt">
                <span toggle_block="cards_groups_block">
                    <a href="#" data-toggle="modal" data-target="#control_add_cards_group" class="<?=Text::BTN?> btn-outline-primary m-b-5"><i class="fa fa-plus"></i> Добавить группу</a>
                    <a href="#" data-toggle="modal" data-target="#control_add_cards" class="<?=Text::BTN?> btn-outline-primary m-b-5"><i class="fa fa-plus"></i> Добавить карты</a>
                    <span class="<?=Text::BTN?> btn-outline-success m-b-5" onclick="groupCardsToXls()"><i class="fa fa-file-excel"></i> Выгрузить</span>
                    <span class="<?=Text::BTN?> btn-outline-success m-b-5" toggle="cards_groups_block"><i class="fa fa-pen"></i></span>
                </span>

                <span toggle_block="cards_groups_block" class="dn action_del">
                    <a href="#" class="<?=Text::BTN?> btn-outline-danger btn_del_cards m-b-5"><i class="fa fa-trash-alt"></i> Удалить выделенные карты</a>
                    <span class="<?=Text::BTN?> btn-outline-warning m-b-5" toggle="cards_groups_block"><i class="fa fa-times"></i></span>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card-body border-bottom d-lg-none bg-white">
    <div class="row">
        <div class="col-12">
            <span class="btn btn-info" toggle_class="cards_groups_list">
                <i class="fa fa-bars"></i> Группы карт
            </span>
        </div>
    </div>
</div>

<div class="vtabs customvtab tabs_cards_groups bg-white tabs-floating">
    <ul class="nav nav-tabs tabs-vertical bg-light p-t-10" role="tablist" toggle_block="cards_groups_list">
        <div class="v-scroll">
        <?if(empty($cardsGroups)){?>
            <li class="nav-item">
                <span class="nav-link text-muted">
                    Группы не найдены
                </span>
            </li>
        <?}else{?>
            <?foreach($cardsGroups as $key => $group){?>
                <li class="nav-item" tab="cards_group_<?=$group['GROUP_ID']?>">
                    <a class="nav-link" data-toggle="tab" href="#cards_group_<?=$group['GROUP_ID']?>" role="tab">
                        <span class="check_span_hidden">
                            <input type="hidden" name="group_id" value="<?=$group['GROUP_ID']?>">
                            <input type="hidden" name="group_name" value="<?=$group['GROUP_NAME']?>">
                            <input type="hidden" name="group_type" value="<?=$group['GROUP_TYPE']?>">

                            <span class="<?=Text::BTN?> btn-outline-danger btn-sm" onclick="deleteCardsGroup(<?=$group['GROUP_ID']?>, event)"><i class="fa fa-trash-alt"></i></span>
                            <span class="<?=Text::BTN?> btn-outline-success btn-sm" onclick="showEditCardsGroupPopup(<?=$group['GROUP_ID']?>, event)"><i class="fa fa-pen"></i></span>
                        </span>

                        <span class="gray">[<?=$group['GROUP_ID']?>]</span>
                        <span class="group_name"><?=$group['GROUP_NAME']?></span>
                    </a>
                </li>
            <?}?>
        <?}?>
        </div>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content p-0">
        <?if(!empty($cardsGroups)){?>
            <?foreach($cardsGroups as $key => $group){?>
                <div class="tab-pane" id="cards_group_<?=$group['GROUP_ID']?>" group_id="<?=$group['GROUP_ID']?>" role="tabpanel"></div>
            <?}?>
        <?}?>
    </div>
</div>

<?=$popupAddCards?>
<?=$popupAddCardsGroup?>
<?=$popupEditCardsGroup?>

<script>
    $(function(){
        //renderVerticalTabsScroll($('.tabs_cards_groups .v-scroll'));
        $('.tabs_cards_groups :not(.before_scroll) .nav-link').on('click', function(){
            var t = $(this);

            loadGroupCards(t);

            //костыль.. так как вложенность табов не сохраняется из-за постраничности
            $('.tabs_cards_groups > .nav-tabs .nav-link.active').not(t).removeClass('active show');
        });

        $('.tabs_cards_groups .nav-item:not(.before_scroll):first .nav-link').click();

        $("[toggle=cards_groups_block]").on('click', function(){
            $('.check_span_hidden, .td_check, .td_edit').toggle();
        });

        $('.btn_del_cards').on('click', function () {
            var cards = [];
            var group = $('.tab-pane.active');
            var group_id = group.attr('group_id');

            $('.td_check [type=checkbox][name=card_id]:checked').each(function () {
                cards.push($(this).val());
            });

            if(cards.length == 0){
                message(0, 'Не выделенно ни одной карты');
            }

            if(!confirm('Удалить ' + cards.length + ' карты?')){
                return false;
            }

            $.post('/control/del-cards-from-group', {group_id: group_id, cards_numbers: cards}, function (data) {
                if (data.success) {
                    message(1, 'Карты удалены');

                    for(var i in cards){
                        $('.card_row[id="'+ cards[i] +'"]', group).remove();
                    }
                } else {
                    message(0, 'Ошибка удаления');
                }
            });
        });
    });

    function deleteCardsGroup(groupId, event)
    {
        event.stopPropagation();

        if(!confirm('Удалить группу карт?')){
            return false;
        }

        $.post('/control/del-cards-group', {groups: [groupId]}, function (data) {

            for(var i in data.data){
                var group = $('[tab="cards_group_'+ groupId +'"]');

                if (data.data[i].deleted) {
                    group.remove();
                } else {
                    message(0, 'Группа <b>'+ group.find('.group_name').text() +'</b> содержит карты');
                }
            }

            if ($('.tabs_cards_groups .nav-link.active').length == 0) {
                $('.tabs_cards_groups .nav-item:not(.before_scroll):first .nav-link').click();
            }

        });

        return false;
    }

    function loadGroupCards(t, force)
    {
        var tab = t.closest('[tab]');
        var tabsBlock = $(".tabs_cards_groups");
        var groupId = tab.attr('tab') ? tab.attr('tab').replace('cards_group_', '') : '';
        var tabContent = $(t.attr('href'), tabsBlock);

        if(tabContent.text() == '' || force == true){
            addLoader(tabContent.parent());

            $.post('/control/load-group-cards/' + groupId, {}, function(data){
                removeLoader(tabContent.parent());
                tabContent.html(data);
                renderVerticalTabsScroll($('.tabs_cards_groups .v-scroll'));
            });
        } else {
            setTimeout(function () {
                renderVerticalTabsScroll($('.tabs_cards_groups .v-scroll'));
            }, 100);
        }
    }

    function showEditCardsGroupPopup(groupId, event)
    {
        event.stopPropagation();

        var block = $('#control_edit_cards_group');

        $('input', block).val('');

        $('[name=edit_cards_group_name]', block).val($('[tab=cards_group_'+ groupId +'] [name=group_name]').val());
        $('[name=edit_cards_group_id]', block).val(groupId);
        $('[name=edit_cards_group_type]', block).val($('[tab=cards_group_'+ groupId +'] [name=group_type]').val());

        block.modal('show');

        return false;
    }

    function groupCardsToXls()
    {
        var group = $(".tabs_cards_groups .nav-link.active").closest('[tab]');

        if (group.length == 0) {
            message(0, 'Нет данный для выгрузки');
            return;
        }

        var group_id = group.attr('tab').replace('cards_group_', '');
        window.open('/control/load-group-cards/?group_id=' + group_id + '&to_xls=1');
    }
</script>