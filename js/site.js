$(function(){
    $('.hamburger a').on('click', function(){
        $('.wrapper').toggleClass('menu_collapsed');
    });

    $(document).on('click', "[tab]", function(){
        var t = $(this);
        var block = t.closest('.tabs_switcher');
        $(' > div > [tab_content], > div > [tab], > div > .scroll > [tab]', block).removeClass('active');
        t.addClass('active');
        $('[tab_content='+ t.attr('tab') +']', block).addClass('active');

        if(t.hasClass('tab_v')) {
            renderScroll(t.closest('.tabs_switcher').find('.scroll'));
        }

        return false;
    });

    $(document).on('click', "[toggle]", function(){
        $("[toggle_block='"+ $(this).attr('toggle') +"']").toggle();
    });

    $(document).on('click', '.filter_toggle', function () {
        var t = $(this);
        t.closest('.filter_outer').find('.filter_block').slideToggle();
        t.toggleClass('active');
    });

    $('.datepicker').each(function(){
        renderDatePicker($(this));
    });

    $(document).on('click', ".btn_toggle", function(){
        var btn = $(this);
        btn.parent().find('.btn').removeClass('active');
        btn.addClass('active');
    });

    $('.fancy').fancybox({
        padding: [0,0,0,0]
    });

    $(document).on('click', '.fancy_close', function(){
        $.fancybox.close();
    });

    $(document).on('change', '.switch_block [type=checkbox].switch', function(){
        var t = $(this);
        var switchBlock = t.closest('.switch_block');

        if(t.prop('checked') == true){
            switchBlock.find('input, select, textarea').prop('disabled', false);
            switchBlock.find('.sb_content').removeClass('sb_disabled');
            switchBlock.find('.checkbox_inner').removeClass('checkbox_disabled');
            switchBlock.find('.radio_inner').removeClass('radio_disabled');
        }else{
            switchBlock.find('input, select, textarea').prop('disabled', true);
            switchBlock.find('.sb_content').addClass('sb_disabled');
            switchBlock.find('.checkbox_inner').addClass('checkbox_disabled');
            switchBlock.find('.radio_inner').addClass('radio_disabled');
        }
    });

    $('.mark_read').on('click', function () {
        $.post('/messages/make_read', {}, function (data) {
            if(data.success){
                message(1, 'Сообщения отмечены прочинанными');
                $('.notices').fadeOut();
                $('.mail span span').remove();
                $('.unread0').removeClass('unread0');
                setTimeout(function () {
                    $('.notices').remove();
                }, 400);
            }else{
                message(0, 'Ошибка');
            }
        });
        return false;
    });
});

function renderDatePicker(elem)
{
    var options = {
        dateFormat: "dd.mm.yy",
        buttonImage: "/img/icon_calendar.png",
        showOn: "button",
        buttonImageOnly: true,
        changeMonth:true,
        changeYear:true,
        yearRange: "2000:2099"
    };

    if(elem.attr('maxDate') == 1){
        options.maxDate = new Date();
    }

    elem.wrap('<span class="datepicker_out" />');

    elem.datepicker(options);
}

function renderScroll(elem)
{
    setTimeout(function () {
        var block = elem.closest('.tabs_vertical_block');
        var preScrollHeight = block.find('.before_scroll').size() ? block.find('.before_scroll').height() : 0;

        var height = block.find('.tab_v_content.active').outerHeight() - preScrollHeight;

        elem.css('height', height).show();
    }, 500);
}

function cardLoad(elem, force)
{
    if($(".tabs_cards [tab_content="+ elem.attr('tab') +"]").text() == '' || force == true){
        $(".tabs_cards [tab_content="+ elem.attr('tab') +"]").empty().addClass('block_loading');

        $.post('/clients/card/' + elem.attr('tab') + '/?contract_id=' + $('[name=contracts_list]').val(), {}, function(data){
            $(".tabs_cards [tab_content="+ elem.attr('tab') +"]").html(data).removeClass('block_loading');
        });
    }
}

function paginationAjax(url, name, callback, params)
{
    var outer = $('.' + name + '_out');
    var block = $('<div class="' + name + '" />');
    var more = $('<div class="ajax_block_more"><button class="btn btn_small">Загрузить еще...</button></div>');

    outer.append(block);
    outer.append(more);
    outer.data('offset', 0);

    _paginationAjaxLoad(url, outer, block, callback, params);
    more.on('click', function(){
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

    $.post(url, params, function(data){
        if(data.success){
            callback(data.data.items, block);
            if(data.data.more){
                outer.find('.ajax_block_more').fadeIn();
            }
            outer.data('offset', parseInt(outer.data('offset')) + data.data.items.length);
        }else{
            outer.find('.ajax_block_more').fadeIn().html('<span class="gray">Данные отсутствуют</span>');
        }
    });
}