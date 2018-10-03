<div class="card card-transfer-block">
    <div class="card-body">
        <div class="row m-b-20 border-bottom p-b-20">
            <div class="col-sm-5">
                <div class="m-b-5">
                    <b class="font-18">Карты старого договора:<sup>*</sup></b>
                </div>

                <?=Form::buildField('card_choose_multi', 'card_choose_multi', false, [
                    'show_all'      => true,
                    'placeholder'   => 'Выбрать карты'
                ])?>

                <div class="m-b-15 m-t-15">или</div>

                <textarea class="form-control" name="cards_list" placeholder="Ввести список карт"></textarea>
            </div>
            <div class="col-sm-2 p-t-40 text-center">
                <b class="font-20">&xrArr;</b>
            </div>
            <div class="col-sm-5">
                <div class="m-b-5">
                    <b class="font-18">Новый договор:</b>
                </div>

                <?=Form::buildField('contract_choose_single', 'contract_new')?>
            </div>
        </div>

        <div class="row m-b-20">
            <div class="col-sm-5">
                <div class="m-b-5">
                    <b class="font-18">Дата начала переноса:</b>
                </div>

                <?=Form::buildField('datepick', 'date_from', date('d.m.Y'))?>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-5">
                <div class="m-b-5">
                    <b class="font-18">Дата окончания переноса:</b>
                </div>

                <?=Form::buildField('datepick', 'date_to')?>
            </div>
        </div>

        <div class="m-b-20">
            <input type="checkbox" class="<?=Text::CHECKBOX?>" checked name="transfer_cards" id="transfer_cards"> <label for="transfer_cards">Перенос карт</label><br>
            <input type="checkbox" class="<?=Text::CHECKBOX?>" checked name="transfer_trn" id="transfer_trn"> <label for="transfer_trn">Перенос транзакций<sup>**</sup></label><br>
            <input type="checkbox" class="<?=Text::CHECKBOX?>" checked name="save_holder" id="save_holder"> <label for="save_holder">С сохранением держателей</label>
        </div>

        <div class="m-b-20">
            <span class="<?=Text::BTN?> btn-outline-primary btn-lg" onclick="transferCards($(this))">Перенести</span>
        </div>

        <i class="text-muted">* - Выбор клиента и договора обязателен</i><br>
        <i class="text-muted">** - Транзакции будут перенесены только за текущий период. Если требуется перенести транзакции за прошлые периоды, обратитесь в <a href="/support">Техническую поддержку</a></i>
    </div>
</div>

<script>
    var isAjax = false;

    function transferCards(btn)
    {
        if (isAjax) {
            return false;
        }
        isAjax = true;

        var block = btn.closest('.card-transfer-block');
        addLoader(block);

        var params = {
            old_contract:           getComboBoxValue($('[name=contract_choose_single]'), true),
            new_contract:           getComboBoxValue($('[name=contract_new]')),
            cards:                  getComboBoxMultiValue($('[name=card_choose_multi]')),
            cards_list:             $('[name=cards_list]').val(),
            params: {
                date_from:              $('[name=date_from]').val(),
                date_to:                $('[name=date_to]').val(),
                transfer_cards:         $('[name=transfer_cards]').is(':checked') ? 1 : 0,
                transfer_transactions:  $('[name=transfer_trn]').is(':checked') ? 1 : 0,
                save_holder:            $('[name=save_holder]').is(':checked') ? 1 : 0,
            }
        };

        $.post('/administration/cards-transfer', params, function (data) {
            if (data.success) {
                message(1, 'Перенос прошел успешно');
            } else {
                message(0, 'Ошибка переноса');
            }
            isAjax = false;
            removeLoader(block);
        });
    }
</script>