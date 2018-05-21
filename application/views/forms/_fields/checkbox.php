<span class="form_field" field="<?=$type?>">
    <input type="checkbox" class="custom_field filled-in chk-col-purple" name="<?=$name?>" id="field<?=$name?>"
        <?=(isset($params['weight']) ? 'weight="'.$params['weight'].'"' : '')?>
    >
    <label for="field<?=$name?>"></label>
</span>
<script>
    $(function () {
        $('[name=<?=$name?>]').each(function () {
            renderCheckbox($(this));
        });
    });
</script>