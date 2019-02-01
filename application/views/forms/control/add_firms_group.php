<div class="modal-body">
    <div class="form-group row m-b-0">
        <div class="col-sm-4 text-muted form__row__title">
            Название группы:
        </div>
        <div class="col-sm-8 with-mt">
            <input type="text" name="add_firms_group_name" class="form-control">
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), addFirmsGroup)"><i class="fa fa-plus"></i> Добавить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addFirmsGroup(btn)
    {
        var params = {
            name:        $('[name=add_firms_group_name]').val(),
        };

        if(params.name == ''){
            endSubmitForm();
            message(0, 'Введите название группы');
            return false;
        }

        $.post('/control/add-firms-group', {params:params}, function(data){
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