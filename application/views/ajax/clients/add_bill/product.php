<div class="form_client_add_bill_product m-b-10 border-bottom p-b-10">
    <span class="font-weight-bold">Товар</span>
    <span class="btn btn-sm btn_icon btn-outline-danger ts_remove" onclick="addBillDeleteRow($(this))"><i class="fa fa-times"></i></span>

    <div class="row m-t-5">
        <div class="col-md-6 col-lg-3">
            Вид топлива:<br>
            <?=Form::buildField('service_choose_single', 'add_bill_product_service_' . $iteration)?>
        </div>
        <div class="col-md-6 col-lg-3">
            Кол-во:<br>
            <input type="text" name="add_bill_product_cnt_<?$iteration?>" onkeyup="calcRowSumm($(this))" class="form-control">
        </div>
        <div class="col-md-6 col-lg-3 with-mb">
            Цена:<br>
            <input type="text" name="add_bill_product_price_<?$iteration?>" onkeyup="calcRowSumm($(this))" class="form-control">
        </div>
        <div class="col-md-6 col-lg-3 with-mb">
            Сумма:<br>
            <input type="text" name="add_bill_product_summ_<?$iteration?>" disabled class="form-control">
        </div>
    </div>
</div>