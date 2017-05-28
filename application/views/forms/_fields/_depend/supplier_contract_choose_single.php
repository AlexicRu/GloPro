<span class="form_field" field="<?=$type?>">
    <input type="text" name="<?=$name?>" class="custom_field combobox input_wide <?=(!empty($params['classes']) ? $params['classes'] : '')?>" autocomplete="off"
        <?=(!empty($params['placeholder']) ? 'placeholder="'.$params['placeholder'].'"' : '')?>
        <?=(!isset($params['weight']) ? 'weight="'.$params['weight'].'"' : '')?>
        depend_on="<?=$params['depend_on']?>"
        url="/help/list_suppliers_contracts">
</span>

<script>
    $(function () {
        $('[name=<?=$name?>]').each(function () {
            renderComboBox($(this), {'depend_on': {'name': 'supplier_id', 'field': '<?=$params['depend_on']?>'}});
        });
    });
</script>