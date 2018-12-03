<span class="custom-control custom-checkbox form_field" field="<?=$type?>">
    <label>
        <input type="checkbox" class="custom_field custom-control-input" name="<?=$name?>"
            <?=(isset($params['weight']) ? 'weight="'.$params['weight'].'"' : '')?>
        >
        <span class="custom-control-label"></span>
    </label>
</span>