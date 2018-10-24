<div class="form">

<?if(!empty($fields[Model_Report::REPORT_CONSTRUCTOR_TYPE_PERIOD])){
    foreach($fields[Model_Report::REPORT_CONSTRUCTOR_TYPE_PERIOD] as $field){?>
        <div class="form-group row">
            <div class="col-md-4 text-muted">
                <div class="hidden-sm-down text-right"><?=$field['PROPERTY_NAME']?>:</div>
                <div class="hidden-md-up"><?=$field['PROPERTY_NAME']?>:</div>
            </div>
            <div class="col-md-8 with-mt">
                <?=Form::buildField($field['PROPERTY_FORM'], $field['PARAM_NAME'], false, ['weight' => $field['PROPERTY_WEIGHT']])?>
            </div>
        </div>
    <?}
}

if(!empty($fields[Model_Report::REPORT_CONSTRUCTOR_TYPE_ADDITIONAL])){?>

    <div class="form-group row m-b-0">
        <div class="col-md-4 text-muted">
            <div class="hidden-sm-down text-right">Дополнительные параметры:</div>
            <div class="hidden-md-up">Дополнительные параметры:</div>
        </div>
        <div class="col-md-8 with-mt report_additional_params">
            <?foreach($fields[Model_Report::REPORT_CONSTRUCTOR_TYPE_ADDITIONAL] as $field){?>

                <div class="m-b-20">
                    <b class="m-b-5"><?=$field['PROPERTY_NAME']?>:</b><br>
                    <?=Form::buildField($field['PROPERTY_FORM'], $field['PARAM_NAME'], false, [
                        'weight' => $field['PROPERTY_WEIGHT'],
                        'show_all' => !empty($field['PROPERTY_ALL']) ? $field['PROPERTY_ALL'] : false
                    ])?>
                </div>

            <?}?>
        </div>
    </div>
<?}

if(!empty($fields[Model_Report::REPORT_CONSTRUCTOR_TYPE_FORMAT])){?>
    <div class="form-group row">
        <div class="col-md-4 text-muted">
            <div class="hidden-sm-down text-right">Формат:</div>
            <div class="hidden-md-up">Формат:</div>
        </div>
        <div class="col-md-8 with-mt">
            <?foreach($fields[Model_Report::REPORT_CONSTRUCTOR_TYPE_FORMAT] as $field){?>
                <?=Form::buildField($field['PROPERTY_FORM'], $field['PARAM_NAME'])?>
            <?}?>
        </div>
    </div>
<?}?>

    <div class="form-group row m-b-0">
        <div class="col-md-4"></div>
        <div class="col-md-8 with-mt">
            <span class="btn btn-outline-primary waves-effect waves-light" onclick="generateReport($(this))"><i class="icon-download"></i> Сформировать</span>
        </div>
    </div>

</div>