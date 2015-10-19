<div class="block block_margin f18">
    <span class="gray">Текущий баланс:</span> <b><?=number_format($balance['BALANCE'], 2, ',', ' ')?> &#x20bd;</b>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span class="gray">Оборот за текущий перид:</span> <b>55 522,56 л.</b>
</div>

<div class="tabs_block">
    <div class="tabs">
        <span ajax_tab="contract" class="tab <?=($tab == 'contract' ? 'active' : '')?>"><i class="icon-contract"></i> Договор</span><span ajax_tab="cards" class="tab <?=($tab == 'cards' ? 'active' : '')?>"><i class="icon-cards"></i> Карты</span><span ajax_tab="account" class="tab  <?=($tab == 'account' ? 'active' : '')?>"><i class="icon-account"></i> Счет</span><span ajax_tab="reports" class="tab <?=($tab == 'reports' ? 'active' : '')?>"><i class="icon-reports"></i> Отчеты</span>
    </div>
    <div class="tabs_content tabs_content_no_padding">
        <?=$content?>
    </div>
</div>