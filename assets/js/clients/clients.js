var clientsFilterParams = {
    show_all_btn: true
};

/**
 * применяем фильтры и грузим клиентов заново
 */
function clientsFilter()
{
    var sortSelect = $('[name=clients-sort] option:selected');

    clientsFilterParams.sort = sortSelect.attr('sort');
    clientsFilterParams.sortWay = sortSelect.attr('way');
    clientsFilterParams.statuses = {};
    clientsFilterParams.statuses.active = $('[name=clients_filter_status_active]').is(':checked') ? 1 : 0;
    clientsFilterParams.statuses.inactive = $('[name=clients_filter_status_inactive]').is(':checked') ? 1 : 0;

    clientsReload();
}

/**
 * аяксовая постраничная загрузка клиентов
 */
function clientsReload()
{
    $('.ajax_block_clients_out').empty();

    paginationAjax('/clients/clients-list', 'ajax_block_clients', renderAjaxPaginationClients, clientsFilterParams);
}