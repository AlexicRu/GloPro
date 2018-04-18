<?if(Access::allow('clients_client-add')){?>
    <div class="text-right m-b-30">
        <a href="#client_add" class="btn btn-primary fancy">+ Добавить клиента</a>
    </div>
<?}?>
<?
if(!empty($_REQUEST['search'])){?>
    <h3>Результаты поиска</h3>
<?}?>

<div class="ajax_block_clients_out block_loading">

</div>

<?if(Access::allow('clients_client-add')){?>
    <?=$popupClientAdd?>
<?}?>


<script>
    $(function(){
        paginationAjax('/clients/?search=<?=(!empty($_REQUEST['search']) ? strip_tags($_REQUEST['search']) : '')?>', 'ajax_block_clients', renderAjaxPaginationClients, {show_all_btn: true});
    });

    function renderAjaxPaginationClients(data, block)
    {
        for(var i in data){
            var client = data[i];
            var tpl = $('<div class="card card-body client">' +
                '<div class="d-flex">' +
                    '<div>' +
                        '<h3 class="card-title"><span class="lstick"></span><a href="/clients/client/' + client.CLIENT_ID + '">' + client.CLIENT_NAME + '</a></h3>' +
                    '</div>' +
                    '<div class="ml-auto">' +
                        '<span class="label label-light-inverse p-2 font-16 m-b-10">ID ' + client.CLIENT_ID + '</span>'+
                    '</div>' +
                '</div>' +
            '</div>');

            if (client.LONG_NAME || client.contracts.length) {
                $('<div class="row"><div class="col-8 client-longName" /><div class="col-4 client-contractsBtn text-right"></div>').insertAfter(tpl.find('.d-flex'));
            }

            if (client.LONG_NAME) {
                tpl.find('.client-longName').html('<h4>' + client.LONG_NAME + '</h4>');
            }

            if (client.contracts && client.contracts.length) {
                tpl.find('.client-contractsBtn').html(
                    '<span class="btn btn-outline-primary" toggle="client' + client.CLIENT_ID + '">' +

                        '<span toggle_block="client' + client.CLIENT_ID + '"><i class="fa fa-chevron-down"></i><span class="d-none d-sm-inline"> Договоры</span></span>' +
                        '<span toggle_block="client' + client.CLIENT_ID + '" class="dn"><i class="fa fa-chevron-up"></i><span class="d-none d-sm-inline"> Свернуть</span></span>' +
                    '</div>'
                );

                $('<div class="table_out p-t-20 dn" toggle_block="client' + client.CLIENT_ID + '">' +
                    '<div class="d-none d-md-block">' +
                        '<table class="table m-b-0" />' +
                    '</div>' +
                    '<div class="d-md-none client-contractData" />' +
                '</div>').appendTo(tpl);

                for (var j in client.contracts) {
                    var contract = client.contracts[j];

                    $('<tr>' +
                        '<td><span class="label label-' + contract.contract_state_class + '">' + contract.contract_state_name + '</span></td>' +
                        '<td><a href="/clients/client/' + client.CLIENT_ID + '?contract_id=' + contract.CONTRACT_ID + '">' + contract.CONTRACT_NAME + '</a></td>' +
                        '<td><span class="gray">Счет:</span> ' + contract.balance_formatted + '</td>' +
                        '<td><span class="gray">Карты:</span> ' + contract.ALL_CARDS + '</td>' +
                    '</tr>').appendTo(tpl.find('table'));


                    /*
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Cras justo odio
    <span class="badge badge-primary badge-pill">14</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Dapibus ac facilisis in
    <span class="badge badge-primary badge-pill">2</span>
  </li>
</ul>
                     */

                    /*$('<div class="row m-b-10">' +
                        '<div class="col-4"><span class="label ' + contract.contract_state_class + '">' + contract.contract_state_name + '</span></div>' +
                        '<div class="col-8"><a href="/clients/client/' + client.CLIENT_ID + '?contract_id=' + contract.CONTRACT_ID + '">' + contract.CONTRACT_NAME + '</a></div>' +
                    '</div><div class="row m-b-30">' +
                        '<div class="col-6"><span class="gray">Счет:</span> ' + contract.balance_formatted + '</div>' +
                        '<div class="col-6"><span class="gray">Карты:</span> ' + contract.ALL_CARDS + '</div>' +
                    '</div>').appendTo(tpl.find('.client-contractData'));*/

                    $('<ul class="list-group m-b-10">' +
                        '<li class="list-group-item">' +
                            '<span class="float-right badge badge-'+ contract.contract_state_class +' badge-pill">'+ contract.contract_state_name +'</span>' +
                            '<a href="/clients/client/' + client.CLIENT_ID + '?contract_id=' + contract.CONTRACT_ID + '">' + contract.CONTRACT_NAME + '</a>' +
                        '</li>' +
                        '<li class="list-group-item">' +
                            '<span class="float-right"><span class="gray">Карты:</span> ' + contract.ALL_CARDS + '</span>' +
                            '<span class="gray">Счет:</span> ' + contract.balance_formatted +
                        '</li>' +
                    '</ul>').appendTo(tpl.find('.client-contractData'));
                }
            }

            block.append(tpl);
        }
    }
</script>