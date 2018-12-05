<!-- Nav tabs -->
<ul class="nav nav-tabs customtab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#tabConversion" role="tab">
            <i class="far fa-sync fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Конвертация</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#fence" role="tab" onclick="checkLoadedTubeServicesData()">
            <i class="far fa-credit-card-front fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Для лимитов</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#full" role="tab">
            <i class="far fa-list-ul fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Полный справочник</span>
        </a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="tabConversion" role="tabpanel">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-xl-8">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Источник:</span>
                            </div>
                            <select class="sources_list custom-select">
                                <?foreach ($tubesList as $tube) {?>
                                    <option value="<?=$tube['TUBE_ID']?>" <?=($tube['CARD_LIMIT_CHANGE_ID'] == 1 ? 'disabled' : '')?>><?=$tube['TUBE_NAME']?></option>
                                <?}?>
                            </select>
                        </div>

                        <div class="services_list jsGrid"></div>
                    </div>
                    <div class="col-xl-4 with-mt">
                        <div class="card m-b-0">
                            <div class="card-body bg-light">
                                <h3 class="card-title"><span class="lstick"></span>Добавление конвертации услуг</h3>

                                <div class="form-group row m-t-20">
                                    <div class="col-sm-4 text-muted form__row__title">
                                        Ввод из источника:
                                    </div>
                                    <div class="col-sm-8 with-mt">
                                        <input type="text" name="add_service_in_source" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4 text-muted form__row__title">
                                        Выбор из источника:
                                    </div>
                                    <div class="col-sm-8 with-mt">
                                        <?=Form::buildField('service_choose_single', 'add_service_in_service')?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-8 with-mt">
                                        <span class="<?=Text::BTN?> btn-primary" onclick="addService()">Добавить</span>
                                    </div>
                                </div>

                                <i class="text-muted">
                                    Примечание: Для настройки конвертации услуг по источникам, где доступно управление лимитами карт, обратитесь в <a href="/support">Техническую поддержку</a>
                                </i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="tab-pane" id="fence" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <div class="font-weight-bold font-18 mb-2">Выберите трубу:</div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Источник:</span>
                    </div>
                    <select class="tubes_list_limits custom-select" onchange="loadTubeServicesData($(this))">
                        <?foreach ($tubesList2 as $tube) {?>
                            <option value="<?=$tube['TUBE_ID']?>"><?=$tube['TUBE_NAME']?></option>
                        <?}?>
                    </select>
                </div>

                <div class="tube-data"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="full" role="tabpanel">
        <div class="p-3 bg-white">
            <?include('_servicesListFull.php')?>
        </div>
    </div>
</div>



<script>
    $(function () {
        changeSource($('.sources_list option:first').attr('value'));

        $('.sources_list').on('change', function () {
            changeSource($(this).val());
        });
    });

    var isAjax = false;
    function addService()
    {
        if (isAjax) {
            return false;
        }

        var params = {
            'tube_id':    $('.sources_list').val(),
            'service_id': getComboBoxValue($('[name=add_service_in_service].combobox')),
            'name':       $('[name=add_service_in_source]').val(),
        };

        if (params.service_id == '' || params.name == '' || params.tube_id == '') {
            message('error', 'Заполните все поля');
            return false;
        }

        $.post('/references/add-convert-service', params, function (data) {
            if (data.success) {
                message('success', 'Услуга успшно добавлена');

                changeSource($('.sources_list option:selected').attr('value'));
            } else {
                message('error', 'Ошибка добавления услуги');
            }
        });
    }

    function changeSource(source)
    {
        var block = $('services_list');

        addLoader(block);

        if (!source) {
            removeLoader(block);
            message('error', 'Список услуг пуст');
            return false;
        }

        $.post('/references/service-list-load', {tube_id: source}, function (data) {
            if (data.success) {
                drawTable(data.data);
                //changeSelect(data.data);
            } else {
                message('error', 'Ошибка загрузки списка услуг');
            }

            removeLoader(block);
        });
    }

    function changeSelect(data)
    {
        var select = $('[name=add_service_in_service]');

        select.empty();

        for (var i in data){
            var optionValue = data[i].DESCRIPTION;

            if (select.find('option[value="'+ optionValue +'"]').length == 0) {
                select.append('<option value="'+ optionValue +'">'+ data[i].DESCRIPTION +'</option>');
            }
        }
    }

    function drawTable(rows)
    {
        var grid = $(".jsGrid.services_list");

        grid.jsGrid({
            width: '100%',
            sorting: true,
            paging: true,
            pageSize: 10,

            data: rows,

            fields: [
                { name: "SERVICE_ID", type: "text", title: 'ID', width:50},
                { name: "SERVICE_NAME", type: "text", title: 'Наименование в справочнике', width:90},
                { name: "FULL_NAME", type: "text", title: 'Полное наименование', width:150},
                { name: "FOREIGN_DESC", type: "text", title: 'Наименование в источнике', width:160},
            ]
        });
    }

    function checkLoadedTubeServicesData()
    {
        if ($('.tube-data').is(':empty')) {
            loadTubeServicesData($('.tubes_list_limits'));
        }
    }

    function loadTubeServicesData(select)
    {
        var value = select.val();
        var block = $('.tube-data');

        addLoader(block);

        $.post('/references/load-tube-services-data/', {tube_id: value}, function(data){
            removeLoader(block);
            block.html(data);
        });
    }
</script>