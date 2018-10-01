<h1>Точки обслуживания</h1>

<div class="block no_padding dots_info">
    <div class="tab_content_header">
        <div class="fr">
            <span class="btn waves-effect waves-light btn_green btn_icon" onclick="dotsInfoToXls()"><i class="fa fa-file-excel"></i> Выгрузить</span>
        </div>
        <br class="clr">
    </div>

    <div class="list"></div>
</div>

<script>
    $(function(){
        showDotsList();
    });

    function showDotsList()
    {
        var block = $('.dots_info .list');

        if(block.html() != ''){
            return true;
        }

        addLoader(block;

        $.post('/control/show-dots', { postfix: 'dots_info' }, function (data) {
            removeLoader(block);
            block.html(data);
        });
    }

    function dotsInfoToXls()
    {
        var pos_id = [];

        $('.ajax_block_dots_list_dots_info [pos_id]').each(function () {
            pos_id.push($(this).attr('pos_id'));
        });

        window.open('/control/load-dots?to_xls=1&pos_id=' + pos_id.join(','));
    }
</script>