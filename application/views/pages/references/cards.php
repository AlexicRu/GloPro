<div class="text-right m-b-20">
    <span class="<?=Text::BTN?> btn-success" onclick="gridToXls()"><i class="fa fa-file-excel"></i> Выгрузить в Excel</span>
</div>

<div class="jsGrid jsGrid-checkbox references_cards_jsGrid"></div>

<script>
    var db = {
        loadData: function(filter) {
            return $.grep(this.rows, function(row) {
                return (!filter.CARD_ID || row.CARD_ID.toLowerCase().indexOf(filter.CARD_ID.toLowerCase()) > -1)
                    && (!filter.SOURCE_NAME || row.SOURCE_NAME.toLowerCase().indexOf(filter.SOURCE_NAME.toLowerCase()) > -1)
                    && (!filter.SOURCE_STATE || row.SOURCE_STATE == filter.SOURCE_STATE)
                    && (!filter.ISSUE_STATE || row.ISSUE_STATE == filter.ISSUE_STATE)
                    && (!filter.status || row.status == filter.status)
                ;
            });
        },
        rows: [],
        statuses: [
            {'name': ''},
            {'name': 'В работе'},
            {'name': 'Не в работе'}
        ]
    };

    <?if (!empty($cardsList)) {
        foreach($cardsList as $card) {?>
            db.rows.push({
                'CARD_ID'       : '<?=$card['CARD_ID']?>',
                'SOURCE_NAME'   : '<?=$card['SOURCE_NAME']?>',
                'SOURCE_STATE'  : '<?=$card['SOURCE_STATE']?>',
                'ISSUE_STATE'   : '<?=$card['ISSUE_STATE']?>',
                'status'        : <?=($card['ISSUE_ID'] == 0 ? 'true' : 'false')?>,
            });
        <?}
    }?>

    window.db = db;

    var grid = $(".references_cards_jsGrid");

    grid.jsGrid({
        width: '100%',
        sorting: true,
        filtering: true,
        paging: true,
        pageSize: 15,

        controller:db,

        fields: [
            { name: "CARD_ID", type: "text", title: 'Номер карты', width:200},
            { name: "SOURCE_NAME", type: "text", title: 'Имя источника', width:'auto'},
            { name: "SOURCE_STATE", type: "select", title: 'Статус в источнике', width:200, items: db.statuses, valueField: "name", textField: "name" },
            { name: "ISSUE_STATE", type: "text", title: 'Статус выдачи', width:250 },
            {
                title: 'Не выдано',
                width: 80,
                name: 'status',
                type: 'checkbox',
                itemTemplate: function(_, item) {
                    var tpl = $('<label class="custom-control custom-checkbox">' +
                            '<input type="checkbox" class="custom-control-input" disabled>' +
                            '<span class="custom-control-label"></span>' +
                        '</label>')
                    ;

                    if (item.status) {
                        tpl.find('[type=checkbox]').prop('checked', true);
                    }

                    return tpl;
                },
            }
        ]
    });

    grid.jsGrid("search");
    
    function gridToXls()
    {
        var csv = grid.jsGrid("exportData");

        var form = $('<form method="post" action="/index/as-xls" style="display: none" />');
        var textarea = $('<textarea name="csv" />');
        textarea.val(csv);
        textarea.appendTo(form);
        form.appendTo('body');
        form.submit();
        form.remove();
    }
</script>