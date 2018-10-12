<?if(Access::allow('clients_client-add')){?>
    <div class="text-right m-b-30">
        <a href="#" class="btn waves-effect waves-light btn-outline-primary" data-toggle="modal" data-target="#client_add"><i class="fa fa-plus"></i> Добавить клиента</a>
    </div>
<?}?>
<?
if(!empty($_REQUEST['search'])){?>
    <h3>Результаты поиска</h3>
<?}?>

<div class="ajax_block_clients_out"></div>

<?if(Access::allow('clients_client-add')){?>
    <?=$popupClientAdd?>
<?}?>


<script>
    $(function(){
        paginationAjax('/clients/?search=<?=(!empty($_REQUEST['search']) ? strip_tags($_REQUEST['search']) : '')?>', 'ajax_block_clients', renderAjaxPaginationClients, {show_all_btn: true});
    });

    var fl = true;

    function renderAjaxPaginationClients(data, block)
    {
        for(var i in data){
            var client = data[i];
            var tpl = $('<div class="card client"><div class="card-body">' +
                '<div class="d-flex">' +
                    '<div>' +
                        '<h3 class="card-title"><span class="lstick"></span><a href="/clients/client/' + client.CLIENT_ID + '">' + client.CLIENT_NAME + '</a></h3>' +
                    '</div>' +
                    '<div class="ml-auto">' +
                        '<span class="label label-light-inverse p-2 font-16 m-b-10 nowrap">ID ' + client.CLIENT_ID + '</span>'+
                    '</div>' +
                '</div>' +
            '</div></div>');

            if (client.LONG_NAME || (client.contracts && client.contracts.length)) {
                $('<div class="row"><div class="col-9 col-sm-8 col-md-9 client-longName" /><div class="col-3 col-sm-4 col-md-3 client-contractsBtn text-right"></div>').insertAfter(tpl.find('.d-flex'));
            }

            if (client.LONG_NAME) {
                tpl.find('.client-longName').html('<h4>' + client.LONG_NAME + '</h4>');
            }

            if (client.contracts && client.contracts.length) {
                tpl.find('.client-contractsBtn').html(
                    '<span class="btn waves-effect waves-light btn-outline-info" toggle="client' + client.CLIENT_ID + '">' +

                        '<span toggle_block="client' + client.CLIENT_ID + '"><i class="fa fa-chevron-down"></i><span class="d-none d-sm-inline"> Договоры</span></span>' +
                        '<span toggle_block="client' + client.CLIENT_ID + '" class="dn"><i class="fa fa-chevron-up"></i><span class="d-none d-sm-inline"> Свернуть</span></span>' +
                    '</div>'
                );

                $('<div class="table_out p-t-20 dn" toggle_block="client' + client.CLIENT_ID + '">' +
                    '<div class="d-none d-md-block">' +
                        '<table class="table m-b-0" />' +
                    '</div>' +
                    '<div class="d-md-none client-contractData" />' +
                '</div>').appendTo(tpl.find('.card-body'));

                for (var j in client.contracts) {
                    var contract = client.contracts[j];

                    $('<tr>' +
                        '<td><span class="label label-' + contract.contract_state_class + '">' + contract.contract_state_name + '</span></td>' +
                        '<td><a href="/clients/client/' + client.CLIENT_ID + '?contract_id=' + contract.CONTRACT_ID + '">' + contract.CONTRACT_NAME + '</a></td>' +
                        '<td><span class="gray">Счет:</span> <b>' + contract.balance_formatted + '</b></td>' +
                        '<td><span class="gray">Карты:</span> <b>' + contract.ALL_CARDS + '</b></td>' +
                    '</tr>').appendTo(tpl.find('table'));

                    $('<ul class="list-group m-b-10">' +
                        '<li class="list-group-item">' +
                            '<span class="float-right badge badge-'+ contract.contract_state_class +' badge-pill">'+ contract.contract_state_name +'</span>' +
                            '<a href="/clients/client/' + client.CLIENT_ID + '?contract_id=' + contract.CONTRACT_ID + '">' + contract.CONTRACT_NAME + '</a>' +
                        '</li>' +
                        '<li class="list-group-item">' +
                            '<span class="float-right"><span class="gray">Карты:</span> <b>' + contract.ALL_CARDS + '</b></span>' +
                            '<span class="gray">Счет:</span> <b>' + contract.balance_formatted + '</b>' +
                        '</li>' +
                    '</ul>').appendTo(tpl.find('.client-contractData'));
                }
            }

            block.append(tpl);
        }

        if (fl) {
            EnjoyHintRun('clients');
            fl = false;
            block.parent().find('.ajax_block_load_all').click();
        }
    }
</script>