<div class="modal-body">
    <div class="ajax_block_contract_history_out">

    </div>
</div>

<script>
    $(function(){
        paginationAjax('/clients/contract-history', 'ajax_block_contract_history', renderAjaxPaginationContractHistory, {
            'contract_id': $('[name=contracts_list]').val()
        });
    });

    function renderAjaxPaginationContractHistory(data, block) {

        if (block.find('table').length == 0) {
            block.append('<table class="table table-striped"><thead><tr><th>Дата</th><th>Комментарий</th></tr></thead><tbody /></table>');
        }

        var table = block.find('table tbody');

        for(var i = 0 in data){
            var tpl = $('<tr><td class="td1 text-muted" /><td class="td2" /></tr>');
            tpl.find('.td1').text(data[i].DATE_TIME);
            tpl.find('.td2').text(data[i].CONTRACT_EVENT);
            table.append(tpl);
        }
    }
</script>