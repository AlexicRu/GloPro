<tr limit_group="<?=(!empty($limit['LIMIT_ID']) ? $limit['LIMIT_ID'] : -1)?>">
    <td class="align-top p-b-20">
        <?
        if (!empty($limit['services'])) {
            foreach ($limit['services'] as $limitService) {
                echo Form::buildLimitService($cardId, $limitService, $postfix);
            }
        }
        ?>
        <div>
            <nobr>
                <?if ($settings['canAddService']) {?>
                    <button class="btn btn-sm btn-outline-success waves-effect waves-light btn_card_edit_add_serviсe" onclick="cardEditAddService_<?=$postfix?>($(this))"><i class="fa fa-plus"></i> добавить услугу</button>
                <?}?>
                <?if ($settings['canDelLimit']) {?>
                    <button class="btn btn-sm btn-outline-danger waves-effect waves-light btn_card_edit_del_limit" onclick="cardEditDelLimit_<?=$postfix?>($(this))"><i class="fa fa-times"></i> удалить лимит</button>
                <?}?>
            </nobr>
        </div>
    </td>
    <td class="align-top" width="150">
        <input type="number" name="limit_value" value="<?=(isset($limit['LIMIT_VALUE']) ? $limit['LIMIT_VALUE'] : '')?>" placeholder="Объем / сумма" class="form-control"
            <?if (!$settings['canUseFloat']) {?>onkeypress="$(this).val(parseInt($(this).val()))"<?}?>
            min="<?=$settings['minValue']?>"
        >
    </td>
    <td class="align-top">
        <select name="unit_type" class="custom-select" <?=(empty($settings['editSelect']) ? 'disabled' : '')?>>
            <?foreach($settings['limitParams'] as $limitParam => $value){?>
                <option value="<?=$limitParam?>" <?if(isset($limit['UNIT_TYPE']) && $limitParam == $limit['UNIT_TYPE']){?>selected<?}?>><?=$value?></option>
            <?}?>
        </select>
    </td>
    <?if ($settings['cntTypes']) {?>
        <td class="align-top" width="75">
            <input type="text" name="duration_value"
                   value="<?=(isset($limit['DURATION_VALUE']) ? $limit['DURATION_VALUE'] : '')?>"
                   placeholder="Кол-во"
                   class="form-control" <?=(empty($settings['editDurationValue']) ? 'disabled' : '')?>
                   <?=($settings['minDurationValue'] !== false ? 'min="'. $settings['minDurationValue'] .'"' : '')?>
                   <?=($settings['maxDurationValue'] !== false ? 'min="'. $settings['maxDurationValue'] .'"' : '')?>
            >
        </td>
    <?}?>
    <td class="align-top">
        <select name="duration_type" class="custom-select" <?=(empty($settings['editSelect']) ? 'disabled' : '')?>>
            <?foreach($settings['limitTypes'] as $limitType => $value){?>
                <option value="<?=$limitType?>" <?if(isset($limit['DURATION_TYPE']) && $limitType == $limit['DURATION_TYPE']){?>selected<?}?>><?=$value?></option>
            <?}?>
        </select>
    </td>
</tr>