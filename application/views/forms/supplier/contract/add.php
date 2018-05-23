<div class="modal-body">

    <div class="form form_add_supplier_contract">
        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down">Номер:</div>
                <span class="hidden-sm-up">Номер:</span>
            </div>
            <div class="col-sm-8">
                <input type="text" name="add_supplier_contract_name" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down">Дата начала:</div>
                <span class="hidden-sm-up">Дата начала:</span>
            </div>
            <div class="col-sm-8">
                <input type="date" class="form-control" name="add_supplier_contract_date_start" value="<?=date('Y-m-d')?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down">Дата окончания:</div>
                <span class="hidden-sm-up">Дата окончания:</span>
            </div>
            <div class="col-sm-8">
                <input type="date" class="form-control" name="add_supplier_contract_date_end">
            </div>
        </div>
    </div>

    <small><i>* - Дату окончания оставить пустой в случае бессрочного договора</i></small>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),addSupplierContract)"><i class="fa fa-plus"></i> Добавить договор</span>
    <button type="button" class="btn-danger <?=Text::BTN?>" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addSupplierContract(btn)
    {
        var block = $('.form_add_supplier_contract');

        var params = {
            supplier_id:    supplierId,
            name:           $('[name=add_supplier_contract_name]', block).val(),
            date_start:     $('[name=add_supplier_contract_date_start]', block).val(),
            date_end:       $('[name=add_supplier_contract_date_end]', block).val(),
        };

        if(params.name == ''){
            message(0, 'Введите название договора');
            return false;
        }
        if(params.date_start == ''){
            message(0, 'Введите начала действия');
            return false;
        }

        $.post('/suppliers/contract-add', {params:params}, function(data){
            if(data.success){
                message(1, 'Договор успешно добавлен');
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            }else{
                message(0, data.data ? data.data : 'Ошибка добавления договора');
            }
        });
    }
</script>