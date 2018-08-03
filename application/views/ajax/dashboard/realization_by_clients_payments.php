<div class="row">
    <div class="col-sm-6 text-muted">
        <div class="text-right hidden-xs-down text-muted">Сумма платежей:</div>
        <span class="hidden-sm-up">Сумма платежей:</span>
    </div>
    <div class="col-sm-6">
        <?=number_format($data['SUMPAY'], 2, '.', '&nbsp;')?>&nbsp;<?=Text::RUR?>
    </div>
</div>