<div class="supplier-contract__contract">
    <div class="p-20 border-bottom m-b-20">
        <div class="row align-items-center font-20">
            <div class="col-9">
                [<?=$contract['CONTRACT_ID']?>]
                <span toggle_block="toggle_contract">
                    <b><?=$contract['CONTRACT_NAME']?></b> от <?=$contract['DATE_BEGIN']?> <?if($contract['DATE_END'] != '31.12.2099'){?>до <?=$contract['DATE_END']?><?}?> &nbsp;
                    <span class="badge <?=Model_Supplier_Contract::$statusContractClasses[$contract['CONTRACT_STATE']]?>"><?=Model_Supplier_Contract::$statusContractNames[$contract['CONTRACT_STATE']]?></span>
                </span>
                <span toggle_block="toggle_contract" class="dn">
                    <input type="text" name="CONTRACT_NAME" value="<?=Text::quotesForForms($contract['CONTRACT_NAME'])?>" class="form-control">
                    <span class="text-muted">от</span>
                    <input type="date" name="DATE_BEGIN" value="<?=Date::formatToDefault($contract['DATE_BEGIN'])?>" class="form-control">
                    <span class="text-muted">до</span>
                    <input type="date" name="DATE_END" value="<?=Date::formatToDefault($contract['DATE_END'])?>" class="form-control">
                    <select class="custom-select" name="CONTRACT_STATE">
                        <?
                        foreach(Model_Supplier_Contract::$statusContractNames as $id => $name){
                            ?><option value="<?=$id?>" <?if($id == $contract['CONTRACT_STATE']){echo 'selected';}?>><?=$name?></option><?
                        }
                        ?>
                    </select>
                </span>
            </div>
            <div class="col-3 text-right">
                <?if(Access::allow('suppliers_contract-edit')){?>
                    <div toggle_block="toggle_contract"><button class="<?=Text::BTN?> btn-outline-primary" toggle="toggle_contract"><i class="fa fa-pencil-alt"></i> Редактировать</button></div>
                    <div class="dn" toggle_block="toggle_contract">
                        <button class="<?=Text::BTN?> btn-success" onclick="editSupplierContract()"><i class="fa fa-check"></i> Сохранить</button>
                        <button class="<?=Text::BTN?> btn-danger" toggle="toggle_contract"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
                    </div>
                <?}?>
            </div>
        </div>
    </div>

    <div class="as_table">
        <div class="col">
            <table>
                <tr>
                    <td class="gray right" width="150">Валюта:</td>
                    <td>
                        Российский Рубль – <?=Text::RUR?>
                    </td>
                </tr>
                <tr>
                    <td class="gray right">Тип источника:</td>
                    <td>
                        <div toggle_block="toggle_contract">
                            <?if($contract['DATA_SOURCE'] == Model_Supplier_Contract::DATA_SOURCE_INSIDE){?>
                                Цепочка договоров внутри системы
                            <?}else{
                                foreach ($tubes as $tube) {
                                    if ($tube['TUBE_ID'] == $contract['TUBE_ID']) {
                                        ?>Внешний - <b><?=$tube['TUBE_NAME']?></b><?
                                    }
                                }
                            }?>
                        </div>
                        <div toggle_block="toggle_contract" class="dn">
                            <div class="supplier-contract__contract-data-source">
                                <label>
                                    <input type="radio" name="DATA_SOURCE" value="<?=Model_Supplier_Contract::DATA_SOURCE_INSIDE?>" <?=($contract['DATA_SOURCE'] == Model_Supplier_Contract::DATA_SOURCE_INSIDE ? 'checked' : '')?> onchange="checkSupplierContractDataSource()">
                                    Цепочка договоров внутри системы
                                </label>
                            </div>
                            <div class="supplier-contract__contract-data-source">
                                <label>
                                    <input type="radio" name="DATA_SOURCE" value="<?=Model_Supplier_Contract::DATA_SOURCE_OUTSIDE?>" <?=($contract['DATA_SOURCE'] == Model_Supplier_Contract::DATA_SOURCE_OUTSIDE ? 'checked' : '')?> onchange="checkSupplierContractDataSource()">
                                    Внешний источник
                                </label>
                                <select name="TUBE_ID" <?=($contract['DATA_SOURCE'] != Model_Supplier_Contract::DATA_SOURCE_OUTSIDE ? 'disabled' : '')?>>
                                    <?foreach ($tubes as $tube) {?>
                                        <option value="<?=$tube['TUBE_ID']?>" <?=($tube['TUBE_ID'] == $contract['TUBE_ID'] ? 'selected' : '')?>><?=$tube['TUBE_NAME']?></option>
                                    <?}?>
                                </select>
                            </div>
                        </div>
                    </td>
                </tr>
                <?/*?><tr>
                    <td class="gray right">Услуги:</td>
                    <td>
                        <div toggle_block="toggle_contract" class="contract_service_render_value"></div>
                        <div class="dn" toggle_block="toggle_contract">
                            <?=Form::buildField('service_choose_single', 'CONTRACT_SERVICES', $contractServices, [
                                'show_all' => true,
                                'render_value_to' => '.contract_service_render_value'
                            ])?>
                        </div>
                    </td>
                </tr><?*/?>
                <?if(Access::allow('view_supplier_contract_group_dots')){?>
                <tr>
                    <td class="gray right">Группы точек:</td>
                    <td>
                        <div toggle_block="toggle_contract" class="contract_pos_groups_render_value"></div>
                        <div class="dn" toggle_block="toggle_contract">
                            <?=Form::buildField('pos_group_choose_single', 'CONTRACT_POS_GROUPS', $contractDotsGroups, [
                                'show_all' => true,
                                'render_value_to' => '.contract_pos_groups_render_value',
                                'group_type' => Model_Dot::GROUP_TYPE_SUPPLIER
                            ])?>
                        </div>
                    </td>
                </tr>
                <?}?>
            </table>
        </div>
        <div class="col line_inner">
            <b class="f18">Баланс по договору:</b>
            <br>
            <?if(!empty($contract['BALANCE']) && !is_numeric($contract['BALANCE'])){?>
                <div class="f30"><b><?=$contract['BALANCE']?></b></div>
            <?}else{?>
                <div class="f50"><b><?=number_format($contract['BALANCE'], 2, ',', ' ')?></b> <?=Text::RUR?></div>
                <?if (!empty($contract['BALANCE_DATE'])) {?><i class="gray">на <?=$contract['BALANCE_DATE']?></i><?}?>
            <?}?>

        </div>
    </div>
</div>

<script>
    var DATA_SOURCE_INSIDE = <?=Model_Supplier_Contract::DATA_SOURCE_INSIDE?>;
</script>