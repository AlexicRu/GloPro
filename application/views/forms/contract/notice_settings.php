<div class="modal-body">
    <div class="form-group row">
        <div class="col-sm-5 text-muted form__row__title">
            При блокировке карт:
        </div>
        <div class="col-sm-7">
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_email_card" name="notice_email_card" <?=(!empty($settings['EML_CARD_BLOCK']) ? 'checked' : '')?>>
            <label for="notice_email_card">E-mail</label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_sms_card" name="notice_sms_card" <?=(!empty($settings['SMS_CARD_BLOCK']) ? 'checked' : '')?>>
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
        <div class="col-sm-5 text-muted form__row__title">
            При пополнении счета:
        </div>
        <div class="col-sm-7">
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_email_payment" name="notice_email_payment" <?=(!empty($settings['EML_ADD_PAYMENT']) ? 'checked' : '')?>>
            <label for="notice_email_payment">E-mail</label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_sms_payment" name="notice_sms_payment" <?=(!empty($settings['SMS_ADD_PAYMENT']) ? 'checked' : '')?>>
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
        <div class="col-sm-5 text-muted form__row__title">
            При блокировке фирмы:
        </div>
        <div class="col-sm-7">
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_email_firm" name="notice_email_firm" <?=(!empty($settings['EML_CONTRACT_BLOCK']) ? 'checked' : '')?>>
            <label for="notice_email_firm">E-mail</label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_sms_firm" name="notice_sms_firm" <?=(!empty($settings['SMS_CONTRACT_BLOCK']) ? 'checked' : '')?>>
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
        <div class="col-sm-5 text-muted form__row__title">
            При приближению к критическому порогу:
        </div>
        <div class="col-sm-7">
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_email_barrier" name="notice_email_barrier" <?=(!empty($settings['EML_BLNC_CTRL']) ? 'checked' : '')?>>
            <label for="notice_email_barrier">E-mail</label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_sms_barrier" name="notice_sms_barrier" <?=(!empty($settings['SMS_BLNC_CTRL']) ? 'checked' : '')?>>
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

    <div class="form-group row">
        <div class="col-sm-5 text-muted form__row__title">
            Порог:
        </div>
        <div class="col-sm-7">
            <input type="number" name="notice_email_barrier_value" class="form-control" value="<?=(!empty($settings['EML_BLNC_CTRL_VALUE']) ? $settings['EML_BLNC_CTRL_VALUE'] : '')?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5 text-muted form__row__title">
            Уведомление о балансе:
        </div>
        <div class="col-sm-7">
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_email_balance" name="notice_email_balance" <?=(!empty($settings['EML_BALANCE']) ? 'checked' : '')?>>
            <label for="notice_email_balance">E-mail</label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <br>
                <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_sms_balance" name="notice_sms_balance" <?=(!empty($settings['SMS_BALANCE']) ? 'checked' : '')?>>
                <label for="notice_sms_balance">
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
        <div class="col-sm-5 text-muted form__row__title">
            В какие дни уведомлять о балансе:
        </div>
        <div class="col-sm-7">
            <?
            $days = str_split(!empty($settings['DAYS_NOTE']) ? $settings['DAYS_NOTE'] : '0000000');
            ?>
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_balance_days_monday" name="notice_balance_days_monday"    <?=($days[0] ? 'checked' : '')?>>
            <label for="notice_balance_days_monday">Понедельник</label><br>
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_balance_days_tuesday" name="notice_balance_days_tuesday"   <?=($days[1] ? 'checked' : '')?>>
            <label for="notice_balance_days_tuesday">Вторник</label><br>
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_balance_days_wednesday" name="notice_balance_days_wednesday" <?=($days[2] ? 'checked' : '')?>>
            <label for="notice_balance_days_wednesday">Среда</label><br>
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_balance_days_thursday" name="notice_balance_days_thursday"  <?=($days[3] ? 'checked' : '')?>>
            <label for="notice_balance_days_thursday">Черверг</label><br>
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_balance_days_friday" name="notice_balance_days_friday"    <?=($days[4] ? 'checked' : '')?>>
            <label for="notice_balance_days_friday">Пятница</label><br>
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_balance_days_saturday" name="notice_balance_days_saturday"  <?=($days[5] ? 'checked' : '')?>>
            <label for="notice_balance_days_saturday">Суббота</label><br>
            <input type="checkbox" class="<?=Text::CHECKBOX?>" id="notice_balance_days_sunday" name="notice_balance_days_sunday"    <?=($days[6] ? 'checked' : '')?>>
            <label for="notice_balance_days_sunday">Воскресенье</label><br>
        </div>
    </div>

</div>

<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),editContractNoticesGo)"><i class="fa fa-check"></i> Сохранить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function editContractNoticesGo(btn)
    {
        var form = btn.closest('.modal-content');
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