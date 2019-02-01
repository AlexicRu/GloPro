<div class="modal-body">

    <div class="form form_contract_increase_limit">
        <div class="form-group row m-b-0">
            <div class="col-sm-4 text-muted form__row__title">
                Количество:
            </div>
            <div class="col-sm-8 with-mt">
                <div class="input-group">
                    <input type="text" name="contract_increase_limit_name" class="form-control">

                    <div class="input-group-append">
                        <span class="input-group-text">
                            <span class="fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" data-original-title="Значение со знаком минус уменьшит лимит"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), contractIncreaseLimit)"><i class="fa fa-check"></i> Сохранить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    function contractIncreaseLimit()
    {
        var params = {
            limit_id:       increaseLimitId,
            amount:         $('[name=contract_increase_limit_name]').val()
        };

        if(params.amount == ''){
            message(0, 'Введите корректное количество');
            endSubmitForm();
            return false;
        }

        $.post('/clients/contract-increase-limit', params, function(data){
            endSubmitForm();

            if (data.success) {
                message(1, 'Лимит успешно изменен');
                loadContract('account');
            } else {
                message(0, 'Ошибка изменения лимита');
            }
        });
    }
</script>