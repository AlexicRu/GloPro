<div class="modal-body">
    <div class="form form_add_card">
        <div class="form-group row">
            <div class="col-sm-4">
                <span class="text-right hidden-xs-down">Номер карты:</span>
                <span class="hidden-sm-up">Номер карты:</span>
            </div>
            <div class="col-sm-8">
                <?=Form::buildField('card_available_choose_single', 'add_card_id', false, ['classes' => 'input_big'])?>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <span class="text-right hidden-xs-down">Владелец:</span>
                <span class="hidden-sm-up">Владелец:</span>
            </div>
            <div class="col-sm-8">
                <input type="text" name="add_card_holder" class="form-control">
            </div>
        </div>

        <div class="form-group row m-b-0">
            <div class="col-sm-4">
                <span class="text-right hidden-xs-down">Срок действия:</span>
                <span class="hidden-sm-up">Срок действия:</span>
            </div>
            <div class="col-sm-8">
                <input type="date" class="form-control" name="add_card_expire_date">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="btn btn-primary" onclick="submitForm($(this), addCardGo)"><i class="fa fa-plus"></i> Добавить карту</span>
    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
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