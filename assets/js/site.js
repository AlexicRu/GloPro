var CLASS_LOADING = 'block_loading';

$(function(){
    $('.mark_read').on('click', function () {
        $.post('/messages/make-read', {}, function (data) {
            if(data.success){
                message(1, 'Сообщения отмечены прочитанными');
                $('.mailbox').closest('.nav-item').find('.nav-link').click();
            }else{
                message(0, 'Ошибка');
            }
        });
        return false;
    });

    $(document).on('click', "[toggle]", function(){
        $("[toggle_block='"+ $(this).attr('toggle') +"']").toggle();
    });
});

function message(type, text, sticky)
{
    var header;

    if(type == 0 || type == 'error'){
        header = 'Ошибка!';
        type = 'error';
    }
    if(type == 1 || type == 'success'){
        header = 'Успех!';
        type = 'success';
    }
    if(type == 2 || type == 'info'){
        header = '';
        type = 'info';
    }
    if(type == 3 || type == 'warning'){
        header = 'Внимание!';
        type = 'warning';
    }

    if (!sticky) {
        sticky = false;
    }

    var params = {
        heading: header,
        text: text,
        position: 'top-right',
        loaderBg:'#ff6849',
        icon: type,
        hideAfter: 3000,
        stack: 5
    };

    if (sticky == true) {
        params.hideAfter = false;
    }

    $.toast(params);
}

function paginationAjaxRefresh(name)
{
    var outer = $('.' + name + '_out');
    var block = $('.' + name);
    outer.data('offset', 0);
    block.empty();

    outer.find('.ajax_block_more .ajax_block_load').click();
}

function paginationAjax(url, name, callback, params)
{
    var outer = $('.' + name + '_out');
    var block = $('<div class="' + name + '" />');
    var btnBlock = $('<div class="ajax_block_more text-center" />');
    var more = $('<button class="btn waves-effect waves-light btn-outline-secondary ajax_block_load m-l-5 m-r-5">Загрузить еще...</button>');
    var all = $('<button class="btn waves-effect waves-light btn-outline-secondary m-l-5 m-r-5">Загрузить все</button>');

    outer.addClass('ajax_pagination_out');
    block.addClass('ajax_pagination');

    more.appendTo(btnBlock);

    if (params && params.show_all_btn) {
        all.appendTo(btnBlock);
    }

    outer.append(block);
    outer.append(btnBlock);
    outer.data('offset', 0);

    _paginationAjaxLoad(url, outer, block, callback, params);

    more.on('click', function(){
        _paginationAjaxLoad(url, outer, block, callback, params);
    });

    all.on('click', function(){
        params.show_all = true;
        _paginationAjaxLoad(url, outer, block, callback, params);
    });
}

function _paginationAjaxLoad(url, outer, block, callback, params)
{
    if(!params){
        params = {};
    }

    params.offset = outer.data('offset');

    var more = outer.find('.ajax_block_more');
    var onError = false;

    if (params.onError != undefined && typeof params.onError === 'function') {
        onError = params.onError;
        params.onError = false;
    }

    $.post(url, params, function(data){
        if(data.success){
            callback(data.data.items, block, params);

            outer.data('offset', parseInt(outer.data('offset')) + data.data.items.length);

            if(data.data.more){
                //ALL
                if (params.show_all) {
                    _paginationAjaxLoad(url, outer, block, callback, params);
                }
            } else {
                more.fadeOut();
            }
        }else{
            if (onError) {
                onError(block, params);
            } else {
                if (params.emptyMessage) {
                    more.html(params.emptyMessage);
                } else {
                    more.html('<span class="gray">Данные отсутствуют</span>');
                }
            }
        }
        block.closest('.block_loading').removeClass(CLASS_LOADING);
        more.fadeIn();
    });
}

var submitFormInAction = false;

/**
 * функция предварительной обработки перед сабмитом формы
 *
 * @param btn
 * @param callback
 * @returns {boolean}
 */
function submitForm(btn, callback)
{
    if (submitFormInAction) {
        return false;
    }

    submitFormInAction = true;

    callback(btn);
}

/**
 * отмена блокировки отправки
 */
function endSubmitForm()
{
    submitFormInAction = false;
}

function renderVerticalTabsScroll(elem)
{
    var block = elem.closest('.vtabs');
    var preScrollHeight = block.find('.before_scroll').length ? block.find('.before_scroll').height() : 0;

    var height = block.find('.tab-pane.active').outerHeight() - preScrollHeight;

    elem.css('height', height > 300 ? height : 300);

    if (elem.data('rendered')) {
        elem.perfectScrollbar('update');
    } else {
        elem.data('rendered', true).perfectScrollbar();
    }
}