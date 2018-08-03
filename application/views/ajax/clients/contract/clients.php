<?if (empty($clients)) {?>
    <div class="line_inner">Клиенты не найдены</div>
<?} else {?>

    <?foreach ($clients as $client) {?>
        <div class="line_inner" manager_id="<?=$managerId?>" client_id="<?=$client['CLIENT_ID']?>">
            <span class="gray"><?=$client['CLIENT_ID']?></span>
            &nbsp;&nbsp;&nbsp; <b><?=$client['CLIENT_NAME']?></b>
            <div class="fr">
                <a href="#" class="red del" onclick="delManagersClient($(this))"><i class="fa fa-trash-alt"></i> Удалить <i class="fa fa-times"></i></a>
            </div>

            <?if(Access::allow('managers_edit-manager-clients-contract-binds')) {?>
                <div class="line_inner__second_line">
                    <table class="table_form">
                        <tr>
                            <td class="gray right">
                                Договоры:
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <span class="btn btn_green" onclick="saveManagerClientContractBinds($(this))"><i class="fa fa-check"></i> Сохранить</span>
                            </td>
                        </tr>
                    </table>
                </div>
            <?}?>
        </div>
    <?}?>
<?}?>