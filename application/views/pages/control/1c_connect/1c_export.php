<style>
    .client_contract_elem{
        display: inline-block; vertical-align: top; margin: 0 10px 30px 0; position: relative; padding: 0 40px 0 0;
    }
    .client_contract_elem .ts_remove{
        top:0; right: 0;
    }
</style>

<div class="export_1c">
    <div class="row m-b-20">
        <div class="col-sm-2 text-muted form__row__title">
            Период:
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">от</span></div>
                        <input type="date" name="date_from" class="form-control">
                    </div>
                </div>
                <div class="col-md-6 with-mt">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">до</span></div>
                        <input type="date" name="date_to" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-b-20">
        <div class="col-sm-2 text-muted form__row__title">
            Клиент,<br class="hidden-sm-down">
            Договор:
        </div>
        <div class="col-sm-10">
            <div class="client_contracts_list"></div>
            <button class="<?=Text::BTN?> btn-sm btn-outline-primary" onclick="renderNewClientForm()"><i class="fa fa-plus"></i> Добавить клиента</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <button class="<?=Text::BTN?> btn-success btn_manager_settings_go" onclick="export1c()"><i class="fa fa-file-excel"></i> Выгрузить</button>
        </div>
    </div>
</div>

<script>
    function renderNewClientForm()
    {
        var block = $('.client_contracts_list');

        var iteration = $('.client_contract_elem', block).length + 1;

        $.get('/control/client-contract-form?iteration=' + iteration, function (data) {
            block.append(data);
        });
    }

    function export1c()
    {
        var block = $('.export_1c');

        var params = {
            date_from: $('[name=date_from]', block).val(),
            date_to: $('[name=date_to]', block).val(),
            contracts: []
        };

        if (!params.date_from || !params.date_to) {
            message(0, 'Выберите даты');
            return;
        }

        $('.client_contracts_list .client_contract_elem', block).each(function () {
            var t = $(this);
            var field = $('[name^=client_contract]', t);

            var values = getComboBoxMultiValue(field);

            if (values.length) {
                for (var i in values) {
                    params.contracts.push(values[i]);
                }
            }
        });

        window.open('/control/1c-export?' + $.param(params));
    }
</script>