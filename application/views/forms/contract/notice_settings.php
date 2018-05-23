<div class="modal-body">
    <div class="font-20 font-weight-bold m-b-10">Уведомления по e-mail:</div>

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
        var params = {
            notice_email_card:          $('[name=notice_email_card]').is(":checked") ? 1 : 0,
            notice_email_firm:          $('[name=notice_email_firm]').is(":checked") ? 1 : 0,
            notice_email_barrier:       $('[name=notice_email_barrier]').is(":checked") ? 1 : 0,
            notice_email_barrier_value: $('[name=notice_email_barrier_value]').val()
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