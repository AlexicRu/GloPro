<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <span class="mark_read btn-success <?=Text::BTN?>"><i class="fa fa-check"></i> Отметить прочитанными</span>
            </div>
            <div class="col-sm-6">
                <form class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
            </span>
                    <input type="text" name="m_search" class="form-control input_messages" placeholder="Поиск..." value="<?=$mSearch?>">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="ajax_block_messages_out"></div>

<script>
    $(function(){
        paginationAjax('/messages/', 'ajax_block_messages', renderAjaxPaginationMessages, {'search': '<?=$mSearch?>'});

        $('.input_messages').on('keypress', function (e) {
            if(e.keyCode == 13) {
                var t = $(this);
                var form = t.closest('form');

                form.submit();
            }
        });
    });

    function renderAjaxPaginationMessages(data, block)
    {
        for(var i in data){
            var tpl = $('<li class="media m-b-20 p-20 bg-white">' +
                '        <div class="media-body">' +
                '            <h4 class="mt-0 mb-1 n_title" />' +
                '            <div class="n_date text-muted" />' +
                '            <div class="n_body m-t-10" />' +
                '        </div>' +
                '    </li>');

            if(data[i]['STATUS'] == 0){
                tpl.addClass('border border-primary');
            }
            tpl.find('.n_title').text(data[i]['NOTE_TITLE']).attr('href', '/news/' + data[i].NOTE_ID);
            tpl.find('.n_date').text(data[i]['NOTE_DATE']);
            tpl.find('.n_body').html(data[i]['NOTE_BODY']);
            block.append(tpl);
        }
    }
</script>