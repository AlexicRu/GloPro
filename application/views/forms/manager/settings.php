<?
$isEdit = true;
if(empty($manager)){
    $manager = $user;
    $isEdit = false;
}
if(!isset($reload)){
    $reload = true;
}
?>
<form method="post" onsubmit="return checkFormManagerSettings($(this));">
    <?if($isEdit){?>
        <input type="hidden" name="manager_settings_id" value="<?=$manager['MANAGER_ID']?>">
    <?}?>

    <div class="row">
        <div class="col-md-6">
            <div class="form">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">Имя:</div>
                        <span class="hidden-sm-up">Имя:</span>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" name="manager_settings_name" class="form-control" value="<?=$manager['MANAGER_NAME']?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">Фамилия:</div>
                        <span class="hidden-sm-up">Фамилия:</span>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" name="manager_settings_surname" class="form-control" value="<?=$manager['MANAGER_SURNAME']?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">Отчество:</div>
                        <span class="hidden-sm-up">Отчество:</span>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" name="manager_settings_middlename" class="form-control" value="<?=$manager['MANAGER_MIDDLENAME']?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">E-mail:</div>
                        <span class="hidden-sm-up">E-mail:</span>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" name="manager_settings_email" class="form-control" value="<?=$manager['EMAIL']?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">Телефон:</div>
                        <span class="hidden-sm-up">Телефон:</span>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" name="manager_settings_phone" class="form-control" value="<?=$manager['CELLPHONE']?>">
                    </div>
                </div>

                <?if (Access::allow('change_phone_note')) {?>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="text-right hidden-xs-down text-muted">Телефон для оповещений:</div>
                            <span class="hidden-sm-up">Телефон для оповещений:</span>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="manager_settings_phone_note" class="form-control" value="<?=$manager['PHONE_FOR_SMS']?>">
                        </div>
                    </div>
                <?}?>

                <?if(!empty($changeRole)){?>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="text-right hidden-xs-down text-muted">Роль:</div>
                            <span class="hidden-sm-up">Роль:</span>
                        </div>
                        <div class="col-sm-8">
                            <select name="manager_settings_role" class="custom-select">
                                <?foreach(Access::getAvailableRoles() as $role => $name){?>
                                    <option value="<?=$role?>" <?if($role == $manager['ROLE_ID']){?>selected<?}?>><?=$name?></option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                <?}?>

                <?if (in_array($manager['ROLE_ID'], array_keys(Access::$clientRoles))) {?>
                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <input type="checkbox" id="manager_settings_limit_<?=$manager['MANAGER_ID']?>" name="manager_settings_limit" <?if ($manager['LIMIT_RESTRICTION'] == 1) {?>checked<?}?> class="<?=Text::CHECKBOX?>">
                            <label for="manager_settings_limit_<?=$manager['MANAGER_ID']?>">Ограничение в 1000 литров и 30000 рублей на лимит</label>
                        </div>
                    </div>
                <?}?>

                <div class="form-group row hidden-md-down">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <button class="<?=Text::BTN?> btn-outline-success btn_manager_settings_go"><i class="fa fa-check"></i> Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-light p-3">
                <b class="font-weight-bold m-b-10">Смена пароля</b>

                <div class="form">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="text-right hidden-xs-down text-muted">Логин:</div>
                            <span class="hidden-sm-up">Логин:</span>
                        </div>
                        <div class="col-sm-8">
                            <?if (Access::allow('clients_edit-login')) {?>
                                <div toggle_block="edit_login">
                                    <span class="login_value"><?=$manager['LOGIN']?></span>
                                    <span class="btn waves-effect waves-light btn_small" toggle="edit_login"><i class="icon icon-pen"></i></span>
                                </div>
                                <div toggle_block="edit_login" style="display: none">
                                    <input type="text" value="<?=$manager['LOGIN']?>" name="edit_login" class="form-control">
                                    <span class="btn waves-effect waves-light btn_small btn_green" onclick="editLogin($(this));"><i class="icon icon-ok"></i></span>
                                    <span class="btn waves-effect waves-light btn_small btn_red" toggle="edit_login"><i class="icon icon-cancel"></i></span>
                                </div>
                            <?} else {?>
                                <?=$manager['LOGIN']?>
                            <?}?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="text-right hidden-xs-down text-muted">Пароль:</div>
                            <span class="hidden-sm-up">Пароль:</span>
                        </div>
                        <div class="col-sm-8">
                            <input type="password" name="manager_settings_password" class="form-control" <?=($manager['MANAGER_ID'] == Access::USER_TEST ? 'readonly' : '')?>>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <div class="text-right hidden-xs-down text-muted">Пароль еще раз:</div>
                            <span class="hidden-sm-up">Пароль еще раз:</span>
                        </div>
                        <div class="col-sm-8">
                            <input type="password" name="manager_settings_password_again" class="form-control" <?=($manager['MANAGER_ID'] == Access::USER_TEST ? 'readonly' : '')?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row hidden-lg-up m-t-20 m-b-0">
        <div class="col-sm-4"></div>
        <div class="col-sm-8">
            <button class="<?=Text::BTN?> btn-outline-success btn_manager_settings_go"><i class="fa fa-check"></i> Сохранить</button>
        </div>
    </div>

</form>

<script>
    $(function () {
        $("[name=manager_settings_phone], [name=manager_settings_phone_note]").each(function () {
            renderPhoneInput($(this));
        });
    });

    function checkFormManagerSettings(form)
    {
        var pass = $('[name=manager_settings_password]', form).val();
        var passAgain = $('[name=manager_settings_password_again]', form).val();

        if(pass != passAgain){
            message(0, 'Пароли не совпадают');
            return false;
        }

        var phone = $("[name=manager_settings_phone]");
        var phoneNote = $("[name=manager_settings_phone_note]");

        if (
            phone.intlTelInput('isValidNumber') == false &&
            ('+' + phone.intlTelInput("getSelectedCountryData").dialCode) != phone.intlTelInput('getNumber')
        ) {
            message(0, 'Некорректный номер телефона');
            return false;
        }

        if (
            phoneNote.intlTelInput('isValidNumber') == false &&
            ('+' + phoneNote.intlTelInput("getSelectedCountryData").dialCode) != phoneNote.intlTelInput('getNumber')
        ) {
            message(0, 'Некорректный номер телефона для оповещений');
            return false;
        }

        $.post('/managers/settings', form.find(':input[name!="edit_login"]').serialize(), function (data) {
           if(data.success){
               <?if($reload){?>
               window.location.reload();
               <?}?>

               message(1, 'Данные обновлены');
           }else{
               var error = 'Ошибка обновления';
               if (data.data) {
                   error = data.data;
               }
               message(0, error);
           }
        });

        return false;
    }

    function editLogin(btn)
    {
        var td = btn.closest('td');
        var txt = td.find('.login_value');
        var input = td.find('[name=edit_login]');
        var form = btn.closest('form');
        var managerId = form.find('[name=manager_settings_id]').val();

        if(input.val() == ''){
            message(0, 'Логин не должен быть пустым');
            return false;
        }

        var params = {
            login: input.val(),
            manager_id: managerId
        };

        $.post('/clients/edit-login', params, function (data) {
            if(data.success){
                message(1, 'Логин обновлен');
                txt.text(data.data.login)
                td.find('[toggle=edit_login]:first').click();
            }else{
                message(0, 'Ошибка. ' + data.data.error);
            }
        });
    }
</script>