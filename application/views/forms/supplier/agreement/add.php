<div class="modal-body">

    <div class="form form_add_agreement">
        <div class="form-group row m-b-0">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Название:</div>
                <span class="hidden-sm-up text-muted">Название:</span>
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="add_agreement_name" class="form-control">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),addAgreement)"><i class="fa fa-plus"></i> Добавить<span class="hidden-xs-down"> соглашение</span></span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addAgreement(btn)
    {
        var block = $('.form_add_agreement');

        var params = {
            contract_id:    contractId,
            agreement_name: $('[name=add_agreement_name]').val()
        };

        if(params.add_agreement_name == ''){
            message(0, 'Введите название соглашения');
            endSubmitForm();
            return false;
        }

        $.post('/suppliers/agreement-add', {params:params}, function(data){
            if(data.success){
                modalClose();
                message(1, 'Соглашение успешно добавлено');
                loadSupplierContract('agreements');
            }else{
                message(0, data.data ? data.data : 'Ошибка добавления соглашения');
            }
            endSubmitForm();
        });
    }
</script>