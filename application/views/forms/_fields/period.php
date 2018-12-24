<span class="form_field row" field="<?=$type?>">
    <div class="col-xl-6">
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">от</span></div>
            <input type="date" name="<?= $name ?>_start" class="form-control" value="<?= date('Y-m-01') ?>">
        </div>
    </div>
    <div class="col-xl-6 with-mt">
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">до</span></div>
            <input type="date" name="<?= $name ?>_end" class="form-control" value="<?= date('Y-m-d') ?>">
        </div>
    </div>
</span>