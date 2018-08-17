<div class="bg-light tsc_item line_inner p-3">

    <div class="float-right hidden-xs-down">
        <span class="<?=Text::BTN?> btn-sm btn-outline-danger ts_remove"><i class="fa fa-times"></i></span>
    </div>

    <div class="text-right hidden-sm-up m-b-5">
        <span class="<?=Text::BTN?> btn-sm btn-outline-danger ts_remove"><i class="fa fa-times"></i></span>
    </div>

    <div class="reference_block row" uid="<?=$uid?>">
        <?
        $referenceList = [];

        foreach($reference as $referenceBlock){
            $referenceItem = reset($referenceBlock);
            $referenceList[] = [
                'CONDITION_ID' => $referenceItem['CONDITION_ID'],
                'WEB_CONDITION' => $referenceItem['WEB_CONDITION'],
            ];
        }
        ?>
        <div class="col-xl-4 col-sm-6">
            <select name="CONDITION_ID" class="custom-select">
                <?foreach($referenceList as $referenceItem){?>
                    <option value="<?=$referenceItem['CONDITION_ID']?>">
                        <?=$referenceItem['WEB_CONDITION']?>
                    </option>
                <?}?>
            </select>
        </div>

        <div class="col-xl-3 col-sm-6">
            <?foreach($reference as $referenceBlock){
                $referenceFirst = reset($referenceBlock);?>
                <select class="reference_compare custom-select" style="display: none" name="COMPARE_ID" condition_id="<?=$referenceFirst['CONDITION_ID']?>">
                    <?foreach($referenceBlock as $referenceItem){?>
                        <option value="<?=$referenceItem['COMPARE_ID']?>">
                            <?=$referenceItem['WEB_COMPARISON']?>
                        </option>
                    <?}?>
                </select>
            <?}?>
        </div>

        <div class="col-xl-5 col-12 with-mb">
            <?foreach($reference as $referenceBlock){
                $referenceFirst = reset($referenceBlock);?>
                <span class="web_form_element" style="display: none" condition_id="<?=$referenceFirst['CONDITION_ID']?>"><?=Form::buildField($referenceFirst['WEB_FORM'], $referenceFirst['WEB_FORM'])?></span>
            <?}?>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.reference_block[uid=<?=$uid?>] [name=CONDITION_ID]').on('change', function () {
            onChangeCondition($(this));
        });
    });
</script>