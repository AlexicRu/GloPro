<div id="vue_supplier_info">

    <div toggle_block="edit_supplier">
        <div class="row m-b-10">
            <div class="col-md-2 col-sm-4 m-b-10">
                <div class="supplier-detail__avatar" v-bind:class="avatar_class">
                    <div class="supplier-detail__avatar-pic" v-bind:style="avatar_style"></div>
                </div>
            </div>
            <div class="col-md-10 col-sm-8">
                <h2>
                    <span>{{ supplier.SUPPLIER_NAME }}</span>

                    <div class="float-right">
                        <span class="badge badge-secondary">ID: <?=$supplier['ID']?></span>
                    </div>
                </h2>

                <p>{{ supplier.LONG_NAME }}</p>
            </div>
        </div>
    </div>

    <div toggle_block="edit_supplier" class="dn">
        <div class="row m-b-10">
            <div class="col-md-3 col-sm-4 m-b-10">
                <div class="dropzone supplier-detail__avatar-dropzone"></div>
            </div>
            <div class="col-md-9 col-sm-8">
                <h2><input type="text" class="form-control form-control-lg" v-model="supplier.SUPPLIER_NAME"></h2>

                <p><input type="text" class="form-control" v-model="supplier.LONG_NAME"></p>
            </div>
        </div>
    </div>

    <div toggle_block="supplier_info" class="dn m-b-10">
        <div class="row">
            <div class="col-md-6">

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">Юридический адрес:</div>
                        <span class="hidden-sm-up text-muted">Юридический адрес:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(supplier.Y_ADDRESS)"></span>
                        <span toggle_block="edit_supplier" class="dn"><nobr><input type="text" class="form-control" v-model="supplier.Y_ADDRESS"></nobr></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">Фактический адрес:</div>
                        <span class="hidden-sm-up text-muted">Фактический адрес:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(supplier.F_ADDRESS)"></span>
                        <span toggle_block="edit_supplier" class="dn"><input type="text" class="form-control" v-model="supplier.F_ADDRESS"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">Почтовый адрес:</div>
                        <span class="hidden-sm-up text-muted">Почтовый адрес:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(supplier.P_ADDRESS)"></span>
                        <span toggle_block="edit_supplier" class="dn"><input type="text" class="form-control" v-model="supplier.P_ADDRESS"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">Контактное лицо:</div>
                        <span class="hidden-sm-up text-muted">Контактное лицо:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(supplier.CONTACT_PERSON)"></span>
                        <span toggle_block="edit_supplier" class="dn"><input type="text" class="form-control" v-model="supplier.CONTACT_PERSON"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">Комментарий:</div>
                        <span class="hidden-sm-up text-muted">Комментарий:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(comments_formatted)"></span>
                        <span toggle_block="edit_supplier" class="dn"><textarea class="form-control" v-model="supplier.COMMENTS"></textarea></span>
                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">Телефон:</div>
                        <span class="hidden-sm-up text-muted">Телефон:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(supplier.PHONE)"></span>
                        <span toggle_block="edit_supplier" class="dn"><nobr><input type="text" class="form-control" name="phone" v-model="supplier.PHONE"></nobr></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">E-mail:</div>
                        <span class="hidden-sm-up text-muted">E-mail:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(email_formatted)"></span>
                        <span toggle_block="edit_supplier" class="dn"><nobr><input type="text" class="form-control" v-model="supplier.EMAIL"></nobr></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">ИНН:</div>
                        <span class="hidden-sm-up text-muted">ИНН:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(supplier.INN)"></span>
                        <span toggle_block="edit_supplier" class="dn"><nobr><input type="text" class="form-control" v-model="supplier.INN"></nobr></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">КПП:</div>
                        <span class="hidden-sm-up text-muted">КПП:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(supplier.KPP)"></span>
                        <span toggle_block="edit_supplier" class="dn"><nobr><input type="text" class="form-control" v-model="supplier.KPP"></nobr></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">ОГРН:</div>
                        <span class="hidden-sm-up text-muted">ОГРН:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(supplier.OGRN)"></span>
                        <span toggle_block="edit_supplier" class="dn"><input type="text" class="form-control" v-model="supplier.OGRN"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">ОКПО:</div>
                        <span class="hidden-sm-up text-muted">ОКПО:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(supplier.OKPO)"></span>
                        <span toggle_block="edit_supplier" class="dn"><input type="text" class="form-control" v-model="supplier.OKPO"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4">
                        <div class="text-right hidden-xs-down text-muted">ОКОНХ:</div>
                        <span class="hidden-sm-up text-muted">ОКОНХ:</span>
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="edit_supplier" v-html="checkEmpty(supplier.OKONH)"></span>
                        <span toggle_block="edit_supplier" class="dn"><input type="text" class="form-control" v-model="supplier.OKONH"></span>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="more_info dn" toggle_block="supplier_info">
        <a href="#" class="<?=Text::BTN?> btn-outline-secondary btn_min_width" toggle="supplier_info">Скрыть</a> &nbsp;

        <?if(Access::allow('suppliers_supplier-edit')){?>
        <button class="<?=Text::BTN?> btn-primary" toggle="edit_supplier" toggle_block="edit_supplier"><i class="fa fa-pen"></i> Редактировать</button> &nbsp;

        <button class="<?=Text::BTN?> btn-success dn" toggle_block="edit_supplier" onclick="saveSupplierInfo()"><i class="fa fa-check"></i> Сохранить</button>
        <button class="<?=Text::BTN?> btn-danger dn" toggle="edit_supplier" toggle_block="edit_supplier" v-on:click="cancelForm()"><i class="fa fa-times"></i> Отмена</button>
        <?}?>
    </div>
    <div class="more_info" toggle_block="supplier_info">
        <a href="#" class="<?=Text::BTN?> btn-outline-secondary" toggle="supplier_info">Информация о поставщике</a>
    </div>

</div>

<script>
    var vueSupplierInfo = new Vue({
        el: '#vue_supplier_info',
        data: {
            supplier: {
                ICON_PATH: '<?=$supplier['ICON_PATH']?>',
                SUPPLIER_NAME: '<?=$supplier['SUPPLIER_NAME']?>',
                LONG_NAME: '<?=$supplier['LONG_NAME']?>',
                Y_ADDRESS: '<?=$supplier['Y_ADDRESS']?>',
                F_ADDRESS: '<?=$supplier['F_ADDRESS']?>',
                P_ADDRESS: '<?=$supplier['P_ADDRESS']?>',
                CONTACT_PERSON: '<?=$supplier['CONTACT_PERSON']?>',
                COMMENTS: '<?=$supplier['COMMENTS']?>',
                PHONE: '<?=$supplier['PHONE']?>',
                EMAIL: '<?=$supplier['EMAIL']?>',
                INN: '<?=$supplier['INN']?>',
                KPP: '<?=$supplier['KPP']?>',
                OGRN: '<?=$supplier['OGRN']?>',
                OKPO: '<?=$supplier['OKPO']?>',
                OKONH: '<?=$supplier['OKONH']?>',
            }
        },
        computed: {
            email_formatted: function () {
                var email = this.supplier.EMAIL;

                return email ? '<a href="mailto:' + email + '">' + email + '</a>' : '';
            },
            comments_formatted: function () {
                return this.supplier.COMMENTS.replace(/\n/g, "<br>");
            },
            avatar_class: function () {
                return this.supplier.ICON_PATH ? '' : 'supplier-detail__avatar-empty';
            },
            avatar_style: function () {
                var icon = this.supplier.ICON_PATH;
                return icon ? {backgroundImage: 'url('+ icon +')'} : '';
            }
        },
        methods: {
            checkEmpty: function (val) {
                return val ? val : '<i class="gray">Не заполнено</i>';
            },
            cancelForm: function () {
                Object.assign(this.supplier, this._cache);
            },
            cacheForm: function () {
                this._cache = Object.assign({}, this.supplier);
            }
        },
        mounted: function () {
            this.cacheForm();
            renderPhoneInput($('[name=phone]'));
        }
    })
</script>