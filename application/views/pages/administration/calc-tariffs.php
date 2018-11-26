<div class="tabs_administration_calc_tariffs">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs customtab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tabClient" role="tab">
                <i class="far fa-clipboard fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Тариф клиента</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabClose" role="tab">
                <i class="far fa-clipboard-check fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Закрытие периода</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabQueue" role="tab" onclick="loadQueueCalc()">
                <i class="far fa-clipboard-list-check fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Очередь расчета</span>
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content p-20 bg-white">
        <div class="tab-pane active" id="tabClient" role="tabpanel">
            <div class="calc_tariffs_client_block t_sections_list"></div>

            <div class="<?=Text::BTN?> btn-outline-primary" onclick="addCalcTariffsClient()"><i class="fa fa-plus"></i> Добавить клиента</div>

            <div class="p-t-20 m-t-20 border-top">
                <div class="<?=Text::BTN?> btn-success" onclick="calcTariffsGo()"><i class="fa fa-check"></i> Рассчитать</div>
            </div>
            <br>
            <i class="text-muted">
                * - дата начала и дата окончания расчета тарифа не старше чем 3 месяца от текущей даты. Для расчета тарифа за более ранний период сделайте запрос через <a href="/support">Поддержку</a>
            </i>
        </div>
        <div class="tab-pane" id="tabClose" role="tabpanel">
            <?
            include __DIR__ . '/calc_tariffs/close.php';
            ?>
            <br>
            <table>
                <tr>
                    <td class="right gray">
                        Закрыть период на дату:
                    </td>
                    <td>
                        <input type="date" name="close_by_day" class="form-control">
                    </td>
                    <td>
                        <span class="<?=Text::BTN?> btn-primary">Запуск</span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="tab-pane" id="tabQueue" role="tabpanel">
            <div class="calc_queue"></div>
        </div>
    </div>
</div>

<script>
    $(function () {
        addCalcTariffsClient();
    });

    function addCalcTariffsClient()
    {
        var block = $('.calc_tariffs_client_block');

        var params = {
            iteration: block.find('.client_row').length + 1
        };

        $.post('/administration/calc-tariffs-render-client', params, function (data) {
            block.append(data)
        });
    }

    function loadQueueCalc()
    {
        var block = $('.calc_queue');

        addLoader(block);

        $.post('/administration/load-calc-queue', {}, function (data) {
            removeLoader(block);
            block.html(data);
        })
    }

    var contractsInAction = [];

    function calcTariffsGo()
    {
        var block = $('.calc_tariffs_client_block');

        var flEmpty = true;

        block.find('.client_row').each(function () {
            var t = $(this);

            if (t.find('.btns .btn:visible').length == 0) {

                var contractId = getComboBoxValue(t.find('[name^=contract_]'));

                if (contractId) {
                    if (contractsInAction.indexOf(contractId) == -1) {
                        contractsInAction.push(contractId);
                        flEmpty = false;
                        calcTariff(t);
                    } else {
                        message(0, 'По одному договору нельзя запустить несколько расчетов.<br>Договор: '
                            + $('[value=' + contractId + ']').closest('.form_field').find('[type=text]').val()
                        );
                        t.find('.btns .calc_tariffs_client_error').show();
                    }
                }
            }
            block.find('input[type=text]').prop('disabled', true);
        });

        if (flEmpty) {
            message(0, 'Нет данных для расчета');
        }

        setTimeout(function () {
            loadQueueCalc();
        }, 1000);
    }

    function calcTariff(block)
    {
        var params = {
            client_id:   getComboBoxValue(block.find('[name^=client_]')),
            contract_id: getComboBoxValue(block.find('[name^=contract_]')),
            start:       block.find('[name^=date_start_]').val(),
            end:         block.find('[name^=date_end_]').val(),
        };

        if (!params.contract_id) {
            message(0, 'Во всех клиентах должны быть выбраны договоры');
            return false;
        }

        if (!params.start || !params.end) {
            message(0, 'Для договора: "'+ $('[value='+ params.contract_id +']').closest('.form_field').find('[type=text]').val() +'" необходимо заполнить даты');
            return false;
        }

        block.find('.badges .badge').hide();
        block.find('.badges .calc_tariffs_client_go').show();

        $.post('/administration/calc-tariff', params, function (data) {
            block.find('.badges .badge').hide();
            if (data.success) {
                block.find('.badges .calc_tariffs_client_ok').show();
            } else {
                block.find('.badges .calc_tariffs_client_error').show();
            }
        });
    }
</script>