var SHOW_ALL_VALUE          = -1;
var SHOW_ALL_NAME           = '-- Все --';
var SHOW_NOT_FOUNT_VALUE    = 0;
var SHOW_NOT_FOUND_NAME     = 'Не найдено';
var ajaxComboBox;

$(function(){
    renderElements();

    $(window).on('resize', function () {
        resetComboBoxResultPositioning();
    });
});

function renderElements()
{
    $(document).on('click', function(e){
        var t = $(e.target);

        if(t.closest('.combobox_multi_wrapper').length == 0){
            $('.combobox_multi_wrapper .combobox_result').hide();
        } else {
            $('.combobox_multi_wrapper').not(t.closest('.combobox_multi_wrapper')).find('.combobox_result').hide();
        }
        if(t.closest('.combobox_outer').length == 0){
            $('.combobox_outer .combobox_result').hide();
        } else {
            $('.combobox_outer').not(t.closest('.combobox_outer')).find('.combobox_result').hide();
        }
    });
}

function renderComboBoxMulti(combo, params)
{
    if(combo.data('rendered')){
        return false;
    }

    params.multi = true;

    preRenderComboBox(combo, params);

    combo.on('keyup', function () {
        keyupComboBox(combo, params);
    }).on('focus', function () {
        combo.trigger('keyup');
    });
}

function renderComboBox(combo, params)
{
    if(combo.data('rendered')){
        return false;
    }

    preRenderComboBox(combo, params);

    combo.on('keyup', function () {
        keyupComboBox(combo, params);
    }).on('focus', function () {
        combo.trigger('keyup');
    });
}

/**
 * рендерим основные части
 * @param combo
 * @param params
 */
function preRenderComboBox(combo, params)
{
    if (params && params != '') {
        for (var i in params) {
            combo.data(i, params[i]);
        }
    } else {
        params = {};
    }

    combo.data('rendered', true);

    combo.wrap('<div class="combobox_outer" />');

    var outer = combo.closest('.combobox_outer');

    if (params.multi) {
        outer.wrap('<div class="combobox_multi_wrapper" />');

        var wrapper = combo.closest('.combobox_multi_wrapper');

        wrapper.prepend('<div class="combobox_multi_selected" />');

        var selected = wrapper.find('.combobox_multi_selected');
    }

    var result = $('<div class="combobox_result" />');
    result.appendTo(outer);

    var hiddenValue = $('<input type="hidden" name="combobox_value">');
    hiddenValue.appendTo(outer);

    var resultList = $('<div class="combobox_result_list" />');
    resultList.appendTo(result);

    var more = $('<div class="combobox_result_more"><span class="'+ BTN +' btn-outline-secondary btn-xs">Загрузить еще...</span></div>');
    more.appendTo(result);

    more.find('.btn').on('click', function () {
        params['offset'] = resultList.find('.combobox_result_item').length;
        combo.trigger('keyup');
    });
}

function keyupComboBox(combo, params)
{
    if(ajaxComboBox){
        ajaxComboBox.abort();
    }

    var url             = combo.attr('url');
    var outer           = combo.closest('.combobox_outer');
    var result          = outer.find('.combobox_result');
    var resultList      = outer.find('.combobox_result_list');
    var more            = outer.find('.combobox_result_more');
    var hiddenValue     = outer.find('[name=combobox_value]');
    var dependWrapper   = outer.parents('.with_depend:last');

    if (params.multi) {
        var wrapper     = combo.closest('.combobox_multi_wrapper');
        var selected    = wrapper.find('.combobox_multi_selected');
    }

    checkComboBoxResultPositioning(combo);

    if(params['depend_to']){
        var dependCombo = $('[name=' + params['depend_to'] + ']', dependWrapper);

        if (dependCombo.hasClass('combobox_multi')) {
            resetComboBoxMultiValue(dependCombo);
        } else {
            setComboBoxValue(dependCombo, false);
        }
    }

    var val = combo.val();

    if (!params['offset']) {
        result.hide();
        resultList.html('');
        more.hide();
    } else {
        more.find('.btn').prepend('<i class="fas fa-circle-notch fa-spin m-r-5"></i>');
    }

    var postParams = {
        params: params, //?
        search: val,
        offset: params['offset'] ? params['offset'] : 0
    };

    if(params['depend_on']){
        var value = getComboBoxValue($('[name="'+ params['depend_on']['name'] + '"]', dependWrapper), true);

        if(value == ''){
            return;
        }

        postParams[params['depend_on']['param']] = value;
    }

    checkRenderTo(combo, {}, true);

    combo.addClass('loading');

    if (!params.multi) {
        hiddenValue.val('');
    }

    ajaxComboBox = $.post(url, postParams, function(data){
        var items = data.data && data.data.items ? data.data.items : [];
        more.find('.fa-circle-notch').remove();

        if(data.success){
            if(params.show_all){
                items.unshift({
                    name: SHOW_ALL_NAME,
                    value: SHOW_ALL_VALUE
                });
            }

            if (data.data && data.data.more) {
                more.show();
            } else {
                more.hide();
            }
        }

        if (items.length == 0) {
            items.unshift({
                name: SHOW_NOT_FOUND_NAME,
                value: SHOW_NOT_FOUNT_VALUE,
                disabled: true
            });
        }

        for(var i in items){
            var tpl = $('<div class="combobox_result_item"></div>');

            tpl.attr('value', items[i].value);
            tpl.text(items[i].name);

            if(items[i].disabled) {
                tpl.attr('disabled', true);
            } else {
                if (params.multi) {
                    tpl.attr('onclick', 'selectComboBoxMultiResult($(this))');
                } else {
                    tpl.attr('onclick', 'selectComboBoxResult($(this))');
                }
            }

            if (params.multi) {
                if(selected.find('.combobox_multi_selected_item[value='+ items[i].value +']').length){
                    tpl.addClass('combobox_result_item_selected');
                }
            }

            tpl.appendTo(resultList);
        }

        result.show();

        renderPaginationScroll(resultList);

        combo.removeClass('loading');

        //при обычном поиске постраничность сбрасывается
        params['offset'] = 0;

        ajaxComboBox = false;
    });
}

function selectComboBoxMultiResult(item)
{
    item.toggleClass('combobox_result_item_selected');

    var value = item.attr('value');

    var wrapper = item.closest('.combobox_multi_wrapper');
    var selected = wrapper.find('.combobox_multi_selected');

    var selectedItem = selected.find('.combobox_multi_selected_item[value='+ value +']');

    if(selectedItem.length){
        uncheckComboBoxMultiItem(selectedItem);
        return;
    }

    if (value == SHOW_ALL_VALUE) {
        //если выбрали все, то все остальное выключаем
        selected.find('.combobox_multi_selected_item[value!="'+ SHOW_ALL_VALUE +'"]').each(function () {
            var t = $(this);
            wrapper.find('.combobox_result_item_selected[value='+ t.attr('value') +']').removeClass('combobox_result_item_selected');
            uncheckComboBoxMultiItem(t);
        });
    } else {
        //если выбрали что-то отличное от все, то выключаемв все
        var itemAll = selected.find('.combobox_multi_selected_item[value='+ SHOW_ALL_VALUE +']');
        if (itemAll.length) {
            wrapper.find('.combobox_result_item_selected[value='+ SHOW_ALL_VALUE +']').removeClass('combobox_result_item_selected');
            uncheckComboBoxMultiItem(itemAll);
        }
    }

    renderComboBoxMultiSelectedItem(value, item.text(), wrapper);
}

function renderComboBoxMultiSelectedItem(value, text, wrapper)
{
    var selected = wrapper.find('.combobox_multi_selected');
    var hiddenValue = wrapper.find('[name=combobox_value]');

    var tpl = $('<div class="combobox_multi_selected_item"><span class="combobox_multi_selected_item_name" /><span class="combobox_multi_selected_item_close" onclick="uncheckComboBoxMultiItem($(this))">×</span></div>');

    tpl.find('.combobox_multi_selected_item_name').text(text);
    tpl.attr('value', value);

    selected.append(tpl);

    var values = hiddenValue.val() != '' ? hiddenValue.val().split(',') : [];
    values.push(value);

    hiddenValue.val(values.join(','));

    checkRenderTo(wrapper.find('.combobox_multi'), {value:value, text:text});
}

function uncheckComboBoxMultiItem(item)
{
    var wrapper = item.closest('.combobox_multi_wrapper');
    var selected = wrapper.find('.combobox_multi_selected');
    var selectedItem = item.closest('.combobox_multi_selected_item');
    var hiddenValue = wrapper.find('[name=combobox_value]');

    checkRenderTo(wrapper.find('.combobox_multi'), {value:selectedItem.attr('value')}, true);

    selectedItem.remove();

    var values = [];

    selected.find('.combobox_multi_selected_item').each(function () {
        values.push($(this).attr('value'));
    });

    hiddenValue.val(values.join(','));
}

function selectComboBoxResult(item, params)
{
    item.toggleClass('combobox_result_item_selected');

    var value = item.attr('value');
    var outer = item.closest('.combobox_outer');
    var combo = outer.find('.combobox');
    var hiddenValue = outer.find('[name=combobox_value]');

    combo.val(item.text());
    hiddenValue.val(value);

    if (combo.data('onSelect')) {
        window[combo.data('onSelect')](value);
    }

    $('.combobox_result', outer).hide();
}

function setComboBoxValue(combo, value)
{
    var outer = combo.closest('.combobox_outer');
    var hiddenValue = outer.find('[name=combobox_value]');

    if(!value || value == ''){
        combo.val('');
        hiddenValue.val('');
    }else{
        if (value == SHOW_ALL_VALUE && combo.data('show_all')){
            combo.val(SHOW_ALL_NAME);
            hiddenValue.val(SHOW_ALL_VALUE);

            checkRenderTo(combo, {value:SHOW_ALL_VALUE, text:SHOW_ALL_NAME});
        } else {

            $.post(combo.attr('url'), {ids: value}, function (data) {
                if (data.success) {
                    combo.val(data.data.items[0].name);
                    hiddenValue.val(data.data.items[0].value);

                    checkRenderTo(combo, {value:data.data.items[0].value, text:data.data.items[0].name});
                }
            });
        }
    }
}

function getComboBoxValue(combo, skipDepend)
{
    if(combo.attr('depend_to') && skipDepend != true){
        var outerDepend = combo.parents('.with_depend:last');
        var dependField = combo.attr('depend_to');
        combo = $('[name='+ dependField +']', outerDepend);

        if(combo.hasClass('combobox_multi')){
            return getComboBoxMultiValue(combo);
        }
    }

    var outer = combo.closest('.combobox_outer');
    var hiddenValue = outer.find('[name=combobox_value]');

    return hiddenValue.val();
}

function getComboBoxMultiValue(combo)
{
    var wrapper = combo.closest('.combobox_multi_wrapper');
    var hiddenField = wrapper.find('[name=combobox_value]');
    var hiddenValue = hiddenField.val();

    if (!hiddenValue){
        return [];
    }

    var hiddenArray = hiddenValue.split(',');

    if (hiddenArray.indexOf(SHOW_ALL_VALUE.toString()) != -1) {
        return [SHOW_ALL_VALUE];
    }

    return hiddenArray;
}

function resetComboBoxMultiValue(combo)
{
    var wrapper = combo.closest('.combobox_multi_wrapper');
    var selected = wrapper.find('.combobox_multi_selected');
    var hiddenValue = wrapper.find('[name=combobox_value]');

    selected.empty();

    hiddenValue.val('');
}

function setComboBoxMultiValue(combo, value)
{
    var wrapper = combo.closest('.combobox_multi_wrapper');

    var list = value ? value.split(',') : [];

    if (parseInt(list[0]) == SHOW_ALL_VALUE && combo.data('show_all')){
        renderComboBoxMultiSelectedItem(SHOW_ALL_VALUE, SHOW_ALL_NAME, wrapper);

        list.shift();
    }

    $.post(combo.attr('url'), { ids:list }, function(data){
        if(data.success){
            for(var j in data.data.items){
                renderComboBoxMultiSelectedItem(data.data.items[j].value, data.data.items[j].name, wrapper);
            }
        }
    });
}

/**
 * дополнительный рендер результата в какой-то блок
 */
function checkRenderTo(combo, item, isRemove) {
    var renderTo = combo.data('render_value_to');

    if (!renderTo) {
        return;
    }

    var block = $(renderTo);

    if (combo.hasClass('combobox_multi')) {
        //combobox_multi
        if (isRemove) {
            block.find('[value='+ item.value +']').remove();
        } else {
            var tpl = $('<div class="combobox_multi_selected_item" />');

            tpl.attr('value', item.value).text(item.text);

            tpl.appendTo(block);
        }
    } else if (combo.hasClass('combobox')) {
        //combobox
        if (isRemove) {
            block.find('.combobox_multi_selected_item').remove();
        } else {
            var tpl = $('<div class="combobox_multi_selected_item" />');

            tpl.attr('value', item.value).text(item.text);

            tpl.appendTo(block);
        }
    }
}

function renderPaginationScroll(elem)
{
    if (typeof $().perfectScrollbar == 'function') {
        if (elem.data('rendered')) {
            elem.perfectScrollbar('update');
        } else {
            elem.data('rendered', true).perfectScrollbar({
                useBothWheelAxes: false,
                suppressScrollX: true
            });
        }
    } else {
        elem.css('overflow-y', 'scroll')
    }
}

/**
 * позиционирование выпадающего блока, влезет ли в экран при выпадении вниз
 */
function checkComboBoxResultPositioning(combo)
{
    if (combo.data('result-positioning') == true) {
        return;
    }

    var height = $('body').height();
    var result = combo.closest('.combobox_outer').find('.combobox_result');
    var comboResultTop = combo.offset().top
        + combo.outerHeight()
        + parseInt(result.find('.combobox_result_list').css('max-height'))
        + parseInt(result.find('.combobox_result_more').outerHeight())
        + 20
    ;

    result.removeClass('combobox_result_top combobox_result_bottom');

    if (comboResultTop > height) {
        result.addClass('combobox_result_top');
    } else {
        result.addClass('combobox_result_bottom');
    }

    combo.data('result-positioning', true);
}

function resetComboBoxResultPositioning()
{
    $('.combobox').each(function () {
        $(this).data('result-positioning', false);
    });
}