<div class="modal-body">
    <div class="form form_add_card">
        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Номер карты:
            </div>
            <div class="col-sm-8 w">
                <?=Form::buildField('card_available_choose_single', 'add_card_id', false, ['classes' => 'input_big'])?>
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

        <div class="form-group row m-b-0">
            <div class="col-sm-4 text-muted form__row__title">
                Срок действия:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="date" class="form-control" name="add_card_expire_date">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),addCardGo)"><i class="fa fa-plus"></i> Добавить карту</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addCardGo()
    {
        var params = {
            contract_id:    $('[name=contracts_list]').val(),
            card_id:        $('[name=add_card_id]').val(),
            holder:         $('[name=add_card_holder]').val(),
            expire_date:    $('[name=add_card_expire_date]').val()
        };

        if(params.card_id == ''){
            message(0, 'Введите номер карты');
            endSubmitForm();
            return false;
        }

        $.post('/clients/card-add', {params:params}, function(data){
            if(data.success){
                message(1, 'Карта успешно добавлена');
                loadContract('cards');
            }else{
                message(0, data.data ? data.data : 'Ошибка добавления карты');
            }
            endSubmitForm();
        });
    }
</script>