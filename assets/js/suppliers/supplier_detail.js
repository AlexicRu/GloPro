var supplierId = false;
var contractId = false;
var dropzone = false;

$(function () {
    contractId = $('[name=suppliers_contracts_list]').val();
    supplierId = $('[name=supplier_id]').val();

    dropzone = new Dropzone('.supplier-detail__avatar-dropzone', {
        url: "/index/upload-file?component=supplier",
        autoProcessQueue: false,
        addRemoveLinks: true,
        maxFiles: 1,
        success: function(file, response)
        {
            if(response.success){
                Vue.set(vueSupplierInfo.supplier, 'ICON_PATH', response.data.file.file);
            }
        },
        queuecomplete: function ()
        {
            _saveSupplierInfo();
        }
    });

    loadSupplierContract();
});

function saveSupplierInfo()
{
    if(dropzone.getQueuedFiles().length){
        dropzone.processQueue();
    }else{
        _saveSupplierInfo();
    }
}

function _saveSupplierInfo()
{
    var block = $(".supplier-detail__info");

    var params = vueRawData(vueSupplierInfo.supplier);

    $.post('/suppliers/supplier-edit/' + supplierId, { params:params }, function(data){
        if(data.success){
            message(1, 'Поставщик обновлен');

            $("[toggle='edit_supplier']:first", block).click();
        }else{
            message(0, 'Сохранение не удалось' + (data.data ? '. ' + data.data : ''));
        }

        vueSupplierInfo.cacheForm();
        dropzone.removeAllFiles();
    });
}

function loadSupplierContract(tab)
{
    if (!tab) {
        tab = 'contract';
    }

    var block = $('.supplier-contract');

    addLoader(block);

    $.post('/suppliers/contract/' + contractId, {tab: tab}, function (data) {
        removeLoader(block);
        block.html(data);
    });
}

function editSupplierContract()
{
    var block = $('.supplier-contract__contract');

    var params = {
        CONTRACT_NAME:          $('[name=CONTRACT_NAME]', block).val(),
        DATE_BEGIN:             $('[name=DATE_BEGIN]', block).val(),
        DATE_END:               $('[name=DATE_END]', block).val(),
        CONTRACT_STATE:         $('[name=CONTRACT_STATE]', block).val(),
        DATA_SOURCE:            $('[name=DATA_SOURCE]:checked', block).val(),
        TUBE_ID:                $('[name=TUBE_ID]', block).val(),
        CONTRACT_SERVICES:      getComboBoxValue($('[name=CONTRACT_SERVICES]', block)),
        CONTRACT_POS_GROUPS:    getComboBoxValue($('[name=CONTRACT_POS_GROUPS]', block)),
    };

    if (params.CONTRACT_NAME == '' ||
        (params.CONTRACT_SERVICES != undefined && params.CONTRACT_SERVICES == '') /*||
        (params.CONTRACT_POS_GROUPS != undefined && params.CONTRACT_POS_GROUPS.length == 0)*/
    ) {
        message(0, 'Заполните все поля');
        return;
    }

    $.post('/suppliers/contract-edit/' + contractId, {params:params}, function (data) {
        if (data.success) {
            message(1, 'Контракт успешно обновлен');

            loadSupplierContract();

            $('[name=suppliers_contracts_list] option:selected').text(
                'Договор: ' + params.CONTRACT_NAME + ' от ' + params.DATE_BEGIN +
                (params.DATE_END != '31.12.2099' ? ' от ' + params.DATE_END : '') +
                ' [' + contractId + ']'
            );
        } else {
            message(0, data.data ? data.data : 'Ошибка добавления контракта');
        }
    });
}

function checkSupplierContractDataSource()
{
    var block = $('.supplier-contract__contract');

    var dataSource = $('[name=DATA_SOURCE]:checked').val();

    if (dataSource == DATA_SOURCE_INSIDE) {
        $('[name=TUBE_ID]').prop('disabled', true);
    } else {
        $('[name=TUBE_ID]').prop('disabled', false);
    }
}

function checkAgreementDiscountType(radio)
{
    var block = radio.closest('.agreement__outer');

    var discountType = $('[name=DISCOUNT_TYPE]:checked').val();

    if (discountType == DISCOUNT_TYPE_FROM_LOAD) {
        $('[name=TARIF_ID]').prop('disabled', true);
    } else {
        $('[name=TARIF_ID]').prop('disabled', false);
    }
}

function loadAgreement(elem, force)
{
    var tab = elem.closest('[tab]');
    var tabPane = $(".tabs_agreements #agreement" + tab.attr('tab'));

    if(tabPane.is(':empty') || force == true){
        addLoader(tabPane);

        $.post('/suppliers/agreement/' + tab.attr('tab') + '/?contract_id=' + contractId, {}, function(data){
            removeLoader(tabPane);
            tabPane.html(data);
        });
    }
}

function agreementSave(btn)
{
    var block = btn.closest('.agreement__outer');
    var agreementId = block.attr('agreement_id');

    var params = {
        'contract_id':      contractId,
        'agreement_id':     agreementId,
        'agreement_name':   $('[name=AGREEMENT_NAME]', block).val(),
        'date_begin':       $('[name=DATE_BEGIN]', block).val(),
        'date_end':         $('[name=DATE_END]', block).val(),
        'discount_type':    $('[name=DISCOUNT_TYPE]:checked', block).val(),
        'tarif_id':         getComboBoxValue($('[name=TARIF_ID]', block))
    };

    if (
        params.agreement_name == '' ||
        params.date_begin == ''
    ) {
        message(0, 'Заполните обязательные поля');
        return false;
    }

    $.post('/suppliers/agreement-edit', {params:params}, function (data) {
        if (data.success) {
            message(1, 'Соглашение успешно обновлено');
            loadAgreement($('.tabs_agreements .nav-link.active'), true);

            $('.tabs_agreements .nav-link.active .agreement_name').text(params.agreement_name);
        } else {
            message(0, 'Ошибка сохранения');
        }
    });
}