<div class="modal-body">
    <form class="form form_news_add">
        <?if(!empty($detail['NEWS_ID'])){?>
            <input type="hidden" name="news_edit_id" value="<?=$detail['NEWS_ID']?>">
            <input type="hidden" name="news_edit_image_path" value="<?=$detail['PICTURE']?>">
        <?}?>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down">Заголовок:</div>
                <span class="hidden-sm-up">Заголовок:</span>
            </div>
            <div class="col-sm-8">
                <input type="text" name="news_edit_title" class="form-control" value="<?=(empty($detail['TITLE']) ? '' : $detail['TITLE'])?>">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="text-right hidden-xs-down">Фото:</div>
                <span class="hidden-sm-up">Фото:</span>
            </div>
            <div class="col-sm-8">
                <div class="news_edit_image dropzone"></div>
            </div>
        </div>

        <div class="form-group row m-b-0">
            <div class="col-12">
                <textarea name="news_edit_text"></textarea>
            </div>
        </div>

    </form>
</div>
<div class="modal-footer">
    <?if(!empty($detail['NEWS_ID'])){?>
        <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),goEditNews)"><i class="fa fa-check"></i> Редактировать</span>
    <?}else{?>
        <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this),goEditNews)"><i class="fa fa-plus"></i> Добавить</span>
    <?}?>

    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    var editor = $('[name=news_edit_text]');
    var image = false;
    var dropzone = false;

    $(function(){
        dropzone = new Dropzone('.news_edit_image', {
            url: "/index/upload-file?component=image",
            autoProcessQueue: false,
            addRemoveLinks: true,
            maxFiles: 1,
            success: function(file, response)
            {
                if(response.success){
                    image = response.data.file.file;
                }
            },
            queuecomplete: function ()
            {
                goAddNews();initWYSIWYG
            }
        });

        initWYSIWYG(editor);

        <?if(!empty($detail['NEWS_ID'])){?>
            editor.trumbowyg('html', $('.n_body').html());
        <?}?>
    });

    function goEditNews()
    {
        if(dropzone.getAcceptedFiles().length){
            dropzone.processQueue();
        }else{
            goAddNews();
        }
    }

    function goAddNews()
    {
        var params = {
            id:     $('[name=news_edit_id]').val(),
            title:  $('[name=news_edit_title]').val(),
            text:   editor.trumbowyg('html'),
            image:  image ? image : $('[name=news_edit_image_path]').val()
        };

        if(params.title == ''){
            message(0, 'Введите заголовок новости');
            endSubmitForm();
            return false;
        }

        $.post('/news/news-edit', {params:params}, function(data){
            if(data.success){
                <?if(!empty($detail['NEWS_ID'])){?>
                    message(1, 'Новость успешно отредактированна');
                <?}else{?>
                    message(1, 'Новость успешно добавлена');
                <?}?>
                modalClose();
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            }else{
                <?if(!empty($detail['NEWS_ID'])){?>
                    message(0, 'Ошибка редактирования новости');
                <?}else{?>
                    message(0, 'Ошибка добавления новости');
                <?}?>
            }
            dropzone.removeAllFiles();
            image = false;
            endSubmitForm();
        });
    }
</script>