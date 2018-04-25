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
        <div class="col-md-6">
            <div class="row m-b-10">
                <div class="col-4 text-right">Юридический адрес:</div>
                <div class="col-8">
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
                <div class="col-4 text-right">Фактический адрес:</div>
                <div class="col-8">
                    <span toggle_block="edit_client" uid="client_f_address"><?=($client['F_ADDRESS'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_f_address" class="dn"><input type="text" name="F_ADDRESS" value="<?=$client['F_ADDRESS']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-4 text-right">Почтовый адрес:</div>
                <div class="col-8">
                    <span toggle_block="edit_client" uid="client_p_address"><?=($client['P_ADDRESS'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_p_address" class="dn"><input type="text" name="P_ADDRESS" value="<?=$client['P_ADDRESS']?>" class="form-control"></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-4 text-right">Комментарий:</div>
                <div class="col-8">
                    <span toggle_block="edit_client" uid="client_comments"><?=($client['COMMENTS'] ? str_replace("\n", "<br>", $client['COMMENTS']) : '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_comments" class="dn"><textarea name="COMMENTS" class="form-control"><?=$client['COMMENTS']?></textarea></span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row m-b-10">
                <div class="col-4 text-right">Телефон:</div>
                <div class="col-8">
                    <span toggle_block="edit_client" uid="client_phone"><?=($client['PHONE'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_phone" class="dn"><nobr><input type="text" name="PHONE" value="<?=$client['PHONE']?>" class="form-control">*</nobr></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-4 text-right">E-mail:</div>
                <div class="col-8">
                    <span toggle_block="edit_client" uid="client_email"><?=($client['EMAIL'] ? '<a href="mailto:'.$client['EMAIL'].'">'.$client['EMAIL'].'</a>' : '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_email" class="dn"><nobr><input type="text" name="EMAIL" value="<?=$client['EMAIL']?>" class="form-control">*</nobr></span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-4 text-right">ИНН:</div>
                <div class="col-8">
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
                <div class="col-4 text-right">КПП:</div>
                <div class="col-8">
                    <span toggle_block="edit_client" uid="client_kpp"><?=($client['KPP'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_kpp" class="dn">
                        <nobr>
                            <input type="text" name="KPP" value="<?=$client['KPP']?>" class="form-control"
                                <?=(!empty($client['KPP']) && Access::deny('edit_client_full') ? 'disabled' : '')?>
                            >*
                        </nobr>
                    </span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-4 text-right">ОГРН:</div>
                <div class="col-8">
                    <span toggle_block="edit_client" uid="client_ogrn"><?=($client['OGRN'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_ogrn" class="dn">
                        <input type="text" name="OGRN" value="<?=$client['OGRN']?>" class="form-control"
                            <?=(!empty($client['OGRN']) && Access::deny('edit_client_full') ? 'disabled' : '')?>
                        >
                    </span>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-4 text-right">ОКПО:</div>
                <div class="col-8">
                    <span toggle_block="edit_client" uid="client_okpo"><?=($client['OKPO'] ?: '<span class="gray">Не заполнено</span>')?></span>
                    <span toggle_block="edit_client" uid="client_okpo" class="dn"><input type="text" name="OKPO" value="<?=$client['OKPO']?>" class="form-control"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="more_info dn" toggle_block="block1">
    <a href="#" class="btn waves-effect waves-light btn-outline-secondary m-t-10" toggle="block1">Скрыть</a> &nbsp;

    <?if(Access::allow('clients-client-edit')){?>
        <button class="btn waves-effect waves-light btn-primary m-t-10" toggle="edit_client" toggle_block="edit_client"><i class="fa fa-pencil-alt"></i> Редактировать</button> &nbsp;
    <?}?>

    <span toggle_block="edit_client" class="dn nowrap">
        <button class="btn waves-effect waves-light btn-success m-t-10 client_edit_btn"><i class="fa fa-check"></i> Сохранить</button> &nbsp;
        <button class="btn waves-effect waves-light btn-danger m-t-10" toggle="edit_client"><i class="fa fa-times"></i> Отмена</button> &nbsp;
    </span>

    <?if(Access::allow('client_cabinet-create') && empty($client['EXISTS_OFFICE'])){?>
        <a href="#" class="btn waves-effect waves-light btn-outline-primary m-t-10" data-toggle="modal" data-target="#client_cabinet_create"><i class="fa fa-plus"></i> Создать ЛК</a>
    <?}?>
</div>
<div class="more_info" toggle_block="block1">
    <a href="#" class="btn waves-effect waves-light btn-outline-secondary" toggle="block1">Информация о компании</a>
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
                    Договор: [<?=$contract['CONTRACT_ID']?>] <?=$contract['CONTRACT_NAME']?> от <?=$contract['DATE_BEGIN']?> <?if($contract['DATE_END'] != '31.12.2099'){?>до <?=$contract['DATE_END']?><?}?>
                </option>
            <?}}?>
        </select>
    </div>
    <div class="col-md-4 text-right d-none d-md-block">
        <?if(Access::allow('clients_contract-add')){?>
            <a href="#" class="btn waves-effect waves-light btn-outline-primary" data-toggle="modal" data-target="#contract_add"><i class="fa fa-plus"></i> Создать договор</a>
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