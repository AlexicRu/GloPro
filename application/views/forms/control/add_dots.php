<div class="modal-body">
    <div class="popup_list_preview">
        <span class="<?=Text::BTN?> btn-outline-success">Загрузить точки</span>
    </div>
    <div class="popup_list"></div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), addGroupDotsToGroup)"><i class="fa fa-plus"></i> Добавить точки</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addGroupDotsToGroup(btn)
    {
        var block = $('.popup_list');
        var groupId = $('.tabs_dots_groups .tab_v.active [name=group_id]').val();
        var dotsIds = [];

        $('[name=pos_id]:checked', block).each(function () {
            dotsIds.push($(this).val());
        });

        if(dotsIds.length == 0){
            endSubmitForm();
            message(0, 'Не выбрано ни одной карты');
            return false;
        }

        $.post('/control/add-dots-to-group', {dots_ids:dotsIds, group_id:groupId}, function (data) {
            endSubmitForm();
            if(data.success){
                message(1, 'Карты успешно добавлены');

                var tab = $('.tabs_dots_groups .tab_v.active');

                loadGroupDots(tab, true);
            }  else {
                message(0, 'Ошибка добавления карт');
            }
            $('.pre_fancy_close').click();
        });
    }

    $(function(){
        $('.pre_fancy_close').on('click', function () {
            modalClose();
            setTimeout(function () {
                $('.popup_list').empty().hide();
                $('.popup_list_preview').show();
            }, 500);
        });

        $('.popup_list_preview .btn').on('click', function () {
            var block = $('.popup_list');

            $('.popup_list_preview').hide();
            block.show();
            addLoader(block);

            var groupId = $('.tabs_dots_groups .nav-link.active [name=group_id]').val();

            $.post('/control/show-dots', { postfix: 'popup_list', show_checkbox: 1, group_id:groupId }, function (data) {
                removeLoader(block);
                block.html(data);
            });
        });
    });
</script>