<div class="client_contract_elem">
    <div class="close btn btn_red btn_small btn_icon ts_remove" onclick="deleteRow($(this))"><i class="fa fa-times"></i></div>
    <?=Form::buildField('contract_choose_multi', 'client_contract' . $iteration)?>
</div>
