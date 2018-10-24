<div class="modal-body">
    <div class="form form_add_client">
        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Телефон для оповещений:</div>
                <span class="hidden-sm-up text-muted">Телефон для оповещений:</span>
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="manager_settings_phone_note" class="input_big" value="<?=$manager['PHONE_FOR_INFORM']?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">
                    <button class="<?=Text::BTN?> btn-sm manager_settings_confirm_code_btn btn-outline-primary" onclick="getSmsConfirmCode($(this))">
                        Получить код
                    </button>
                </div>
                <span class="hidden-sm-up text-muted">
                    <button class="<?=Text::BTN?> btn-sm manager_settings_confirm_code_btn btn-outline-primary" onclick="getSmsConfirmCode($(this))">
                        Получить код
                    </button>
                </span>
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="manager_settings_confirm_code" class="input_mini">
            </div>
        </div>
    </div>

    <i class="gray">
        Запросить новый код можно через (секунды): <b class="sms_code_renew">0</b><br>
        Время жизни кода (секунды): <b class="sms_code_lifetime">0</b>
    </i>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), doAddInform)"><i class="fa fa-plug"></i> Подключить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    $(function () {
        $("[name=manager_settings_phone_note]").each(function () {
            renderPhoneInput($(this));
        });
    });

    function doAddInform(btn)
    {
        var phoneNote = $("[name=manager_settings_phone_note]");
        var confirmCode = $("[name=manager_settings_confirm_code]").val();

        if (phoneNote.intlTelInput('isValidNumber') == false) {
            message(0, 'Некорректный номер телефона для оповещений');
            return false;
        }

        if (!confirmCode || confirmCode.length != 4) {
            message(0, 'Некорректный код подтверждения');
            return false;
        }

        var params = {
            phone: phoneNote.intlTelInput('getNumber'),
            code: confirmCode,
        };

        $.post('/inform/enable-inform', params, function (data) {
            if (data.success) {
                message(1, 'Информирование успешно подключено');
                $.fancybox.close();

                var form = $('.manager_settings_form:visible');

                $('.manager_settings_inform > div', form).toggle();
                $('.manager_settings_inform_phone', form).text(params.phone);
                $('.manager_settings_inform_checkboxes [type=checkbox]:not(.blocked)', form).prop('disabled', false).trigger('change');
            } else {
                var error = '';

                if (data.data) {
                    error = data.data;
                }

                message(0, 'Ошибка подключение информирования. ' + error);
            }
        });
    }

    var SMSCodeRenew = 0;
    var SMSCodeLifetime = 0;
    var i, i2;
    function getSmsConfirmCode(btn)
    {
        if (SMSCodeRenew != 0) {
            return false;
        }

        var phoneNote = $("[name=manager_settings_phone_note]");

        if (phoneNote.intlTelInput('isValidNumber') == false) {
            message(0, 'Некорректный номер телефона для оповещений');
            return false;
        }

        $.post('/inform/send-sms-confirm-code', {phone: phoneNote.intlTelInput('getNumber')}, function (data) {
            if (data.success) {
                message(1, 'SMS с кодом отправлено');

                clearInterval(i);
                clearInterval(i2);

                SMSCodeRenew = data.data.renew;
                SMSCodeLifetime = data.data.lifetime;
                $('.sms_code_renew').text(SMSCodeRenew);
                $('.sms_code_lifetime').text(SMSCodeLifetime);
                btn.prop('disabled', true);

                i = setInterval(function () {
                    SMSCodeRenew--;

                    $('.sms_code_renew').text(SMSCodeRenew);

                    if (!SMSCodeRenew) {
                        clearInterval(i);
                        btn.prop('disabled', false);
                    }
                }, 1000);

                i2 = setInterval(function () {
                    SMSCodeLifetime--;

                    $('.sms_code_lifetime').text(SMSCodeLifetime);

                    if (!SMSCodeLifetime) {
                        clearInterval(i2);
                    }
                }, 1000);
            } else {
                message(0, data.data);
            }
        });
    }
</script>