<div class="card border-bottom m-b-0">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <form class="input-group form_dots_groups" onsubmit="return collectForms($(this), 'form_dots_groups')">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" name="filter[search]" class="form-control input_messages" placeholder="Поиск..." value="<?=(!empty($filter['search']) ? $filter['search'] : '')?>">
                </form>
            </div>
            <div class="col-sm-8 text-right with-mb">
                <span toggle_block="dots_groups_block">
                    <a href="#" data-toggle="modal" data-target="#control_add_dots_group" class="<?=Text::BTN?> btn-outline-primary m-b-5"><i class="fa fa-plus"></i> Добавить группу</a>
                    <a href="#" data-toggle="modal" data-target="#control_add_dots" class="<?=Text::BTN?> btn-outline-primary m-b-5"><i class="fa fa-plus"></i> Добавить точки</a>
                    <span class="<?=Text::BTN?> btn-outline-success m-b-5" onclick="groupDotsToXls()"><i class="fa fa-file-excel"></i> Выгрузить</span>
                    <span class="<?=Text::BTN?> btn-outline-success m-b-5" toggle="dots_groups_block"><i class="fa fa-pencil-alt"></i></span>
                </span>

                <span toggle_block="dots_groups_block" class="dn action_del">
                    <a href="#" class="<?=Text::BTN?> btn-outline-danger btn_del_dots m-b-5"><i class="fa fa-trash-alt"></i> Удалить выделенные точки</a>
                    <span class="<?=Text::BTN?> btn-outline-warning m-b-5" toggle="dots_groups_block"><i class="fa fa-times"></i></span>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card-body border-bottom d-lg-none bg-white">
    <div class="row">
        <div class="col-12">
            <span class="btn btn-info" toggle_class="dots_groups_list">
                <i class="fa fa-bars"></i> Группы точек
            </span>
        </div>
    </div>
</div>

<div class="vtabs customvtab tabs_dots_groups bg-white tabs-floating">
    <ul class="nav nav-tabs tabs-vertical p-t-10" role="tablist" toggle_block="dots_groups_list">
        <li class="nav-item no_content before_scroll">
            <form class="p-r-10 p-l-10 p-b-10 border-bottom m-b-10 form_groups_dots" onsubmit="return collectForms($(this), 'form_groups_dots')">
                <?foreach(Model_Dot::$groupsTypesNames as $groupsType => $groupsTypesName){?>
                    <div class="m-b-5">
                        <input type="checkbox" name="filter[group_type][]" value="<?=$groupsType?>"
                            <?=(!empty($filter['group_type']) && in_array($groupsType, $filter['group_type']) ? 'checked' : '')?>
                            id="group_type_<?=$groupsType?>"
                            class="<?=Text::CHECKBOX?>"
                        >
                        <label for="group_type_<?=$groupsType?>" class="font-14">
                            <?=$groupsTypesName?>
                        </label>
                    </div>
                <?}?>

                <button class="<?=Text::BTN?> btn-outline-primary btn-sm">Применить</button>
            </form>
        </li>

        <div class="v-scroll">
            <?if(empty($dotsGroups)){?>
                <li class="nav-item">
                <span class="nav-link text-muted">
                    Группы не найдены
                </span>
                </li>
            <?}else{?>
                <?foreach($dotsGroups as $key => $group){?>
                    <li class="nav-item" tab="dots_group_<?=$group['GROUP_ID']?>">
                        <a class="nav-link nowrap" data-toggle="tab" href="#dots_group_<?=$group['GROUP_ID']?>" role="tab">
                        <span class="check_span_hidden">
                            <input type="hidden" name="group_id" value="<?=$group['GROUP_ID']?>">
                            <input type="hidden" name="group_name" value="<?=$group['GROUP_NAME']?>">
                            <input type="hidden" name="group_type" value="<?=$group['GROUP_TYPE']?>">

                            <span class="<?=Text::BTN?> btn-outline-danger btn-sm" onclick="deleteDotsGroup(<?=$group['GROUP_ID']?>, event)"><i class="fa fa-trash-alt"></i></span>
                            <span class="<?=Text::BTN?> btn-outline-success btn-sm" onclick="showEditDotsGroupPopup(<?=$group['GROUP_ID']?>, event)"><i class="fa fa-pencil-alt"></i></span>
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
        <?if(!empty($dotsGroups)){?>
            <?foreach($dotsGroups as $key => $group){?>
                <div class="tab-pane" id="dots_group_<?=$group['GROUP_ID']?>" group_id="<?=$group['GROUP_ID']?>" role="tabpanel"></div>
            <?}?>
        <?}?>
    </div>
</div>

<?=$popupAddDots?>
<?=$popupAddDotsGroup?>
<?=$popupEditDotsGroup?>

<script>
    $(function(){
        //renderVerticalTabsScroll($('.tabs_dots_groups .v-scroll'));
        $('.tabs_dots_groups :not(.before_scroll) .nav-link').on('click', function(){
            var t = $(this);

            loadGroupDots(t);

            //костыль.. так как вложенность табов не сохраняется из-за постраничности
            $('.tabs_dots_groups > .nav-tabs .nav-link.active').not(t).removeClass('active show');
        });

        $('.tabs_dots_groups .nav-item:not(.before_scroll):first .nav-link').click();

        $("[toggle=dots_groups_block]").on('click', function(){
            $('.check_span_hidden, .td_check, .td_edit').toggle();
        });

        $('.btn_del_dots').on('click', function () {
            var dots = [];
            var group = $('.tab-pane.active');
            var group_id = group.attr('group_id');

            $('.td_check [type=checkbox][name=pos_id]:checked').each(function () {
                dots.push($(this).val());
            });

            if(dots.length == 0){
                message(0, 'Не выделенно ни одной точки');
            }

            if(!confirm('Удалить ' + dots.length + ' точки?')){
                return false;
            }

            $.post('/control/del-dots-from-group', {group_id: group_id, dots_numbers: dots}, function (data) {
                if (data.success) {
                    message(1, 'Точки удалены');

                    for(var i in dots){
                        $('.dot_row[id="'+ dots[i] +'"]', group).remove();
                    }
                } else {
                    message(0, 'Ошибка удаления');
                }
            });
        });
    });

    function deleteDotsGroup(groupId, event)
    {
        event.stopPropagation();

        if(!confirm('Удалить группу точек?')){
            return false;
        }

        $.post('/control/del-dots-group', {groups: [groupId]}, function (data) {

            for(var i in data.data){
                var group = $('[tab="dots_group_'+ groupId +'"]');

                if (data.data[i].deleted) {
                    group.remove();
                } else {
                    message(0, 'Группа <b>'+ group.find('.group_name').text() +'</b> содержит точки');
                }
            }

            if ($('.tabs_dots_groups .nav-link.active').length == 0) {
                $('.tabs_dots_groups .nav-item:not(.before_scroll):first .nav-link').click();
            }

        });

        return false;
    }

    function loadGroupDots(t, force)
    {
        var tab = t.closest('[tab]');
        var tabsBlock = $(".tabs_dots_groups");
        var groupId = tab.attr('tab') ? tab.attr('tab').replace('dots_group_', '') : '';
        var tabContent = $(t.attr('href'), tabsBlock);

        if(tabContent.text() == '' || force == true){
            addLoader(tabContent.parent());

            $.post('/control/load-group-dots/' + groupId, {}, function(data){
                removeLoader(tabContent.parent());
                tabContent.html(data);
                renderVerticalTabsScroll($('.tabs_dots_groups .v-scroll'));
            });
        } else {
            setTimeout(function () {
                renderVerticalTabsScroll($('.tabs_dots_groups .v-scroll'));
            }, 100);
        }
    }

    function showEditDotsGroupPopup(groupId, event)
    {
        event.stopPropagation();

        var block = $('#control_edit_dots_group');

        $('input', block).val('');

        $('[name=edit_dots_group_name]', block).val($('[tab=dots_group_'+ groupId +'] [name=group_name]').val());
        $('[name=edit_dots_group_id]', block).val(groupId);
        $('[name=edit_dots_group_type]', block).val($('[tab=dots_group_'+ groupId +'] [name=group_type]').val());

        block.modal('show');

        return false;
    }

    function groupDotsToXls()
    {
        var group = $(".tabs_dots_groups .nav-link.active").closest('[tab]');

        if (group.length == 0) {
            message(0, 'Нет данный для выгрузки');
            return;
        }

        var group_id = group.attr('tab').replace('dots_group_', '');
        window.open('/control/load-group-dots/?group_id=' + group_id + '&to_xls=1');
    }
</script>