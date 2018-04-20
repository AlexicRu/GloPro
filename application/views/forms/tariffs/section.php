<div class="section_wrapper">
    <fieldset uid_section="<?=$uidSection?>" section_num="<?=$section['SECTION_NUM']?>">
        <legend>Секция <?=$section['SECTION_NUM']?> &nbsp; <span class="up_arrow" onclick="sectionMove('up', $(this))"></span> <span class="down_arrow" onclick="sectionMove('down', $(this))"></span> &nbsp;</legend>
        <span class="btn waves-effect waves-light btn_small btn_icon btn_red ts_remove"><i class="fa fa-times"></i></span>

        <b class="f18">Условия:</b>
        <div class="ts_conditions">
            <?foreach($conditions as $key => $condition){
                $uid = $tariffId.'_'.$section['SECTION_NUM'].'_'.$condition['CONDITION_NUM'];
                ?>
                <div class="tsc_item line_inner">
                    <span class="btn waves-effect waves-light btn_small btn_icon btn_red ts_remove"><i class="fa fa-times"></i></span>
                    <?=Model_Tariff::buildReference($uid, $reference)?>
                    <script>
                        $(function () {
                            changeCondition('<?=$uid?>', <?=$condition['CONDITION_ID']?>, <?=$condition['COMPARE_ID']?>, '<?=$condition['CONDITION_VALUE']?>');
                        });
                    </script>
                </div>
            <?}?>
        </div>

        <span class="btn waves-effect waves-light btn_add_condition btn_small" onclick="addSectionCondition($(this))"><i class="fa fa-plus"></i> Добавить условие</span>

        <br><br>

        <b class="f18">Параметры:</b>
        <?=Model_Tariff::buildParams($uidSection, (!empty($section['params']) ? $section['params'] : []))?>
    </fieldset>
</div>