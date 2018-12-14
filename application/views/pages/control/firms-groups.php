<div class="card border-bottom m-b-0">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <form class="input-group form_firms_groups" onsubmit="return collectForms($(this), 'form_firms_groups')">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" name="filter[search]" class="form-control input_messages" placeholder="Поиск..." value="<?=(!empty($filter['search']) ? $filter['search'] : '')?>">
                </form>
            </div>
            <div class="col-sm-8 text-right with-mt">
                <span toggle_block="firms_groups_block">
                    <a href="#" data-toggle="modal" data-target="#control_add_firms_group" class="<?=Text::BTN?> btn-outline-primary m-b-5"><i class="fa fa-plus"></i> Добавить группу</a>
                    <a href="#" data-toggle="modal" data-target="#control_add_firms" class="<?=Text::BTN?> btn-outline-primary m-b-5"><i class="fa fa-plus"></i> Добавить фирмы</a>
                    <span class="<?=Text::BTN?> btn-success m-b-5" onclick="groupFirmsToXls()"><i class="fa fa-file-excel"></i> Выгрузить</span>
                    <span class="<?=Text::BTN?> btn-outline-primary m-b-5" toggle="firms_groups_block"><i class="fa fa-pen"></i></span>
                </span>

                <span toggle_block="firms_groups_block" class="dn action_del">
                    <span class="<?=Text::BTN?> btn-danger btn_del_firms m-b-5"><i class="fa fa-trash-alt"></i> Удалить выделенные фирмы</span>
                    <span class="<?=Text::BTN?> btn-danger m-b-5" toggle="firms_groups_block"><i class="fa fa-times"></i></span>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card-body border-bottom d-lg-none bg-white">
    <div class="row">
        <div class="col-12">
            <span class="<?=Text::BTN?> btn-outline-info" toggle_class="firms_groups_list">
                <i class="fa fa-bars"></i> Группы фирм
            </span>
        </div>
    </div>
</div>

<div class="vtabs customvtab tabs_firms_groups bg-white tabs-floating">
    <ul class="nav nav-tabs tabs-vertical bg-light p-t-10" role="tablist" toggle_block="firms_groups_list">
        <div class="v-scroll">
            <?if(empty($firmsGroups)){?>
                <li class="nav-item">
                <span class="nav-link text-muted">
                    Группы не найдены
                </span>
                </li>
            <?}else{?>
                <?foreach($firmsGroups as $key => $group){?>
                    <li class="nav-item" tab="firms_group_<?=$group['GROUP_ID']?>">
                        <a class="nav-link" data-toggle="tab" href="#firms_group_<?=$group['GROUP_ID']?>" role="tab">
                        <span class="check_span_hidden">
                            <input type="hidden" name="group_id" value="<?=$group['GROUP_ID']?>">
                            <input type="hidden" name="group_name" value="<?=$group['GROUP_NAME']?>">
                            <input type="hidden" name="group_type" value="<?=$group['GROUP_TYPE']?>">

                            <span class="<?=Text::BTN?> btn-danger btn-sm" onclick="deleteFirmsGroup(<?=$group['GROUP_ID']?>, event)"><i class="fa fa-trash-alt"></i></span>
                            <span class="<?=Text::BTN?> btn-outline-primary btn-sm" onclick="showEditFirmsGroupPopup(<?=$group['GROUP_ID']?>, event)"><i class="fa fa-pen"></i></span>
                        </span>

                            <span class="group_name"><?=$group['GROUP_NAME']?></span>
                            <span class="text-muted float-right">[<?=$group['GROUP_ID']?>]</span>
                        </a>
                    </li>
                <?}?>
            <?}?>
        </div>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content p-0">
        <?if(!empty($firmsGroups)){?>
            <?foreach($firmsGroups as $key => $group){?>
                <div class="tab-pane" id="firms_group_<?=$group['GROUP_ID']?>" group_id="<?=$group['GROUP_ID']?>" role="tabpanel"></div>
            <?}?>
        <?}?>
    </div>
</div>

<?=$popupAddFirms?>
<?=$popupAddFirmsGroup?>
<?=$popupEditFirmsGroup?>

<script>
    $(function(){
        //renderVerticalTabsScroll($('.tabs_firms_groups .v-scroll'));
        $('.tabs_firms_groups :not(.before_scroll) .nav-link').on('click', function(){
            var t = $(this);

            loadGroupFirms(t);

            //костыль.. так как вложенность табов не сохраняется из-за постраничности
            $('.tabs_firms_groups > .nav-tabs .nav-link.active').not(t).removeClass('active show');
        });

        $('.tabs_firms_groups .nav-item:not(.before_scroll):first .nav-link').click();

        $("[toggle=firms_groups_block]").on('click', function(){
            $('.check_span_hidden, .td_check, .td_edit').toggle();
        });

        $('.btn_del_firms').on('click', function () {
            var firms = [];
            var group = $('.tab-pane.active');
            var group_id = group.attr('group_id');

            $('.td_check [type=checkbox][name=firm_id]:checked', group).each(function () {
                firms.push($(this).val());
            });

            if(firms.length == 0){
                message(0, 'Не выделенно ни одной фирмы');
            }

            if(!confirm('Удалить ' + firms.length + ' фирмы?')){
                return false;
            }

            $.post('/control/del-firms-from-group', {group_id: group_id, firms_numbers: firms}, function (data) {
                if (data.success) {
                    message(1, 'Фирмы удалены');

                    for(var i in firms){
                        $('.firm_row[id="'+ firms[i] +'"]', group).remove();
                    }
                } else {
                    message(0, 'Ошибка удаления');
                }
            });
        });
    });

    function deleteFirmsGroup(groupId, event)
    {
        event.stopPropagation();

        if(!confirm('Удалить группу фирм?')){
            return false;
        }

        $.post('/control/del-firms-group', {groups: [groupId]}, function (data) {

            for(var i in data.data){
                var group = $('[tab="firms_group_'+ groupId +'"]');

                if (data.data[i].deleted) {
                    group.remove();
                } else {
                    message(0, 'Группа <b>'+ group.find('.group_name').text() +'</b> содержит фирмы');
                }
            }

            if ($('.tabs_firms_groups .nav-link.active').length == 0) {
                $('.tabs_firms_groups .nav-item:not(.before_scroll):first .nav-link').click();
            }

        });

        return false;
    }

    function loadGroupFirms(t, force)
    {
        var tab = t.closest('[tab]');
        var tabsBlock = $(".tabs_firms_groups");
        var groupId = tab.attr('tab') ? tab.attr('tab').replace('firms_group_', '') : '';
        var tabContent = $(t.attr('href'), tabsBlock);

        if(tabContent.text() == '' || force == true){
            addLoader(tabContent.parent());

            $.post('/control/load-group-firms/' + groupId, {}, function(data){
                removeLoader(tabContent.parent());
                tabContent.html(data);
                renderVerticalTabsScroll($('.tabs_firms_groups .v-scroll'));
            });
        } else {
            setTimeout(function () {
                renderVerticalTabsScroll($('.tabs_firms_groups .v-scroll'));
            }, 100);
        }
    }

    function showEditFirmsGroupPopup(groupId, event)
    {
        event.stopPropagation();

        var block = $('#control_edit_firms_group');

        $('input', block).val('');

        $('[name=edit_firms_group_name]', block).val($('[tab=firms_group_'+ groupId +'] [name=group_name]').val());
        $('[name=edit_firms_group_id]', block).val(groupId);
        $('[name=edit_firms_group_type]', block).val($('[tab=firms_group_'+ groupId +'] [name=group_type]').val());

        block.modal('show');

        return false;
    }

    function groupFirmsToXls()
    {
        var group = $(".tabs_firms_groups .nav-link.active").closest('[tab]');

        if (group.length == 0) {
            message(0, 'Нет данный для выгрузки');
            return;
        }

        var group_id = group.attr('tab').replace('firms_group_', '');
        window.open('/control/load-group-firms/?group_id=' + group_id + '&to_xls=1');
    }
</script>