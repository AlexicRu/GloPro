<!-- Nav tabs -->
<ul class="nav nav-tabs customtab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#tabInfo<?=$managerId?>" role="tab">
            <i class="far fa-info fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Информация</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tabClients<?=$managerId?>" role="tab" onclick="showManagersClients(<?=$managerId?>)">
            <i class="far fa-users fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Клиенты</span>
        </a>
    </li>
    <?if (Access::allow('managers_load-reports')) {?>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tabReports<?=$managerId?>" role="tab" onclick="showManagersReports(<?=$managerId?>)">
            <i class="far fa-file-alt fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Отчеты</span>
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
                <button class="<?=Text::BTN?> <?=($manager['STATE_ID'] != Model_Manager::STATE_MANAGER_ACTIVE ? 'btn-success' : 'btn-danger')?>" onclick="managerStateToggle(<?=$manager['MANAGER_ID']?>, $(this))">
                    <span <?=($manager['STATE_ID'] != Model_Manager::STATE_MANAGER_ACTIVE ? 'style="display:none"' : '')?>><i class="fa fa-lock-alt"></i> Заблокировать</span>
                    <span <?=($manager['STATE_ID'] == Model_Manager::STATE_MANAGER_ACTIVE ? 'style="display:none"' : '')?>><i class="fa fa-unlock-alt"></i> Разблокировать</span>
                </button>
            <?}?>
        </div>

        <?=$managerSettingsForm?>
    </div>
    <div class="tab-pane" id="tabClients<?=$managerId?>" role="tabpanel">
        <div class="card border-bottom m-b-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" onkeypress="if(event.keyCode == 13){searchManagerClients($(this), <?=$managerId?>)}" class="form-control" placeholder="Поиск...">
                        </div>
                    </div>
                    <div class="col-sm-5 text-right with-mt">
                        <a href="#" data-toggle="modal" data-target="#manager_add_clients" class="<?=Text::BTN?> btn-outline-primary"><i class="fa fa-plus"></i> Добавить клиентов</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-3">
            <div class="client_list"></div>
        </div>
    </div>
    <?if (Access::allow('managers_load-reports')) {?>
    <div class="tab-pane" id="tabReports<?=$managerId?>" role="tabpanel">
        <div class="p-3 border-bottom text-right">
            <a href="#" data-toggle="modal" data-target="#manager_add_reports" class="<?=Text::BTN?> btn-outline-primary"><i class="fa fa-plus"></i> Добавить отчеты</a>
        </div>
        <div class="p-3">
            <div class="report_list"></div>
        </div>
    </div>
    <?}?>
</div>