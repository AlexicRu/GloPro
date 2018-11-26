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
            <label class="custom-control custom-checkbox mb-0">
                <input type="checkbox" class="custom-control-input" name="CLOSE_CALCULATION"
                    <?=(!isset($params['CLOSE_CALCULATION']) || !empty($params['CLOSE_CALCULATION']) ? 'checked' : '')?>>
                <span class="custom-control-label">Завершить расчет</span>
            </label>
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