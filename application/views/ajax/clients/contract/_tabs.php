<div class="card">
    <div class="card-body font-20">
        <div class="row">
            <div class="col-md-6">
                <span class="text-muted">Текущий баланс:</span>
                <b class="nowrap"><?=number_format($balance['BALANCE'], 2, ',', ' ')?> <?=Text::RUR?></b>
            </div>
            <div class="col-md-6">
                <span class="text-muted">Оборот за текущий период:</span>
                <b class="nowrap"><?=number_format($balance['MONTH_REALIZ'], 2, ',', ' ')?> л.</b>
            </div>
        </div>
    </div>
</div>

<!-- Nav tabs -->
<ul class="nav nav-tabs customtab" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?=($tab == 'contract' ? 'active' : '')?>" href="#" ajax_tab="contract">
            <i class="fa fa-book fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Договор</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=($tab == 'cards' ? 'active' : '')?>" href="#" ajax_tab="cards">
            <i class="fa fa-credit-card-front fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Карты</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=($tab == 'account' ? 'active' : '')?>" href="#" ajax_tab="account">
            <i class="fa fa-briefcase fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Счет</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=($tab == 'reports' ? 'active' : '')?>" href="#" ajax_tab="reports">
            <i class="fa fa-file-alt fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Отчеты</span>
        </a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active">
        <div class="bg-white">
            <?=$content?>
        </div>
    </div>
</div>