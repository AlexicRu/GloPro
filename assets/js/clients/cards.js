var cardsFilterParams = {
    emptyMessage: '<li class="nav-item"><span class="nav-link"><i class="text-muted">Карты не найдены</i></span></li>'
};
var ajaxCard = false;

/*
     0 - не отображать кнопку "Блокировать"/"Разблокировать"
     1 - отображать кнопку "Блокировать"/"Разблокировать",
     2 - отображать, но при блокировании такой карты писать: "Заявка на блокировку/разблокировку отправлена менеджеру. Карта будет заблокирована/разблокирована в течение 48 часов!" (писать блокирока или разблокировка в зависимости от действия)
     при изъятии такой карты писать: "Карта откреплена от договора! Проверьте статус в сторонней системе!"
    */
function cardToggle(t)
{
    var comment = '';

    if(t.hasClass('btn-danger')){
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
                t.toggleClass('btn-danger').toggleClass('btn-success').find('span').toggle();

                var tab = $('.tabs_cards [tab='+ params.card_id +'] > a');
                var cnt_in_work = $('.cards_cnt_in_work');
                var cnt_blocked = $('.cards_cnt_blocked');

                if(t.hasClass('btn-success')){
                    tab.find('[ban]').append('<span class="mt-1 badge badge-danger"><i class="fa fa-lock-alt"></i></span>');
                    cnt_in_work.text(parseInt(cnt_in_work.text()) - 1);
                    cnt_blocked.text(parseInt(cnt_blocked.text()) + 1);

                    var blockAvailableText = 'Заявка на блокировку отправлена менеджеру. Карта будет заблокирована в течение 48 часов!';
                }else{
                    tab.find('.badge-danger').remove();
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

function cardsReload()
{
    $('.ajax_block_cards_list_out').empty()
        .closest('.tabs_cards').find('.tab-content').empty()
    ;

    paginationAjax('/clients/cards-list/?contract_id=' + $('[name=contracts_list]').val(), 'ajax_block_cards_list', renderAjaxPaginationCardsList, cardsFilterParams);
}

/**
 * фильтр
 */
function cardsFilter(type)
{
    cardsFilterParams.query = $(".cards_search").val();

    var sortSelect = $('[name=cards-sort] option:selected');
    cardsFilterParams.sort = sortSelect.attr('sort');
    cardsFilterParams.sortWay = sortSelect.attr('way');

    switch (type) {
        case 'work':
            cardsFilterParams.status = 'work';
            break;
        case 'disabled':
            cardsFilterParams.status = 'disabled';
            break;
        case 'all':
            delete cardsFilterParams.status;
            break;
    }

    cardsReload();

    return false;
}

function cardLoad(cardId, force)
{
    if (ajaxCard) {
        ajaxCard.abort();
    }

    var contentBlock = $("#card" + cardId);
    //var search = '?tab=cards&card=' + cardId;
    var search = '?tab=cards';
    history.pushState("","", location.pathname + search);

    if(contentBlock.text() == '' || force == true){
        addLoader(contentBlock);

        ajaxCard = $.post('/clients/card/' + cardId + '/?contract_id=' + $('[name=contracts_list]').val(), {}, function (data) {
            removeLoader(contentBlock);
            contentBlock.html(data);
            renderVerticalTabsScroll($('.tabs_cards .ajax_pagination:first'));
        });
    }
}