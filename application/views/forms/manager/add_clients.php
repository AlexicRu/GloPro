<div class="clients_list_autocomplete_block items_list_autocomplete_block">
    <div class="input_out">
        <div class="input_with_icon">
            <i class="icon-find"></i>
            <input type="text" class="input_big" placeholder="Начните вводить имя клиента" onkeyup="loadClientList($(this))">
        </div>
    </div>
    <div class="found_items_list"></div>
    <div class="selected_items_list"></div>

    <div class="right">
        <button class="btn waves-effect waves-light btn_reverse btn_manager_add_clients_go" onclick="managerAddClients($(this))"><i class="fa fa-check"></i> Добавить</button>
        <span class="btn waves-effect waves-light btn_red fancy_close"><i class="fa fa-times"></i> Отмена</span>
    </div>
</div>