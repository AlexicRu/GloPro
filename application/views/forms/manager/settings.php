<form method="post" onsubmit="return checkFormManagerSettings($(this));" class="manager_settings_form">
    <?if(empty($selfEdit)){?>
        <input type="hidden" name="manager_settings_id" value="<?=$manager['MANAGER_ID']?>">
    <?}?>

    <div class="row">
        <div class="col-md-6">
            <div class="form">
                <div class="form-group row">
                    <div class="col-sm-4 text-muted form__row__title">
                        Имя:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <input type="text" name="manager_settings_name" class="form-control" value="<?=$manager['MANAGER_NAME']?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 text-muted form__row__title">
                        Фамилия:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <input type="text" name="manager_settings_surname" class="form-control" value="<?=$manager['MANAGER_SURNAME']?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 text-muted form__row__title">
                        Отчество:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <input type="text" name="manager_settings_middlename" class="form-control" value="<?=$manager['MANAGER_MIDDLENAME']?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 text-muted form__row__title">
                        E-mail:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <input type="text" name="manager_settings_email" class="form-control" value="<?=$manager['EMAIL']?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 text-muted form__row__title">
                        Телефон:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <input type="text" name="manager_settings_phone" class="form-control" value="<?=$manager['CELLPHONE']?>">
                    </div>
                </div>

                <?if(!empty($changeRole)){?>
                    <div class="form-group row">
                        <div class="col-sm-4 text-muted form__row__title">
                            Роль:
                        </div>
                        <div class="col-sm-8 with-mt">
                            <select name="manager_settings_role" class="custom-select">
                                <?foreach(Access::getAvailableRoles() as $role => $name){?>
                                    <option value="<?=$role?>" <?if($role == $manager['ROLE_ID']){?>selected<?}?>><?=$name?></option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                <?}?>

                <?if (Access::allow('change_manager_settings_limit') && in_array($manager['ROLE_ID'], array_keys(Access::$clientRoles))) {?>
                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8 with-mt">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="manager_settings_limit"
                                       <?if ($manager['LIMIT_RESTRICTION'] == 1) {?>checked<?}?>
                                >
                                <span class="custom-control-label">Ограничение в 1000 литров и 30000 рублей на лимит</span>
                            </label>
                        </div>
                    </div>
                <?}?>

                <div class="form-group row hidden-md-down">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8 with-mt">
                        <button class="<?= Text::BTN ?> btn-success"><i class="fa fa-check"></i> Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-light p-3">
                <b class="font-weight-bold m-b-10 font-18">Смена пароля</b>

                <div class="form">
                    <div class="form-group row">
                        <div class="col-sm-4 text-muted form__row__title">
                            Логин:
                        </div>
                        <div class="col-sm-8 with-mt">
                            <?if (Access::allow('clients_edit-login')) {?>
                                <div toggle_block="edit_login">
                                    <span class="login_value"><?=$manager['LOGIN']?></span>
                                    <span class="<?=Text::BTN?> btn-sm btn-primary" toggle="edit_login"><i class="fa fa-pen"></i></span>
                                </div>
                                <div toggle_block="edit_login" style="display: none">
                                    <input type="text" value="<?=$manager['LOGIN']?>" name="edit_login" class="form-control">
                                    <span class="<?=Text::BTN?> btn-sm btn-success" onclick="editLogin($(this));"><i class="fa fa-check"></i></span>
                                    <span class="<?=Text::BTN?> btn-sm btn-danger" toggle="edit_login"><i class="fa fa-times"></i></span>
                                </div>
                            <?} else {?>
                                <?=$manager['LOGIN']?>
                            <?}?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4 text-muted form__row__title">
                            Пароль:
                        </div>
                        <div class="col-sm-8 with-mt">
                            <input type="password" name="manager_settings_password" class="form-control" <?=($manager['MANAGER_ID'] == Access::USER_TEST ? 'readonly' : '')?>>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4 text-muted form__row__title">
                            Пароль еще раз:
                        </div>
                        <div class="col-sm-8 with-mt">
                            <input type="password" name="manager_settings_password_again" class="form-control" <?=($manager['MANAGER_ID'] == Access::USER_TEST ? 'readonly' : '')?>>
                        </div>
                    </div>

                    <br>
                    <b class="font-18 m-b-10">Информирование</b>

                    <div class="manager_settings_inform">
                        <div <?=($manager['PHONE_FOR_INFORM'] ? '' : 'style="display:none"')?>>
                            <b>Подключено на номер <span class="manager_settings_inform_phone"><?=$manager['PHONE_FOR_INFORM']?></span></b>

                            <?if(!empty($selfEdit)){?>
                                &nbsp;&nbsp;&nbsp;
                                <span class="<?=Text::BTN?> btn-sm btn-danger" onclick="disableInform($(this))">Отключить</span>
                            <?}?>
                        </div>
                        <div <?=(!$manager['PHONE_FOR_INFORM'] ? '' : 'style="display:none"')?>>
                            <b>Не подключено</b>

                            <?if(!empty($selfEdit)){?>
                                &nbsp;&nbsp;&nbsp;
                                <span data-toggle="modal" data-target="#manager_inform" class="<?=Text::BTN?> btn-sm btn-success">Подключить</span>
                            <?}?>
                        </div>
                    </div>

                    <div class="p-3 manager_settings_inform_checkboxes">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   name="manager_sms_is_on"
                                <?=($manager['SMS_IS_ON'] ? 'checked' : '')?>
                                <?=(($manager['PHONE_FOR_INFORM'] && $manager['SENDER_SMS']) || Access::allow('root') ? '' : 'disabled')?>
                            >
                            <span class="custom-control-label">
                                SMS  <?=(!$manager['SENDER_SMS'] ? '<span class="text-muted">Недоступно. Обратитесь к менеджеру.</span>' : '')?>
                            </span>
                        </label>

                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   name="manager_telegram_is_on"
                                <?=($manager['TELEGRAM_IS_ON'] ? 'checked' : '')?>
                                <?=($manager['PHONE_FOR_INFORM'] ? '' : 'disabled')?>
                            >
                            <span class="custom-control-label">
                                Telegram
                                <?if (empty($manager['TELEGRAM_CHAT_ID'])) {?>
                                    <span class="text-muted">Необходима авторизация через Telegram бота</span>
                                <?}?>
                            </span>
                        </label>

                        <br>
                        <a href="https://t.me/GloProInfo_bot" target="_blank">@GloProInfo_bot</a> - наш телеграм бот.<br>
                        <i class="text-muted">Перейдите по ссылке или найдите его через поиск в Telegram.</i><br>
                        <i class="text-muted">Авторизация в телеграм боте автоматически установит галочку Telegram информирования.</i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row hidden-lg-up m-t-20 m-b-0">
        <div class="col-sm-4"></div>
        <div class="col-sm-8 with-mt">
            <button class="<?= Text::BTN ?> btn-success"><i class="fa fa-check"></i> Сохранить</button>
        </div>
    </div>
</form>

<?if (!empty($selfEdit) && !empty($popupManagerInform)) {
    echo $popupManagerInform;
}?>

<script>
    $(function () {
        $("[name=manager_settings_phone]").each(function () {
            renderPhoneInput($(this));
        });
    });

    <?if (!empty($selfEdit)) {?>
    function disableInform(btn)
    {
        if (!confirm('Отключаем информирование?')) {
            return false;
        }

        $.post('/inform/disable-inform', {}, function (data) {
            if (data.success) {
                message(1, 'Информирование успешно отключено');

                $('.manager_settings_inform > div', btn.closest('.manager_settings_form')).toggle();
                $('.manager_settings_inform_checkboxes [type=checkbox]', btn.closest('.manager_settings_form')).prop('disabled', true).trigger('change');
            } else {
                message(0, 'Ошибка отключение информирования');
            }
        });
    }
    <?}?>

    function checkFormManagerSettings(form)
    {
        var pass = $('[name=manager_settings_password]', form).val();
        var passAgain = $('[name=manager_settings_password_again]', form).val();

        if(pass != passAgain){
            message(0, 'Пароли не совпадают');
            return false;
        }

        var phone = $("[name=manager_settings_phone]");

        if (
            phone.intlTelInput('isValidNumber') == false &&
            ('+' + phone.intlTelInput("getSelectedCountryData").dialCode) != phone.intlTelInput('getNumber') &&
            phone.intlTelInput('getNumber') != ''
        ) {
            message(0, 'Некорректный номер телефона');
            return false;
        }

        $.post('/managers/settings', form.find(':input[name!="edit_login"]').serialize(), function (data) {
           if(data.success){
               message(1, 'Данные обновлены');

               <?if(!empty($noReload)){?>
               setTimeout(function () {
                   window.location.reload();
               }, 1000);
               <?}?>
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
        var td = btn.closest('div');
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