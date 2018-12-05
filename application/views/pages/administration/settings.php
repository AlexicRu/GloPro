<!-- Nav tabs -->
<ul class="nav nav-tabs customtab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#main" role="tab">
            <i class="far fa-cogs fa-lg"></i> <span class="hidden-xs-down m-l-5">Основные</span>
        </a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="main" role="tabpanel">
        <div class="p-20 bg-white">
            <div id="vue_agent_info">
                <div class="border-bottom mb-3 pb-3 font-20">
                    <?if (Access::allow('root')) {?>
                        <span toggle_block="agentBlock1">
                            <b v-html="checkEmpty(agent.title.WEB_NAME)"></b>
                            &nbsp;
                            <span class="badge badge-light">ID <?=$agent['AGENT_ID']?></span>
                        </span>
                        <span toggle_block="agentBlock1" class="dn">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" v-model="agent.title.WEB_NAME" placeholder="Имя">
                                <div class="input-group-append">
                                    <span class="input-group-text"><?=$agent['AGENT_ID']?></span>
                                </div>
                            </div>
                        </span>
                    <?} else {?>
                        <span v-html="checkEmpty(agent.title.WEB_NAME)"></span>
                    <?}?>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        WEB имя:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <?if (Access::allow('root')) {?>
                            <span toggle_block="agentBlock1" v-html="checkEmpty(agent.title.FULL_NAME)"></span>
                            <span toggle_block="agentBlock1" class="dn">
                                <input class="form-control" type="text" v-model="agent.title.FULL_NAME">
                            </span>
                        <?} else {?>
                            <span v-html="checkEmpty(agent.title.FULL_NAME)"></span>
                        <?}?>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Статус:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <?if (Access::allow('root')) {?>
                            <span toggle_block="agentBlock1" v-html="statusFormatted"></span>
                            <span toggle_block="agentBlock1" class="dn">
                                <select class="custom-select" type="text" v-model="agent.title.STATE_ID">
                                    <?foreach (Model_Agent::$agentStatuses as $status => $statusName) {?>
                                        <option value="<?=$status?>"><?=$statusName?></option>
                                    <?}?>
                                </select>
                            </span>
                        <?} else {?>
                            <span v-html="statusFormatted"></span>
                        <?}?>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Номер договора на доступ к Личному кабинету:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <?if (Access::allow('root')) {?>
                            <span toggle_block="agentBlock1" v-html="checkEmpty(agent.title.GP_CONTRACT)"></span>
                            <span toggle_block="agentBlock1" class="dn"><input class="form-control" type="text" v-model="agent.title.GP_CONTRACT"></span>
                        <?} else {?>
                            <span v-html="checkEmpty(agent.title.GP_CONTRACT)"></span>
                        <?}?>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Дата договора на доступ к Личному кабинету:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <?if (Access::allow('root')) {?>
                            <span toggle_block="agentBlock1" v-html="checkEmpty(agent.title.GP_CONTRACT_DATE)"></span>
                            <span toggle_block="agentBlock1" class="dn"><input class="form-control" type="text" v-model="agent.title.GP_CONTRACT_DATE"></span>
                        <?} else {?>
                            <span v-html="checkEmpty(agent.title.GP_CONTRACT_DATE)"></span>
                        <?}?>
                    </div>
                </div>

                <?if (Access::allow('root')) {?>
                <div class="row m-b-10">
                    <div class="col-sm-8 offset-sm-4">
                        <span toggle_block="agentBlock1">
                            <span class="<?=Text::BTN?> btn-outline-primary" toggle="agentBlock1"><i class="fa fa-pen"></i><span class="d-none d-sm-inline-block ml-1">Редактировать</span></span>
                        </span>
                        <span toggle_block="agentBlock1" class="dn">
                            <button class="<?=Text::BTN?> btn-success" onclick="saveAgentTitleInfo()"><i class="fa fa-check"></i> Сохранить</button>
                            <span class="<?=Text::BTN?> btn-danger" v-on:click="cancelForm('agentBlock1')"><i class="fa fa-times"></i><span class="d-none d-sm-inline-block ml-1">Закрыть</span></span>
                        </span>
                    </div>
                </div>
                <?}?>

                <div class="font-weight-bold mb-3 font-18 mt-5">Информация о компании:</div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        ИНН агента:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_INN)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_INN"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        КПП агента:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_KPP)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_KPP"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Юридический адрес:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_Y_ADDRESS)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_Y_ADDRESS"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Почтовый адрес:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_P_ADDRESS)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_P_ADDRESS"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Фактический адрес:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_F_ADDRESS)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_F_ADDRESS"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Email:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(emailFormatted)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_EMAIL"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Телефон:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_PHONE)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" name="phone" type="text" v-model="agent.info.AGENT_PHONE"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Город:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_CITY)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_CITY"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Должность подписанта в именительном падеже:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_SIGNER_POST_1)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_SIGNER_POST_1"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Имя подписанта в именительном падеже:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_SIGNER_NAME_1)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_SIGNER_NAME_1"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Должность подписанта в родительном падеже:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_SIGNER_POST_2)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_SIGNER_POST_2"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Имя подписанта в родительном падеже:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <span toggle_block="agentBlock2" v-html="checkEmpty(agent.info.AGENT_SIGNER_NAME_2)"></span>
                        <span toggle_block="agentBlock2" class="dn"><input class="form-control" type="text" v-model="agent.info.AGENT_SIGNER_NAME_2"></span>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-8 offset-sm-4">
                        <span toggle_block="agentBlock2">
                            <span class="<?=Text::BTN?> btn-outline-primary" toggle="agentBlock2"><i class="fa fa-pen"></i><span class="d-none d-sm-inline-block ml-1">Редактировать</span></span>
                        </span>
                        <span toggle_block="agentBlock2" class="dn">
                            <button class="<?=Text::BTN?> btn-success" onclick="saveAgentInfoInfo()"><i class="fa fa-check"></i> Сохранить</button>
                            <span class="<?=Text::BTN?> btn-danger" v-on:click="cancelForm('agentBlock2')"><i class="fa fa-times"></i><span class="d-none d-sm-inline-block ml-1">Закрыть</span></span>
                        </span>
                    </div>
                </div>

                <div class="font-weight-bold mb-3 font-18 mt-5">Сервисные настройки:</div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Email для отправки оповещений:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <?if (Access::allow('root')) {?>
                            <span toggle_block="agentBlock3" v-html="checkEmpty(agent.service.SEND_FROM)"></span>
                            <span toggle_block="agentBlock3" class="dn"><input class="form-control" type="text" v-model="agent.service.SEND_FROM"></span>
                        <?} else {?>
                            <span v-html="checkEmpty(agent.service.SEND_FROM)"></span>
                        <?}?>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Префикс к выставлению счета:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <?if (Access::allow('root')) {?>
                            <span toggle_block="agentBlock3" v-html="checkEmpty(agent.service.BILL_PREFIX)"></span>
                            <span toggle_block="agentBlock3" class="dn"><input class="form-control" type="text" v-model="agent.service.BILL_PREFIX"></span>
                        <?} else {?>
                            <span v-html="checkEmpty(agent.service.BILL_PREFIX)"></span>
                        <?}?>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Номенклатура счета:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <?if (Access::allow('root')) {?>
                            <span toggle_block="agentBlock3" v-html="checkEmpty(agent.service.DEFAULT_GOOD_NAME)"></span>
                            <span toggle_block="agentBlock3" class="dn"><input class="form-control" type="text" v-model="agent.service.DEFAULT_GOOD_NAME"></span>
                        <?} else {?>
                            <span v-html="checkEmpty(agent.service.DEFAULT_GOOD_NAME)"></span>
                        <?}?>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        Ссылка к ЛК для клиентов:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <?if (Access::allow('root')) {?>
                            <span toggle_block="agentBlock3" v-html="checkEmpty(agent.service.OFFICE_LINK)"></span>
                            <span toggle_block="agentBlock3" class="dn"><input class="form-control" type="text" v-model="agent.service.OFFICE_LINK"></span>
                        <?} else {?>
                            <span v-html="checkEmpty(agent.service.OFFICE_LINK)"></span>
                        <?}?>
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-sm-4 form__row__title text-muted">
                        SMS рассылка:
                    </div>
                    <div class="col-sm-8 with-mt">
                        <?if (Access::allow('root')) {?>
                            <span toggle_block="agentBlock3" v-html="smsSubscriptionFormatted"></span>
                            <span toggle_block="agentBlock3" class="dn">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" v-model="agent.service.SENDER_SMS">
                                    <span class="custom-control-label"></span>
                                </label>
                            </span>
                        <?} else {?>
                            <span v-html="smsSubscriptionFormatted"></span>
                        <?}?>
                    </div>
                </div>

                <?if (Access::allow('root')) {?>
                    <div class="row m-b-10">
                        <div class="col-sm-8 offset-sm-4">
                            <span toggle_block="agentBlock3">
                                <span class="<?=Text::BTN?> btn-outline-primary" toggle="agentBlock2"><i class="fa fa-pen"></i><span class="d-none d-sm-inline-block ml-1">Редактировать</span></span>
                            </span>
                            <span toggle_block="agentBlock3" class="dn">
                                <button class="<?=Text::BTN?> btn-success" onclick="saveAgentServiceInfo()"><i class="fa fa-check"></i> Сохранить</button>
                                <span class="<?=Text::BTN?> btn-danger" v-on:click="cancelForm('agentBlock3')"><i class="fa fa-times"></i><span class="d-none d-sm-inline-block ml-1">Закрыть</span></span>
                            </span>
                        </div>
                    </div>
                <?}?>
            </div>
        </div>
    </div>
</div>

<script>
    var agentId = '<?=$agent['AGENT_ID']?>';
    var vueAgentInfo = new Vue({
        el: '#vue_agent_info',
        data: {
            agent: {
                title : {
                    AGENT_ID:               '<?=$agent['AGENT_ID']?>',
                    FULL_NAME:              '<?=$agent['FULL_NAME']?>',
                    WEB_NAME:               '<?=$agent['WEB_NAME']?>',
                    STATE_ID:               '<?=$agent['STATE_ID']?>',
                    GP_CONTRACT:            '<?=$agent['GP_CONTRACT']?>',
                    GP_CONTRACT_DATE:       '<?=$agent['GP_CONTRACT_DATE']?>'
                },
                info : {
                    AGENT_INN:              '<?=$agent['AGENT_INN']?>',
                    AGENT_KPP:              '<?=$agent['AGENT_KPP']?>',
                    AGENT_Y_ADDRESS:        '<?=$agent['AGENT_Y_ADDRESS']?>',
                    AGENT_P_ADDRESS:        '<?=$agent['AGENT_P_ADDRESS']?>',
                    AGENT_F_ADDRESS:        '<?=$agent['AGENT_F_ADDRESS']?>',
                    AGENT_EMAIL:            '<?=$agent['AGENT_EMAIL']?>',
                    AGENT_PHONE:            '<?=$agent['AGENT_PHONE']?>',
                    AGENT_CITY:             '<?=$agent['AGENT_CITY']?>',
                    AGENT_SIGNER_POST_1:    '<?=$agent['AGENT_SIGNER_POST_1']?>',
                    AGENT_SIGNER_NAME_1:    '<?=$agent['AGENT_SIGNER_NAME_1']?>',
                    AGENT_SIGNER_POST_2:    '<?=$agent['AGENT_SIGNER_POST_2']?>',
                    AGENT_SIGNER_NAME_2:    '<?=$agent['AGENT_SIGNER_NAME_2']?>'
                },
                service : {
                    SEND_FROM:              '<?=$agent['SEND_FROM']?>',
                    BILL_PREFIX:            '<?=$agent['BILL_PREFIX']?>',
                    DEFAULT_GOOD_NAME:      '<?=$agent['DEFAULT_GOOD_NAME']?>',
                    OFFICE_LINK:            '<?=$agent['OFFICE_LINK']?>',
                    SENDER_SMS:             <?=($agent['SENDER_SMS'] ? 'true' : 'false')?>
                }
            }
        },
        computed: {
            smsSubscriptionFormatted: function () {
                var enable = this.agent.service.SENDER_SMS;

                return '<div class="custom-control custom-checkbox"><label class="custom-control-label"><input type="checkbox" class="custom-control-input" '+ (enable ? 'checked' : '') +' disabled></label></div>';
            },
            emailFormatted: function () {
                var email = this.agent.info.AGENT_EMAIL;

                return email ? '<a href="mailto:' + email + '">' + email + '</a>' : '';
            },
            statusFormatted: function () {
                var status = this.agent.title.STATUS_ID;

                return status == <?=Model_Agent::AGENT_STATUS_ACTIVE?> ? '<span class="badge badge-success">В работе</span>' : '<span class="badge badge-danger">Заблокирован</span>';
            }
        },
        methods: {
            checkEmpty: function (val) {
                return val ? val : '<i class="text-muted">Не заполнено</i>';
            },
            cancelForm: function (toggle) {
                this.agent = JSON.parse(JSON.stringify(this._cache));

                $('[toggle='+ toggle +']:first').click();
            },
            cacheForm: function () {
                this._cache = JSON.parse(JSON.stringify(this.agent));
            }
        },
        mounted: function () {
            this.cacheForm();
            renderPhoneInput($('[name=phone]'));
        }
    });

    <?if (Access::allow('root')) {?>
    function saveAgentServiceInfo()
    {
        var params = vueRawData(vueAgentInfo.agent.service);

        $.post('/administration/agent-edit/' + agentId, { params:params, part: '<?=Model_Agent::AGENT_PART_SERVICE?>' }, function(data){
            if(data.success){
                message(1, 'Сервисный блок настроек агента обновлен');
            }else{
                message(0, 'Сохранение не удалось');
            }

            vueAgentInfo.cacheForm();
            vueAgentInfo.cancelForm('agentBlock1');
        });
    }

    function saveAgentTitleInfo()
    {
        var params = vueRawData(vueAgentInfo.agent.title);

        $.post('/administration/agent-edit/' + agentId, { params:params, part: '<?=Model_Agent::AGENT_PART_TITLE?>' }, function(data){
            if(data.success){
                message(1, 'Титульный блок настроек агента обновлен');
            }else{
                message(0, 'Сохранение не удалось');
            }

            vueAgentInfo.cacheForm();
            vueAgentInfo.cancelForm('agentBlock3');
        });
    }
    <?}?>

    function saveAgentInfoInfo()
    {
        var params = vueRawData(vueAgentInfo.agent.info);

        $.post('/administration/agent-edit/' + agentId, { params:params, part: '<?=Model_Agent::AGENT_PART_INFO?>' }, function(data){
            if(data.success){
                message(1, 'Информационный блок настроек агента обновлен');
            }else{
                message(0, 'Сохранение не удалось');
            }

            vueAgentInfo.cacheForm();
            vueAgentInfo.cancelForm('agentBlock2');
        });
    }
</script>