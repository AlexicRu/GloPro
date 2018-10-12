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

<h2 class="text-themecolor">Запрос</h2>

<div class="card">
    <div class="card-body">
        <textarea name="query" placeholder="Текст запроса" class="form-control"></textarea>
        <div class="row">
            <div class="col-4">
                <span class="btn btn-primary" onclick="executeQuery()">Выполнить</span>
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
                <input type="checkbox" name="raw" id="raw" class="<?=Text::CHECKBOX?>">
                <label for="raw">Raw</label>
            </div>
        </div>
    </div>
</div>

<div class="result__block">
    <h2 class="text-themecolor">Результат <span class="text-muted time"></span></h2>
    <div class="card">
        <div class="card-body">
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