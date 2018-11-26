<?if (empty($clients)) {?>
    <div class="line_inner">Клиенты не найдены</div>
<?} else {?>

    <div class="card-columns">
    <?foreach ($clients as $client) {?>
        <div class="card" manager_id="<?=$managerId?>" client_id="<?=$client['CLIENT_ID']?>">
            <div class="card-body bg-light">
                <div class="float-right">
                    <a href="#" class="text-danger" onclick="delManagersClient($(this))"><i class="fa fa-trash-alt"></i></a>
                </div>

                <b><?=$client['CLIENT_NAME']?></b>
                <span class="text-muted">[<?=$client['CLIENT_ID']?>]</span>

                <?if(Access::allow('managers_edit-manager-clients-contract-binds')) {?>
                    <?
                        $contractsIds = [];

                        if (!empty($contractsTree[$client['CLIENT_ID']])) {
                            $contractsIds = $contractsTree[$client['CLIENT_ID']];
                        }
                    ?>
                    <?=Form::buildField('contract_choose_multi', 'manager_clients_contract_binds'.$client['CLIENT_ID'], implode(',', $contractsIds), [
                        'depend_values' => ['client_id' => $client['CLIENT_ID']],
                        'depend_postfix' => $client['CLIENT_ID']
                    ])?>

                    <span class="<?=Text::BTN?> btn-success btn-sm m-t-5" onclick="saveManagerClientContractBinds($(this))"><i class="fa fa-check"></i> Сохранить</span>
                <?}?>
            </div>
        </div>
    <?}?>
    </div>
<?}?>