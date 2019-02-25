<div class="modal-body">
    <div class="form form_add_card">
        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Номер карты:
            </div>
            <div class="col-sm-8 w">
                <?= Form::buildField('card_available_choose_multi', 'add_card_ids', false, ['classes' => 'input_big']) ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Карты списком:
                <br>
                <i>
                    <small>Новая карта на новой строке</small>
                </i>
            </div>
            <div class="col-sm-8 with-mt">
                <textarea class="form-control" name="add_card_list" placeholder="Ввести список карт"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Владелец:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="add_card_holder" class="form-control">
            </div>
        </div>

        <div class="form-group row mb-0 row-last">
            <div class="col-sm-4 text-muted form__row__title">
                Срок действия:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="date" class="form-control" name="add_card_expire_date">
            </div>
        </div>

        <div class="form-group row mb-0 row-result dn">
            <div class="col-sm-4 text-muted form__row__title">
                Результат добавления:
            </div>
            <div class="col-sm-8 with-mt">
                <div class="result"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?= Text::BTN ?> btn-primary" onclick="submitForm($(this), addCardGo)"><i class="fa fa-plus"></i> Добавить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addCardGo(btn)
    {
        var modal = btn.closest('.modal');

        $('.row-last', modal).addClass('mb-0');
        $('.row-result', modal).addClass('dn').find('.result').empty();

        var params = {
            contract_id:    $('[name=contracts_list]').val(),
            cards: getComboBoxMultiValue($('[name=add_card_ids]')),
            cards_list: $('[name=add_card_list]').val(),
            holder:         $('[name=add_card_holder]').val(),
            expire_date:    $('[name=add_card_expire_date]').val()
        };

        if (params.cards.length == 0 && params.cards_list == '') {
            message(0, 'Выберите карты для добавления');
            endSubmitForm();
            return false;
        }

        $.post('/clients/cards-add', {params: params}, function (data) {
            endSubmitForm();

            if(data.success){
                message(1, 'Карты успешно добавлены');
                loadContract('cards');
            }else{
                $('.row-last', modal).removeClass('mb-0');
                $('.row-result', modal).removeClass('dn');

                message(0, 'Ошибка добавления карт');

                for (var i in data.data) {
                    var tpl = $('<div class="row"><div class="col-sm-5"><b>' + data.data[i].card + '</b></div><div class="col-sm-7 with-mt text-danger">' + data.data[i].error + '</div></div>');

                    tpl.appendTo(modal.find('.result'));
                }
            }
        });
    }
</script>