<div class="modal-body">
    <div class="form-group row m-b-0">
        <div class="col-sm-4">
            <div class="text-right hidden-xs-down text-muted">Название группы:</div>
            <span class="hidden-sm-up text-muted">Название группы:</span>
        </div>
        <div class="col-sm-8 with-mt">
            <input type="text" name="edit_cards_group_name" class="form-control">
        </div>
    </div>

    <?if (in_array($user['ROLE_ID'], Access::$adminRoles)) {?>
        <div class="form-group row m-t-20 m-b-0">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down text-muted">Тип группы:</div>
                <span class="hidden-sm-up text-muted">Тип группы:</span>
            </div>
            <div class="col-sm-8 with-mt">
                <select class="custom-select" name="edit_cards_group_type">
                    <?foreach (Model_Card::$cardsGroupsTypes as $id => $name) {?>
                        <option value="<?=$id?>"><?=$name?></option>
                    <?}?>
                </select>
            </div>
        </div>
    <?} else {?>
        <input type="hidden" name="edit_cards_group_type" value="<?=Model_Card::CARD_GROUP_TYPE_USER?>">
    <?}?>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), editCardsGroup)"><i class="fa fa-check"></i> Сохранить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function editCardsGroup(btn)
    {
        var params = {
            group_id:    $('[name=edit_cards_group_id]').val(),
            name:        $('[name=edit_cards_group_name]').val(),
            type:        $('[name=edit_cards_group_type]').val(),
        };

        if(params.name == ''){
            endSubmitForm();
            message(0, 'Введите название группы');
            return false;
        }

        $.post('/control/edit-cards-group', {params:params}, function(data){
            endSubmitForm();
            if(data.success){
                message(1, 'Группа успешно обновлена');
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            }else{
                message(0, data.data ? data.data : 'Ошибка обновления группы');
            }
        });
    }
</script>