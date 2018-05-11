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
        <div class="col-8">
            <span class="btn btn-primary" toggle_class="card_list"><i class="fa fa-bars"></i> Список карт</span>
        </div>
        <div class="col-4 text-right">
            <?if(Access::allow('clients_card-add')){?>
                <a class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#card_add"><i class="fa fa-plus"></i> Добавить карту</a>
            <?}?>
        </div>
    </div>
</div>

<div class="vtabs customvtab tabs_cards">
    <ul class="nav nav-tabs tabs-vertical tabs-floating" role="tablist" toggle_block="card_list">
        <?if(Access::allow('clients_card-add')){?>
            <li class="nav-item no_content d-none d-xl-inline">
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
    $(function(){
/*
 0 - не отображать кнопку "Блокировать"/"Разблокировать"
 1 - отображать кнопку "Блокировать"/"Разблокировать",
 2 - отображать, но при блокировании такой карты писать: "Заявка на блокировку/разблокировку отправлена менеджеру. Карта будет заблокирована/разблокирована в течение 48 часов!" (писать блокирока или разблокировка в зависимости от действия)
 при изъятии такой карты писать: "Карта откреплена от договора! Проверьте статус в сторонней системе!"
*/
        $(document).off('click', '.btn_card_toggle').on('click', '.btn_card_toggle', function(){
            var t = $(this);

            var comment = '';

            if(t.hasClass('btn_red')){
                comment = prompt('Причина блокировки:');
            }

            if(comment != null) {
                var params = {
                    card_id: $('.tab_v_content.active [name=card_id]').val(),
                    contract_id: $('[name=contracts_list]').val(),
                    comment: comment
                };

                $.post('/clients/card-toggle', {params:params}, function (data) {
                    if (data.success) {
                        t.toggleClass('btn_red').toggleClass('btn_green').find('span').toggle();

                        var tab = $('.tabs_cards [tab='+ params.card_id +'] > div');
                        var cnt_in_work = $('.cards_cnt_in_work');
                        var cnt_blocked = $('.cards_cnt_blocked');

                        if(t.hasClass('btn_green')){
                            tab.append('<span class="label label_error label_small">Заблокирована</span>');
                            cnt_in_work.text(parseInt(cnt_in_work.text()) - 1);
                            cnt_blocked.text(parseInt(cnt_blocked.text()) + 1);

                            var blockAvailableText = 'Заявка на блокировку отправлена менеджеру. Карта будет заблокирована в течение 48 часов!';
                        }else{
                            tab.find('.label_error').remove();
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
        });
    });

    function renderAjaxPaginationOperationsHistory(data, block)
    {
        for(var i = 0 in data){
            var tpl = $('<div class="line_inner"><span class="gray" /> &nbsp;&nbsp;&nbsp; <span /><div class="fr" /></div>');
            tpl.find('span.gray').text(data[i].H_DATE);
            tpl.find('span:last').text(data[i].M_FIO);
            tpl.find('div.fr').html(data[i].SHORT_DESCRIPTION);

            if(data[i].DESCRIPTION){
                tpl.append('<div class="full_comment">Комментарий: '+ data[i].DESCRIPTION +'</div>');
            }

            block.append(tpl);
        }

        renderScroll($('.tabs_cards .scroll'));
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