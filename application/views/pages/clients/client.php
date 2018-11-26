<script src="<?=Common::getAssetsLink()?>js/clients/client.js"></script>

<h2>
    <span toggle_block="edit_client" uid="client_name"><?=$client['NAME']?></span>
    <span toggle_block="edit_client" uid="client_name" class="dn">
        <nobr>
            <input type="text" class="form-control form-control-lg" name="NAME" value="<?=Text::quotesForForms($client['NAME'])?>"
                <?=(!empty($client['NAME']) && Access::deny('edit_client_full') ? 'disabled' : '')?>
            >*
        </nobr>
    </span>
</h2>

<p>
    <span toggle_block="edit_client" uid="client_long_name"><?if($client['LONG_NAME']){?><?=$client['LONG_NAME']?><?}?></span>
    <span toggle_block="edit_client" uid="client_long_name" class="dn"><input type="text" class="form-control" placeholder="Полное название" name="LONG_NAME" value="<?=Text::quotesForForms($client['LONG_NAME'])?>"></span>
</p>

<div toggle_block="block1" class="dn edit_client_block m-b-10">
    <div class="row">
        <div class="col-lg-6">
            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    Юридический адрес:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="client_y_address"><?=($client['Y_ADDRESS'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_y_address" class="dn">
                        <nobr>
                            <input type="text" name="Y_ADDRESS" value="<?=$client['Y_ADDRESS']?>" class="form-control"
                                <?=(!empty($client['Y_ADDRESS']) && Access::deny('edit_client_full') ? 'disabled' : '')?>
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
                    <span toggle_block="edit_client" uid="client_f_address"><?=($client['F_ADDRESS'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_f_address" class="dn"><input type="text" name="F_ADDRESS" value="<?=$client['F_ADDRESS']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    Почтовый адрес:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="client_p_address"><?=($client['P_ADDRESS'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_p_address" class="dn"><input type="text" name="P_ADDRESS" value="<?=$client['P_ADDRESS']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    Комментарий:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="client_comments"><?=($client['COMMENTS'] ? str_replace("\n", "<br>", $client['COMMENTS']) : '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_comments" class="dn"><textarea name="COMMENTS" class="form-control"><?=$client['COMMENTS']?></textarea></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    Телефон:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="client_phone"><?=($client['PHONE'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_phone" class="dn"><nobr><input type="text" name="PHONE" value="<?=$client['PHONE']?>" class="form-control"></nobr></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    E-mail:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="client_email"><?=($client['EMAIL'] ? '<a href="mailto:'.$client['EMAIL'].'">'.$client['EMAIL'].'</a>' : '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_email" class="dn"><nobr><input type="text" name="EMAIL" value="<?=$client['EMAIL']?>" class="form-control">*</nobr></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    ИНН:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="client_inn"><?=($client['INN'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_inn" class="dn">
                        <nobr>
                            <input type="text" name="INN" value="<?=$client['INN']?>" class="form-control"
                                <?=(!empty($client['INN']) && Access::deny('edit_client_full') ? 'disabled' : '')?>
                            >*
                        </nobr>
                    </span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    КПП:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="client_kpp"><?=($client['KPP'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_kpp" class="dn">
                        <nobr>
                            <input type="text" name="KPP" value="<?=$client['KPP']?>" class="form-control"
                                <?=(!empty($client['KPP']) && Access::deny('edit_client_full') ? 'disabled' : '')?>
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
                    <span toggle_block="edit_client" uid="client_ogrn"><?=($client['OGRN'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_ogrn" class="dn">
                        <input type="text" name="OGRN" value="<?=$client['OGRN']?>" class="form-control"
                            <?=(!empty($client['OGRN']) && Access::deny('edit_client_full') ? 'disabled' : '')?>
                        >
                    </span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    ОКПО:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="client_okpo"><?=($client['OKPO'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_okpo" class="dn"><input type="text" name="OKPO" value="<?=$client['OKPO']?>" class="form-control"></span>
                </div>
            </div>
        </div>

        <div class="col-lg-6">

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    Наименование банка:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="bank"><?=($client['BANK'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="bank" class="dn"><input type="text" name="BANK" value="<?=$client['BANK']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    БИК банка:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="bank_bik"><?=($client['BANK_BIK'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="bank_bik" class="dn"><input type="text" name="BANK_BIK" value="<?=$client['BANK_BIK']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 form__row__title text-muted">
                    Кор. счет:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="bank_corr_account"><?=($client['BANK_CORR_ACCOUNT'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="bank_corr_account" class="dn"><input type="text" name="BANK_CORR_ACCOUNT" value="<?=$client['BANK_CORR_ACCOUNT']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 form__row__title text-muted">
                    Расчетный  счет:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="bank_account"><?=($client['BANK_ACCOUNT'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="bank_account" class="dn"><input type="text" name="BANK_ACCOUNT" value="<?=$client['BANK_ACCOUNT']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    Адрес банка:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="bank_address"><?=($client['BANK_ADDRESS'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="bank_address" class="dn"><input type="text" name="BANK_ADDRESS" value="<?=$client['BANK_ADDRESS']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    Генеральный директор:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="ceo"><?=($client['CEO'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="ceo" class="dn"><input type="text" name="CEO" value="<?=$client['CEO']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    Генеральный директор (кратко):
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="ceo_short"><?=($client['CEO_SHORT'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="ceo_short" class="dn"><input type="text" name="CEO_SHORT" value="<?=$client['CEO_SHORT']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    Главный  бухгалтер:
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="accountant"><?=($client['ACCOUNTANT'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="accountant" class="dn"><input type="text" name="ACCOUNTANT" value="<?=$client['ACCOUNTANT']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-4 text-muted form__row__title">
                    Генеральный бухгалтер (кратко):
                </div>
                <div class="col-sm-8 with-mt">
                    <span toggle_block="edit_client" uid="accountant_short"><?=($client['ACCOUNTANT_SHORT'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="accountant_short" class="dn"><input type="text" name="ACCOUNTANT_SHORT" value="<?=$client['ACCOUNTANT_SHORT']?>" class="form-control"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="more_info dn" toggle_block="block1">
    <span class="<?=Text::BTN?> btn-outline-secondary m-t-10" toggle="block1">Скрыть</span> &nbsp;

    <?if(Access::allow('clients_client-edit')){?>
        <button class="<?=Text::BTN?> btn-outline-primary m-t-10" toggle="edit_client" toggle_block="edit_client"><i class="fa fa-pen"></i> Редактировать</button> &nbsp;
    <?}?>

    <?if(Access::allow('clients_client-delete')){?>
        <button class="<?=Text::BTN?> btn-danger m-t-10" onclick="clientDelete($(this))"><i class="fa fa-trash-alt"></i> Удалить</button> &nbsp;
    <?}?>

    <span toggle_block="edit_client" class="dn nowrap">
        <button class="<?=Text::BTN?> btn-success m-t-10 client_edit_btn"><i class="fa fa-check"></i> Сохранить</button> &nbsp;
        <button class="<?=Text::BTN?> btn-danger m-t-10" toggle="edit_client"><i class="fa fa-times"></i> Отмена</button> &nbsp;
    </span>

    <?if(Access::allow('client_cabinet-create') && empty($client['EXISTS_OFFICE'])){?>
        <a href="#" class="<?=Text::BTN?> btn-outline-primary m-t-10" data-toggle="modal" data-target="#client_cabinet_create"><i class="fa fa-plus"></i> Создать ЛК</a>
    <?}?>
</div>
<div class="more_info" toggle_block="block1">
    <span class="<?=Text::BTN?> btn-outline-secondary" toggle="block1">Информация о компании</span>
</div>

<div class="row m-t-40">
    <div class="d-md-none m-b-20 col-12">
        <?if(Access::allow('clients_contract-add')){?>
            <a href="#" class="btn waves-effect waves-light btn-outline-primary" data-toggle="modal" data-target="#contract_add"><i class="fa fa-plus"></i> Создать договор</a>
        <?}?>
    </div>
    <div class="col-md-8">
        <select name="contracts_list" class="custom-select" <?=(empty($contracts) ? 'disabled' :'')?>>
            <?if(empty($contracts)){?>
                <option value="0">Нет договоров</option>
            <?}else{
            foreach($contracts as $contract){?>
                <option value="<?=$contract['CONTRACT_ID']?>" <?=((!empty($contractId) && $contractId == $contract['CONTRACT_ID']) ? 'selected' : '')?>>
                    Договор: <?=$contract['CONTRACT_NAME']?> [<?=$contract['CONTRACT_ID']?>] от <?=$contract['DATE_BEGIN']?> <?if($contract['DATE_END'] != Date::DATE_MAX){?>до <?=$contract['DATE_END']?><?}?>
                </option>
            <?}}?>
        </select>
    </div>
    <div class="col-md-4 text-right d-none d-md-block">
        <?if(Access::allow('clients_contract-add')){?>
            <a href="#" class="<?=Text::BTN?> btn-outline-primary" data-toggle="modal" data-target="#contract_add"><i class="fa fa-plus"></i> Создать договор</a>
        <?}?>
    </div>
</div>

<?if(Access::allow('clients_contract-add')){?>
    <?=$popupContractAdd?>
<?}?>

<?if(Access::allow('client_cabinet-create')){?>
    <?=$popupCabinetCreate?>
<?}?>

<div class="ajax_contract_block m-t-40"></div>

<script>
    var clientId = <?=$client['CLIENT_ID']?>;
</script>