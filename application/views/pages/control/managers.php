<div class="card">
    <div class="card-body border-bottom d-xl-none">
        <div class="row">
            <div class="col-4">
                <span class="btn btn-info" toggle_class="manager_list">
                    <i class="fa fa-bars"></i> <span class="d-none d-sm-inline-block">Список менеджеров</span>
                </span>
            </div>
            <div class="col-8 text-right">
                <a class="<?=Text::BTN?> btn-outline-primary" href="#" data-toggle="modal" data-target="#manager_add"><i class="fa fa-plus"></i> Добавить <span class="d-none d-sm-inline-block">менеджера</span></a>
            </div>
        </div>
    </div>


    <div class="vtabs customvtab tabs_managers">
        <ul class="nav nav-tabs tabs-vertical tabs-floating p-t-10" role="tablist" toggle_block="manager_list">
            <li class="nav-item no_content before_scroll">
                <form class="p-r-10 p-l-10 p-b-10 border-bottom m-b-10">
                    <input type="text" name="filter[search]" class="form-control input_messages" placeholder="Поиск..." value="<?=(empty($filter['search']) ? '' : $filter['search'])?>">

                    <div class="m-t-5 m-b-5">
                        <input id="filter_only_managers" type="checkbox" class="<?=Text::CHECKBOX?>" name="filter[only_managers]" value="1" <?=(empty($filter['only_managers']) ? '' : 'checked')?>>
                        <label for="filter_only_managers">Только менеджеры</label>
                    </div>
                    <button class="<?=Text::BTN?> btn-outline-primary">Применить</button>
                </form>
            </li>

            <li class="nav-item no_content d-none d-xl-block before_scroll">
                <a class="nav-link nowrap" href="#" data-toggle="modal" data-target="#manager_add"><i class="fa fa-plus"></i> Добавить менеджера</a>
            </li>

            <div class="v-scroll">
                <?if(empty($managers)){?>
                    <li class="nav-item">
                        <a class="nav-link nowrap" href="#">
                            <span class="text-muted">Менеджеры не найдены</span>
                        </a>
                    </li>
                <?}else{?>
                    <?foreach($managers as $key => $manager){?>
                        <li class="nav-item" tab="manager<?=$manager['MANAGER_ID']?>">
                            <a class="nav-link nowrap" data-toggle="tab" href="#manager<?=$manager['MANAGER_ID']?>" role="tab">
                                <span class="text-muted">[<?=$manager['MANAGER_ID']?>]</span>
                                <?=$manager['M_NAME']?>
                            </a>
                        </li>
                    <?}?>
                <?}?>

            </div>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?if(!empty($managers)){?>
                <?foreach($managers as $key => $manager){?>
                    <div class="tab-pane" id="manager<?=$manager['MANAGER_ID']?>" role="tabpanel">
                        <?=$key?>
                    </div>
                <?}?>
            <?}?>
        </div>
    </div>
</div>

<?=$popupManagerAdd?>

<script>
    $(function(){
        renderVerticalTabsScroll($('.tabs_managers .v-scroll'));

        $('.tabs_managers :not(.before_scroll) .nav-link').on('click', function(){
            var t = $(this);

            loadManager(t);
        });

        $('.tabs_managers .nav-item:not(.before_scroll):first .nav-link').click();
    });
    
    function loadManager(t, force)
    {
        var tab = t.closest('[tab]');
        var tabsBlock = $(".tabs_managers");
        var managerId = tab.attr('tab').replace('manager', '');
        var tabContent = $("[tab_content=manager"+ managerId +"]", tabsBlock);

        if(tabContent.text() == '' || force == true){
            tabContent.empty().parent().addClass('block_loading');

            $.post('/control/manager/' + managerId, {}, function(data){
                tabContent.html(data).parent().removeClass('block_loading');
            });
        }
    }
</script>