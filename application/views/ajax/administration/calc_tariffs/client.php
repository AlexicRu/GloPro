<div class="border-bottom m-b-20 client_row can_delete">
    <div>
        <b class="font-20">Клиент</b>

        <div class="float-right">
            <span class="<?=Text::BTN?> btn-sm btn-outline-danger ts_remove" onclick="deleteRow($(this))"><i class="fa fa-times"></i></span>
        </div>
    </div>

    <div class="form-group row m-b-0">
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-sm-4 text-muted form__row__title">
                    Договор:
                </div>
                <div class="col-sm-8">
                    <?=Form::buildField('contract_choose_single', 'contract_' . $iteration, false, [
                        'depend_on' => ['name' => 'client_' . $iteration],
                        'onSelect' => 'findTariffByContract'
                    ])?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-sm-4 text-muted form__row__title">
                    Тариф по договору:
                </div>
                <div class="col-sm-8 with-mt">
                    <span class="current_tariff"></span>

                    <span class="badges m-l-10">
                        <span class="calc_tariffs_client_ok badge badge-success dn"><i class="fa fa-check"></i> Ok</span>
                        <span class="calc_tariffs_client_go badge badge-info dn">... Расчет</span>
                        <span class="calc_tariffs_client_error badge badge-danger dn">Ошибка</span>
                    </span>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4 text-muted form__row__title">
                    Период:
                </div>
                <div class="col-sm-8 with-mt">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <input type="date" name="date_start_<?=$iteration?>" class="form-control" value="<?=date('Y-m-01')?>">
                        </div>
                        <span class="input-group-text">-</span>
                        <div class="input-group-append">
                            <input type="date" name="date_end_<?=$iteration?>" class="form-control" value="<?=date('Y-m-d')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function findTariffByContract(contractId)
    {
        var row = $('[value=' + contractId + ']').closest('.client_row');

        $.post('/administration/get-tariff-by-contract', {contract_id: contractId}, function (data) {
            if (data.success) {
                row.find('.current_tariff').text(data.data.name);
            } else {
                message(0, 'Тариф не найден. Договор: ' +
                    $('[value=' + contractId + ']').closest('.form_field').find('[type=text]').val()
                );
            }
        });
    }
</script>