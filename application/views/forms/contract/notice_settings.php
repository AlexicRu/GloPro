<div class="modal-body">
    <div class="form-group row">
        <div class="col-sm-5">
            <div class="text-right hidden-xs-down text-muted">При блокировке карт:</div>
            <span class="hidden-sm-up text-muted">При блокировке карт:</span>
        </div>
        <div class="col-sm-7">
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_email_card" name="notice_email_card" <?=($settings['EML_CARD_BLOCK'] ? 'checked' : '')?>>
            <label for="notice_email_card">E-mail</label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_sms_card" name="notice_sms_card" <?=($settings['SMS_CARD_BLOCK'] ? 'checked' : '')?>>
                <label for="notice_sms_card">
                    <?
                    $types = [];
                    if ($manager['SENDER_SMS'] && $manager['SMS_IS_ON']) {$types[] = 'SMS';}
                    if ($manager['TELEGRAM_IS_ON']) {$types[] = 'Telegram';}
                    ?>
                    <?=implode(' / ', $types)?>
                </label>
            <?}?>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <div class="text-right hidden-xs-down text-muted">При пополнении счета:</div>
            <span class="hidden-sm-up text-muted">При пополнении счета:</span>
        </div>
        <div class="col-sm-7">
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_email_payment" name="notice_email_payment" <?=($settings['EML_ADD_PAYMENT'] ? 'checked' : '')?>>
            <label for="notice_email_payment">E-mail</label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_sms_payment" name="notice_sms_payment" <?=($settings['SMS_ADD_PAYMENT'] ? 'checked' : '')?>>
                <label for="notice_sms_payment">
                    <?
                    $types = [];
                    if ($manager['SENDER_SMS'] && $manager['SMS_IS_ON']) {$types[] = 'SMS';}
                    if ($manager['TELEGRAM_IS_ON']) {$types[] = 'Telegram';}
                    ?>
                    <?=implode(' / ', $types)?>
                </label>
            <?}?>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <div class="text-right hidden-xs-down text-muted">При блокировке фирмы:</div>
            <span class="hidden-sm-up text-muted">При блокировке фирмы:</span>
        </div>
        <div class="col-sm-7">
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_email_firm" name="notice_email_firm" <?=($settings['EML_CONTRACT_BLOCK'] ? 'checked' : '')?>>
            <label for="notice_email_firm">E-mail</label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_sms_firm" name="notice_sms_firm" <?=($settings['SMS_CONTRACT_BLOCK'] ? 'checked' : '')?>>
                <label for="notice_sms_firm">
                    <?
                    $types = [];
                    if ($manager['SENDER_SMS'] && $manager['SMS_IS_ON']) {$types[] = 'SMS';}
                    if ($manager['TELEGRAM_IS_ON']) {$types[] = 'Telegram';}
                    ?>
                    <?=implode(' / ', $types)?>
                </label>
            <?}?>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <div class="text-right hidden-xs-down text-muted">При приближению к критическому порогу:</div>
            <span class="hidden-sm-up text-muted">При приближению к критическому порогу:</span>
        </div>
        <div class="col-sm-7">
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_email_barrier" name="notice_email_barrier" <?=($settings['EML_BLNC_CTRL'] ? 'checked' : '')?>>
            <label for="notice_email_barrier">E-mail</label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_sms_barrier" name="notice_sms_barrier" <?=($settings['SMS_BLNC_CTRL'] ? 'checked' : '')?>>
                <label for="notice_sms_barrier">
                    <?
                    $types = [];
                    if ($manager['SENDER_SMS'] && $manager['SMS_IS_ON']) {$types[] = 'SMS';}
                    if ($manager['TELEGRAM_IS_ON']) {$types[] = 'Telegram';}
                    ?>
                    <?=implode(' / ', $types)?>
                </label>
            <?}?>
        </div>
    </div>

    <div class="form-group row m-b-0">
        <div class="col-sm-5">
            <div class="text-right hidden-xs-down text-muted">Порог:</div>
            <span class="hidden-sm-up text-muted">Порог:</span>
        </div>
        <div class="col-sm-7">
            <input type="text" name="notice_email_barrier_value" class="form-control" value="<?=$settings['EML_BLNC_CTRL_VALUE']?>">
        </div>
    </div>

    <tr>
        <td class="gray right">Уведомление о балансе:</td>
        <td>
            <label><input type="checkbox" name="notice_email_balance" <?=(!empty($settings['EML_BALANCE']) ? 'checked' : '')?>> E-mail</label>
            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <label>
                    <input type="checkbox" name="notice_sms_balance" <?=(!empty($settings['SMS_BALANCE']) ? 'checked' : '')?>>
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
        <td class="gray right">В какие дни уведомлять о балансе:</td>
        <td>
            <?
            $days = str_split(!empty($settings['DAYS_NOTE']) ? $settings['DAYS_NOTE'] : '0000000');
            ?>
            <label><input type="checkbox" name="notice_balance_days_monday"    <?=($days[0] ? 'checked' : '')?>> Понедельник</label><br>
            <label><input type="checkbox" name="notice_balance_days_tuesday"   <?=($days[1] ? 'checked' : '')?>> Вторник</label><br>
            <label><input type="checkbox" name="notice_balance_days_wednesday" <?=($days[2] ? 'checked' : '')?>> Среда</label><br>
            <label><input type="checkbox" name="notice_balance_days_thursday"  <?=($days[3] ? 'checked' : '')?>> Черверг</label><br>
            <label><input type="checkbox" name="notice_balance_days_friday"    <?=($days[4] ? 'checked' : '')?>> Пятница</label><br>
            <label><input type="checkbox" name="notice_balance_days_saturday"  <?=($days[5] ? 'checked' : '')?>> Суббота</label><br>
            <label><input type="checkbox" name="notice_balance_days_sunday"    <?=($days[6] ? 'checked' : '')?>> Воскресенье</label>
        </td>
    </tr>
</div>

<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),editContractNoticesGo)"><i class="fa fa-check"></i> Сохранить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
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
            notice_sms_balance:         $('[name=notice_sms_balance]', form).is(":checked") ? 1 : 0,
            notice_email_card:          $('[name=notice_email_card]', form).is(":checked") ? 1 : 0,
            notice_email_firm:          $('[name=notice_email_firm]', form).is(":checked") ? 1 : 0,
            notice_email_payment:       $('[name=notice_email_payment]', form).is(":checked") ? 1 : 0,
            notice_email_barrier:       $('[name=notice_email_barrier]', form).is(":checked") ? 1 : 0,
            notice_email_balance:       $('[name=notice_email_balance]', form).is(":checked") ? 1 : 0,
            notice_email_barrier_value: $('[name=notice_email_barrier_value]', form).val(),
            notice_balance_days: "" +
                ($('[name=notice_balance_days_monday]', form).is(":checked") ? 1 : 0) +
                ($('[name=notice_balance_days_tuesday]', form).is(":checked") ? 1 : 0) +
                ($('[name=notice_balance_days_wednesday]', form).is(":checked") ? 1 : 0) +
                ($('[name=notice_balance_days_thursday]', form).is(":checked") ? 1 : 0) +
                ($('[name=notice_balance_days_friday]', form).is(":checked") ? 1 : 0) +
                ($('[name=notice_balance_days_saturday]', form).is(":checked") ? 1 : 0) +
                ($('[name=notice_balance_days_sunday]', form).is(":checked") ? 1 : 0)
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