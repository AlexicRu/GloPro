<div class="modal-body">

    <div class="form form_add_client">
        <div class="form-group row">
            <div class="text-right col-4">Номер:</div>
            <div class="col-8">
                <input type="text" name="add_contract_name" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="text-right col-4">Дата начала:</div>
            <div class="col-8">
                <input type="date" class="form-control" name="add_contract_date_start" value="<?=date('d.m.Y')?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="text-right col-4">Дата окончания:</div>
            <div class="col-8">
                <input type="date" class="form-control" name="add_contract_date_end">
            </div>
        </div>
    </div>

    <small><i>* - Дату окончания оставить пустой в случае бессрочного договора</i></small>

</div>
<div class="modal-footer">
    <span class="btn btn-primary" onclick="submitForm($(this), addContractGo)"><i class="fa fa-plus"></i> Создать договор</span>
    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal"><i class="fa fa-times"></i> Отмена</button>
</div>

<script>
    function addContractGo(btn)
    {
        var params = {
            client_id:  clientId,
            name:       $('[name=add_contract_name]').val(),
            date_start: $('[name=add_contract_date_start]').val(),
            date_end:   $('[name=add_contract_date_end]').val(),
        };

        if(params.name == ''){
            message(0, 'Введите название договора');
            endSubmitForm();
            return false;
        }
        if(params.date_start == ''){
            message(0, 'Введите начала действия');
            endSubmitForm();
            return false;
        }

        $.post('/clients/contract-add', {params:params}, function(data){
            if(data.success){
                message(1, 'Договор успешно добавлен');
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            }else{
                message(0, data.data ? data.data : 'Ошибка добавления договора');
                endSubmitForm();
            }
        });
    }
</script>