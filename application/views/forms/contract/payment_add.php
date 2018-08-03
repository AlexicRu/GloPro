<div class="modal-body">
    <div class="form form_add_contract_payment">
        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Номер:</div>
                <span class="hidden-sm-up">Номер:</span>
            </div>
            <div class="col-sm-8">
                <input type="number" name="add_contract_payment_num" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Дата платежного поручения:</div>
                <span class="hidden-sm-up">Дата платежного поручения:</span>
            </div>
            <div class="col-sm-8">
                <input type="date" name="add_contract_payment_date" class="form-control" maxDate="1" value="<?=date('Y-m-d')?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Сумма (<?=Text::RUR?>):</div>
                <span class="hidden-sm-up">Сумма (<?=Text::RUR?>):</span>
            </div>
            <div class="col-sm-8">
                <input type="number" name="add_contract_payment_value" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Комментарий:</div>
                <span class="hidden-sm-up">Комментарий:</span>
            </div>
            <div class="col-sm-8">
                <textarea name="add_contract_payment_comment" class="form-control"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),addContractPaymentGo)"><i class="fa fa-plus"></i> Добавить платеж</span>
    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addContractPaymentGo(btn)
    {
        var params = {
            contract_id:    $('[name=contracts_list]').val(),
            num:            $('[name=add_contract_payment_num]').val(),
            date:           $('[name=add_contract_payment_date]').val(),
            value:          $('[name=add_contract_payment_value]').val(),
            comment:        $('[name=add_contract_payment_comment]').val()
        };

        if(params.num == ''){
            message(0, 'Введите номер');
            endSubmitForm();
            return false;
        }

        if(params.date == ''){
            message(0, 'Введите дату');
            endSubmitForm();
            return false;
        }

        if(params.value == ''){
            message(0, 'Введите сумму');
            endSubmitForm();
            return false;
        }

        $.post('/clients/contract-payment-add', {params:params}, function(data){
            if(data.success){
                message(1, data.data);
                loadContract('account');
            }else{
                message(0, data.data);
            }
            endSubmitForm();
        });
    }
</script>