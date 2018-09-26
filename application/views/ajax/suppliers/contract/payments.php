<div class="p-20">
    <i class="text-muted">Отображение платежей только по типу источника "Цепочка договоров внутри системы"</i>

    <div class="ajax_block_payments_history_out m-t-20"></div>
</div>

<script>
    $(function(){
        paginationAjax('/suppliers/contract-payments-history/' + $('[name=suppliers_contracts_list]').val(), 'ajax_block_payments_history', renderAjaxPaginationPaymentsHistory);
    });

    function renderAjaxPaginationPaymentsHistory(data, block)
    {
        for(var i = 0 in data){
            var tpl = $('<div class="row bg-light m-b-5 p-t-10 p-b-10">'+
                '<div class="col-5 col-xl-3 text-muted" row_date />'+
                '<div class="col-7 col-xl-3" row_num />'+
                '<div class="with-mb col-xl-6" row_summ />'+
                '<div class="with-mb col-12" row_comment />'+
                '</div>');

            tpl.find('[row_date]').text(data[i].ORDER_DATE);
            tpl.find('[row_num]').text('№' + data[i].ORDER_NUM);
            tpl.find('[row_summ]').html('<span class="text-muted">Сумма</span> <b>' + number_format(data[i].SUMPAY, 2, ',', ' ') + ' <?=Text::RUR?></b>');

            if (data[i].DATE_IN) {
                tpl.find('[row_comment]').append('<div class="text-muted"><i>Внесена:</i> '+ data[i].DATE_IN +'</div>');
            }

            if (data[i].PAY_COMMENT) {
                tpl.find('[row_comment]').append('<div><i>Комментарий:</i> '+ data[i].PAY_COMMENT + '</div>');
            }

            block.append(tpl);
        }
    }
</script>
