<style>
    pre{
        box-shadow: none; margin-bottom: 0;
    }
</style>

<div class="card">
    <div class="card-body">
        <a href="/system/full" class="ajax btn-warning btn">Full rebuild</a> - gulp build, version refresh and git

        <div class="result"></div>
    </div>
</div>

<h2 class="text-themecolor">Версия</h2>

<div class="card">
    <div class="card-body">
        <a href="/system/version-refresh" class="ajax btn btn-outline-primary m-b-20">Обновить</a>

        <div class="result">
            <pre><?=$version?></pre>
        </div>
    </div>
</div>

<h2 class="text-themecolor">Сборка frontend</h2>

<div class="card">
    <div class="card-body">
        <a href="/system/gulp/build" class="btn btn-outline-primary ajax"><b>gulp build</b> - css, js, fonts, image</a> &nbsp;&nbsp;&nbsp;
        <a href="/system/gulp/fast" class="btn btn-outline-primary ajax"><b>gulp fast</b> - css, js</a> &nbsp;&nbsp;&nbsp;
        <a href="/system/gulp/images" class="btn btn-outline-primary ajax"><b>gulp images</b></a>

        <div class="result"></div>
    </div>
</div>

<h2 class="text-themecolor">Сборка backend</h2>

<div class="card">
    <div class="card-body">
        <a href="/system/deploy" class="ajax btn btn-outline-primary"><b>deploy</b> - git</a>

        <div class="result"></div>
    </div>
</div>

<script>
    $('.ajax').on('click', function () {
        var t = $(this);
        var result = t.closest('.card-body').find('.result');

        result.empty().addClass(CLASS_LOADING);

        $.post(t.attr('href'), {}, function (html) {
            result.removeClass(CLASS_LOADING).html('<pre>' + html + '</pre>');
        });

        return false;
    });
</script>