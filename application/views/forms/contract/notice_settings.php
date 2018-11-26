<?
$types = [];
if ($manager['SENDER_SMS'] && $manager['SMS_IS_ON']) {$types[] = 'SMS';}
if ($manager['TELEGRAM_IS_ON']) {$types[] = 'Telegram';}
?>

<div class="modal-body">
    <div class="form-group row mb-1">
        <div class="col-sm-5 text-muted form__row__title">
            При блокировке карт:
        </div>
        <div class="col-sm-7">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_email_card" <?=(!empty($settings['EML_CARD_BLOCK']) ? 'checked' : '')?>>
                <span class="custom-control-label">E-mail</span>
            </label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="notice_sms_card" <?=(!empty($settings['SMS_CARD_BLOCK']) ? 'checked' : '')?>>
                    <span class="custom-control-label"><?=implode(' / ', $types)?></span>
                </label>
            <?}?>
        </div>
    </div>

    <div class="form-group row mb-1">
        <div class="col-sm-5 text-muted form__row__title">
            При пополнении счета:
        </div>
        <div class="col-sm-7">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_email_payment" <?=(!empty($settings['EML_ADD_PAYMENT']) ? 'checked' : '')?>>
                <span class="custom-control-label">E-mail</span>
            </label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="notice_sms_payment" <?=(!empty($settings['SMS_ADD_PAYMENT']) ? 'checked' : '')?>>
                    <span class="custom-control-label"><?=implode(' / ', $types)?></span>
                </label>
            <?}?>
        </div>
    </div>

    <div class="form-group row mb-1">
        <div class="col-sm-5 text-muted form__row__title">
            При блокировке фирмы:
        </div>
        <div class="col-sm-7">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_email_firm" <?=(!empty($settings['notice_email_firm']) ? 'checked' : '')?>>
                <span class="custom-control-label">E-mail</span>
            </label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="notice_sms_firm" <?=(!empty($settings['SMS_CONTRACT_BLOCK']) ? 'checked' : '')?>>
                    <span class="custom-control-label"><?=implode(' / ', $types)?></span>
                </label>
            <?}?>
        </div>
    </div>

    <div class="form-group row mb-1">
        <div class="col-sm-5 text-muted form__row__title">
            При приближению к критическому порогу:
        </div>
        <div class="col-sm-7">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_email_barrier" <?=(!empty($settings['EML_BLNC_CTRL']) ? 'checked' : '')?>>
                <span class="custom-control-label">E-mail</span>
            </label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="notice_sms_barrier" <?=(!empty($settings['SMS_BLNC_CTRL']) ? 'checked' : '')?>>
                    <span class="custom-control-label"><?=implode(' / ', $types)?></span>
                </label>
            <?}?>
        </div>
    </div>

    <div class="form-group row mb-1">
        <div class="col-sm-5 text-muted form__row__title">
            Порог:
        </div>
        <div class="col-sm-7">
            <input type="number" name="notice_email_barrier_value" class="form-control" value="<?=(!empty($settings['EML_BLNC_CTRL_VALUE']) ? $settings['EML_BLNC_CTRL_VALUE'] : '')?>">
        </div>
    </div>

    <div class="form-group row mb-1">
        <div class="col-sm-5 text-muted form__row__title">
            Уведомление о балансе:
        </div>
        <div class="col-sm-7">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_email_balance" <?=(!empty($settings['EML_BALANCE']) ? 'checked' : '')?>>
                <span class="custom-control-label">E-mail</span>
            </label>

            <?if ($manager['PHONE_FOR_INFORM'] && ($manager['SMS_IS_ON'] || $manager['TELEGRAM_IS_ON'])) {?>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="notice_sms_balance" <?=(!empty($settings['SMS_BALANCE']) ? 'checked' : '')?>>
                    <span class="custom-control-label"><?=implode(' / ', $types)?></span>
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
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_balance_days_monday" <?=($days[0] ? 'checked' : '')?>>
                <span class="custom-control-label">Понедельник</span>
            </label>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_balance_days_tuesday" <?=($days[1] ? 'checked' : '')?>>
                <span class="custom-control-label">Вторник</span>
            </label>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_balance_days_wednesday" <?=($days[2] ? 'checked' : '')?>>
                <span class="custom-control-label">Среда</span>
            </label>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_balance_days_thursday" <?=($days[3] ? 'checked' : '')?>>
                <span class="custom-control-label">Черверг</span>
            </label>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_balance_days_friday" <?=($days[4] ? 'checked' : '')?>>
                <span class="custom-control-label">Пятница</span>
            </label>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_balance_days_saturday" <?=($days[5] ? 'checked' : '')?>>
                <span class="custom-control-label">Суббота</span>
            </label>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="notice_balance_days_sunday" <?=($days[6] ? 'checked' : '')?>>
                <span class="custom-control-label">Воскресенье</span>
            </label>
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