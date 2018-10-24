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
                        <b class="font-18">Добавление конвертации услуг</b>

                        <div class="form-group row m-t-20">
                            <div class="col-sm-4">
                                <div class="text-right hidden-xs-down text-muted">Ввод из источника:</div>
                                <span class="hidden-sm-up text-muted">Ввод из источника:</span>
                            </div>
                            <div class="col-sm-8 with-mt">
                                <input type="text" name="add_service_in_source" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">
                                <div class="text-right hidden-xs-down text-muted">Выбор из источника:</div>
                                <span class="hidden-sm-up text-muted">Выбор из источника:</span>
                            </div>
                            <div class="col-sm-8 with-mt">
                                <?=Form::buildField('service_choose_single', 'add_service_in_service')?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8 with-mt">
                                <span class="<?=Text::BTN?> btn-outline-primary" onclick="addService()">Добавить</span>
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
                { name: "ID", type: "text", title: 'ID', width:50},
                { name: "DESCRIPTION", type: "text", title: 'Наименование в справочнике', width:90},
                { name: "FULL_DESC", type: "text", title: 'Полное наименование', width:150},
                { name: "SERVICE_IN_TUBE", type: "text", title: 'Наименование в источнике', width:160},
            ]
        });
    }
</script>