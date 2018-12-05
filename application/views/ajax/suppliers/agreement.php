<?
$toggle = 'agreement'.$agreement['AGREEMENT_ID'];
?>
<div class="agreement__outer" agreement_id="<?=$agreement['AGREEMENT_ID']?>">

    <div class="p-20 border-bottom">

        <div toggle_block="<?=$toggle?>">
            <div class="row align-items-center font-20">
                <div class="col-9">
                    <span toggle_block="<?=$toggle?>">
                        <b><?=$agreement['AGREEMENT_NAME']?></b>
                        <span class="nowrap"><span class="text-muted">от</span> <?=$agreement['WEB_DATE_BEGIN']?></span>
                        <?if($agreement['WEB_DATE_END'] != Date::DATE_MAX){?><span class="nowrap"><span class="text-muted">до</span> <?=$agreement['WEB_DATE_END']?></span><?}?> &nbsp;

                        <span class="badge badge-light">ID <?=$agreement['AGREEMENT_ID']?></span>
                    </span>
                </div>
                <div class="col-3 text-right">
                    <?if(Access::allow('suppliers_agreement-edit')){?>
                        <div toggle_block="<?=$toggle?>"><button class="<?=Text::BTN?> btn-outline-primary" toggle="<?=$toggle?>"><i class="fa fa-pen"></i><span class="hidden-xs-down"> Редактировать</span></button></div>
                    <?}?>
                </div>
            </div>
        </div>

        <div class="dn" toggle_block="<?=$toggle?>">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="AGREEMENT_NAME" value="<?=Text::quotesForForms($agreement['AGREEMENT_NAME'])?>" class="form-control form-control-lg" placeholder="Название">
                    <div class="input-group-append">
                        <span class="input-group-text"><?=$agreement['AGREEMENT_ID']?></span>
                    </div>
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
                        <input type="date" name="DATE_END" value="<?=($agreement['WEB_DATE_END'] == Date::DATE_MAX ? '' : Date::formatToDefault($agreement['WEB_DATE_END']))?>" class="form-control"
                               min="<?=Date::formatToDefault($agreement['WEB_DATE_BEGIN'])?>"
                        >
                    </div>
                </div>
            </div>

            <?if(Access::allow('suppliers_contract-edit')){?>
                <div class="form-group row m-b-0">
                    <div class="col-sm-12">
                        <button class="<?=Text::BTN?> btn-success" onclick="agreementSave($(this))"><i class="fa fa-check"></i> Сохранить</button>
                        <button class="<?=Text::BTN?> btn-danger" toggle="<?=$toggle?>"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
                    </div>
                </div>
            <?}?>

        </div>
    </div>

    <div class="p-20">
        <div class="row">
            <div class="col-sm-4 text-muted form__row__title">
                Расчет скидки:
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

                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input"
                               name="DISCOUNT_TYPE"
                               value="<?=Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_LOAD?>"
                                <?=($agreement['DISCOUNT_TYPE'] == Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_LOAD ? 'checked' : '')?>
                               onchange="checkAgreementDiscountType($(this))"
                        >
                        <span class="custom-control-label">Из данных загрузки</span>
                    </label>

                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input"
                               name="DISCOUNT_TYPE"
                               value="<?=Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_TARIFF?>"
                            <?=($agreement['DISCOUNT_TYPE'] == Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_TARIFF ? 'checked' : '')?>
                               onchange="checkAgreementDiscountType($(this))"
                        >
                        <span class="custom-control-label">По тарифу</span>
                    </label>

                    <?=Form::buildField('contract_tariffs', 'TARIF_ID', $agreement['TARIF_ID'])?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var DISCOUNT_TYPE_FROM_LOAD = <?=Model_Supplier_Agreement::DISCOUNT_TYPE_FROM_LOAD?>;
</script>