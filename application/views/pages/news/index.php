<?if(Access::allow('news_news-edit', true)){?>
<div class="text-right m-b-30">
    <a href="#" class="<?=Text::BTN?> btn-outline-primary" data-toggle="modal" data-target="#news_edit"><i class="fa fa-plus"></i> Добавить новость</a>
</div>
<?}?>

<ul class="ajax_block_news_out list-unstyled m-b-0"></ul>


<?if(Access::allow('news_news-edit', true)){?>
    <?=$popupNewsAdd?>
<?}?>

<script>
    $(function(){
        paginationAjax('/news/', 'ajax_block_news', renderAjaxPaginationNews);
    });

    function renderAjaxPaginationNews(data, block)
    {
        for(var i in data){
            var tpl = $('<li class="media m-b-20 p-20 bg-white">' +
                '        <div class="mr-3 n_img" />' +
                '        <div class="media-body">' +
                '            <h4 class="mt-0 mb-1 n_title"><a /></h4>' +
                '            <div class="n_date text-muted" />' +
                '            <div class="n_body m-t-10 m-b-20" />' +
                '            <div class="n_link"><a class="'+ BTN +' btn-outline-primary">Читать подробнее</a></div>' +
                '        </div>' +
                '    </li>');

            if(data[i]['MANAGER_WHO_CREATE'] == 0){
                tpl.find('.n_title').prepend('<i class="fal fa-user fa-lg m-r-5"></i> ');
            }
            tpl.find('.n_title a').text(data[i]['NOTE_TITLE']).attr('href', '/news/' + data[i].NOTE_ID);
            tpl.find('.n_date').text(data[i]['NOTE_DATE']);
            tpl.find('.n_link a').attr('href', '/news/' + data[i].NOTE_ID);
            tpl.find('.n_body').html(data[i]['announce']);
            if(data[i].PICTURE) {
                tpl.find('.n_img').css('background-image', 'url('+ data[i].PICTURE +')');
            }else{
                tpl.find('.n_img').remove();
            }
            block.append(tpl);
        }
    }
</script>