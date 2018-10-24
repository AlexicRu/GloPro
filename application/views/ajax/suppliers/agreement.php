<?
$toggle = 'agreement'.$agreement['AGREEMENT_ID'];
?>
<div class="agreement__outer" agreement_id="<?=$agreement['AGREEMENT_ID']?>">

    <div class="p-20 border-bottom">

        <div toggle_block="<?=$toggle?>">
            <div class="row align-items-center font-20">
                <div class="col-9">
                    [<?=$agreement['AGREEMENT_ID']?>]
                    <span toggle_block="<?=$toggle?>">
                        <b><?=$agreement['AGREEMENT_NAME']?></b>
                        <span class="text-muted">от</span> <?=$agreement['WEB_DATE_BEGIN']?>
                        <?if($agreement['WEB_DATE_END'] != '31.12.2099'){?><span class="text-muted">до</span> <?=$agreement['WEB_DATE_END']?><?}?> &nbsp;
                    </span>
                </div>
                <div class="col-3 text-right">
                    <?if(Access::allow('suppliers_agreement-edit')){?>
                        <div toggle_block="<?=$toggle?>"><button class="<?=Text::BTN?> btn-outline-primary" toggle="<?=$toggle?>"><i class="fa fa-pencil-alt"></i><span class="hidden-xs-down"> Редактировать</span></button></div>
                    <?}?>
                </div>
            </div>
        </div>

        <div class="dn" toggle_block="<?=$toggle?>">
            <div class="form-group row font-20">
                <label class="col-sm-2 col-form-label">[<?=$agreement['AGREEMENT_ID']?>]</label>
                <div class="col-sm-10">
                    <input type="text" name="AGREEMENT_NAME" value="<?=Text::quotesForForms($agreement['AGREEMENT_NAME'])?>" class="form-control" placeholder="Название">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 m-b-20 p-b-5">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">от</div>
                        </div>
                        <input type="date" name="DATE_BEGIN" value="<?=Date::formatToDefault($agreement['WEB_DATE_BEGIN'])?>" class="form-control">
                    </div>
                </div>

                <div class="col-md-4 m-b-20 p-b-5">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">до</div>
                        </div>
                        <input type="date" name="DATE_END" value="<?=Date::formatToDefault($agreement['WEB_DATE_END'])?>" class="form-control">
                    </div>
                </div>
            </div>

            <?if(Access::allow('suppliers_contract-edit')){?>
                <div class="form-group row m-b-0">
                    <div class="col-sm-12">
                        <button class="btn waves-effect waves-light btn-success" onclick="agreementSave($(this))"><i class="fa fa-check"></i> Сохранить</button>
                        <button class="btn waves-effect waves-light btn-danger" toggle="<?=$toggle?>"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
                    </div>
                </div>
            <?}?>

        </div>
    </div>

    <div class="p-20">
        <div class="row">
            <div class="col-sm-4 text-muted">
                <div class="text-right hidden-xs-down text-muted">Расчет скидки:</div>
                <div class="hidden-sm-up">Засчет скидки:</div>
            </div>
            <div class="col-sm-8 with-mt">
                <div toggle_block="<?=$toggle?>">
                    <?if($agreement['DISCOUNT_TYPE'] == Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_LOAD){?>
                        Из данных загрузки
                    <?}else{
                        foreach ($tariffs as $tariff) {
                            if ($tariff['TARIF_ID'] == $agreement['TARIF_ID']) {
                                ?>По тарифу - <b><?=$tariff['TARIF_NAME']?></b><?
                            }
                        }
                    }?>
                </div>

                <div toggle_block="<?=$toggle?>" class="dn">

                    <div class="m-b-5">
                        <input type="radio"
                               class="with-gap radio-col-purple"
                               id="DISCOUNT_TYPE_<?=Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_LOAD?>_<?=$agreement['AGREEMENT_ID']?>"
                               name="DISCOUNT_TYPE"
                               value="<?=Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_LOAD?>"
                               <?=($agreement['DISCOUNT_TYPE'] == Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_LOAD ? 'checked' : '')?>
                               onchange="checkAgreementDiscountType($(this))"
                        >
                        <label for="DISCOUNT_TYPE_<?=Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_LOAD?>_<?=$agreement['AGREEMENT_ID']?>">Из данных загрузки</label>
                    </div>

                    <div class="m-b-5">
                        <input type="radio"
                               class="with-gap radio-col-purple"
                               id="DISCOUNT_TYPE_<?=Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_TARIFF?>_<?=$agreement['AGREEMENT_ID']?>"
                               name="DISCOUNT_TYPE"
                               value="<?=Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_TARIFF?>"
                               <?=($agreement['DISCOUNT_TYPE'] == Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_TARIFF ? 'checked' : '')?>
                               onchange="checkAgreementDiscountType($(this))"
                        >
                        <label for="DISCOUNT_TYPE_<?=Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_TARIFF?>_<?=$agreement['AGREEMENT_ID']?>">По тарифу</label>

                        <?=Form::buildField('contract_tariffs', 'TARIF_ID', $agreement['TARIF_ID'])?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var DISCOUNT_TYPE_FROM_LOAD = <?=Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_LOAD?>;
</script>