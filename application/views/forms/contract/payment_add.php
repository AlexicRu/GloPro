<div class="modal-body">
    <div class="form form_add_contract_payment">
        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Номер:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="number" name="add_contract_payment_num" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Дата платежного поручения:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="date" name="add_contract_payment_date" class="form-control" maxDate="1" value="<?=date('Y-m-d')?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4"></div>
            <div class="col-sm-8 with-mt">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="add_contract_payment_minus">
                    <span class="custom-control-label">Списание</span>
                </label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Сумма (<?=Text::RUR?>):
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="add_contract_payment_value" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Комментарий:
            </div>
            <div class="col-sm-8 with-mt">
                <textarea name="add_contract_payment_comment" class="form-control"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),addContractPaymentGo)"><i class="fa fa-plus"></i> Добавить платеж</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    $(function () {
        money($('[name=add_contract_payment_value]'));
    });

    function addContractPaymentGo(btn)
    {
        var params = {
            contract_id:    $('[name=contracts_list]').val(),
            num:            $('[name=add_contract_payment_num]').val(),
            date:           $('[name=add_contract_payment_date]').val(),
            value:          getMoney($('[name=add_contract_payment_value]')),
            comment:        $('[name=add_contract_payment_comment]').val(),
            minus:          $('[name=add_contract_payment_minus]').is(':checked') ? 1 : 0
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
            endSubmitForm();

            if(data.success){
                message(1, data.data);
                loadContract('account');
            }else{
                message(0, data.data);
            }
        });
    }
</script>