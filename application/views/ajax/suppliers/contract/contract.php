<div class="supplier-contract__contract">
    <div class="p-20 border-bottom">

        <div toggle_block="toggle_contract">
            <div class="row align-items-center font-20">
                <div class="col-9">
                    <span toggle_block="toggle_contract">
                        <b><?=$contract['CONTRACT_NAME']?></b> <span class="text-muted">[<?=$contract['CONTRACT_ID']?>]</span> от <?=$contract['DATE_BEGIN']?> <?if($contract['DATE_END'] != Date::DATE_MAX){?>до <?=$contract['DATE_END']?><?}?> &nbsp;
                        <span class="badge <?=Model_Supplier_Contract::$statusContractClasses[$contract['CONTRACT_STATE']]?>"><?=Model_Supplier_Contract::$statusContractNames[$contract['CONTRACT_STATE']]?></span>
                    </span>
                </div>
                <div class="col-3 text-right">
                    <?if(Access::allow('suppliers_contract-edit')){?>
                        <div toggle_block="toggle_contract"><button class="<?=Text::BTN?> btn-outline-primary" toggle="toggle_contract"><i class="fa fa-pen"></i><span class="hidden-xs-down"> Редактировать</span></button></div>
                    <?}?>
                </div>
            </div>
        </div>

        <div class="dn" toggle_block="toggle_contract">
            <div class="form-group font-20">
                <div class="input-group">
                    <input type="text" name="CONTRACT_NAME" value="<?=Text::quotesForForms($contract['CONTRACT_NAME'])?>" class="form-control form-control-lg" placeholder="Название">
                    <div class="input-group-append">
                        <span class="input-group-text"><?=$contract['CONTRACT_ID']?></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 m-b-20 p-b-5">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">от</div>
                        </div>
                        <input type="date" name="DATE_BEGIN" value="<?=Date::formatToDefault($contract['DATE_BEGIN'])?>" class="form-control">
                    </div>
                </div>

                <div class="col-md-4 m-b-20 p-b-5">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">до</div>
                        </div>
                        <input type="date" name="DATE_END" value="<?=Date::formatToDefault($contract['DATE_END'])?>" class="form-control">
                    </div>
                </div>

                <div class="col-md-4 m-b-20 p-b-5">
                    <select class="custom-select" name="CONTRACT_STATE">
                        <?
                        foreach(Model_Supplier_Contract::$statusContractNames as $id => $name){
                            ?><option value="<?=$id?>" <?if($id == $contract['CONTRACT_STATE']){echo 'selected';}?>><?=$name?></option><?
                        }
                        ?>
                    </select>
                </div>
            </div>

            <?if(Access::allow('suppliers_contract-edit')){?>
                <div class="form-group row m-b-0">
                    <div class="col-sm-12">
                        <button class="<?=Text::BTN?> btn-success" onclick="editSupplierContract()"><i class="fa fa-check"></i> Сохранить</button>
                        <button class="<?=Text::BTN?> btn-danger" toggle="toggle_contract"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
                    </div>
                </div>
            <?}?>

        </div>
    </div>

    <div class="row p-20">
        <div class="col-lg-6">

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted form__row__title">
                    Валюта:
                </div>
                <div class="col-sm-7">
                    Российский Рубль – <?=Text::RUR?>
                </div>
            </div>

            <div class="row m-b-10">
                <div class="col-sm-5 text-muted form__row__title">
                    Тип источника:
                </div>
                <div class="col-sm-7">
                    <div toggle_block="toggle_contract">
                        <?if($contract['DATA_SOURCE'] == Model_Supplier_Contract::DATA_SOURCE_INSIDE){?>
                            Цепочка договоров внутри системы
                        <?}else{
                            foreach ($tubes as $tube) {
                                if ($tube['TUBE_ID'] == $contract['TUBE_ID']) {
                                    ?>Внешний - <?=($tube['CURRENT_STATE'] == Model_Tube::STATE_INACTIVE ? '[Не в работе] ' : '')?><b><?=$tube['TUBE_NAME']?></b><?
                                }
                            }
                        }?>
                    </div>
                    <div toggle_block="toggle_contract" class="dn">
                        <div class="supplier-contract__contract-data-source">
                            <label class="custom-control custom-radio">
                                <input type="radio" name="DATA_SOURCE" class="custom-control-input"
                                       value="<?=Model_Supplier_Contract::DATA_SOURCE_INSIDE?>"
                                    <?=($contract['DATA_SOURCE'] == Model_Supplier_Contract::DATA_SOURCE_INSIDE ? 'checked' : '')?>
                                       onchange="checkSupplierContractDataSource()"
                                >
                                <span class="custom-control-label">Цепочка договоров внутри системы</span>
                            </label>
                        </div>
                        <div class="supplier-contract__contract-data-source">
                            <label class="custom-control custom-radio">
                                <input type="radio" name="DATA_SOURCE" class="custom-control-input"
                                       value="<?=Model_Supplier_Contract::DATA_SOURCE_OUTSIDE?>"
                                    <?=($contract['DATA_SOURCE'] == Model_Supplier_Contract::DATA_SOURCE_OUTSIDE ? 'checked' : '')?>
                                       onchange="checkSupplierContractDataSource()"
                                >
                                <span class="custom-control-label">Внешний источник</span>
                            </label>
                            <select class="custom-select" name="TUBE_ID" <?=($contract['DATA_SOURCE'] != Model_Supplier_Contract::DATA_SOURCE_OUTSIDE ? 'disabled' : '')?>>
                                <?foreach ($tubes as $tube) {?>
                                    <option value="<?=$tube['TUBE_ID']?>" <?=($tube['TUBE_ID'] == $contract['TUBE_ID'] ? 'selected' : '')?>>
                                        <?=($tube['CURRENT_STATE'] == Model_Tube::STATE_INACTIVE ? '[Не в работе] ' : '')?><?=$tube['TUBE_NAME']?>
                                    </option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <?if(Access::allow('view_supplier_contract_group_dots')){?>
                <div class="row m-b-10">
                    <div class="col-sm-5 text-muted form__row__title">
                        Группы точек:
                    </div>
                    <div class="col-sm-7">
                        <div toggle_block="toggle_contract" class="contract_pos_groups_render_value"></div>
                        <div class="dn" toggle_block="toggle_contract">
                            <?=Form::buildField('pos_group_choose_single', 'CONTRACT_POS_GROUPS', $contractDotsGroups, [
                                'show_all' => true,
                                'render_value_to' => '.contract_pos_groups_render_value',
                                'group_type' => Model_Dot::GROUP_TYPE_SUPPLIER
                            ])?>
                        </div>
                    </div>
                </div>
            <?}?>

        </div>
        <div class="col-lg-6">
            <div class="card m-b-0">
                <div class="card-body bg-light">
                    <b class="f18">Баланс по договору:</b>
                    <br>
                    <?if(!empty($contract['BALANCE']) && !is_numeric($contract['BALANCE'])){?>
                        <div class="font-20 font-weight-bold"><?=$contract['BALANCE']?></div>
                    <?}else{?>
                        <div class="font-20 font-weight-bold"><?=number_format($contract['BALANCE'], 2, ',', ' ')?> <?=Text::RUR?></div>
                        <?if (!empty($contract['BALANCE_DATE'])) {?><i class="text-muted">на <?=$contract['BALANCE_DATE']?></i><?}?>
                    <?}?>
            </div>
        </div>
    </div>

</div>

<script>
    var DATA_SOURCE_INSIDE = <?=Model_Supplier_Contract::DATA_SOURCE_INSIDE?>;
</script>