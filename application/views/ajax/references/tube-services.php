<div class="row mt-4">
    <div class="col-sm-6 services-open">
        <div class="font-weight-bold font-18 mb-2">Установлено для управления лимитами:</div>
        <?foreach ($servicesOpen as $service) {?>
            <h3 service="<?=$service['SERVICE_ID']?>">
                <span class="badge badge-primary"><?=$service['FOREIGN_DESC']?></span>
                <a href="#" class="text-danger" onclick="deleteServiceFromTube(<?=$service['SERVICE_ID']?>)"><i class="fa fa-trash-alt font-16"></i></a>
            </h3>
        <?}?>
    </div>
    <div class="col-sm-6 with-mt services-available">
        <div class="font-weight-bold font-18 mb-2">Доступно для добавления:</div>
        <?foreach ($servicesAvailable as $service) {?>
            <h3 service="<?=$service['SERVICE_ID']?>">
                <span class="badge badge-success"><?=$service['SYSTEM_SERVICE_NAME']?></span>
                <a href="#" class="text-primary" onclick="addServiceToTube(<?=$service['SERVICE_ID']?>)"><i class="fa fa-plus font-16"></i></a>
            </h3>
        <?}?>
    </div>
</div>

<script>
    function deleteServiceFromTube(serviceId)
    {
        var block = $('.tube-data');
        var tubeId = $('.tubes_list_limits').val();
        var params = {
            tube_id: tubeId,
            service_id: serviceId,
            action: 'delete'
        };

        addLoader(block);

        $.post('/references/edit-tube-service', params, function (data) {
            removeLoader(block);

            if (data.success) {
                message(true, 'Услуга успешно удалена');

                var badge = $('<h3 service="'+ serviceId +'">' +
                    '    <span class="badge badge-success">'+ $('h3[service='+ serviceId +'] .badge').text() +'</span>' +
                    '    <a href="#" class="text-primary" onclick="addServiceToTube('+ serviceId +')"><i class="fa fa-plus font-16"></i></a>' +
                    '</h3>');

                $('h3[service='+ serviceId +']').remove();
                $('.services-available').append(badge);
            } else {
                message(false, 'Ошибка удаления услуги');
            }
        });

        return false;
    }

    function addServiceToTube(serviceId)
    {
        var block = $('.tube-data');
        var tubeId = $('.tubes_list_limits').val();
        var params = {
            tube_id: tubeId,
            service_id: serviceId,
            action: 'add'
        };

        addLoader(block);

        $.post('/references/edit-tube-service', params, function (data) {
            removeLoader(block);

            if (data.success) {
                message(true, 'Услуга успешно добавлена');

                var badge = $('<h3 service="'+ serviceId +'">' +
                    '    <span class="badge badge-primary">'+ $('h3[service='+ serviceId +'] .badge').text() +'</span>' +
                    '    <a href="#" class="text-danger" onclick="deleteServiceFromTube('+ serviceId +')"><i class="fa fa-trash-alt font-16"></i></a>' +
                    '</h3>');

                $('h3[service='+ serviceId +']').remove();
                $('.services-open').append(badge);
            } else {
                message(false, 'Ошибка добавления услуги');
            }
        });

        return false;
    }
</script>