<style>
    textarea{
        width: 100%; height: 300px; margin-bottom: 30px;
    }
    .result__block{
        display: none;
    }
    .result{
        margin: 0; width: 100%; overflow-x: auto;
    }
    .checkbox_outer{
        display: inline-block;
    }
</style>

<div class="card">
    <div class="card-body">
        <h3 class="card-title"><span class="lstick"></span>Запрос</h3>

        <textarea name="query" placeholder="Текст запроса" class="form-control"></textarea>
        <div class="row">
            <div class="col-4">
                <span class="<?=Text::BTN?> btn-primary" onclick="executeQuery()">Выполнить</span>
            </div>
            <div class="col-4 text-right">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Limit</span>
                    </div>
                    <input type="number" class="form-control" name="limit" value="10">
                </div>
            </div>
            <div class="col-4">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="raw">
                    <span class="custom-control-label">Raw</span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="result__block">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title"><span class="lstick"></span>Результат <span class="text-muted time"></span></h3>
            <div class="result"></div>
        </div>
    </div>
</div>

<script>
    function executeQuery()
    {
        $('.result__block').show();

        var result = $('.result');

        addLoader(result);

        var params = {
            query: $('[name=query]').val(),
            limit: $('[name=limit]').val(),
            raw: $('[name=raw]').is(':checked') ? 1 : 0,
        };

        $.post('/system/query', params, function (data) {
            removeLoader(result);
            result.html(data);
        });
    }
</script>