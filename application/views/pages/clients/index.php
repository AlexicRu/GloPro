<div class="card">
    <div class="card-body">
        <div class="row align-items-center no-gutters">
            <div class="col-2 col-md-3">
                <a href="#clientsFilter" data-toggle="collapse" class="<?=Text::BTN?> btn-outline-info">
                    <i class="fa fa-filter"></i>
                    <span class="d-none d-md-inline-block">Фильтр</span>
                </a>
            </div>
            <div class="col-8 col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-sort-amount-up"></i>
                            <span class="ml-1 d-none d-xl-inline-block">Сортировка:</span>
                        </span>
                    </div>
                    <select class="custom-select" name="clients-sort" onchange="clientsFilter();">
                        <option way="desc" sort="id">ID &downarrow;</option>
                        <option way="asc" sort="id">ID &uparrow;</option>
                        <option way="desc" sort="name">Название &downarrow;</option>
                        <option way="asc" sort="name">Название &uparrow;</option>
                    </select>
                </div>
            </div>
            <?if(Access::allow('clients_client-add')){?>
                <div class="col-2 col-md-3 text-right">
                    <a href="#" class="<?=Text::BTN?> btn-outline-primary" data-toggle="modal" data-target="#client_add">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-md-inline-block">Добавить</span>
                        <span class="d-none d-xl-inline-block">клиента</span>
                    </a>
                </div>
            <?}?>
        </div>

        <div class="collapse" id="clientsFilter">
            <div class="pt-4">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" checked name="clients_filter_status_active">
                    <span class="custom-control-label">В работе</span>
                </label>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" checked name="clients_filter_status_inactive">
                    <span class="custom-control-label">Удаленные</span>
                </label>
            </div>
            <div class="pt-2">
                <span class="<?=Text::BTN?> btn-primary" onclick="clientsFilter()">Применить</span>
            </div>
        </div>
    </div>
</div>

<?
if(!empty($_REQUEST['search'])){?>
    <h3>Результаты поиска: <?=$_REQUEST['search']?></h3>
<?}?>

<div class="ajax_block_clients_out"></div>

<?if(Access::allow('clients_client-add')){?>
    <?=$popupClientAdd?>
<?}?>

<script>
    clientsFilterParams.search = '<?=(!empty($_REQUEST['search']) ? strip_tags($_REQUEST['search']) : '')?>';

    $(function(){
        clientsReload();
    });

    var fl = true;

    function renderAjaxPaginationClients(data, block, params)
    {
        for(var i in data){
            var client = data[i];
            var tpl = $('<div class="card client"><div class="card-body">' +
                '<div class="d-flex">' +
                    '<div>' +
                        '<h3 class="card-title"><span class="lstick"></span><a href="/clients/client/' + client.CLIENT_ID + '">' + client.CLIENT_NAME + '</a></h3>' +
                    '</div>' +
                    '<div class="ml-auto">' +
                        '<span class="badge badge-light font-16">ID ' + client.CLIENT_ID + '</span>'+
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
                    '<span class="'+ BTN+' btn-outline-info" toggle="client' + client.CLIENT_ID + '">' +

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
                    var link = '/clients/client/' + client.CLIENT_ID + '?contract_id=' + contract.CONTRACT_ID;
                    var card = '';

                    if (contract.found_card !== false) {
                        card = '<a href="'+ link +'&tab=cards&card='+ contract.found_card +'" class="d-inline-block ml-2"><i class="far fa-credit-card-front"></i></a>';
                    }

                    $('<tr>' +
                        '<td><span class="badge badge-' + contract.contract_state_class + '">' + contract.contract_state_name + '</span></td>' +
                        '<td><a href="'+ link +'">' + contract.CONTRACT_NAME + '</a>'+card+'</td>' +
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

            if (params.more) {
                setTimeout(function () {
                    block.parent().find('.ajax_block_load_all').click();
                }, 1000);
            }
        }
    }
</script>