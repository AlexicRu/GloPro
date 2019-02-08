<style>
    .jsGrid:not(:empty), .jsGrid.block_loading {
        margin-top: 30px;
    }
</style>

<div class="block p-3 bg-white">
    <div class="row m-b-20">
        <div class="col-xl-3 col-md-4 col-sm-6">
            <div class="upload_pays_all font-20">Всего строк: <b>0</b></div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 with-mt">
            <div class="upload_pays_new font-20">Загружено: <b>0</b></div>
        </div>
        <div class="col-xl-6 col-md-4 text-right with-mt">
            <button disabled onclick="connect1cPayments_addPayments($(this))"
                    class="<?= Text::BTN ?> btn-primary load_connect1c_payments_btn">Загрузить выделенные
            </button>
        </div>
    </div>

    <div class="bank_statement dropzone"></div>
    <div class="jsGrid bank_statement_jsGrid"></div>
</div>


<script>
    var dropzone = false;

    $(function () {
        dropzone = new Dropzone('.bank_statement', {
            url: "/control/upload-bank-statement",
            acceptedFiles: '.txt',
            addedfile: function () {
                var grid = $(".bank_statement_jsGrid");

                if ($('.jsgrid-table', grid).length) {
                    grid.jsGrid("destroy");
                }
                addLoader(grid);
            },
            success: function (file, response) {
                if (response.data && response.data.rows) {
                    bankStatement_drawTable(response.data.rows);
                    $('.upload_pays_all b').text(response.data.rows.length);
                    $('.upload_pays_new b').text(0);
                } else {
                    var grid = $(".bank_statement_jsGrid");
                    removeLoader(grid);
                    grid.html('<div class="text-center"><i class="text-muted">Данные отсутствуют</i></div>');
                }
            },
            error: function (file, response) {
                var grid = $(".bank_statement_jsGrid");

                removeLoader(grid);

                message(0, response);
            }
        });
    });

    function bankStatement_drawTable(rows) {
        var grid = $(".bank_statement_jsGrid");
        removeLoader(grid);
        grid.jsGrid({
            width: '100%',
            sorting: true,

            data: rows,

            fields: [
                {
                    headerTemplate: function () {
                        return $('<label class="custom-control custom-checkbox">' +
                            '<input type="checkbox" class="custom-control-input" checked onchange="bankStatement_toggleSelectedItems($(this))">' +
                            '<span class="custom-control-label"></span>' +
                            '</label>')
                            ;
                    },
                    itemTemplate: function (_, item) {
                        return $('<label class="custom-control custom-checkbox">' +
                            '<input type="checkbox" class="custom-control-input add_element" checked>' +
                            '<span class="custom-control-label"></span>' +
                            '</label>')
                            .data("summ", item.summ)
                            .data("inbankid", item.inbankid)
                            .data("docdate", item.docdate)
                            .data("paydirection", item.paydirection)
                            ;
                    },
                    sorting: false,
                    align: 'center',
                    width: 40
                },
                {name: "docdate", type: "text", title: 'Дата', width: 100},
                {name: "inbankid", type: "text", title: 'Номер', width: 80},
                {name: "summ", type: "text", title: 'Сумма', width: 100},
                {name: 'html', type: 'text', title: 'Клиент / Договор', width: 250},
                {name: 'found', type: 'text', title: 'Автоматически', width: 200},
                {name: "paydirection", type: "text", title: 'НазначениеПлатежа', width: 'auto'},
            ]
        });
    }

    function bankStatement_toggleSelectedItems(btn) {
        var tbl = btn.closest('.jsGrid');

        tbl.find('[type=checkbox].add_element').prop('checked', btn.prop('checked')).trigger('change');
    }

    function bankStatement_addPayments(btn) {
        btn.prop('disabled', true);

        var tbl = $('.bank_statement_jsGrid');
        var payments = [];

        tbl.find('.add_element:checked').each(function () {
            var t = $(this).closest('.custom-control');
            var row = t.closest('tr');

            var contractId = getComboBoxValue($('[name^="contract_choose_single"]'));

            if (contractId) {
                payments.push({
                    contract_id: t.data('contract_id'),
                    num: t.data('inbankid'),
                    date: t.data('date'),
                    value: t.data('summ'),
                    comment: t.data('paydirection')
                });
            }
        });

        $.post('/clients/contract-payment-add', {'multi': 1, payments: payments}, function (data) {
            if (data.success) {
                message(1, 'Платежи успешно добавлены');
                $(".bank_statement_jsGrid").jsGrid("destroy");
                $('.upload_pays_new b').text(payments.length);
            } else {
                message(0, 'Ошибка добавления платежей');
                btn.prop('disabled', false);
            }
        })
    }
</script>