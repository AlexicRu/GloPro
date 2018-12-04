<div class="form">
    <div class="form-group row">
        <div class="col-sm-4 col-lg-3 text-muted form__row__title">
            Email для ответов:
        </div>
        <div class="col-sm-8 col-lg-9">
            <input type="text" name="feedback_email" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-4 col-lg-3 text-muted form__row__title">
            Тема сообщения:
        </div>
        <div class="col-sm-8 col-lg-9">
            <input type="text" name="feedback_subject" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-4 col-lg-3 text-muted form__row__title">
            Текст сообщения:
        </div>
        <div class="col-sm-8 col-lg-9">
            <textarea name="feedback_text" class="form-control"></textarea>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-4 col-lg-3 text-muted form__row__title">
            Прикрепленные файлы:
        </div>
        <div class="col-sm-8 col-lg-9">
            <div class="feedback_files dropzone"></div>
            <i class="text-muted">Максимальный размер файлов - 3 MB, максимум файлов - 5 шт</i>
        </div>
    </div>

    <div class="form-group row m-b-0">
        <div class="col-sm-8 offset-sm-4 col-lg-9 offset-lg-3">
            <button class="<?=Text::BTN?> btn-success btn_feedback" onclick="preFeedback($(this))"><i class="fa fa-check"></i> Отправить</button>
        </div>
    </div>
</div>

<script>
    var files = [];
    var dropzone = false;

    $(function () {
        dropzone = new Dropzone('.feedback_files', {
            url: "/index/upload-file",
            autoProcessQueue: false,
            addRemoveLinks: true,
            maxFilesize: 3,
            maxFile: 5,
            success: function(file, response)
            {
                if(response.success){
                    files.push(response.data.file);
                    dropzone.options.autoProcessQueue = true;
                }
            },
            queuecomplete: function ()
            {
                dropzone.options.autoProcessQueue = false;
                doFeedback();
            }
        });
    });

    function preFeedback(btn) {
        addLoader(btn.closest('.form'));

        if(dropzone.getQueuedFiles().length){
            dropzone.processQueue();
        }else{
            doFeedback();
        }
    }

    function doFeedback()
    {
        var btn = $('.btn_feedback');
        var block = btn.closest('.form');
        var params = {
            email:      $('[name=feedback_email]').val(),
            subject:    $('[name=feedback_subject]').val(),
            text:       $('[name=feedback_text]').val(),
            files:      files
        };

        if(params.email == '' || params.email.indexOf('@') == -1){
            message(0, 'Введите корректный email');
            removeLoader(block);
            return false;
        }

        if(params.subject == ''){
            message(0, 'Введите тему сообщения');
            removeLoader(block);
            return false;
        }

        $.post('/support/feedback', params, function(data){
            if(data.success){
                message(1, 'Сообщение успешно добавлено');
            }else{
                message(0, data.data ? data.data : 'Ошибка отправки сообщения');
            }

            dropzone.removeAllFiles();
            files = [];
            $('[name=feedback_email]').val('');
            $('[name=feedback_subject]').val('');
            $('[name=feedback_text]').val('');

            removeLoader(block);
        });
    }

</script>