<div class="block no_padding dots_info">
    <div class="text-right m-b-20">
        <span class="<?=Text::BTN?> btn-outline-success" onclick="dotsInfoToXls()"><i class="fa fa-file-excel"></i> Выгрузить</span>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="list"></div>
        </div>
    </div>
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

        addLoader(block);

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