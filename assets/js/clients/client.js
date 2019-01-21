$(function(){
    renderPhoneInput($('[name=PHONE]'));

    var tab = getUrlParameter('tab');
    loadContract(tab ? tab.split('_')[0] : 'contract');

    $('[name=contracts_list]').on('change', function () {
        loadContract('contract');
    });

    $(document).on('click', '[ajax_tab]', function (e) {
        var t = $(this);
        if (t.hasClass('active')) {
            return false;
        }
        loadContract(t.attr('href').replace('#', ''));
    });
});

function saveClientInfo() {
    var block = $(".edit_client_block");

    var params = vueRawData(vueClientInfo.client);

    if (params.NAME == '') {
        message(0, 'Заполните название фирмы');
        return false;
    }

    if (params.Y_ADDRESS == '') {
        message(0, 'Заполните юридический адрес');
        return false;
    }

    if (params.INN == '') {
        message(0, 'Заполните ИНН');
        return false;
    }

    $.post('/clients/client-edit/' + clientId, {params: params}, function (data) {
        if (data.success) {
            message(1, 'Клиент обновлен');

            $("[toggle='edit_client']:first").click();
        } else {
            message(0, 'Сохранение не удалось');
        }
    });
}

function loadContract(tab, query, params)
{
    modalClose();
    var block = $('.ajax_contract_block');
    addLoader(block);
    var contractId = $('[name=contracts_list]').val();

    var search = getUrlParameter('card') && tab == 'cards' ? location.search : '?tab=' + tab;
    history.pushState("","", location.pathname + search);

    $.post('/clients/contract/' + contractId, {tab:tab, query:query, params:params}, function(data){
        removeLoader(block);
        block.html(data);

        /*
        todo
        if (tab == 'contract') {
            EnjoyHintRun('contract');
        } else if (tab == 'cards') {
            EnjoyHintRun('cards');
        } else if (tab == 'account') {
            EnjoyHintRun('account');
        } else if (tab == 'reports') {
            EnjoyHintRun('reports');
        }*/
    });
}

/**
 * Удаление клиента
 *
 * @param btn
 */
function clientDelete(btn) {
    if (confirm('Вы уверены, что хотите удалить клиента?')) {
        $.post('/clients/client-delete', {client_id: clientId}, function (data) {
            if (data.success) {
                window.location.href = '/clients';
            } else {
                message(0, 'Удаление не удалось')
            }
        });
    }
}