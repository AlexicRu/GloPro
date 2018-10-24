<?
$postfix = $card['CARD_ID'];
?>
<div class="modal-body">
    <div class="form form_card_holder_edit_<?=$postfix?>">
        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Держатель:</div>
                <span class="hidden-sm-up text-muted">Держатель:</span>
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="card_holder_edit" class="form-control" value="<?=Text::quotesForForms($card['HOLDER'])?>" maxlength="200">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Выдана держателю:</div>
                <span class="hidden-sm-up text-muted">Выдана держателю:</span>
            </div>
            <div class="col-sm-8 with-mt">
                <input type="date" class="form-control" name="card_holder_edit_date" value="<?=Date::formatToDefault($card['DATE_HOLDER'])?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Комментарий:</div>
                <span class="hidden-sm-up text-muted">Комментарий:</span>
            </div>
            <div class="col-sm-8 with-mt">
                <textarea class="form-control" name="card_holder_edit_comment" style="width: 100%"><?=$card['CARD_COMMENT']?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="btn btn-primary waves-effect waves-light" onclick="submitForm($(this), cardEditHolderGo_<?=$postfix?>)"><i class="fa fa-check"></i> Сохранить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function cardEditHolderGo_<?=$postfix?>(t)
    {
        var form = $('.form_card_holder_edit_<?=$postfix?>');
        var params = {
            contract_id : $('[name=contracts_list]').val(),
            card_id     : $('.tabs_cards .nav-link.active').closest('.nav-item').attr('tab'),
            holder      : $('[name=card_holder_edit]', form).val(),
            date        : $('[name=card_holder_edit_date]', form).val(),
            comment     : $('[name=card_holder_edit_comment]', form).val(),
        };

        if(params.date == false){
            message(0, 'Заполните дату');
            endSubmitForm();
            return;
        }

        $.post('/clients/card-edit-holder', params, function (data) {
            if (data.success) {
                message(1, 'Держатель карты успешно обновлен');
                modalClose();
                cardLoad($('.tabs_cards .nav-link.active').closest('[tab]').attr('tab'), true);
                $('.tabs_cards .nav-link.active [holder]').text(params.holder);
            } else {
                message(0, 'Ошибка обновления держателя карты');

                if(data.data){
                    for(var i in data.data){
                        message(0, data.data[i].text);
                    }
                }
            }
            endSubmitForm();
        });
    }
</script>