<div class="modal-body">
    <div class="form-group row m-b-0">
        <div class="col-sm-4 text-muted form__row__title">
            Название группы:
        </div>
        <div class="col-sm-8 with-mt">
            <input type="text" name="add_cards_group_name" class="form-control">
        </div>
    </div>

    <?if (in_array($user['ROLE_ID'], Access::$adminRoles)) {?>
        <div class="form-group row m-t-20 m-b-0">
            <div class="col-sm-4 text-muted form__row__title">
                Тип группы:
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
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), addCardsGroup)"><i class="fa fa-plus"></i> Добавить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addCardsGroup(btn)
    {
        var params = {
            name:        $('[name=add_cards_group_name]').val(),
            type:        $('[name=add_cards_group_type]').val(),
        };

        if(params.name == ''){
            endSubmitForm();
            message(0, 'Введите название группы');
            return false;
        }

        $.post('/control/add-cards-group', {params:params}, function(data){
            endSubmitForm();

            if(data.success){
                message(1, 'Группа успешно добавлена');
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            }else{
                message(0, data.data ? data.data : 'Ошибка добавления группы');
            }
        });
    }
</script>