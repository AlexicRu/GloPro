<div class="modal-body">
    <div class="ajax_block_client_bills_list_out">

    </div>
</div>

<script>
    $(function(){
        paginationAjax('/clients/bills-list', 'ajax_block_client_bills_list', renderAjaxPaginationClientBillsList, {
            'contract_id': $('[name=contracts_list]').val()
        });
    });

    function renderAjaxPaginationClientBillsList(data, block)
    {
        if (block.is(':empty')) {
            block.append('<div class="card m-b-0"><div class="card-body p-t-0 p-b-0" /></div>');
        }

        for(var i = 0 in data){
            var tpl = $('<div class="row bg-light m-b-5 p-t-10 p-b-10">' +
                    '<div class="col-5 col-xl-2 text-muted" row_date />'+
                    '<div class="col-7 col-xl-3" row_contract />'+
                    '<div class="with-mt col-5 col-xl-2" row_num />'+
                    '<div class="with-mt col-7 col-xl-2" row_summ />'+
                    '<div class="with-mt col-xl-3" row_btns><div class="btn-group"></div>'+
                '</div>');

            tpl.find('[row_date]').text(data[i].DATE_WEB);
            tpl.find('[row_contract]').text(data[i].CONTRACT_NAME);
            tpl.find('[row_num]').html('<b>' + data[i].NUM_REPORT + '</b>');
            tpl.find('[row_summ]').html('<nobr>' + number_format(data[i].INVOICE_SUM, 2, ',', ' ') + ' <?=Text::RUR?></nobr>');
            tpl.find('[row_btns] .btn-group').html('<a href="/reports/generate?type=<?=Model_Report::REPORT_TYPE_BILL?>&format=pdf&contract_id=' + data[i].CONTRACT_ID + '&invoice_number=' + data[i].INVOICE_NUMBER + '" class="'+ BTN +' btn-sm btn-outline-primary" target="_blank"><i class="icon-download"></i> Скачать</a>');

            <?if(Access::allow('download_bill_as_xls')){?>
            tpl.find('[row_btns] .btn-group').append('<a href="/reports/generate?type=<?=Model_Report::REPORT_TYPE_BILL?>&format=xls&contract_id=' + data[i].CONTRACT_ID + '&invoice_number=' + data[i].INVOICE_NUMBER + '" class="'+ BTN +' btn-sm btn-outline-success" target="_blank">В Excel</a>');
            <?}?>

            block.find('.card-body').append(tpl);
        }
    }

</script>