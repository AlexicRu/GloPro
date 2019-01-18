<div id="vue_client_info">

    <h2>
        <span toggle_block="edit_client" uid="client_name">
            {{ client.NAME }}

            <div class="float-right">
                <span class="badge badge-secondary">ID <?= $client['CLIENT_ID'] ?></span>
            </div>
        </span>
        <span toggle_block="edit_client" class="dn">
            <nobr>
                <input type="text" class="form-control form-control-lg" v-model="client.NAME"
                    <?= (!empty($client['NAME']) && Access::deny('edit_client_full') ? 'disabled' : '') ?>
                >*
            </nobr>
        </span>
    </h2>

    <p>
        <span toggle_block="edit_client">{{ client.LONG_NAME }}</span>
        <span toggle_block="edit_client" class="dn"><input type="text" class="form-control"
                                                           placeholder="Полное название"
                                                           v-model="client.LONG_NAME"></span>
    </p>

    <div toggle_block="block1" class="dn edit_client_block m-b-10">
        <div class="row">
            <div class="col-lg-6">
                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Юридический адрес:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.Y_ADDRESS)"></span>
                        <span toggle_block="edit_client" class="dn">
                        <nobr>
                            <input type="text" v-model="client.Y_ADDRESS" class="form-control"
                                <?= (!empty($client['Y_ADDRESS']) && Access::deny('edit_client_full') ? 'disabled' : '') ?>
                            >*
                        </nobr>
                    </span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Фактический адрес:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.F_ADDRESS)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.F_ADDRESS"
                                                                           class="form-control"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Почтовый адрес:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.P_ADDRESS)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.P_ADDRESS"
                                                                           class="form-control"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Комментарий:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(comments_formatted)"></span>
                        <span toggle_block="edit_client" class="dn"><textarea v-model="client.COMMENTS"
                                                                              class="form-control"></textarea></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Телефон:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.PHONE)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" class="form-control" name="phone"
                                                                           v-model="client.PHONE"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        E-mail:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(email_formatted)"></span>
                        <span toggle_block="edit_client" class="dn"><nobr><input type="text" v-model="client.EMAIL"
                                                                                 class="form-control">*</nobr></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        ИНН:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.INN)"></span>
                        <span toggle_block="edit_client" class="dn">
                            <div class="row">
                                <div class="col-7">
                                    <nobr>
                                        <input type="text" v-model="client.INN" class="form-control"
                                            <?= (!empty($client['INN']) && Access::deny('edit_client_full') ? 'disabled' : '') ?>
                                        >*
                                    </nobr>
                                </div>
                                <div class="col-5 text-right">
                                    <span class="<?= Text::BTN ?> btn-primary btn-sm" onclick="loadClientInfoByInn()"><i
                                                class="far fa-cloud-download"></i> Загрузить</span>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        КПП:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.KPP)"></span>
                        <span toggle_block="edit_client" class="dn">
                        <nobr>
                            <input type="text" v-model="client.KPP" class="form-control"
                                <?= (!empty($client['KPP']) && Access::deny('edit_client_full') ? 'disabled' : '') ?>
                            >
                        </nobr>
                    </span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        ОГРН:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.OGRN)"></span>
                        <span toggle_block="edit_client" class="dn">
                        <input type="text" v-model="client.OGRN" class="form-control"
                            <?= (!empty($client['OGRN']) && Access::deny('edit_client_full') ? 'disabled' : '') ?>
                        >
                    </span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        ОКПО:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.OKPO)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.OKPO"
                                                                           class="form-control"></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Наименование банка:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.BANK)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.BANK"
                                                                           class="form-control"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        БИК банка:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.BANK_BIK)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.BANK_BIK"
                                                                           class="form-control"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Кор. счет:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.BANK_CORR_ACCOUNT)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text"
                                                                           v-model="client.BANK_CORR_ACCOUNT"
                                                                           class="form-control"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Расчетный счет:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.BANK_ACCOUNT)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.BANK_ACCOUNT"
                                                                           class="form-control"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Адрес банка:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.BANK_ADDRESS)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.BANK_ADDRESS"
                                                                           class="form-control"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Генеральный директор:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.CEO)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.CEO"
                                                                           class="form-control"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Генеральный директор (кратко):
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.CEO_SHORT)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.CEO_SHORT"
                                                                           class="form-control"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Главный бухгалтер:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.ACCOUNTANT)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.ACCOUNTANT"
                                                                           class="form-control"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 text-muted form__row__title">
                        Главный бухгалтер (кратко):
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_client" v-html="checkEmpty(client.ACCOUNTANT_SHORT)"></span>
                        <span toggle_block="edit_client" class="dn"><input type="text" v-model="client.ACCOUNTANT_SHORT"
                                                                           class="form-control"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="more_info dn" toggle_block="block1">
        <span class="<?= Text::BTN ?> btn-outline-secondary m-t-10" toggle="block1">Скрыть</span> &nbsp;

        <? if (Access::allow('clients_client-edit')) { ?>
            <button class="<?= Text::BTN ?> btn-outline-primary m-t-10" toggle="edit_client" toggle_block="edit_client">
                <i class="fa fa-pen"></i> Редактировать
            </button> &nbsp;
        <? } ?>

        <? if (Access::allow('clients_client-delete')) { ?>
            <button class="<?= Text::BTN ?> btn-danger m-t-10" onclick="clientDelete($(this))"><i
                        class="fa fa-trash-alt"></i> Удалить
            </button> &nbsp;
        <? } ?>

        <span toggle_block="edit_client" class="dn nowrap">
            <button class="<?= Text::BTN ?> btn-success m-t-10" onclick="saveClientInfo()"><i class="fa fa-check"></i> Сохранить</button> &nbsp;
            <button class="<?= Text::BTN ?> btn-danger m-t-10" toggle="edit_client" @click="cancelForm()"><i
                        class="fa fa-times"></i> Отмена</button> &nbsp;
        </span>

        <? if (Access::allow('client_cabinet-create') && empty($client['EXISTS_OFFICE'])) { ?>
            <a href="#" class="<?= Text::BTN ?> btn-outline-primary m-t-10" data-toggle="modal"
               data-target="#client_cabinet_create"><i class="fa fa-plus"></i> Создать ЛК</a>
        <? } ?>
    </div>

    <div class="more_info" toggle_block="block1">
        <span class="<?= Text::BTN ?> btn-outline-secondary" toggle="block1">Информация о компании</span>
    </div>

</div>

<script>
    var vueClientInfo = new Vue({
        el: '#vue_client_info',
        data: {
            client: {
                NAME: '<?=$client['NAME']?>',
                LONG_NAME: '<?=$client['LONG_NAME']?>',
                Y_ADDRESS: '<?=$client['Y_ADDRESS']?>',
                F_ADDRESS: '<?=$client['F_ADDRESS']?>',
                P_ADDRESS: '<?=$client['P_ADDRESS']?>',
                COMMENTS: '<?=$client['COMMENTS']?>',
                PHONE: '<?=$client['PHONE']?>',
                EMAIL: '<?=$client['EMAIL']?>',
                INN: '<?=$client['INN']?>',
                KPP: '<?=$client['KPP']?>',
                OGRN: '<?=$client['OGRN']?>',
                OKPO: '<?=$client['OKPO']?>',
                BANK: '<?=$client['BANK']?>',
                BANK_BIK: '<?=$client['BANK_BIK']?>',
                BANK_CORR_ACCOUNT: '<?=$client['BANK_CORR_ACCOUNT']?>',
                BANK_ACCOUNT: '<?=$client['BANK_ACCOUNT']?>',
                BANK_ADDRESS: '<?=$client['BANK_ADDRESS']?>',
                CEO: '<?=$client['CEO']?>',
                CEO_SHORT: '<?=$client['CEO_SHORT']?>',
                ACCOUNTANT: '<?=$client['ACCOUNTANT']?>',
                ACCOUNTANT_SHORT: '<?=$client['ACCOUNTANT_SHORT']?>',
            },
        },
        computed: {
            email_formatted: function () {
                var email = this.client.EMAIL;

                return email ? '<a href="mailto:' + email + '">' + email + '</a>' : '';
            },
            comments_formatted: function () {
                return this.client.COMMENTS.replace(/\n/g, "<br>");
            }
        },
        methods: {
            checkEmpty: function (val) {
                return val ? val : '<i class="text-muted">Не заполнено</i>';
            },
            cancelForm: function () {
                Object.assign(this.client, this._cache);
            },
            cacheForm: function () {
                this._cache = Object.assign({}, this.client);
            }
        },
        mounted: function () {
            this.cacheForm();
            renderPhoneInput($('[name=phone]'));
        }
    })
</script>