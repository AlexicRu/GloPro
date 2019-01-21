<style>
    .tabs_connect_1c .jsGrid:not(:empty), .tabs_connect_1c .jsGrid.block_loading {
        margin-top: 30px;
    }
</style>

<div class="block">
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
                {name: "PAYMENT_STATUS", type: "text", title: 'Статус', width: 100},
                {name: "OPERATION_NAME", type: "text", title: 'Действие', width: 120},
                {name: "CONTRACT_NAME", type: "text", title: 'Договор', width: 120},
                {name: "ORDER_DATE", type: "text", title: 'Дата п/п', width: 100},
                {name: "PAYMENT_DATE", type: "text", title: 'Дата оплаты', width: 120},
                {name: "SUMPAY", type: "number", title: 'Сумма', width: 80},
                {name: "DOC_CURRENCY", type: "text", title: 'Валюта', width: 80},
                {name: "ORDER_NUM", type: "number", title: 'Номер п/п', width: 100},
                {name: "PURPOSE", type: "text", title: 'Описание', width: 'auto'},
                {name: "COMMENT", type: "text", title: 'Комментарий', width: 250}
            ]
        });
    }
</script>