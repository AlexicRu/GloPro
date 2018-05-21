<span class="form_field row" field="<?=$type?>">
    <div class="col-md-5">
        <input type="date" name="<?=$name?>_start" class="form-control" value="<?=date('Y-m-01')?>">
    </div>
    <div class="col-md-2 text-center hidden-sm-down">-</div>
    <div class="col-md-5 with-mb">
        <input type="date" name="<?=$name?>_end" class="form-control" value="<?=date('Y-m-d')?>">
    </div>
</span>