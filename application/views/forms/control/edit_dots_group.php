<div class="modal-body">
    <input type="hidden" name="edit_dots_group_id">

    <div class="form-group row">
        <div class="col-sm-4 text-muted form__row__title">
            Название группы:
        </div>
        <div class="col-sm-8 with-mt">
            <input type="text" name="edit_dots_group_name" class="form-control">
        </div>
    </div>

    <div class="form-group row m-b-0">
        <div class="col-sm-4 text-muted form__row__title">
            Тип:
        </div>
        <div class="col-sm-8 with-mt">
            <select class="custom-select" name="edit_dots_group_type">
                <?foreach(Model_Dot::getGroupTypesNames() as $groupsType => $groupsTypesName){?>
                    <option value="<?=$groupsType?>"><?=$groupsTypesName?></option>
                <?}?>
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), editDotsGroup)"><i class="fa fa-check"></i> Сохранить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function editDotsGroup(btn)
    {
        var params = {
            group_id:    $('[name=edit_dots_group_id]').val(),
            name:        $('[name=edit_dots_group_name]').val(),
            group_type:  $('[name=edit_dots_group_type]').val()
        };

        if(params.name == ''){
            message(0, 'Введите название группы');
            return false;
        }

        $.post('/control/edit-dots-group', {params:params}, function(data){
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