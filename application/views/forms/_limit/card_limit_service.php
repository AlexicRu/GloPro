<div class="form_elem" limit_service>
    <nobr>
            <select name="limit_service" class="custom-select select-width-auto m-b-5" onchange="checkServices_<?=$postfix?>()" <?=(empty($settings['editServiceSelect']) ? 'disabled' : '')?>>
            <?foreach($servicesList as $service){?>
                <option
                        group="<?=$service['SYSTEM_SERVICE_GROUP']?>"
                        value="<?=$service['SERVICE_ID']?>"
                        <?if(isset($limitService['id']) && $service['SERVICE_ID'] == $limitService['id']){?>selected<?}?>
                ><?=$service['FOREIGN_DESC']?></option>
            <?}?>
        </select>

        <?if ($settings['canDelService']) {?>
            <button class="btn btn-sm btn-outline-danger align-top waves-effect waves-light btn_card_edit_del_serviсe" onclick="cardEditDelService_<?=$postfix?>($(this))"><i class="fa fa-times"></i></button>
        <?}?>
    </nobr>
</div>