<div class="tariff_wrapper">
    <table>
        <tr>
            <td class="gray right" width="200">Название:</td>
            <td>
                <input type="hidden" name="tarif_id" value="<?=(!empty($tariff['TARIF_ID']) ? $tariff['TARIF_ID'] : 0)?>">
                <input type="text" name="tarif_name" class="input_big input_grand" value="<?=(!empty($tariff['TARIF_NAME']) ? Text::quotesForForms($tariff['TARIF_NAME']) : '')?>">
            </td>
        </tr>
    </table>

    <div class="t_sections_list">
        <?if(!empty($settings)){?>
            <?foreach($settings as $conditions){
                $section = reset($conditions);
                $uidSection = $tariff['TARIF_ID'].'_'.$section['SECTION_NUM'];
                ?>
                <?=Model_Tariff::buildSection($uidSection, $section,  $tariff['TARIF_ID'], $conditions, $reference)?>
            <?}?>
        <?}?>
    </div>
    <span class="btn waves-effect waves-light btn_add_section" onclick="addSection($(this))"><i class="fa fa-plus"></i> Добавить секцию</span>

    <div class="row_btns">
        <span class="btn waves-effect waves-light btn_green" onclick="saveTariff($(this))"><i class="fa fa-check"></i> Сохранить</span>
    </div>
</div>