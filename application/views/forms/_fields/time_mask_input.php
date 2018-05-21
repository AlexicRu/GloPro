<span class="form_field" field="<?=$type?>">
    <input type="text" class="time_mask_input custom_field form-control" name="<?=$name?>" placeholder="__:__:__">
</span>

<script>
    $(function () {
        $('[name=<?=$name?>]').mask('00:00:00');
    });
</script>