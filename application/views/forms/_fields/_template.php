<?
$withDepend = false;
$hiddenDepend = false;

if (isset($params['depend_on'])) {
    $withDepend = true;
}

if ($withDepend) {?>
    <!-- depend render START -->
    <div class="with_depend">

        <div class="depend_to">
            <?
            $data = [
                'placeholder' => !empty($params['depend_on']['placeholder']) ? $params['depend_on']['placeholder'] : 'Поиск...',
                'depend_to' => $name
            ];

            $valueDepend = false;
            if (!empty($params['depend_values'][$params['depend_on']['param']])) {
                $valueDepend = $params['depend_values'][$params['depend_on']['param']];
                $data['hidden'] = true;
                $data['depend_values'] = $params['depend_values'];
            }

            $dependPostfix = '';
            if (!empty($params['depend_postfix'])) {
                $dependPostfix = $params['depend_postfix'];
                $data['depend_postfix'] = $params['depend_postfix'];
            }

            $params['depend_on']['name'] = (!empty($params['depend_on']['name']) ? $params['depend_on']['name'] : $params['depend_on']['field']) . $dependPostfix;
            ?>
            <?=Form::buildField($params['depend_on']['field'], $params['depend_on']['name'], $valueDepend, $data)?>
        </div>

        <div class="depend_on">
<?}?>

            <!-- combobox render START -->
            <span class="form_field" field="<?=$type?>">
                <input type="<?=(!empty($params['hidden']) ? 'hidden' : 'text')?>"
                       autocomplete="off"
                       name="<?=$name?>"
                       url="<?=$params['url']?>"
                       class="form-control custom_field combobox <?=(!empty($params['multi']) ? 'combobox_multi' : '')?> <?=(!empty($params['classes']) ? $params['classes'] : '')?>"
                       placeholder="<?=(!empty($params['placeholder']) ? $params['placeholder'] : 'Поиск...')?>"
                       <?if (isset($params['weight'])){?>weight="<?=$params['weight']?>"<?}?>
                       <?if (!empty($params['depend_to'])){?>depend_to="<?=$params['depend_to']?>"<?}?>
                       <?if (!empty($params['depend_on']['name'])){?>depend_on="<?=$params['depend_on']['name']?>"<?} /*for info, not used*/?>
                >
            </span>
            <!-- combobox render END -->

<?if ($withDepend) {?>
        </div>
    </div>
    <!-- depend render END -->
<?}?>

<script>
    $(function () {
        $('[name=<?=$name?>]').each(function () {
            var t = $(this);

            <?if (!empty($params['multi'])) {?>
                renderComboBoxMulti(t, <?=json_encode($params)?>);
            <?}else{?>
                renderComboBox(t, <?=json_encode($params)?>);
            <?}?>
            <?if (!empty($value)) {?>
                setFormFieldValue(t.parent(), '<?=$value?>');
            <?}?>
        });
    });
</script>