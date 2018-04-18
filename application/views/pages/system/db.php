<style>
    textarea{
        width: 100%; height: 400px; margin-bottom: 30px;
    }
    .result__block{
        display: none;
    }
    .result{
        margin: 0; width: 100%; overflow-x: auto;
    }
</style>

<h1>DB</h1>

<h2>Запрос</h2>
<div class="block">
    <div>
        <textarea name="query" placeholder="Запрос"></textarea>
    </div>
    <span class="btn" onclick="executeQuery()">Выполнить</span>
</div>

<div class="result__block">
    <h2>Результат</h2>
    <div class="block">
        <div class="result"></div>
    </div>
</div>

<script>
    function executeQuery()
    {
        $('.result__block').show();

        var result = $('.result');

        result.empty().addClass(CLASS_LOADING);

        $.post('/system/query', {query: $('[name=query]').val()}, function (data) {
            result.removeClass(CLASS_LOADING);
            result.html(data);
        });
    }
</script>