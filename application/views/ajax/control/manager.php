<!-- Nav tabs -->
<ul class="nav nav-tabs customtab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#tabInfo<?=$managerId?>" role="tab">
            Информация
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tabClients<?=$managerId?>" role="tab" onclick="showManagersClients(<?=$managerId?>)">
            Клиенты
        </a>
    </li>
    <?if (Access::allow('managers_load-reports')) {?>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tabReports<?=$managerId?>" role="tab" onclick="showManagersReports(<?=$managerId?>)">
            Отчеты
        </a>
    </li>
    <?}?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active p-3" id="tabInfo<?=$managerId?>" role="tabpanel">
        <div class="d-flex justify-content-between m-b-20">
            <h2>ID: <?=$managerId?></h2>

            <?if(Access::allow('manager_toggle')) {?>
                <button class="<?=Text::BTN?> <?=($manager['STATE_ID'] != Model_Manager::STATE_MANAGER_ACTIVE ? 'btn-outline-success' : 'btn-outline-danger')?>" onclick="managerStateToggle(<?=$manager['MANAGER_ID']?>, $(this))">
                    <span <?=($manager['STATE_ID'] != Model_Manager::STATE_MANAGER_ACTIVE ? 'style="display:none"' : '')?>><i class="fa fa-lock-alt"></i> Заблокировать</span>
                    <span <?=($manager['STATE_ID'] == Model_Manager::STATE_MANAGER_ACTIVE ? 'style="display:none"' : '')?>><i class="fa fa-unlock-alt"></i> Разблокировать</span>
                </button>
            <?}?>
        </div>

        <?=$managerSettingsForm?>
    </div>
    <div class="tab-pane" id="tabClients<?=$managerId?>" role="tabpanel">
        <div class="p-3 border-bottom d-flex justify-content-between">
            <div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" onkeypress="if(event.keyCode == 13){searchManagerClients($(this), <?=$managerId?>)}" class="form-control" placeholder="Поиск...">
                </div>
            </div>
            <div>
                <a href="#" data-toggle="modal" data-target="#manager_add_clients" class="<?=Text::BTN?> btn-outline-primary">Добавить клиентов</a>
            </div>
        </div>
        <div class="p-3">
            <div class="client_list"></div>
        </div>
    </div>
    <?if (Access::allow('managers_load-reports')) {?>
    <div class="tab-pane" id="tabReports<?=$managerId?>" role="tabpanel">
        <div class="p-3 border-bottom text-right">
            <a href="#" data-toggle="modal" data-target="#manager_add_reports" class="<?=Text::BTN?> btn-outline-primary">Добавить отчеты</a>
        </div>
        <div class="p-3">
            <div class="report_list"></div>
        </div>
    </div>
    <?}?>
</div>