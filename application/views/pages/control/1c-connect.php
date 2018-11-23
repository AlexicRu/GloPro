<style>
    .tabs_connect_1c .jsGrid:not(:empty), .tabs_connect_1c .jsGrid.block_loading{
        margin-top: 30px;
    }
</style>

<div class="tabs_connect_1c">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs customtab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tabPayments" role="tab">
                <i class="far fa-download fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Загрузка платежей</span>
            </a>
        </li>
        <?if (Access::allow('control_1c-export')) {?>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabExport" role="tab">
                <i class="far fa-upload fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Выгрузка в 1С</span>
            </a>
        </li>
        <?}?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active bg-white" id="tabPayments" role="tabpanel">
            <div class="p-3 border-bottom">
                <div class="row m-b-0">
                    <div class="col-lg-3 col-md-6 upload_pays_all font-20">Всего строк: <b>0</b></div>
                    <div class="col-lg-3 col-md-6 upload_pays_old font-20">Проведенных: <b>0</b></div>
                    <div class="col-lg-3 col-md-6 upload_pays_new font-20">К загрузке: <b>0</b></div>
                    <div class="col-lg-3 col-md-6 upload_pays_error font-20">Ошибки: <b class="red">0</b></div>
                </div>
            </div>
            <div class="p-3">
                <div class="row m-b-20">
                    <div class="col-xl-4">
                        <small>
                            <i class="gray">- Дата платежа не может быть больше текущей даты</i><br>
                            <i class="gray">- Дата платежа не может быть меньше текущей даты минус 2 месяца</i>
                        </small>
                    </div>
                    <div class="col-xl-4 text-right with-mt">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Формат:
                            </div>
                            <select class="custom-select" name="date_format">
                                <option value="d.m.Y" selected>дд.мм.гггг</option>
                                <option value="Y-m-d">гггг-мм-дд</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4 text-right with-mt">
                        <button disabled onclick="connect1cPayments_addPayments($(this))" class="<?=Text::BTN?> btn-outline-primary load_connect1c_payments_btn">Загрузить выделенные</button>
                    </div>
                </div>

                <div class="connect_1c_payments dropzone"></div>
                <div class="jsGrid connect_1c_payments_jsGrid"></div>
            </div>
        </div>
        <?if (Access::allow('control_1c-export')) {?>
        <div class="tab-pane" id="tabExport" role="tabpanel">
            <div class="p-3 bg-white">
                <? include('1c_connect/1c_export.php') ?>
            </div>
        </div>
        <?}?>
    </div>
</div>

<script>
    var dropzone = false;

    $(function(){
        dropzone = new Dropzone('.connect_1c_payments', {
            url: "/control/upload-pays",
            acceptedFiles: '.txt, .json, .xls, .xlsx, .csv',
            addedfile: function () {
                $('.load_connect1c_payments_btn').prop('disabled', true);

                var grid = $(".connect_1c_payments_jsGrid");

                if ($('.jsgrid-table', grid).length) {
                    grid.jsGrid("destroy");
                }
                addLoader(grid);
            },
            success: function(file, response)
            {
                if(response.data && response.data.rows){
                    connect1cPayments_drawTable(response.data.rows);

                    $('.load_connect1c_payments_btn').prop('disabled', false);
                } else {
                    var grid = $(".connect_1c_payments_jsGrid");
                    removeLoader(grid);
                    grid.html('<div class="text-center"><i class="text-muted">Данные отсутствуют</i></div>');
                }

                if(response.data && response.data.summary){
                    $('.upload_pays_all b').text(response.data.summary.all);
                    $('.upload_pays_new b').text(response.data.summary.new);
                    $('.upload_pays_old b').text(response.data.summary.old);
                    $('.upload_pays_error b').text(response.data.summary.error);
                }
            },
            error : function(file, response) {
                var grid = $(".connect_1c_payments_jsGrid");

                removeLoader(grid);

                message(0, response);
            }
        });

        dropzone.on('sending', function (file, xhr, formData) {
            formData.append('date_format', $('[name=date_format]').val());
        });
    });

    function connect1cPayments_drawTable(rows)
    {
        var grid = $(".connect_1c_payments_jsGrid");
        removeLoader(grid);
        grid.jsGrid({
            width: '100%',
            sorting: true,

            data: rows,

            fields: [
                {
                    headerTemplate: function() {
                        var input = $("<input>")
                            .attr('id', 'connect_check_all')
                            .attr("type", "checkbox")
                            .addClass(CHECKBOX)
                            .prop('checked', true)
                            .on("change", function () {
                                connect1cPayments_toggleSelectedItems($(this));
                            });

                        var tpl = $('<span />');

                        tpl.append(input);
                        tpl.append('<label for="connect_check_all" />');

                        return tpl;
                    },
                    itemTemplate: function(_, item) {
                        if(item.CAN_ADD == 1) {
                            var tpl = $('<span />');

                            var input = $("<input>")
                                .attr('id', 'connect_item_' + item.ORDER_NUM)
                                .addClass(CHECKBOX)
                                .addClass('add_element')
                                .prop("checked", true)
                                .attr("type", "checkbox")
                                .data("contract_id", item.CONTRACT_ID)
                                .data("num", item.ORDER_NUM)
                                .data("date", item.ORDER_DATE)
                                .data("value", item.SUMPAY * (item.OPERATION == 50 ? 1 : -1))
                                .data("comment", item.COMMENT)
                            ;

                            tpl.append(input);
                            tpl.append('<label for="connect_item_' + item.ORDER_NUM + '" />');

                            return tpl;
                        }else{
                            return '';
                        }
                    },
                    sorting: false,
                    align: 'center',
                    width: 40
                },
                { name: "PAYMENT_STATUS", type: "text", title: 'Статус', width:100},
                { name: "OPERATION_NAME", type: "text", title: 'Действие', width:120},
                { name: "CONTRACT_NAME", type: "text", title: 'Договор', width:120},
                { name: "ORDER_DATE", type: "text", title: 'Дата п/п', width:100},
                { name: "PAYMENT_DATE", type: "text", title: 'Дата оплаты', width:120},
                { name: "SUMPAY", type: "number", title: 'Сумма', width:80},
                { name: "DOC_CURRENCY", type: "text", title: 'Валюта', width:80},
                { name: "ORDER_NUM", type: "number", title: 'Номер п/п', width:100},
                { name: "PURPOSE", type: "text", title: 'Описание', width:'auto'},
                { name: "COMMENT", type: "text", title: 'Комментарий', width:250}
            ]
        });
    }

    function connect1cPayments_toggleSelectedItems(btn)
    {
        var tbl = btn.closest('.jsGrid');

        tbl.find('[type=checkbox].add_element').prop('checked', btn.prop('checked')).trigger('change');
    }

    function connect1cPayments_addPayments(btn)
    {
        btn.prop('disabled', true);

        var tbl = $('.connect_1c_payments_jsGrid');
        var payments = [];
        
        tbl.find('.add_element:checked').each(function () {
            var t = $(this);

            payments.push({
                contract_id: t.data('contract_id'),
                num: t.data('num'),
                date: t.data('date'),
                value: t.data('value'),
                comment: t.data('comment')
            });
        });

        $.post('/clients/contract-payment-add', {'multi': 1, payments: payments}, function (data) {
            if(data.success){
                message(1, 'Платежи успешно добавлены');
                $(".connect_1c_result_block").jsGrid("destroy");
            }else{
                message(0, 'Ошибка добавления платежей');
                btn.prop('disabled', false);
            }
        })
    }
</script>