<div class="client_contract_elem">
    <div class="close <?=Text::BTN?> btn-outline-danger btn-sm ts_remove m-b-5" onclick="deleteRow($(this))"><i class="fa fa-times"></i></div>
    <?=Form::buildField('contract_choose_multi', 'client_contract' . $iteration)?>
</div>
