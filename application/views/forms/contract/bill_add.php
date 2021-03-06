<style>
    .form_client_add_bill .table_form{
        width: 760px;
    }
    .form_client_add_bill_product{
        position: relative;
    }
</style>

<div class="modal-body">
    <div class="form_client_add_bill">
        <div class="row">
            <div class="col-12 form_client_add_bill_products"></div>
        </div>
        <div class="row m-b-20">
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Сумма</span>
                    </div>
                    <input type="number" name="client_add_bill_summ" class="form-control">
                </div>
            </div>
            <div class="col-md-6 with-mt">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">НДС</span>
                    </div>
                    <input type="text" name="client_add_bill_nds" class="form-control" disabled>
                </div>
            </div>
        </div>

        <?if(Access::allow('client_add_bill_add_product')){?>
            <i class="text-muted">Для выставления счета на сумму добавление товаров не требуется</i>
        <?}?>
    </div>
</div>
<div class="modal-footer">
    <?if(Access::allow('client_add_bill_add_product')){?>
        <span class="<?=Text::BTN?> btn-outline-success" onclick="renderProduct()"><i class="fa fa-plus"></i><span class="hidden-xs-down"> Добавить товар</span></span>
    <?}?>
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), addBill)">Выставить счет</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    $(function(){
        $('[name=client_add_bill_summ]').on('keyup', function () {
            recalcNDS();
        });
    });

    function addBill() {
        var error = false;
        var params = {
            contract_id:    $('[name=contracts_list]').val(),
            sum:            0,
            products:       []
        };

        if ($('.form_client_add_bill_product').length == 0) {
            params.sum += $('[name=client_add_bill_summ]').val();
        } else {
            $('.form_client_add_bill_product').each(function () {
                var t = $(this);
                var product = {
                    service: getComboBoxValue($('[name^=add_bill_product_service_]', t)),
                    cnt: $('[name^=add_bill_product_cnt_]', t).val().replace(',', '.'),
                    price: $('[name^=add_bill_product_price_]', t).val().replace(',', '.'),
                };

                if (product.service == '' || product.cnt == '' || product.price == '') {
                    message(0, 'Заполните товары корректно');
                    error = true;
                    return false;
                }

                params.products.push(product);
                params.sum += parseFloat($('[name^=add_bill_product_summ_]', t).val());
            });
        }

        if (error) {
            endSubmitForm();
            return false;
        }

        if(params.sum == '' || params.sum <= 0){
            message(0, 'Введите корректную сумму');
            endSubmitForm();
            return false;
        }

        window.location.href = '/clients/add-bill?' + $.param(params);
        endSubmitForm();
        modalClose();

        setTimeout(function () {
            paginationAjaxRefresh('ajax_block_client_bills_list');
        }, 1000);
    }

    function calcRowSumm(item)
    {
         var row = item.closest('.form_client_add_bill_product');
         var cnt = $('[name^=add_bill_product_cnt_]', row);
         var cntVal = cnt.val().replace(',', '.');
         var price = $('[name^=add_bill_product_price_]', row);
         var priceVal = price.val().replace(',', '.');
         var summ = $('[name^=add_bill_product_summ_]', row);

         if (isNaN(cntVal) || cntVal < 0) {
             cnt.val(0);
             summ.val(0);
             cntVal = 0;
         }

        if (isNaN(priceVal) || priceVal < 0) {
            price.val(0);
            summ.val(0);
            priceVal = 0;
        }

        if ((parseInt(priceVal * 10000) / 10000) != priceVal) {
            priceVal = parseInt(priceVal * 10000) / 10000;
            price.val(priceVal);
        }

        if ((parseInt(cntVal * 100000) / 100000) != cntVal) {
            cntVal = parseInt(cntVal * 100000) / 100000;
            cnt.val(cntVal);
        }

        var sumRow = parseInt((priceVal * 100) * (cntVal * 100)) / 10000;

        summ.val(sumRow);

        recalcNDS();
        recalcSum();
    }
    
    function renderProduct()
    {
        var block = $('.form_client_add_bill_products');

        $.post('/clients/add-bill-product-template', {}, function (data) {
            block.append(data);
            $('[name=client_add_bill_summ]').prop('disabled', true);
            recalcNDS();
            recalcSum();
        });

    }

    function addBillDeleteRow(btn)
    {
        if(!confirm('Удаляем?')) {
            return;
        }

        var fieldset = btn.parent();

        fieldset.remove();

        if ($('.form_client_add_bill_product').length == 0){
            $('[name=client_add_bill_summ]').prop('disabled', false);
        }

        recalcNDS();
        recalcSum();
    }

    /**
     * 4) НДС считается как "Общая сумма" * 20 / 120 и округляется до 2х знаков
     */
    function recalcNDS()
    {
        var ndsInput = $('[name=client_add_bill_nds]');
        var nds = 0;

        if ($('.form_client_add_bill_product').length == 0) {
            nds = parseFloat($('[name=client_add_bill_summ]').val()) * 20 / 120;
        } else {
            $('[name^=add_bill_product_summ_]').each(function () {
                var t = $(this);
                var val = parseFloat(t.val());
                if (val > 0 && !isNaN(val)) {
                    nds = nds + val;
                }
            });

            nds = nds * 20 / 120;
        }

        ndsInput.val(parseInt(nds*100) / 100);
    }

    function recalcSum()
    {
        var summField = $('[name=client_add_bill_summ]');
        var summ = 0;

        $('[name^=add_bill_product_summ_]').each(function () {
            var t = $(this);
            var val = t.val();

            if (!isNaN(val) && val) {
                summ += parseFloat(val);
            }
        });

        summField.val(summ);
    }
</script>