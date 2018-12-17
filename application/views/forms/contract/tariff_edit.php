<div class="modal-body">
    <div class="form form_contract_tariff_edit">
        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Тариф:
            </div>
            <div class="col-sm-8 with-mt">
                <?=Form::buildField('contract_tariffs', 'TARIF_OFFLINE', $tariffId)?>
            </div>
        </div>

        <div class="form-group row m-b-0">
            <div class="col-sm-4 text-muted form__row__title">
                Дата начала действия тарифа:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="date" class="form-control" name="contract_tariff_edit_date" min="<?=(!empty($contractDateBegin) ? Date::formatToDefault($contractDateBegin) : date('Y-m-01', strtotime("first day of previous month")))?>">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),contractTariffEditGo)"><i class="fa fa-check"></i> Сохранить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function contractTariffEditGo(t)
    {
        var form = t.closest('.modal.show');
        var params = {
            contract_id : $('[name=contracts_list]').val(),
            tariff_id : getComboBoxValue($('[name=TARIF_OFFLINE]', form)),
            date_from : $('[name=contract_tariff_edit_date]', form).val(),
        };

        if(params.date == false){
            message(0, 'Заполните дату');
            endSubmitForm();
            return;
        }

        $.post('/clients/contract-tariff-edit', params, function (data) {
            endSubmitForm();
            if (data.success) {
                message(1, 'Тариф успешно обновлен');

                loadContract('contract');
            } else {
                message(0, 'Ошибка обновления тарифа');
            }
        });
    }
</script>