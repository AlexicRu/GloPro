<div class="form tariff_wrapper">
    <div class="form-group row">
        <div class="col-sm-4">
            <div class="text-right hidden-xs-down text-muted">Название:</div>
            <span class="hidden-sm-up">Название:</span>
        </div>
        <div class="col-sm-8">
            <input type="hidden" name="tarif_id" value="<?=(!empty($tariff['TARIF_ID']) ? $tariff['TARIF_ID'] : 0)?>">
            <input type="text" name="tarif_name" class="form-control" value="<?=(!empty($tariff['TARIF_NAME']) ? Text::quotesForForms($tariff['TARIF_NAME']) : '')?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-4">
            <div class="text-right hidden-xs-down text-muted">Версия:</div>
            <span class="hidden-sm-up">Версия:</span>
        </div>
        <div class="col-sm-8">
            <select name="tariff_versions">
                <?foreach ($tariff['versions'] as $version) {?>
                    <option value="<?=$version['VERSION_ID']?>" <?=($version['VERSION_ID'] == $tariff['current_version'] ? 'selected' : '')?>>
                        <?=$version['VERSION_ID']?> от <?=$version['DATE_CREATE_STR']?>
                    </option>
                <?}?>
            </select>
            <span class="<?=Text::BTN?> btn-sm btn-outline-success" onclick="loadTariffVersion($(this))">Загрузить</span>
        </div>
    </div>

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
    <div class="form-group row">
        <div class="col-12">
            <span class="<?=Text::BTN?> btn-outline-primary btn_add_section" onclick="addSection($(this))"><i class="fa fa-plus"></i> Добавить секцию</span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-12">
            <span class="<?=Text::BTN?> btn-outline-success" onclick="saveTariff($(this))"><i class="fa fa-check"></i> Сохранить</span>
        </div>
    </div>
</div>