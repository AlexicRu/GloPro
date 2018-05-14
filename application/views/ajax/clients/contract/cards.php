<div class="card-body border-bottom">
    <div class="row font-20">
        <div class="col-md-4 col-lg-3">
            <span class="text-muted">Всего карт:</span>
            <a href="#" onclick="filterCards('all')"><?=($cardsCounter['ALL_CARDS']??0)?></a>
        </div>
        <div class="col-md-4 col-lg-3">
            <span class="text-muted">В работе:</span>
            <a href="#" onclick="filterCards('work')" class="cards_cnt_in_work"><?=($cardsCounter['CARDS_IN_WORK']??0)?></a>
        </div>
        <div class="col-md-4 col-lg-3">
            <span class="text-muted">Заблокировано:</span>
            <a href="#" onclick="filterCards('disabled')" class="cards_cnt_blocked"><?=($cardsCounter['CARDS_NOT_WORK']??0)?></a>
        </div>
        <div class="col-md-12 col-lg-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control cards_search" placeholder="Поиск..." value="<?=(!empty($params['query']) ? $params['query'] : '')?>">
            </div>
        </div>
    </div>
</div>

<div class="card-body border-bottom d-xl-none">
    <div class="row">
        <div class="col-4">
            <span class="btn btn-primary" toggle_class="card_list"><i class="fa fa-bars"></i> <span class="d-none d-sm-inline-block">Список карт</span></span>
        </div>
        <div class="col-8 text-right">
            <?if(Access::allow('clients_card-add')){?>
                <a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#card_add"><i class="fa fa-plus"></i> Добавить карту</a>
            <?}?>
        </div>
    </div>
</div>

<div class="vtabs customvtab tabs_cards">
    <ul class="nav nav-tabs tabs-vertical tabs-floating p-t-10" role="tablist" toggle_block="card_list">
        <?if(Access::allow('clients_card-add')){?>
            <li class="nav-item no_content d-none d-xl-block before_scroll">
                <a class="nav-link nowrap" href="#" data-toggle="modal" data-target="#card_add"><i class="fa fa-plus"></i> Добавить карту</a>
            </li>
        <?}?>
        <?include('cards/list.php')?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content"></div>
</div>

<?if(Access::allow('clients_card-add')){?>
    <?=$popupCardAdd?>
<?}?>

<script>
    /*
     0 - не отображать кнопку "Блокировать"/"Разблокировать"
     1 - отображать кнопку "Блокировать"/"Разблокировать",
     2 - отображать, но при блокировании такой карты писать: "Заявка на блокировку/разблокировку отправлена менеджеру. Карта будет заблокирована/разблокирована в течение 48 часов!" (писать блокирока или разблокировка в зависимости от действия)
     при изъятии такой карты писать: "Карта откреплена от договора! Проверьте статус в сторонней системе!"
    */
    function cardToggle(t)
    {
        var comment = '';

        if(t.hasClass('btn-outline-danger')){
            comment = prompt('Причина блокировки:');
        }

        if(comment != null) {
            var params = {
                card_id: $('.tabs_cards .tab-pane.active [name=card_id]').val(),
                contract_id: $('[name=contracts_list]').val(),
                comment: comment
            };

            $.post('/clients/card-toggle', {params:params}, function (data) {
                if (data.success) {
                    t.toggleClass('btn-outline-danger').toggleClass('btn-outline-success').find('span').toggle();

                    var tab = $('.tabs_cards [tab='+ params.card_id +'] > a');
                    var cnt_in_work = $('.cards_cnt_in_work');
                    var cnt_blocked = $('.cards_cnt_blocked');

                    if(t.hasClass('btn-outline-success')){
                        tab.append('<div><span class="label label-danger label_small">Заблокирована</span></div>');
                        cnt_in_work.text(parseInt(cnt_in_work.text()) - 1);
                        cnt_blocked.text(parseInt(cnt_blocked.text()) + 1);

                        var blockAvailableText = 'Заявка на блокировку отправлена менеджеру. Карта будет заблокирована в течение 48 часов!';
                    }else{
                        tab.find('.label-danger').remove();
                        cnt_in_work.text(parseInt(cnt_in_work.text()) + 1);
                        cnt_blocked.text(parseInt(cnt_blocked.text()) - 1);

                        var blockAvailableText = 'Заявка на разблокировку отправлена менеджеру. Карта будет разблокирована в течение 48 часов!';
                    }

                    message(1, t.attr('block_available') == 2 ? blockAvailableText : 'Статус карты изменен');
                } else {
                    message(0, 'Ошибка обновления');
                }
            });
        }
    }

    function renderAjaxPaginationOperationsHistory(data, block)
    {
        for(var i = 0 in data){
            var tpl = $('<div class="row p-t-10 p-b-10 m-b-5 bg-light"><div class="col-md-2 text-muted"></div><div class="col-md-4"></div><div class="col-md-6 text-right"></div></div>');
            tpl.find('div:first').text(data[i].H_DATE);
            tpl.find('div:first').next().text(data[i].M_FIO);
            tpl.find('div:last').html(data[i].SHORT_DESCRIPTION);

            if(data[i].DESCRIPTION){
                tpl.append('<div class="col-12 text-muted text-right">Комментарий: '+ data[i].DESCRIPTION +'</div>');
            }

            block.append(tpl);
        }

        renderVerticalTabsScroll($('.tabs_cards .ajax_pagination:first'));
    }

    /**
     * изъятие карты
     * @param cardId
     */
    function cardWithdraw(cardId, blockAvailable)
    {
        if(!confirm('Изъять карту из договора?')){
            return false;
        }
        var params = {
            card_id: cardId,
            contract_id: $('[name=contracts_list]').val()
        };

        $.post('/clients/card-withdraw', {params:params}, function (data) {
            if (data.success) {

                message(1, blockAvailable == 2 ? 'Карта откреплена от договора! Проверьте статус в сторонней системе!' : 'Успешное изъятие');
                loadContract('cards');
            } else {
                message(0, 'Ошибка изъятия');
            }
        });
        return false;
    }
</script>