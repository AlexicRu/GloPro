<div class="pb-3 text-right">
    <a href="#" data-toggle="modal" data-target="#info_add_element"
       class="<?= Text::BTN ?> btn-outline-primary m-b-5"><i class="fa fa-plus"></i> Добавить элемент</a>
</div>

<?= $popupInfoAddElement ?>

<div class="card-columns">
    <? foreach ($files as $blockId => $block) { ?>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title dropdown-float">
                    <span class="lstick"></span><?= $block['NAME'] ?>

                    <div class="dropdown">
                        <span id="infoElem<?= $blockId ?>" class="btn <?= Text::BTN ?> btn-light"
                              data-toggle="dropdown">
                            <i class="far fa-ellipsis-v"></i>
                        </span>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="infoElem<?= $blockId ?>">
                            <span class="dropdown-item asLink"
                                  onclick="editInfoElem(<?= $block['ID'] ?>, '<?= $block['NAME'] ?>', 1, <?= $block['CATEGORY_ID'] ?>, <?= $block['SORT'] ?>)"><i
                                        class="far fa-pen fa-fw text-primary"></i> Редактировать</span>

                            <? if (empty($block['children'])) { ?>
                                <span class="dropdown-item asLink"
                                      onclick="deleteInfoElem(<?= $block['ID'] ?>, '<?= $block['NAME'] ?>', $(this), true)"><i
                                            class="far fa-trash-alt fa-fw text-danger"></i> Удалить</span>
                            <? } ?>
                        </div>
                    </div>
                </h3>

                <? if (!empty($block['children'])) { ?>
                    <? foreach ($block['children'] as $fileId => $file) { ?>
                        <div class="row border-bottom align-items-center hover-bg pt-3 pb-3 info__item">
                            <div class="col-2 text-center">
                                <span class="<?= $file['icon'] ?>"></span>
                            </div>
                            <div class="col-10 col-xxl-8">
                                <a href="<?= $file['FILE_PATH'] ?>" target="_blank"><?= $file['NAME'] ?></a>
                            </div>
                            <div class="col-xxl-2 hidden-xl-down text-right">
                                <div class="dropdown info__item-icon">
                                    <span id="infoElem<?= $blockId ?>-<?= $fileId ?>"
                                          class="btn <?= Text::BTN ?> btn-light" data-toggle="dropdown">
                                        <i class="far fa-ellipsis-v"></i>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="infoElem<?= $blockId ?>-<?= $fileId ?>">
                                        <a class="dropdown-item" href="<?= $file['FILE_PATH'] ?>" target="_blank">
                                            <i class="far fa-download fa-fw text-warning"></i> Скачать
                                        </a>
                                        <span class="dropdown-item asLink"
                                              onclick="editInfoElem(<?= $file['ID'] ?>, '<?= $file['NAME'] ?>', 0, <?= $file['CATEGORY_ID'] ?>, <?= $file['SORT'] ?>)"><i
                                                    class="far fa-pen fa-fw text-primary"></i> Редактировать</span>
                                        <span class="dropdown-item asLink"
                                              onclick="deleteInfoElem(<?= $file['ID'] ?>, '<?= $file['NAME'] ?>', $(this))"><i
                                                    class="far fa-trash-alt fa-fw text-danger"></i> Удалить</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                <? } ?>
            </div>
        </div>
    <? } ?>
</div>

<script>
    function editInfoElem(elemId, name, isCategory, categoryId, sort) {
        var modal = $('#info_add_element');

        modal.find('[name=add_info_element_id]').val(elemId);
        modal.find('[name=add_info_element_name]').val(name);
        modal.find('[name=add_info_element_sort]').val(sort);
        modal.find('[name=add_info_element_is_category]').prop('checked', isCategory);
        modal.find('[name=add_info_element_category_id] option[value=' + categoryId + ']').prop('selected', true);

        modal.modal('show');
    }

    function deleteInfoElem(elemId, name, btn, isCategory) {
        if (isCategory == true) {
            if (btn.closest('.card-body').find('.info__item').length) {
                message(0, 'Раздел содержит файлы. Удаление отменено');
                return false;
            }
        }

        if (!confirm('Удалить ' + name + '?')) {
            return false;
        }

        $.post('/info/delete-element', {id: elemId}, function (data) {
            if (data.success) {
                message(1, 'Элемент успешно удален');

                if (isCategory == true) {
                    btn.closest('.card').remove();
                } else {
                    btn.closest('.info__item').remove();
                }
            } else {
                message(0, 'Ошибка удаления');
            }
        });
    }
</script>