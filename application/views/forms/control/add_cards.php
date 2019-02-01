<div class="modal-body">
    <div class="popup_list_preview">
        <span class="<?=Text::BTN?> btn-outline-success">Загрузить карты</span>
    </div>
    <div class="popup_list"></div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), addGroupCardsToGroup)"><i class="fa fa-plus"></i> Добавить карты</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addGroupCardsToGroup(btn)
    {
        var block = $('.popup_list');
        var groupId = $('.tabs_cards_groups .nav-link.active [name=group_id]').val();
        var cardsIds = [];

        $('[name=card_id]:checked', block).each(function () {
            cardsIds.push($(this).val());
        });

        if(cardsIds.length == 0){
            endSubmitForm();
            message(0, 'Не выбрано ни одной карты');
            return false;
        }

        $.post('/control/add-cards-to-group', {cards_ids:cardsIds, group_id:groupId}, function (data) {
            endSubmitForm();

            if(data.success){
                message(1, 'Карты успешно добавлены');

                var tab = $('.tabs_cards_groups .nav-link.active');

                loadGroupCards(tab, true);
            }  else {
                message(0, 'Ошибка добавления карт');
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

            var groupId = $('.tabs_cards_groups .nav-link.active [name=group_id]').val();

            $.post('/control/show-cards', { postfix: 'popup_list', show_checkbox: 1, group_id:groupId }, function (data) {
                removeLoader(block);
                block.html(data);
            });
        });
    });
</script>