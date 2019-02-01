<div class="modal-body">
    <div class="popup_list_preview">
        <span class="<?=Text::BTN?> btn-outline-success">Загрузить фирмы</span>
    </div>
    <div class="popup_list"></div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), addGroupFirmsToGroup)"><i class="fa fa-plus"></i> Добавить фирмы</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addGroupFirmsToGroup(btn)
    {
        var block = $('.popup_list');
        var groupId = $('.tabs_firms_groups .nav-link.active [name=group_id]').val();
        var firmsIds = [];

        $('[name=firm_id]:checked', block).each(function () {
            firmsIds.push($(this).val());
        });

        if(firmsIds.length == 0){
            endSubmitForm();
            message(0, 'Не выбрано ни одной фирмы');
            return false;
        }

        $.post('/control/add-firms-to-group', {firms_ids:firmsIds, group_id:groupId}, function (data) {
            endSubmitForm();

            if(data.success){
                message(1, 'Фирмы успешно добавлены');

                var tab = $('.tabs_firms_groups .nav-link.active');

                loadGroupFirms(tab, true);
            }  else {
                message(0, 'Ошибка добавления фирм');
            }

            modalClose();

            setTimeout(function () {
                $('.popup_list').empty().hide();
                $('.popup_list_preview').show();
            }, 500);
        });
    }

    $(function(){
        $('.popup_list_preview .btn').on('click', function () {
            var block = $('.popup_list');

            $('.popup_list_preview').hide();
            block.show();
            addLoader(block);

            var groupId = $('.tabs_firms_groups .nav-link.active [name=group_id]').val();

            $.post('/control/show-firms', { postfix: 'popup_list', show_checkbox: 1, group_id:groupId }, function (data) {
                removeLoader(block);
                block.html(data);
            });
        });
    });
</script>