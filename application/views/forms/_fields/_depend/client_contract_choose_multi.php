<span class="form_field" field="<?=$type?>">
    <input type="text" name="<?=$name?>" class="custom_field combobox combobox_multi input_wide <?=(!empty($params['classes']) ? $params['classes'] : '')?>" autocomplete="off"
        <?=(!empty($params['placeholder']) ? 'placeholder="'.$params['placeholder'].'"' : '')?>
        <?=(isset($params['weight']) ? 'weight="'.$params['weight'].'"' : '')?>
        depend_on="<?=$params['depend_on']?>"
        url="/help/list_clients_contracts">
</span>

<script>
    $(function () {
        $('[name=<?=$name?>]').each(function () {
            renderComboBoxMulti($(this), JSON.stringify({'depend_on': {'name': 'client_id', 'field': '<?=$params['depend_on']?>'}}));
        });
    });
</script>