<style>
    pre{
        box-shadow: none; margin-bottom: 0;
    }
</style>

<div class="card">
    <div class="card-body">
        <a href="/system/full" class="ajax btn-warning <?=Text::BTN?>">Full rebuild</a> - gulp build, version refresh and git

        <div class="result"></div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h3 class="card-title"><span class="lstick"></span>Версия</h3>

        <a href="/system/version-refresh" class="ajax <?=Text::BTN?> btn-primary m-b-20">Обновить</a>

        <div class="result">
            <pre><?=$version?></pre>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h3 class="card-title"><span class="lstick"></span>Сборка frontend</h3>

        <a href="/system/gulp/build" class="<?=Text::BTN?> btn-primary ajax"><b>gulp build</b> - css, js, fonts, image</a> &nbsp;&nbsp;&nbsp;
        <a href="/system/gulp/fast" class="<?=Text::BTN?> btn-primary ajax"><b>gulp fast</b> - css, js</a> &nbsp;&nbsp;&nbsp;
        <a href="/system/gulp/images" class="<?=Text::BTN?> btn-primary ajax"><b>gulp images</b></a>

        <div class="result"></div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h3 class="card-title"><span class="lstick"></span>Сборка backend</h3>

        <a href="/system/deploy" class="ajax <?=Text::BTN?> btn-primary"><b>deploy</b> - git</a>

        <div class="result"></div>
    </div>
</div>

<script>
    $('.ajax').on('click', function () {
        var t = $(this);
        var result = t.closest('.card-body').find('.result');

        addLoader(result);

        $.post(t.attr('href'), {}, function (html) {
            removeLoader(result);
            result.html('<pre>' + html + '</pre>');
        });

        return false;
    });
</script>