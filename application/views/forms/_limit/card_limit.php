<div class="form-group row p-b-20 border-bottom" limit_group="<?=(!empty($limit['LIMIT_ID']) ? $limit['LIMIT_ID'] : -1)?>">
    <div class="col-lg-5 align-top">
        <?
        if (!empty($limit['services'])) {
            foreach ($limit['services'] as $limitService) {
                echo Form::buildLimitService($cardId, $limitService, $postfix);
            }
        }
        ?>
        <div limit_group_btns>
            <nobr>
                <?if ($settings['canAddService']) {?>
                    <button class="<?=Text::BTN?> btn-sm btn-outline-success btn_card_edit_add_serviсe" onclick="cardEditAddService_<?=$postfix?>($(this))"><i class="fa fa-plus"></i> добавить услугу</button>
                <?}?>
                <?if ($settings['canDelLimit']) {?>
                    <button class="<?=Text::BTN?> btn-sm btn-outline-danger btn_card_edit_del_limit" onclick="cardEditDelLimit_<?=$postfix?>($(this))"><i class="fa fa-times"></i> удалить лимит</button>
                <?}?>
            </nobr>
        </div>
    </div>
    <div class="col-lg-3 align-top with-mt">
        <div class="input-group">
            <input type="number" name="limit_value" value="<?=(isset($limit['LIMIT_VALUE']) ? $limit['LIMIT_VALUE'] : '')?>" placeholder="Объем / сумма" class="form-control"
                   <?if (!$settings['canUseFloat']) {?>onkeypress="$(this).val(parseInt($(this).val()))"<?}?>
                   min="<?=$settings['minValue']?>"
            >
            <div class="input-group-append">
                <select name="unit_type"
                        class="custom-select" <?= (empty($settings['canEditSelect']) ? 'disabled' : '') ?>>
                    <?foreach($settings['limitParams'] as $limitParam => $value){?>
                        <option value="<?=$limitParam?>" <?if(isset($limit['UNIT_TYPE']) && $limitParam == $limit['UNIT_TYPE']){?>selected<?}?>><?=$value?></option>
                    <?}?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-lg-4 align-top with-mt">
        <div class="input-group">
            <? if ($settings['canViewDurationValue']) { ?>
                <? if (!empty($settings['durationValues'])) { ?>
                    <select name="duration_value" class="custom-select">
                        <? foreach ($settings['durationValues'] as $key => $durationValue) { ?>
                            <option value="<?= $key ?>"><?= $durationValue ?></option>
                        <? } ?>
                    </select>
                <? } else { ?>
                    <input type="text" name="duration_value"
                           value="<?= (isset($limit['DURATION_VALUE']) ? $limit['DURATION_VALUE'] : '') ?>"
                           placeholder="Кол-во"
                           class="form-control" <?= (empty($settings['canEditDurationValue']) ? 'disabled' : '') ?>
                        <?= ($settings['minDurationValue'] !== false ? 'min="' . $settings['minDurationValue'] . '"' : '') ?>
                        <?= ($settings['maxDurationValue'] !== false ? 'min="' . $settings['maxDurationValue'] . '"' : '') ?>
                    >
                <? } ?>
            <?}?>
            <div class="input-group-append">
                <select name="duration_type"
                        class="custom-select" <?= (empty($settings['canEditSelect']) ? 'disabled' : '') ?>>
                    <?foreach($settings['limitTypes'] as $limitType => $value){?>
                        <option value="<?=$limitType?>" <?if(isset($limit['DURATION_TYPE']) && $limitType == $limit['DURATION_TYPE']){?>selected<?}?>><?=$value?></option>
                    <?}?>
                </select>
            </div>
        </div>
    </div>
</div>