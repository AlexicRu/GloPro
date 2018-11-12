<script src="<?=Common::getAssetsLink()?>js/suppliers/supplier_detail.js"></script>

<input type="hidden" name="supplier_id" value="<?=$supplier['ID']?>">

<div class="supplier-detail__info">
    <?include('supplier_detail/info.php')?>
</div>

<div class="row m-t-40 m-b-40">
    <div class="d-md-none m-b-20 col-12">
        <?if(Access::allow('suppliers_contract-add')){?>
            <a href="#" data-toggle="modal" data-target="#supplier_contract_add" class="<?=Text::BTN?> btn-outline-primary"><i class="fa fa-plus"></i> Создать договор</a>
        <?}?>
    </div>
    <div class="col-md-8">
        <select name="suppliers_contracts_list" class="custom-select" onchange="contractId = $(this).val(); loadSupplierContract()">
            <?if(empty($supplierContracts)){?>
                <option value="0">Нет договоров</option>
            <?}else{
                foreach($supplierContracts as $contract){?>
                    <option value="<?=$contract['CONTRACT_ID']?>">
                        Договор: [<?=$contract['CONTRACT_ID']?>] <?=$contract['CONTRACT_NAME']?> от <?=$contract['DATE_BEGIN']?> <?if($contract['DATE_END'] != Date::DATE_MAX){?>до <?=$contract['DATE_END']?><?}?>
                    </option>
                <?}}?>
        </select>
    </div>
    <div class="col-md-4 text-right d-none d-md-block">
        <?if(Access::allow('suppliers_contract-add')){?>
            <a href="#" data-toggle="modal" data-target="#supplier_contract_add" class="<?=Text::BTN?> btn-outline-primary"><i class="fa fa-plus"></i> Создать договор</a>
        <?}?>
    </div>
</div>

<?if(Access::allow('suppliers_contract-add')){?>
    <?=$popupSupplierContractAdd?>
<?}?>

<div class="supplier-contract"></div>