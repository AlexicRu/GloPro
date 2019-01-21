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
            'ПолучательБИК' => 'recieverbik',
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
             */
            fields: [
                {name: "doctype", type: "text", title: 'СекцияДокумент', width: 150},
                {name: "inbankid", type: "text", title: 'Номер', width: 80},
                {name: "docdate", type: "text", title: 'Дата', width: 100},
                {name: "summ", type: "text", title: 'Сумма', width: 150},
                {name: "outdate", type: "text", title: 'ДатаСписано', width: 150},
                {name: "indate", type: "text", title: 'ДатаПоступило', width: 150},
                {name: "payeraccount", type: "text", title: 'ПлательщикСчет', width: 250},
                {name: "payerinfo", type: "text", title: 'Плательщик', width: 300},
                {name: "payerinn", type: "text", title: 'ПлательщикИНН', width: 150},
                {name: "payer", type: "text", title: 'Плательщик1', width: 300},
                {name: "payerdealaccount", type: "text", title: 'ПлательщикРасчСчет', width: 250},
                {name: "payerbank1", type: "text", title: 'ПлательщикБанк1', width: 150},
                {name: "payerbank2", type: "text", title: 'ПлательщикБанк2', width: 150},
                {name: "payerbik", type: "text", title: 'ПлательщикБИК', width: 150},
                {name: "payerfixaccount", type: "text", title: 'ПлательщикКорсчет', width: 250},
                {name: "recieveraccount", type: "text", title: 'ПолучательСчет', width: 250},
                {name: "recieverinfo", type: "text", title: 'Получатель', width: 150},
                {name: "recieverinn", type: "text", title: 'ПолучательИНН', width: 150},
                {name: "reciever1", type: "text", title: 'Получатель1', width: 150},
                {name: "recieverdealaccount", type: "text", title: 'ПолучательРасчСчет', width: 250},
                {name: "recieverbank1", type: "text", title: 'ПолучательБанк1', width: 150},
                {name: "recieverbank2", type: "text", title: 'ПолучательБанк2', width: 150},
                {name: "recieverbik", type: "text", title: 'ПолучательБИК', width: 150},
                {name: "recieverfixaccount", type: "text", title: 'ПолучательКорсчет', width: 250},
                {name: "paytype", type: "text", title: 'ВидОплаты', width: 150},
                {name: "paydirection", type: "text", title: 'НазначениеПлатежа', width: 300},
                {name: "makerstatus", type: "text", title: 'СтатусСоставителя', width: 200},
                {name: "payerkpp", type: "text", title: 'ПлательщикКПП', width: 150},
                {name: "recieverkpp", type: "text", title: 'ПолучательКПП', width: 150},
                {name: "showerkbk", type: "text", title: 'ПоказательКБК', width: 150},
                {name: "okato", type: "text", title: 'ОКАТО', width: 150},
                {name: "showerfundament", type: "text", title: 'ПоказательОснования', width: 200},
                {name: "showerperiod", type: "text", title: 'ПоказательПериода', width: 200},
                {name: "showernumber", type: "text", title: 'ПоказательНомера', width: 200},
                {name: "showerdate", type: "text", title: 'ПоказательДаты', width: 200},
                {name: "showertype", type: "text", title: 'ПоказательТипа', width: 200},
                {name: "paymentperiod", type: "text", title: 'СрокПлатежа', width: 150},
                {name: "quenue", type: "text", title: 'Очередность', width: 150},
            ]
        });
    }
</script>