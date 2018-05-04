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
            <div class="col-6">
                <span class="btn btn-primary" onclick="executeQuery()">Выполнить</span>
            </div>
            <div class="col-6 text-right">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Limit</span>
                    </div>
                    <input type="number" class="form-control" name="limit" value="10">
                </div>
            </div>
        </div>
    </div>
    <span class="btn" onclick="executeQuery()">Выполнить</span>
    &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
    Limit: <input type="number" name="limit" class="input_big input_mini" value="10">
    &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
    Raw: <input type="checkbox" name="raw">
</div>

<div class="result__block">
    <h2 class="text-themecolor">Результат</h2>
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

        result.empty().addClass(CLASS_LOADING);

        var params = {
            query: $('[name=query]').val(),
            limit: $('[name=limit]').val(),
            raw: $('[name=raw]').is(':checked') ? 1 : 0,
        };

        $.post('/system/query', params, function (data) {
            result.removeClass(CLASS_LOADING);
            result.html(data);
        });
    }
</script>