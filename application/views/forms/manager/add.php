<div class="modal-body">
    <div class="form form_add_client">
        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Роль<sup class="required">*</sup>:</div>
                <span class="hidden-sm-up">Роль<sup class="required">*</sup>:</span>
            </div>
            <div class="col-sm-8">
                <select name="manager_add_role" class="custom-select">
                    <?foreach(Access::getAvailableRoles() as $role => $name){?>
                        <option value="<?=$role?>"><?=$name?></option>
                    <?}?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Имя:</div>
                <span class="hidden-sm-up">Имя:</span>
            </div>
            <div class="col-sm-8">
                <input type="text" name="manager_add_name" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Фамилия:</div>
                <span class="hidden-sm-up">Фамилия:</span>
            </div>
            <div class="col-sm-8">
                <input type="text" name="manager_add_surname" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Отчество:</div>
                <span class="hidden-sm-up">Отчество:</span>
            </div>
            <div class="col-sm-8">
                <input type="text" name="manager_add_middlename" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">E-mail:</div>
                <span class="hidden-sm-up">E-mail:</span>
            </div>
            <div class="col-sm-8">
                <input type="text" name="manager_add_email" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Телефон:</div>
                <span class="hidden-sm-up">Телефон:</span>
            </div>
            <div class="col-sm-8">
                <input type="text" name="manager_add_phone" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Логин<sup class="required">*</sup>:</div>
                <span class="hidden-sm-up">Логин<sup class="required">*</sup>:</span>
            </div>
            <div class="col-sm-8">
                <input type="text" name="manager_add_login" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Пароль<sup class="required">*</sup>:</div>
                <span class="hidden-sm-up">Пароль<sup class="required">*</sup>:</span>
            </div>
            <div class="col-sm-8">
                <input type="password" name="manager_add_password" class="form-control">
            </div>
        </div>

        <div class="form-group row m-b-0">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Повторите пароль<sup class="required">*</sup>:</div>
                <span class="hidden-sm-up">Повторите пароль<sup class="required">*</sup>:</span>
            </div>
            <div class="col-sm-8">
                <input type="password" name="manager_add_password_again" class="form-control">
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), managerAdd)"><i class="fa fa-plus"></i> Добавить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    $(function () {
        renderPhoneInput($('[name=manager_add_phone]'));
    });

    function managerAdd()
    {
        var params = {
            role:           $('[name=manager_add_role]').val(),
            name:           $('[name=manager_add_name]').val(),
            surname:        $('[name=manager_add_surname]').val(),
            middlename:     $('[name=manager_add_middlename]').val(),
            email:          $('[name=manager_add_email]').val(),
            phone:          $('[name=manager_add_phone]').val(),
            login:          $('[name=manager_add_login]').val(),
            password:       $('[name=manager_add_password]').val(),
            password_again: $('[name=manager_add_password_again]').val(),
        };

        if(params.login == '' || params.password == ''){
            message(0, 'Заполните логин и пароль');
            endSubmitForm();
            return false;
        }

        if(params.password != params.password_again){
            message(0, 'Пароли не сопадают');
            endSubmitForm();
            return false;
        }

        $.post('/managers/add-manager', {params:params}, function (data) {
            if(data.success){
                message(1, 'Менеджер успешно добавлен');
                modalClose();

                var managerId = data.data.MANAGER_ID;
                var tpl = $('<div class="tab_v tab_v_small"><div></div></div>');
                var tplContent = $('<div class="tab_v_content"></div>');

                tpl
                    .attr('tab', 'manager' + managerId)
                    .find('div').html('<span class="gray">['+ managerId +']</span> '+ data.data.M_NAME)
                ;
                tplContent.attr('tab_content', 'manager' + managerId);

                tpl.on('click', function () {
                    loadManager($(this));
                });

                $('.tabs_managers .tabs_v .scroll').prepend(tpl);
                $('.tabs_managers .tabs_v_content').prepend(tplContent);
            }else{
                message(0, 'Ошибка добавления менеджера');
            }
            endSubmitForm();
        });
    }
</script>