<!-- sample modal content -->
<div id="<?=$popupId?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
     <?=(!empty($backdrop) ? 'data-backdrop="' . $backdrop . '"' : '')?>
>
    <div class="modal-dialog <?=(!empty($popupClass) ? $popupClass : '')?>">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?=$popupHeader?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <?=$popupBody?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->