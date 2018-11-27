<div class="modal-body">

    <div class="global_messages">
        <?
        $id = 0;
        foreach ($globalMessages as $message){?>
            <div class="p-20 <?=(++$id == count($globalMessages) ? 'pb-0' : 'border-bottom')?>">
                <h4 class="mt-0 mb-1 n_title font-weight-bold"><?=$message['NOTE_TITLE']?></h4>
                <div class="n_date text-muted"><?=$message['NOTE_DATE']?></div>
                <div class="n_body m-t-10"><?=$message['NOTE_BODY']?></div>
            </div>
        <?}?>
    </div>

</div>

<div class="modal-footer text-center">
    <span class="<?=Text::BTN?> btn-warning" onclick="globalMessagesMarkAsRead($(this))"><i class="fa fa-check"></i> Закрыть</span>
</div>

<script>
    function globalMessagesMarkAsRead() {
        //$.post('/messages/make-read', {type: <?=Model_Note::NOTE_TYPE_POPUP?>}, function () {
            modalClose();
        //})
    }
</script>