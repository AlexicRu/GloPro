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
    var btnBlock = $('<div class="ajax_block_more" />');
    var more = $('<button class="btn btn_small ajax_block_load">Загрузить еще...</button>');
    var all = $('<button class="btn btn_small">Загрузить все</button>');

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
    outer.find('.ajax_block_more').fadeOut();
    params.offset = outer.data('offset');

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
                } else {
                    outer.find('.ajax_block_more').fadeIn();
                }
            }
        }else{
            if (onError) {
                onError(block, params);
            } else {
                outer.find('.ajax_block_more').fadeIn().html('<span class="gray">Данные отсутствуют</span>');
            }
        }
        block.closest('.block_loading').removeClass('block_loading');
    });
}