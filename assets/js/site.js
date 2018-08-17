var CLASS_LOADING = 'block_loading';
var BTN = ' btn waves-effect waves-light ';
var CHECKBOX = ' filled-in chk-col-purple ';

if (typeof Dropzone == 'function') {
    Dropzone.autoDiscover = false;
}

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
    $(document).on('click', "[toggle_class]", function(){
        $("[toggle_block='"+ $(this).attr('toggle_class') +"']").toggleClass('active');
    });
    $(document).on('click', ".btn_toggle", function(){
        var t = $(this);
        t.parent().find('.btn').removeClass('active');
        t.addClass('active');
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
    var btnBlock = $('<div class="ajax_block_more text-center p-t-10 p-b-10" />');
    var more = $('<button class="btn btn-sm waves-effect waves-light btn-outline-secondary ajax_block_load m-l-5 m-r-5">Загрузить еще...</button>');
    var all = $('<button class="btn btn-sm waves-effect waves-light btn-outline-secondary m-l-5 m-r-5">Загрузить все</button>');

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
                } else {
                    more.fadeIn();
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
                more.fadeIn();
            }
        }
        block.closest('.block_loading').removeClass(CLASS_LOADING);

        if (block.closest('.ps').length) {
            block.closest('.ps').perfectScrollbar('update');
        }
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

/**
 * закрытие открытого модального окна
 */
function modalClose()
{
    var modal = $('.modal.show');

    if (modal.length) {
        $('#' + modal.attr('id')).modal('hide');
    }
}

function renderVerticalTabsScroll(elem)
{
    var block = elem.closest('.vtabs');

    var beforeScrollHeight = 0;

    block.find('> .nav-tabs .nav-item.before_scroll').each(function () {
        beforeScrollHeight += parseInt($(this).height());
    });

    var afterScrollHeight = block.find('> .nav-tabs .ajax_block_more').length ? block.find('> .nav-tabs .ajax_block_more').height() : 0;
    var height = block.find('> .tab-content > .tab-pane.active').outerHeight() - beforeScrollHeight - afterScrollHeight;

    height = height > 300 ? height : 300;

    if (elem.height() > height || elem.data('rendered') == true) {
        elem.css('height', height);

        if (elem.data('rendered')) {
            elem.perfectScrollbar('update');
        } else {
            elem.data('rendered', true).perfectScrollbar({
                useBothWheelAxes: false,
                suppressScrollX: true
            });
        }
    }
}

/**
 * для кастомных полей устанавливаем значение
 *
 * @param field
 * @param value
 */
function setFormFieldValue(field, value)
{
    if (value == '') {
        return;
    }

    var type = field.attr('field');
    var isCombobox = field.find('.combobox').length;
    var isComboboxMulti = field.find('.combobox_multi').length;
    var isCheckbox = field.find('[type=checkbox]').length;

    switch (type) {
        case 'period':
            break;
        default:
            if(isComboboxMulti){
                setComboBoxMultiValue(field.find('.combobox_multi'), value);
            }else if(isCombobox){
                setComboBoxValue(field.find('.combobox'), value);
            }else if(isCheckbox){
                if(value){
                    field.prop('checked', true);
                }else{
                    field.prop('checked', false);
                }
            }else{
                field.find('.custom_field').val(value);
            }
    }
}

function number_format( number, decimals, dec_point, thousands_sep ) {	// Format a number with grouped thousands
    //
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +	 bugfix by: Michael White (http://crestidg.com)

    var i, j, kw, kd, km;

    var belowZero = '';

    if(number < 0){
        belowZero = '-';
        number *= -1;
    }

    // input sanitation & defaults
    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }
    if( dec_point == undefined ){
        dec_point = ",";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 ){
        j = j % 3;
    } else{
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


    return belowZero + km + kw + kd;
}

function initWYSIWYG(elem)
{
    elem.trumbowyg({
        autogrow: true,
        lang: 'ru',
        btnsDef: {
            // Customizables dropdowns
            image: {
                dropdown: ['insertImage', 'upload', 'noembed'],
                ico: 'insertImage'
            }
        },
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            'btnGrp-design',
            ['superscript', 'subscript'],
            ['link'],
            ['image'],
            'btnGrp-justify',
            'btnGrp-lists',
            ['foreColor', 'backColor'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
        plugins: {
            // Add imagur parameters to upload plugin
            upload: {
                serverPath: 'https://api.imgur.com/3/image',
                fileFieldName: 'image',
                headers: {
                    'Authorization': 'Client-ID 9e57cb1c4791cea'
                },
                urlPropertyName: 'data.link'
            }
        }
    });
}

function collectFoundIds(block)
{
    var list = $('.selected_items_list', block);

    var ids = [];

    $('.sil_item').each(function () {
        ids.push($(this).attr('item_id'));
    });

    return ids;
}

function checkFoundItem(check)
{
    var block = check.closest('.items_list_autocomplete_block');
    var row = check.closest('.item_found_row');
    var list = $('.selected_items_list', block);

    if(check.is(':checked')) {
        //add
        var tpl = $('<div class="sil_item"><span class="sili_close" onclick="uncheckFoundItem($(this))">&times;</span></div>');

        tpl.attr('item_id', row.attr('item_id')).prepend(row.data('item_name'));

        tpl.appendTo(list);
    } else {
        //remove
        list.find('[item_id='+ row.attr('item_id') +']').remove();
    }
}

function uncheckFoundItem(close)
{
    var block = close.closest('.items_list_autocomplete_block');
    var list = $('.selected_items_list', block);

    var item = close.closest('.sil_item');

    var foundRow = $('.item_found_row[item_id='+ item.attr('item_id') +']');

    if (foundRow.length) {
        $('[type=checkbox]', foundRow).click();
    } else {
        list.find('[item_id='+ item.attr('item_id') +']').remove();
    }
}

/**
 * money format
 *
 * @param elem
 */
function money(elem)
{
    elem.maskMoney({thousands:' ', decimal:'.', allowZero:true});
}

/**
 * get unformatted value
 *
 * @param elem
 * @returns {*}
 */
function getMoney(elem)
{
    return elem.maskMoney('unmasked')[0];
}