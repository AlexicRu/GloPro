$(function(){
    renderPhoneInput($('[name=PHONE]'));

    $(".client_edit_btn").on('click', function(){
        var block = $(".edit_client_block");

        var params = {
            NAME:                   $('[name=NAME]').val(),
            LONG_NAME:              $('[name=LONG_NAME]').val(),
            Y_ADDRESS:              $('[name=Y_ADDRESS]', block).val(),
            F_ADDRESS:              $('[name=F_ADDRESS]', block).val(),
            P_ADDRESS:              $('[name=P_ADDRESS]', block).val(),
            COMMENTS:               $('[name=COMMENTS]', block).val(),
            PHONE:                  $('[name=PHONE]', block).val(),
            EMAIL:                  $('[name=EMAIL]', block).val(),
            INN:                    $('[name=INN]', block).val(),
            KPP:                    $('[name=KPP]', block).val(),
            OGRN:                   $('[name=OGRN]', block).val(),
            OKPO:                   $('[name=OKPO]', block).val(),
            BANK:                   $('[name=BANK]', block).val(),
            BANK_BIK:               $('[name=BANK_BIK]', block).val(),
            BANK_CORR_ACCOUNT:      $('[name=BANK_CORR_ACCOUNT]', block).val(),
            BANK_ACCOUNT:           $('[name=BANK_ACCOUNT]', block).val(),
            BANK_ADDRESS:           $('[name=BANK_ADDRESS]', block).val(),
            CEO:                    $('[name=CEO]', block).val(),
            CEO_SHORT:              '', //$('[name=CEO_SHORT]', block).val(),
            ACCOUNTANT:             $('[name=ACCOUNTANT]', block).val(),
            ACCOUNTANT_SHORT:       '', //$('[name=ACCOUNTANT_SHORT]', block).val(),
        };

        if(params.NAME == ''){
            message(0, 'Заполните название фирмы');
            return false;
        }

        if(params.Y_ADDRESS == ''){
            message(0, 'Заполните юридический адрес');
            return false;
        }

        if(params.INN == ''){
            message(0, 'Заполните ИНН');
            return false;
        }

        $.post('/clients/client-edit/' + clientId, { params:params }, function(data){
            if(data.success){
                message(1, 'Клиент обновлен');

                $.each( params, function( key, value ) {
                    var uid = $('[name='+ key +']').closest('[uid]');

                    if(key == 'EMAIL'){
                        $("[uid=" + uid.attr('uid') + "]").not(uid).html("<a href='mailto:"+value+"'>"+ value +"</a>");
                    } else if(key == 'COMMENTS') {
                        $("[uid=" + uid.attr('uid') + "]").not(uid).html(value.replace(/\n/g, "<br>"));
                    } else {
                        $("[uid=" + uid.attr('uid') + "]").not(uid).text(value);
                    }
                });

                $("[toggle='edit_client']:first").click();

            }else{
                message(0, 'Сохранение не удалось');
            }
        });
    });

    loadContract(location.hash ? location.hash.replace('#', '') : 'contract');

    $('[name=contracts_list]').on('change', function(){
        loadContract('contract');
    });

    $(document).on('click', '[ajax_tab]', function(e){
        var t = $(this);
        if(t.hasClass('active')){
            return false;
        }
        loadContract(t.attr('href').replace('#', ''));
    });
});

function loadContract(tab, query, params)
{
    modalClose();
    var block = $('.ajax_contract_block');
    addLoader(block);
    var contractId = $('[name=contracts_list]').val();

    location.hash = '#' + tab;

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