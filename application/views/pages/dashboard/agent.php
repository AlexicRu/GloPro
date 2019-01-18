<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><span class="lstick"></span>Выберите период</h3>

                <div class="row">
                    <div class="col-sm-7">
                        <select name="date_agent_month" class="custom-select">
                            <?for ($i = 1; $i <= 12; $i++) {?>
                                <option value="<?=$i?>" <?=($i == date('n') ? 'selected' : '')?>><?=Date::monthRu($i)?></option>
                            <?}?>
                        </select>
                    </div>

                    <div class="col-sm-5 with-mt">
                        <input type="number" class="form-control" name="date_agent_year" value="<?=date('Y')?>">
                    </div>
                </div>

                <div class="m-t-5">
                    <span class="<?=Text::BTN?> btn-success" onclick="buildRealizationsByAgents()"><i class="fa fa-sync-alt"></i> Обновить</span>
                </div>
            </div>
        </div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabRealization" role="tab">
                    <i class="far fa-table fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Реализация</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabCards" role="tab">
                    <i class="far fa-credit-card-front fa-lg"></i> <span class="hidden-xs-down d-inline-block m-l-5">Карты</span>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="tabRealization" role="tabpanel">
                <div class="card">
                    <div class="card-body scroll-x">
                        <div class="realization_by_agents"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tabCards" role="tabpanel">
                <div class="card">
                    <div class="card-body scroll-x">
                        <div class="realization_by_agents_cards_count"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><span class="lstick"></span>В разрезе номенклатур (литры)</h3>

                <div id="realization_by_agents_nomenclature_graph" class="graph"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">

        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><span class="lstick"></span>Реализация за год</h3>

                <div id="realization_by_agents_graph" class="graph hidden-sm-down"></div>
                <div class="hidden-md-up">
                    <i class="text-muted">Данный график вы сможете увидеть на десктопной версии сайта</i>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><span class="lstick"></span>Средняя скидка по конечному клиенту</h3>

                <div id="realization_by_agents_avg_discount_graph" class="graph hidden-sm-down"></div>
                <div class="hidden-md-up">
                    <i class="text-muted">Данный график вы сможете увидеть на десктопной версии сайта</i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        buildRealizationsByAgents();
        buildRealizationByAgentsGraph();
        buildRealizationByAgentsAvgDiscountGraph();
        buildRealizationByAgentsCardsCount();

        AmCharts.addInitHandler( function ( chart ) {
            // set base values
            var categoryWidth = 30;
            var chartHeight;

            // calculate bottom margin based on number of data points
            if (chart.type == 'serial') {
                chartHeight = categoryWidth * chart.graphs.length / 3;
            } else {
                chartHeight = categoryWidth * chart.dataProvider.length / 2;
            }

            // set the value
            chart.div.style.height = parseInt(chartHeight + 500) + 'px';

        }, ['serial', 'pie'] );
    });

    function getDate()
    {
        var day = '01';
        var month = $('[name=date_agent_month]').val();
        var year = $('[name=date_agent_year]').val();

        if (month < 10) {
            month = '0' + month;
        }

        return day + '.' + month + '.' + year;
    }

    function buildRealizationsByAgents() {
        buildRealizationByAgents();
        // buildRealizationByAgentsNomenclature();
        buildRealizationByAgentsNomenclatureGraph();
    }

    function buildRealizationByAgents()
    {
        var block = $('.realization_by_agents');
        addLoader(block);

        $.post('/dashboard/get-realization-by-agents', {date: getDate()}, function (data) {
            removeLoader(block);
            block.html(data);
        })
    }

    function buildRealizationByAgentsCardsCount()
    {
        var block = $('.realization_by_agents_cards_count');
        addLoader(block);

        $.post('/dashboard/get-realization-by-agents-cards-count', {}, function (data) {
            removeLoader(block);
            block.html(data);
        })
    }

    function buildRealizationByAgentsNomenclatureGraph()
    {
        var graphBlock = $('#realization_by_agents_nomenclature_graph');
        addLoader(graphBlock);

        $.post('/dashboard/get-realization-by-agents-nomenclature-graph', {date: getDate()}, function (response) {
            removeLoader(graphBlock);

            if (response.data.length == 0) {
                graphBlock.removeClass('graph').html('<div class="text-center"><i class="text-muted">Нет данных</i></div>');
                return;
            } else {
                graphBlock.addClass('graph');
            }

            var chart = AmCharts.makeChart( "realization_by_agents_nomenclature_graph", {
                "hideCredits":true,
                "type": "pie",
                "theme": "light",
                "dataProvider": response.data,
                "valueField": "SERVICE_AMOUNT",
                "titleField": "LONG_DESC",
                "balloonText": "[[title]]<br><span style='font-size:14px'>литры: <b>[[value]]</b></span>",
                "innerRadius": "30%",
                "labelText": "",
                "legend":{
                    "align": 'center',
                    "valueWidth": 100
                },
                "numberFormatter": {
                    "precision": -1,
                    "decimalSeparator": ".",
                    "thousandsSeparator": " "
                },
                "marginBottom": 10,
                "marginTop": 5,
                "pullOutRadius": 0
            } );
        });
    }

    function buildRealizationByAgentsNomenclature()
    {
        var block = $('.realization_by_agents_nomenclature');
        addLoader(block);

        $.post('/dashboard/get-realization-by-agents-nomenclature', {date: getDate()}, function (data) {
            removeLoader(block);
            block.html(data);
        })
    }

    function buildRealizationByAgentsGraph()
    {
        var graphBlock = $('#realization_by_agents_graph');
        addLoader(graphBlock);

        $.post('/dashboard/get-realization-by-agents-graph', {}, function (response) {
            removeLoader(graphBlock);

            if (response.data.data.length == 0) {
                graphBlock.removeClass('graph').html('<div class="text-center"><i class="text-muted">Нет данных</i></div>');
                return;
            } else {
                graphBlock.addClass('graph');
            }

            var colors = palette('mpn65', response.data.agents.length);

            var graphs = [];

            for(var i in response.data.agents) {
                var graph = {
                    "id":"g" + response.data.agents[i].agent_id,
                    "title": response.data.agents[i].label,
                    "bullet": "round",
                    "bulletSize": 6,
                    "lineColor": "#" + colors.shift(),
                    "lineThickness": 2,
                    "type": "smoothedLine",
                    "valueField": "agent" + response.data.agents[i].agent_id
                };
                graphs.push(graph);
            }

            var chart = AmCharts.makeChart("realization_by_agents_graph", {
                "hideCredits":true,
                "type": "serial",
                "theme": "light",
                "autoMarginOffset": 20,
                "dataProvider": response.data.data,
                "numberFormatter": {
                    "precision": -1,
                    "decimalSeparator": ".",
                    "thousandsSeparator": " "
                },
                "valueAxes": [{
                    "axisAlpha": 0,
                    "position": "left"
                }],
                "legend": {
                    "align": "center",
                    "equalWidths": true,
                    "marginLeft" : 0,
                    "marginRight" : 0,
                },
                "graphs": graphs,
                "valueScrollbar":{
                    "enabled": true,
                    "scrollbarHeight":10
                },
                "chartScrollbar": {
                    "enabled": true,
                    "scrollbarHeight":10
                },
                "chartCursor": {
                    "categoryBalloonDateFormat": "MM.YYYY",
                    "cursorAlpha": 0,
                    "valueLineEnabled":true,
                    "valueLineBalloonEnabled":true,
                    "valueLineAlpha":0.5,
                    "fullWidth":true
                },
                "dataDateFormat": "MM.YYYY",
                "categoryField": "date"
            });
        })
    }

    function buildRealizationByAgentsAvgDiscountGraph()
    {
        var graphBlock = $('#realization_by_agents_avg_discount_graph');
        addLoader(graphBlock);

        $.post('/dashboard/get-realization-by-agents-avg-discount-graph', {}, function (response) {
            removeLoader(graphBlock);

            if (response.data.data.length == 0) {
                graphBlock.removeClass('graph').html('<div class="text-center"><i class="text-muted">Нет данных</i></div>');
                return;
            } else {
                graphBlock.addClass('graph');
            }

            var colors = palette('mpn65', response.data.agents.length);

            var graphs = [];

            for(var i in response.data.agents) {
                var graph = {
                    "id":"g" + response.data.agents[i].agent_id,
                    "title": response.data.agents[i].label,
                    "bullet": "round",
                    "bulletSize": 6,
                    "lineColor": "#" + colors.shift(),
                    "lineThickness": 2,
                    "type": "smoothedLine",
                    "valueField": "agent" + response.data.agents[i].agent_id
                };
                graphs.push(graph);
            }

            var chart = AmCharts.makeChart("realization_by_agents_avg_discount_graph", {
                "hideCredits":true,
                "type": "serial",
                "theme": "light",
                "autoMarginOffset": 20,
                "dataProvider": response.data.data,
                "numberFormatter": {
                    "precision": -1,
                    "decimalSeparator": ".",
                    "thousandsSeparator": " "
                },
                "valueAxes": [{
                    "axisAlpha": 0,
                    "position": "left"
                }],
                "legend": {
                    "align": "center",
                    "equalWidths": true,
                    "marginLeft" : 0,
                    "marginRight" : 0,
                },
                "graphs": graphs,
                "valueScrollbar":{
                    "enabled": true,
                    "scrollbarHeight":10
                },
                "chartScrollbar": {
                    "enabled": true,
                    "scrollbarHeight":10
                },
                "chartCursor": {
                    "categoryBalloonDateFormat": "MM.YYYY",
                    "cursorAlpha": 0,
                    "valueLineEnabled":true,
                    "valueLineBalloonEnabled":true,
                    "valueLineAlpha":0.5,
                    "fullWidth":true
                },
                "dataDateFormat": "MM.YYYY",
                "categoryField": "date"
            });
        })
    }
</script>