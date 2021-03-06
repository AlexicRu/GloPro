<div class="form tariff_wrapper">
    <div class="form-group row">
        <div class="col-sm-4 text-muted form__row__title">
            Название:
        </div>
        <div class="col-sm-6 with-mt">
            <input type="hidden" name="tarif_id" value="<?=(!empty($tariff['TARIF_ID']) ? $tariff['TARIF_ID'] : 0)?>">
            <input type="text" name="tarif_name" class="form-control" value="<?=(!empty($tariff['TARIF_NAME']) ? Text::quotesForForms($tariff['TARIF_NAME']) : '')?>">
        </div>
        <div class="col-sm-2 with-mt remove-on-copy">
            <?if (!empty($tariff)) {?>
                <span class="<?=Text::BTN?> btn-danger" onclick="deleteTariff($(this))"><i class="fa fa-trash-alt"></i></span>
                <span class="<?=Text::BTN?> btn-primary" onclick="copyTariff($(this))"><i class="far fa-copy"></i></span>
            <?}?>
        </div>
    </div>

    <?if (!empty($tariff['versions'])) {?>
    <div class="form-group row remove-on-copy">
        <div class="col-sm-4 text-muted form__row__title">
            Версия:
        </div>
        <div class="col-sm-6 with-mt">
            <select name="tariff_versions" class="custom-select">
                <?foreach ($tariff['versions'] as $version) {?>
                    <option value="<?=$version['VERSION_ID']?>" <?=($version['VERSION_ID'] == $tariff['current_version'] ? 'selected' : '')?>>
                        <?=$version['VERSION_ID']?> от <?=$version['DATE_CREATE_STR']?>
                    </option>
                <?}?>
            </select>
        </div>
        <div class="col-sm-2 with-mt">
            <span class="<?=Text::BTN?> btn-sm btn-success" onclick="loadTariffVersion($(this))">Загрузить</span>
        </div>
    </div>
    <?}?>

    <div class="t_sections_list">
        <?if(!empty($settings)){?>
            <?foreach($settings as $conditions){
                $section = reset($conditions);
                $uidSection = $tariff['TARIF_ID'].'_'.$section['SECTION_NUM'];
                ?>
                <?=Model_Tariff::buildSection($uidSection, $section,  $tariff, $conditions, $reference)?>
            <?}?>
        <?}?>
    </div>

    <?if ((isset($tariff['current_version']) && $tariff['current_version'] == $tariff['LAST_VERSION']) || empty($tariff)) {?>
    <div class="form-group row">
        <div class="col-12">
            <span class="<?=Text::BTN?> btn-outline-primary btn_add_section" onclick="addSection($(this))"><i class="fa fa-plus"></i> Добавить секцию</span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-12">
            <span class="<?=Text::BTN?> btn-success" onclick="saveTariff($(this))"><i class="fa fa-check"></i> Сохранить</span>
        </div>
    </div>
    <?} else {?>
        <i class="text-muted">Только просмотр</i>
    <?}?>
</div>