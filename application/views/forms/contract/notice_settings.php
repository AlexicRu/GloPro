<table class="table_form form_settings">
    <tr>
        <td class="gray right" width="170">При блокировке карт:</td>
        <td>
            <label><input type="checkbox" name="notice_email_card" <?=($settings['EML_CARD_BLOCK'] ? 'checked' : '')?>> E-mail</label>
            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <label>
                    <input type="checkbox" name="notice_sms_card" <?=($settings['SMS_CARD_BLOCK'] ? 'checked' : '')?>>
                    <?
                    $types = [];
                    if ($manager['SENDER_SMS'] && $manager['SMS_IS_ON']) {$types[] = 'SMS';}
                    if ($manager['TELEGRAM_IS_ON']) {$types[] = 'Telegram';}
                    ?>
                    <?=implode(' / ', $types)?>
                </label>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="gray right">При пополнении счета:</td>
        <td>
            <label><input type="checkbox" name="notice_email_payment" <?=($settings['EML_ADD_PAYMENT'] ? 'checked' : '')?>> E-mail</label>
            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <label>
                    <input type="checkbox" name="notice_sms_payment" <?=($settings['SMS_ADD_PAYMENT'] ? 'checked' : '')?>>
                    <?
                    $types = [];
                    if ($manager['SENDER_SMS'] && $manager['SMS_IS_ON']) {$types[] = 'SMS';}
                    if ($manager['TELEGRAM_IS_ON']) {$types[] = 'Telegram';}
                    ?>
                    <?=implode(' / ', $types)?>
                </label>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="gray right">При блокировке фирмы:</td>
        <td>
            <label><input type="checkbox" name="notice_email_firm" <?=($settings['EML_CONTRACT_BLOCK'] ? 'checked' : '')?>> E-mail</label>
            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <label>
                    <input type="checkbox" name="notice_sms_firm" <?=($settings['SMS_CONTRACT_BLOCK'] ? 'checked' : '')?>>
                    <?
                    $types = [];
                    if ($manager['SENDER_SMS'] && $manager['SMS_IS_ON']) {$types[] = 'SMS';}
                    if ($manager['TELEGRAM_IS_ON']) {$types[] = 'Telegram';}
                    ?>
                    <?=implode(' / ', $types)?>
                </label>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="gray right">При приближению к критическому порогу:</td>
        <td>
            <label><input type="checkbox" name="notice_email_barrier" <?=($settings['EML_BLNC_CTRL'] ? 'checked' : '')?>> E-mail</label>
            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <label>
                    <input type="checkbox" name="notice_sms_barrier" <?=($settings['SMS_BLNC_CTRL'] ? 'checked' : '')?>>
                    <?
                    $types = [];
                    if ($manager['SENDER_SMS'] && $manager['SMS_IS_ON']) {$types[] = 'SMS';}
                    if ($manager['TELEGRAM_IS_ON']) {$types[] = 'Telegram';}
                    ?>
                    <?=implode(' / ', $types)?>
                </label>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="gray right">Порог:</td>
        <td>
            <input type="text" name="notice_email_barrier_value" value="<?=$settings['EML_BLNC_CTRL_VALUE']?>">
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <span class="btn btn_reverse" onclick="submitForm($(this), checkFormContractNoticeSettings)"><i class="icon-ok"></i> Сохранить</span>
            <span class="btn btn_red fancy_close">Отмена</span>
        </td>
    </tr>
</table>

<div class="modal-body">
    <b class="font-20 m-b-10">Уведомления по e-mail:</b>

    <div class="m-b-10">
        <input type="checkbox" class="filled-in chk-col-purple" name="notice_email_card" id="notice_email_card" <?=($settings['EML_CARD_BLOCK'] ? 'checked' : '')?>>
        <label for="notice_email_card">При блокировке карт</label>
    </div>

    <div class="m-b-10">
        <input type="checkbox" class="filled-in chk-col-purple" name="notice_email_firm" id="notice_email_firm" <?=($settings['EML_CONTRACT_BLOCK'] ? 'checked' : '')?>>
        <label for="notice_email_firm">При блокировке фирмы</label>
    </div>

    <div class="m-b-10">
        <input type="checkbox" class="filled-in chk-col-purple" name="notice_email_barrier" id="notice_email_barrier" <?=($settings['EML_BLNC_CTRL'] ? 'checked' : '')?>>
        <label for="notice_email_barrier">При приближению к критическому порогу</label>

        <div class="input-group m-t-10">
            <div class="input-group-prepend">
                <div class="input-group-text">Порог:</div>
            </div>
            <input type="text" name="notice_email_barrier_value" value="<?=$settings['EML_BLNC_CTRL_VALUE']?>" class="form-control">
        </div>
    </div>

</div>

<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),editContractNoticesGo)"><i class="fa fa-check"></i> Сохранить</span>
    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function editContractNoticesGo(btn)
    {
        var form = btn.closest('.form_settings');
        var params = {
            notice_sms_card:            $('[name=notice_sms_card]', form).is(":checked") ? 1 : 0,
            notice_sms_firm:            $('[name=notice_sms_firm]', form).is(":checked") ? 1 : 0,
            notice_sms_payment:         $('[name=notice_sms_payment]', form).is(":checked") ? 1 : 0,
            notice_sms_barrier:         $('[name=notice_sms_barrier]', form).is(":checked") ? 1 : 0,
            notice_email_card:          $('[name=notice_email_card]', form).is(":checked") ? 1 : 0,
            notice_email_firm:          $('[name=notice_email_firm]', form).is(":checked") ? 1 : 0,
            notice_email_payment:       $('[name=notice_email_payment]', form).is(":checked") ? 1 : 0,
            notice_email_barrier:       $('[name=notice_email_barrier]', form).is(":checked") ? 1 : 0,
            notice_email_barrier_value: $('[name=notice_email_barrier_value]', form).val()
        };

        $.post('/clients/edit-contract-notices', {contract_id: $('[name=contracts_list]').val(), params:params}, function (data) {
            if(data.success){
                message(1, 'Настройки уведомлений обновлены');
                modalClose();
            }else{
                message(0, 'Ошибка настройки уведомлений');
            }
            endSubmitForm();
        });
    }
</script>