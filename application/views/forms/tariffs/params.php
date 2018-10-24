<div class="params_block" uid="<?=$uid?>">
    <div class="row m-b-5">
        <div class="col-sm-6 col-lg-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Тип</span>
                </div>
                <select name="DISC_TYPE" class="custom-select">
                    <?foreach(Model_Tariff::$paramsTypes as $paramsTypeId => $paramsType){?>
                        <option value="<?=$paramsTypeId?>"><?=$paramsType?></option>
                    <?}?>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4 with-mt">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Параметр</span>
                </div>
                <?foreach(Model_Tariff::$paramsTypesParams as $paramsTypeId => $paramsParams){?>
                    <select name="DISC_PARAM" class="disc_param_select custom-select" disc_type="<?=$paramsTypeId?>">
                        <?foreach($paramsParams as $paramsParamsId => $paramsParam){?>
                            <option value="<?=($paramsParamsId+1)?>">
                                <?=Model_Tariff::$paramsParams[$paramsParam]?>
                            </option>
                        <?}?>
                    </select>
                <?}?>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4 with-mt">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Значение</span>
                </div>
                <input type="number" class="form-control" name="DISC_VALUE" value="<?=(isset($params['DISC_VALUE']) ? $params['DISC_VALUE'] : '')?>">
            </div>
        </div>
        <div class="col-sm-6 col-lg-4 with-mt p-t-10">
            <input class="<?=Text::CHECKBOX?>" id="<?=$uid?>_close_calculation" type="checkbox" name="CLOSE_CALCULATION" <?=(!isset($params['CLOSE_CALCULATION']) || !empty($params['CLOSE_CALCULATION']) ? 'checked' : '')?>>
            <label for="<?=$uid?>_close_calculation" class="m-b-0">Завершить расчет</label>
        </div>
    </div>
</div>


<script>
    $(function () {
        $('.params_block[uid=<?=$uid?>] [name=DISC_TYPE]').on('change', function () {
            onChangeParam($(this));
        });

        <?if(!empty($params)){?>
            changeParam('<?=$uid?>', <?=$params['DISC_TYPE']?>, <?=$params['DISC_PARAM']?>);
        <?}else{?>
            changeParam('<?=$uid?>');
        <?}?>
    });
</script>