<div class="section_wrapper card border">
    <div class="card-body" uid_section="<?=$uidSection?>" section_num="<?=$section['SECTION_NUM']?>">
        <div class="float-right">
            <span class="<?=Text::BTN?> btn-sm btn-outline-danger ts_remove"><i class="fa fa-times"></i></span>
        </div>

        <h3 class="card-title">
            <span class="lstick"></span>Секция <span class="section_num"><?=$section['SECTION_NUM']?></span>

            <div class="btn-group ml-2">
                <span class="<?=Text::BTN?> btn-sm btn-outline-info" onclick="sectionMove('up', $(this))"><i class="fa fa-chevron-up"></i></span>
                <span class="<?=Text::BTN?> btn-sm btn-outline-info" onclick="sectionMove('down', $(this))"><i class="fa fa-chevron-down"></i></span>
            </div>

            <?if ((isset($tariff['current_version']) && $tariff['current_version'] == $tariff['LAST_VERSION']) && !empty($tariff)) {?>
                <span class="<?=Text::BTN?> btn-sm btn-outline-primary remove-on-copy" onclick="sectionCopy($(this))"><i class="far fa-copy"></i></span>
            <?}?>
        </h3>


        <b class="font-18">Условия:</b>
        <div class="ts_conditions m-b-20">
            <?foreach($conditions as $key => $condition){
                $uid = $tariff['TARIF_ID'].'_'.$section['SECTION_NUM'].'_'.$condition['CONDITION_NUM'];
                ?>
                <?=Model_Tariff::buildReference($uid, $reference)?>
                <script>
                    $(function () {
                        changeCondition('<?=$uid?>', <?=$condition['CONDITION_ID']?>, <?=$condition['COMPARE_ID']?>, '<?=$condition['CONDITION_VALUE']?>');
                    });
                </script>
            <?}?>
        </div>

        <span class="<?=Text::BTN?> btn_add_condition btn-sm btn-outline-primary" onclick="addSectionCondition($(this))"><i class="fa fa-plus"></i> Добавить условие</span>

        <br><br>

        <b class="font-18">Параметры:</b>
        <?=Model_Tariff::buildParams($uidSection, (!empty($section['params']) ? $section['params'] : []))?>
    </div>
</div>