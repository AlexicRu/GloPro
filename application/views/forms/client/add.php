<div class="modal-body">
    <div class="form form_add_client">
        <div class="form-group row m-b-0">
            <div class="col-sm-4 text-muted form__row__title">
                Название компании:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="add_client_name" class="form-control">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), addClientGo)"><i class="fa fa-plus"></i> Добавить клиента</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addClientGo(btn) {
        var params = {
            name: $('[name=add_client_name]').val()
        };

        if(params.name == ''){
            message(0, 'Введите название компании');
            endSubmitForm();
            return false;
        }

        $.post('/clients/client-add', {params:params}, function(data){
            endSubmitForm();

            if(data.success){
                message(1, 'Клиент успешно добавлен');
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            }else{
                message(0, 'Ошибка добавления клиента');
            }
        });
    }
</script>