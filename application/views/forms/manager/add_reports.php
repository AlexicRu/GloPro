<div class="modal-body">
    <div class="reports_list_autocomplete_block items_list_autocomplete_block">
        <div class="input-group m-b-10">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Начните вводить название отчета" onkeyup="loadReportList($(this))">
        </div>

        <div class="found_items_list"></div>
        <div class="selected_items_list"></div>
    </div>


</div>
<div class="modal-footer">
    <span class="<?=Text::BTN?> btn-primary" onclick="submitForm($(this), managerAddReports)"><i class="fa fa-plus"></i> Добавить</span>
    <button type="button" class="<?=Text::BTN?> btn-danger" data-dismiss="modal"><i class="fa fa-times"></i><span class="hidden-xs-down"> Отмена</span></button>
</div>