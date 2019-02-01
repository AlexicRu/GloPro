<div class="modal-body">

    <div class="form form_load_by_inn">
        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                ИНН:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="load_by_inn_inn" class="form-control">
            </div>
        </div>

        <div class="form-group row m-b-0">
            <div class="col-sm-4 text-muted form__row__title">
                БИК банка:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="load_by_inn_bik" class="form-control">
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <span class="<?= Text::BTN ?> btn-primary" onclick="submitForm($(this), loadByInnGo)"><i
                class="far fa-cloud-download"></i> Загрузить</span>
    <button type="button" class="<?= Text::BTN ?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span
                class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    function loadByInnGo(btn) {
        var params = {
            inn: $('[name=load_by_inn_inn]').val(),
            bik: $('[name=load_by_inn_bik]').val(),
        };

        if (params.inn == '') {
            message(0, 'Введите ИНН');
            endSubmitForm();
            return false;
        }
        if (params.bik == '') {
            message(0, 'Введите БИК банка');
            endSubmitForm();
            return false;
        }

        $.post('/clients/client-load-info-by-inn', params, function (data) {
            endSubmitForm();

            if (data.success) {
                vueClientInfo.client.INN = data.data.INN ? data.data.INN : vueClientInfo.client.INN;
                vueClientInfo.client.BANK_BIK = data.data.BANK_BIK ? data.data.BANK_BIK : vueClientInfo.client.BANK_BIK;
                //vueClientInfo.client.NAME = data.data.NAME ? data.data.NAME : vueClientInfo.client.NAME;
                vueClientInfo.client.LONG_NAME = data.data.LONG_NAME ? data.data.LONG_NAME : vueClientInfo.client.LONG_NAME;
                vueClientInfo.client.KPP = data.data.KPP ? data.data.KPP : vueClientInfo.client.KPP;
                vueClientInfo.client.OGRN = data.data.OGRN ? data.data.OGRN : vueClientInfo.client.OGRN;
                vueClientInfo.client.OKPO = data.data.OKPO ? data.data.OKPO : vueClientInfo.client.OKPO;
                vueClientInfo.client.Y_ADDRESS = data.data.Y_ADDRESS ? data.data.Y_ADDRESS : vueClientInfo.client.Y_ADDRESS;
                vueClientInfo.client.F_ADDRESS = data.data.F_ADDRESS ? data.data.F_ADDRESS : vueClientInfo.client.F_ADDRESS;
                vueClientInfo.client.BANK = data.data.BANK ? data.data.BANK : vueClientInfo.client.BANK;
                vueClientInfo.client.BANK_CORR_ACCOUNT = data.data.BANK_CORR_ACCOUNT ? data.data.BANK_CORR_ACCOUNT : vueClientInfo.client.BANK_CORR_ACCOUNT;
                vueClientInfo.client.CEO = data.data.CEO ? data.data.CEO : vueClientInfo.client.CEO;

                if ($('[toggle_block="edit_client"].dn:visible').length == 0) {
                    $('[toggle="edit_client"]:first').click();
                }

                message(1, 'Данные успешно загружены');
                modalClose();
            } else {
                message(0, data.data ? data.data : 'Ошибка загрузки данных');
            }
        });
    }
</script>