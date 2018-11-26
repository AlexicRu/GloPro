<div class="global_messages">
    <?foreach ($globalMessages as $message){?>
        <div class="news_elem">
            <div class="n_title"><?=$message['NOTE_TITLE']?></div>
            <div class="n_date gray"><?=$message['NOTE_DATE']?></div>
            <?=$message['NOTE_BODY']?>
        </div>
    <?}?>
</div>

<div class="center">
    <span class="<?=Text::BTN?> btn-warning" onclick="globalMessagesMarkAsRead($(this))"><i class="fa fa-check"></i> Закрыть</span>
</div>

<script>
    function globalMessagesMarkAsRead() {
        //$.post('/messages/make-read', {type: <?=Model_Note::NOTE_TYPE_POPUP?>}, function () {
            modalClose();
        //})
    }
</script>