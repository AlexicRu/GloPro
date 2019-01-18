<?=Common::drawJs('clients/client.js')?>

<div class="client-detail__info">
    <? include('client/info.php') ?>
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
                    Договор: <?=$contract['CONTRACT_NAME']?> от <?=$contract['DATE_BEGIN']?> <?if($contract['DATE_END'] != Date::DATE_MAX){?>до <?=$contract['DATE_END']?><?}?> [<?=$contract['CONTRACT_ID']?>]
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