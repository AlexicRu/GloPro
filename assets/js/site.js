var BTN = ' btn waves-effect waves-light ';
var CHECKBOX = ' filled-in chk-col-purple ';
var currentPaginationAjaxRequest;

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
    var all = $('<button class="btn btn-sm waves-effect waves-light btn-outline-secondary ajax_block_load_all m-l-5 m-r-5">Загрузить все</button>');

    addLoader(outer);

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

    more.find('.ajax_block_load').prepend('<i class="fas fa-circle-notch fa-spin m-r-5"></i>');

    if (params.onError != undefined && typeof params.onError === 'function') {
        onError = params.onError;
        params.onError = false;
    }

    currentPaginationAjaxRequest = $.post(url, params, function(data){
        removeLoader(block.closest('.loading'));
        more.find('.fa-circle-notch').remove();

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
                    more.html('<i class="text-muted">Данные отсутствуют</i>');
                }
                more.fadeIn();
            }
        }

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

    var modal = btn.closest('.modal-content');

    addLoader(modal);

    callback(btn);
}

/**
 * отмена блокировки отправки
 */
function endSubmitForm()
{
    var modal = $('.modal-content.loading');

    removeLoader(modal);

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
    var isComboBox = field.find('.combobox').length;
    var isComboBoxMulti = field.find('.combobox_multi').length;
    var isCheckbox = field.find('[type=checkbox]').length;

    switch (type) {
        case 'period':
            break;
        default:
            if(isComboBoxMulti){
                setComboBoxMultiValue(field.find('.combobox_multi'), value);
            }else if(isComboBox){
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
            //['fullscreen']
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

function renderPhoneInput(elem)
{
    if (!elem.data('rendered')) {
        elem.data('rendered', true).intlTelInput({
            initialCountry: 'ru',
            //preferredCountries: [ "ru", "kz", "rs" ],
            onlyCountries: [ "ru", "kz", "rs" ],
            autoHideDialCode: false,
            nationalMode: false,
            utilsScript: '/assets/plugins/intl-tel-input/js/utils.js',
            autoPlaceholder: false
        });
    }
}

function checkAllRows(t, name)
{
    var block = t.closest('.check_all_block');

    var checked = t.prop('checked');

    block.find('[name='+ name +']').each(function () {
        var _t = $(this);
        if(checked){
            if(!_t.prop('checked')){
                _t.prop('checked', true);
            }
        }else{
            if(_t.prop('checked')){
                _t.prop('checked', false);
            }
        }
    });
}

function addLoader(block)
{
    if (block.is(":empty")) {
        block.addClass('loading__min-width');
    } else {
        block.append('<div class="loading__voile" />');
    }
    block.addClass('loading').append('<svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg>')
}

function removeLoader(block)
{
    block.find('.spinner').remove();
    block.find('.loading__voile').remove();
    block.removeClass('loading loading__min-width');
}

/**
 * collect one form from one class forms
 *
 * @param form
 * @param className
 * @returns {boolean}
 */
function collectForms(form, className)
{
    var forms = $('form.' + className).not(form);

    var strings = [];

    forms.each(function () {
        var t = $(this);

        strings.push(t.serialize());
    });

    form.append('<input type="hidden" name="other_data">');

    form.find('[name=other_data]').val(strings.join('&'));

    return true;
}

/**
 * удаляем строку
 *
 * @param btn
 */
function deleteRow(btn)
{
    if(!confirm('Удаляем?')) {
        return;
    }

    var fieldset = btn.closest('.can_delete');

    fieldset.remove();
}

/**
 * get GET param from url
 *
 * @param sParam
 * @returns {*}
 */
function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
    return '';
};