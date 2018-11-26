<div class="tabs_administration_transactions">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs customtab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tabErrors" role="tab">
                <i class="far fa-ban fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Отказные</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabProcess" role="tab">
                <i class="far fa-spinner fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">В обработке</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabHistory" role="tab">
                <i class="far fa-history fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">История загрузок</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabJournal" role="tab">
                <i class="far fa-download fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Загрузка ведомостей</span>
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content p-20 bg-white">
        <div class="tab-pane active" id="tabErrors" role="tabpanel">
            <div class="text-right border-bottom p-b-20 m-b-20">
                <span class="<?=Text::BTN?> btn-success" onclick="transactionCancelToXls()"><i class="fa fa-file-excel"></i> Выгрузить</span>
            </div>
            <div class="ajax_block_administration_transactions_errors_out"></div>
        </div>
        <div class="tab-pane" id="tabProcess" role="tabpanel">
            <div class="text-right border-bottom p-b-20 m-b-20">
                <span class="<?=Text::BTN?> btn-success" onclick="transactionCancelToXls()"><i class="fa fa-file-excel"></i> Выгрузить</span>
            </div>
            <div class="ajax_block_administration_transactions_process_out"></div>
        </div>
        <div class="tab-pane" id="tabHistory" role="tabpanel">
            <div class="ajax_block_administration_transactions_history_out"></div>
        </div>
        <div class="tab-pane" id="tabJournal" role="tabpanel">
            <div class="padding__20">
                <div class="administration_transactions_journal dropzone"></div>
            </div>

            <div class="jsGrid administration_transactions_journal_jsGrid"></div>
        </div>
    </div>
</div>

<script>
    var skipColumns = ['RNUM', 'TRN_CURRENCY', 'AGENT_ID', 'DATETIME_PROCESS'];

    $(function(){
        var params = {
            show_all_btn:true,
            no_filter: true
        };

        paginationAjax('/administration/transactions-errors', 'ajax_block_administration_transactions_errors', renderAjaxPaginationAdminTransactions, params);
        paginationAjax('/administration/transactions-process', 'ajax_block_administration_transactions_process', renderAjaxPaginationAdminTransactions, params);
        paginationAjax('/administration/transactions-history', 'ajax_block_administration_transactions_history', renderAjaxPaginationAdminTransactions);

        dropzone = new Dropzone('.administration_transactions_journal', {
            url: "/control/upload-journal",
            acceptedFiles: '.txt, .json, .xls, .xlsx, .csv',
            addedfile: function () {
                var grid = $(".administration_transactions_journal_jsGrid");

                if ($('.jsgrid-table', grid).length) {
                    grid.jsGrid("destroy");
                }
                addLoader(grid);
            },
            success: function(file, response)
            {
                if(response.data && response.data.rows){
                    administrationTransactionsJournal_drawTable(response.data.rows);
                } else {
                    var grid = $(".administration_transactions_journal_jsGrid");
                    removeLoader(grid);
                    grid.html('<div class="text-center"><i class="text-muted">Данные отсутствуют</i><br><br></div>');
                }
            },
            error : function(file, response) {
                var grid = $(".administration_transactions_journal_jsGrid");

                removeLoader(grid);

                message(0, response);
            }
        });
    });

    function administrationTransactionsJournal_drawTable(rows)
    {
        var grid = $(".administration_transactions_journal_jsGrid");
        removeLoader(grid);
        grid.jsGrid({
            width: '100%',
            sorting: true,

            onRefreshed: function () {
                $('[type=checkbox]').each(function () {
                    renderCheckbox($(this));
                });
            },

            data: rows,

            fields: [
                { name: "Дата", type: "text", title: 'Дата', width:100},
                { name: "Время", type: "text", title: 'Время', width:100},
                { name: "Номер карты", type: "text", title: 'Номер карты', width:200},
                { name: "Операция", type: "text", title: 'Операция', width:100},
                { name: "Услуга", type: "text", title: 'Услуга', width:100},
                { name: "Количество", type: "text", title: 'Количество', width:100},
                { name: "Цена АЗС", type: "text", title: 'Цена АЗС', width:100},
                { name: "Сумма по цене АЗС", type: "text", title: 'Сумма по цене АЗС', width:100},
                { name: "Цена со скидкой", type: "text", title: 'Цена со скидкой', width:100},
                { name: "Сумма по цене со скидкой", type: "text", title: 'Сумма по цене со скидкой', width:100},
                { name: "Название АЗС", type: "text", title: 'Название АЗС', width:200},
                { name: "Адрес АЗС", type: "text", title: 'Адрес АЗС', width:300},
                { name: "RRN", type: "text", title: 'RRN', width:150},
                { name: "Del", type: "text", title: 'Статус', width:100},
            ]
        });
    }

    function renderAjaxPaginationAdminTransactionsFilter(data, block, params)
    {
        if(block.find('table').length == 0){
            //draw headers
            for(var i in data){

                block.append('<div class="table-responsive"><table class="table table_small table_fullscreen check_all_block"></table></div>');
                block = block.find('table');
                block.append('<tr />');

                for(var j in data[i]){
                    if(skipColumns.indexOf(j) != -1){
                        continue;
                    }

                    var value = '';
                    if (params.filter && params.filter[j]) {
                        value = params.filter[j];
                    }

                    block.find('tr').append('<th><input type="text" name="transactions_filter_'+ j +'" placeholder="'+ j +'" class="form-control transaction_filter" onkeypress="filterTransactions(event, $(this))" value="'+value+'"></th>');

                }

                break;
            }
        }
    }

    function renderAjaxPaginationAdminTransactions(data, block, params)
    {
        var i, j, tr, table;

        if (!params.no_filter) {
            renderAjaxPaginationAdminTransactionsFilter(data, block, params);
        } else {

            if(block.find('table').length == 0) {
                var scrollBlock = $('<div class="table-responsive"><table class="table table_small" /></div>');
                block.append(scrollBlock);

                table = block.find('table');

                //draw headers
                for(i in data){
                    tr = $('<tr />');

                    for(j in data[i]){
                        if(skipColumns.indexOf(j) != -1){
                            continue;
                        }
                        tr.append('<th>'+ j +'</th>');
                    }

                    table.append(tr);
                    break;
                }
            }
        }

        table = block.find('table');

        //draw body
        for(i in data){
            tr = $('<tr />');

            tr.attr('rnum', data[i].RNUM);

            for(j in data[i]){
                if(skipColumns.indexOf(j) != -1){
                    continue;
                }
                tr.append('<td>'+ data[i][j] +'</td>');
            }

            table.append(tr);
        }
    }

    function renderAjaxPaginationAdminTransactionsError(block, params)
    {
        renderAjaxPaginationAdminTransactionsFilter([params['filter']], block, params);

        var subBlock = block.find('table');

        var tpl = $('<tr>' +
            '<td colspan="'+Object.keys(params['filter']).length+'" class="center"><i>Данные отсутствуют</i></td>' +
            '</tr>');

        subBlock.append(tpl);
    }

    function transactionCancelToXls()
    {
        window.open('/administration/transactions-errors?to_xls=1');
    }
    function transactionHistoryToXls()
    {
        var rnum = [];

        $('.ajax_block_administration_transactions_history [rnum]').each(function () {
            rnum.push($(this).attr('rnum'));
        });

        window.open('/administration/transactions-history?to_xls=1&rnum=' + rnum.join(','));
    }

    function filterTransactions(e, btn)
    {
        if (e.keyCode != 13) {
            return false;
        }

        var block = btn.closest('.ajax_block_administration_transactions_history_out');

        var params = {
            filter: {},
            onError: renderAjaxPaginationAdminTransactionsError
        };

        block.find('.transaction_filter').each(function(){
            var t = $(this);
            var name = t.attr('name').replace('transactions_filter_', '');

            params.filter[name] = t.val();
        });

        block.empty();

        paginationAjax('/administration/transactions-history', 'ajax_block_administration_transactions_history', renderAjaxPaginationAdminTransactions, params);
    }
</script>