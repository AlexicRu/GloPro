<?if(Access::allow('suppliers_supplier-add')){?>
    <div class="text-right m-b-30">
        <a href="#" class="btn btn-outline-primary waves-effect waves-light" data-toggle="modal" data-target="#supplier_add"><i class="fa fa-plus"></i> Добавить поставщика</a>
    </div>
<?}?>


<?if(Access::allow('suppliers_supplier-add')){?>
    <?=$popupSupplierAdd?>
<?}?>

<div class="ajax_block_suppliers_out block_loading">

</div>

<script>
    $(function(){
        paginationAjax('/suppliers/suppliers-list/', 'ajax_block_suppliers', renderAjaxPaginationSuppliers, {show_all_btn: true});
    });

    function renderAjaxPaginationSuppliers(data, block)
    {
        if (block.is(':empty')) {
            block.append('<div class="row" />');
        }

        block = block.find('.row');

        for(var i in data){
            var tpl = $('<div class="col-md-6"><div class="card">' +
                '    <div class="card-body">' +
                '        <div class="row">' +
                '            <div class="col-lg-3 col-md-4 align-top text-center">' +
                '                <div class="s_logo" />' +
                '            </div>' +
                '            <div class="col-lg-9 col-md-8">' +
                '                <h5 class="card-title" />' +
                '                <p class="card-text" />' +
                '                <a class="'+ BTN +' btn-primary">Подробнее</a>' +
                '            </div>' +
                '        </div>' +
                '    </div>' +
                '</div></div>');

            tpl.data('supplier_id', data[i].ID);
            tpl.find('.card-title').text(data[i].SUPPLIER_NAME);
            tpl.find('.btn').attr('href', '/suppliers/' + data[i].ID);
            tpl.find('.card-text').text(data[i].LONG_NAME);

            if (data[i].ICON_PATH) {
                tpl.find('.s_logo').css('background-image', 'url("'+ data[i].ICON_PATH +'")');
            } else {
                tpl.find('.s_logo').addClass('s_logo_empty');
            }

            block.append(tpl);
        }
    }
</script>