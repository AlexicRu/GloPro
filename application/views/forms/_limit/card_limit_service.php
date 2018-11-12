<div limit_service class="input-group m-b-5">
    <select name="limit_service" class="custom-select" onchange="checkServices_<?=$postfix?>()" <?=(empty($settings['editServiceSelect']) ? 'disabled' : '')?>>
        <?foreach($servicesList as $service){?>
            <option
                    measure="<?=$service['MEASURE']?>"
                    group="<?=$service['SYSTEM_SERVICE_CATEGORY']?>"
                    value="<?=$service['SERVICE_ID']?>"
                    <?if(isset($limitService['id']) && $service['SERVICE_ID'] == $limitService['id']){?>selected<?}?>
            ><?=$service['FOREIGN_DESC']?></option>
        <?}?>
    </select>
    <?if ($settings['canDelService']) {?>
    <div class="input-group-append">
        <button class="btn btn-sm btn-danger waves-effect waves-light" onclick="cardEditDelService_<?=$postfix?>($(this))"><i class="fa fa-times"></i></button>
    </div>
    <?}?>
</div>