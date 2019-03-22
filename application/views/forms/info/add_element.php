<div class="modal-body">

    <input type="hidden" name="add_info_element_id">

    <div class="form form_add_info_element">
        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Название:
            </div>
            <div class="col-sm-8 with-mt">
                <input type="text" name="add_info_element_name" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Является разделом:
            </div>
            <div class="col-sm-2 with-mt">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="add_info_element_is_category">
                    <span class="custom-control-label"></span>
                </label>
            </div>

            <div class="col-sm-3 text-muted form__row__title with-mt">
                Сортировка:
            </div>
            <div class="col-sm-3 with-mt">
                <input type="text" name="add_info_element_sort" class="form-control" value="100">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 text-muted form__row__title">
                Раздел:
            </div>
            <div class="col-sm-8 with-mt">
                <select name="add_info_element_category_id" class="custom-select">
                    <? foreach ($tree as $leaf) { ?>
                        <option value="<?= $leaf['ID'] ?>">Раздел: <?= $leaf['NAME'] ?></option>
                        <? if (!empty($leaf['children'])) { ?>
                            <optgroup label="подразделы:">
                                <? foreach ($leaf['children'] as $category) { ?>
                                    <option value="<?= $category['ID'] ?>" <?= ($parentCategoryId == $leaf['ID'] ? 'selected' : '') ?>><?= $category['NAME'] ?></option>
                                <? } ?>
                            </optgroup>
                        <? } ?>
                    <? } ?>
                    <? if (Access::allow('can_add_in_root_info_portal')) { ?>
                        <option value="0">-- корневой раздел --</option>
                    <? } ?>
                </select>
                <i class="text-muted font-10">При добавлении раздела внутрь подраздела он не будет отображен</i>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-sm-4 text-muted form__row__title">
                Файл:
            </div>
            <div class="col-sm-8 with-mt">
                <div class="add_info_element_file dropzone"></div>
            </div>
        </div>

    </div>

</div>
<div class="modal-footer">
    <span class="<?= Text::BTN ?> btn-primary" onclick="submitForm($(this), addInfoElementGo)"><i
                class="fa fa-plus"></i> Сохранить</span>
    <button type="button" class="<?= Text::BTN ?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span
                class="hidden-xs-down"> Отмена</span></button>
</div>

<script>
    var infoFile = 0;
    var dropzone = false;
    var modal = false;

    $(function () {
        modal = $('#info_add_element');

        dropzone = new Dropzone('.add_info_element_file', {
            url: "/index/upload-file?component=info",
            autoProcessQueue: false,
            addRemoveLinks: true,
            maxFiles: 1,
            success: function (file, response) {
                if (response.success) {
                    infoFile = response.data.file.file;
                }
            },
            queuecomplete: function () {
                _addInfoElementGo();
            }
        });

        modal.on('hide.bs.modal', function (event) {
            modal.find('[name=add_info_element_id]').val('');
            modal.find('[name=add_info_element_name]').val('');
            modal.find('[name=add_info_element_sort]').val(100);
            modal.find('[name=add_info_element_is_category]').prop('checked', false);
            //сбрасывать выбранный раздел не надо
        })
    });

    function addInfoElementGo() {
        if (dropzone.getAcceptedFiles().length) {
            dropzone.processQueue();
        } else {
            _addInfoElementGo();
        }
    }

    function _addInfoElementGo() {
        var params = {
            id: $('[name=add_info_element_id]').val(),
            name: $('[name=add_info_element_name]').val(),
            category_id: $('[name=add_info_element_category_id]').val(),
            is_category: $('[name=add_info_element_is_category]').is(':checked') ? 1 : 0,
            sort: $('[name=add_info_element_sort]').val(),
            file: infoFile,
        };

        if (params.name == '') {
            message(0, 'Введите название элемента');
            endSubmitForm();
            return false;
        }

        $.post('/info/edit-element', {params: params}, function (data) {
            endSubmitForm();

            if (data.success) {
                message(1, 'Элемент успешно добавлен. Для отображения обновите страницу.');
                modalClose();
            } else {
                message(0, 'Ошибка добавления элемента');
            }
            dropzone.removeAllFiles();
            file = false;
        });
    }
</script>