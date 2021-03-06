<div class="modal-body">

    <div class="form form_cabinet_create">
        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Email:<br><small><i>куда отправить</i></small>:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="cabinet_create_email" class="form-control">
            </div>
        </div>

        <div class="form-group row m-b-0">
            <div class="col-sm-4 text-muted form__row__title">
                Роль:
            </div>
            <div class="col-sm-8 with-mt">
                <select name="cabinet_create_role" class="form-control">
                    <?foreach(Access::$clientRoles as $roleId => $role){?>
                        <option value="<?=$roleId?>"><?=$role?></option>
                    <?}?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), cabinetCreateGo)"><i class="fa fa-plus"></i> Создать</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function cabinetCreateGo(btn)
    {
        var params = {
            client_id:      clientId ,
            email_to:       $('[name=cabinet_create_email]').val(),
            role:           $('[name=cabinet_create_role]').val(),
        };

        if(params.email_to == ''){
            message(0, 'Введите email');
            endSubmitForm();
            return false;
        }

        $.post('/clients/cabinet-create', {params:params}, function(data){
            endSubmitForm();

            if(data.success){
                message(1, 'Личный кабинет успешно создан');
                modalClose();
            }else{
                message(0, data.data ? data.data : 'Ошибка создания личного кабинета');
            }
        });
    }
</script>