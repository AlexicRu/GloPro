<style>
    .jsGrid:not(:empty), .jsGrid.block_loading {
        margin-top: 30px;
    }
</style>

<div class="block p-3 bg-white">
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

            /*
            'СекцияДокумент' => 'doctype',
            'Номер' => 'inbankid',
            'Дата' => 'docdate',
            'Сумма' => 'summ',
            'ДатаСписано' => 'outdate',
            'ДатаПоступило' => 'indate',
            'ПлательщикСчет' => 'payeraccount',
            'Плательщик' => 'payerinfo',
            'ПлательщикИНН' => 'payerinn',
            'Плательщик1' => 'payer',
            'ПлательщикРасчСчет' => 'payerdealaccount',
            'ПлательщикБанк1' => 'payerbank1',
            'ПлательщикБанк2' => 'payerbank2',
            'ПлательщикБИК' => 'payerbik',
            'ПлательщикКорсчет' => 'payerfixaccount',
            'ПолучательСчет' => 'recieveraccount',
            'Получатель' => 'recieverinfo',
            'ПолучательИНН' => 'recieverinn',
            'Получатель1' => 'reciever1',
            'ПолучательРасчСчет' => 'recieverdealaccount',
            'ПолучательБанк1' => 'recieverbank1',
            'ПолучательБанк2' => 'recieverbank2',
            'ПолучательБИК' => 'recieverbik',овый договор:
            'ПолучательКорсчет' => 'recieverfixaccount',
            'ВидОплаты' => 'paytype',
            'НазначениеПлатежа' => 'paydirection',
            'СтатусСоставителя' => 'makerstatus',
            'ПлательщикКПП' => 'payerkpp',
            'ПолучательКПП' => 'recieverkpp',
            'ПоказательКБК' => 'showerkbk',
            'ОКАТО' => 'okato',
            'ПоказательОснования' => 'showerfundament',
            'ПоказательПериода' => 'showerperiod',
            'ПоказательНомера' => 'showernumber',
            'ПоказательДаты' => 'showerdate',
            'ПоказательТипа' => 'showertype',
            'СрокПлатежа' => 'paymentperiod',
            'Очередность' => 'quenue',

1) галочку "занести платеж"
2) дату платежа
3) номер платежа
4) клиент
5) договор
5) назначение

Form::buildField('contract_choose_single', 'contract_new')
             */
            fields: [
                {name: "docdate", type: "text", title: 'Дата', width: 100},
                {name: "inbankid", type: "text", title: 'Номер', width: 80},
                {name: "summ", type: "text", title: 'Сумма', width: 100},
                {name: 'html', type: 'text', title: 'Клиент / Договор', width: 250},
                {name: 'found', type: 'text', title: 'Автоматически', width: 200},
                {name: "paydirection", type: "text", title: 'НазначениеПлатежа', width: 'auto'},
            ]
        });
    }
</script>