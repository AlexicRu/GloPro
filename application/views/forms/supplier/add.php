<div class="modal-body">
    <div class="form form_add_supplier">
        <div class="form-group row m-b-0">
            <div class="col-sm-4 text-muted form__row__title">
                Наименование:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="add_supplier_name" class="form-control">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),addSupplier)"><i class="fa fa-plus"></i> Добавить<span class="hidden-xs-down"> поставщика</span></span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function addSupplier(btn)
    {
        var block = $('.form_add_supplier');

        var params = {
            name: $('[name=add_supplier_name]', block).val()
        };

        if(params.name == ''){
            message(0, 'Введите наименование поставщика');
            endSubmitForm();
            return false;
        }

        $.post('/suppliers/supplier-add', {params:params}, function(data){
            endSubmitForm();

            if(data.success){
                message(1, 'Поставщик успешно добавлен');
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            }else{
                message(0, 'Ошибка добавления поставщика');
            }
        });
    }
</script>