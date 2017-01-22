<span class="form_field" field="<?=$type?>">
    <input type="text" name="<?=$name?>" class="combobox input_wide <?=(!empty($params['classes']) ? $params['classes'] : '')?>" autocomplete="off"
        <?=(!empty($params['placeholder']) ? 'placeholder="'.$params['placeholder'].'"' : '')?>
        url="/help/list_suppliers_contracts">
</span>

<script>
    $(function () {
        $('[name=<?=$name?>]').each(function () {
            renderComboBox($(this), {'depend_on': {'name': 'supplier_id', 'field': '<?=$params['depend_on']?>'}});
        });
    });
</script>