<div class="card">
    <div class="card-body border-bottom d-lg-none">
        <div class="row">
            <div class="col-4">
                <span class="<?=Text::BTN?> btn-outline-info" toggle_class="manager_list">
                    <i class="fa fa-bars"></i> <span class="d-none d-sm-inline-block">Список менеджеров</span>
                </span>
            </div>
            <div class="col-8 text-right">
                <a class="<?=Text::BTN?> btn-outline-primary" href="#" data-toggle="modal" data-target="#manager_add"><i class="fa fa-plus"></i> Добавить <span class="d-none d-sm-inline-block">менеджера</span></a>
            </div>
        </div>
    </div>


    <div class="vtabs customvtab tabs_managers tabs-floating">
        <ul class="nav nav-tabs tabs-vertical bg-light p-t-10" role="tablist" toggle_block="manager_list">
            <li class="nav-item no_content before_scroll">
                <form class="p-r-10 p-l-10 p-b-10 border-bottom m-b-10">
                    <input type="text" name="filter[search]" class="form-control input_messages" placeholder="Поиск..." value="<?=(empty($filter['search']) ? '' : $filter['search'])?>">

                    <div class="m-t-5 m-b-5">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="filter[only_managers]" value="1" <?=(empty($filter['only_managers']) ? '' : 'checked')?>>
                            <span class="custom-control-label">Только менеджеры</span>
                        </label>
                    </div>
                    <button class="<?=Text::BTN?> btn-primary btn-sm">Применить</button>
                </form>
            </li>

            <li class="nav-item no_content d-none d-md-block before_scroll">
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
                            <a class="nav-link" data-toggle="tab" href="#manager<?=$manager['MANAGER_ID']?>" role="tab">
                                <?=$manager['M_NAME']?>
                                <span class="text-muted float-right">[<?=$manager['MANAGER_ID']?>]</span>
                            </a>
                        </li>
                    <?}?>
                <?}?>

            </div>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-0">
            <?if(!empty($managers)){?>
                <?foreach($managers as $key => $manager){?>
                    <div class="tab-pane" id="manager<?=$manager['MANAGER_ID']?>" role="tabpanel"></div>
                <?}?>
            <?}?>
        </div>
    </div>
</div>

<?=$popupManagerAdd?>
<?=$popupManagerAddClients?>
<?=$popupManagerAddReports?>

<script>
    $(function(){
        $('.tabs_managers :not(.before_scroll) .nav-link').on('click', function(){
            var t = $(this);

            loadManager(t);

            //костыль.. так как вложенность табов не сохраняется из-за постраничности
            $('.tabs_managers > .nav-tabs .nav-link.active').not(t).removeClass('active show');
        });

        $('.tabs_managers .nav-item:not(.before_scroll):first .nav-link').click();
    });
    
    function loadManager(t, force)
    {
        var tab = t.closest('[tab]');
        var tabsBlock = $(".tabs_managers");
        var managerId = tab.attr('tab').replace('manager', '');
        var tabContent = $(t.attr('href'), tabsBlock);

        if(tabContent.text() == '' || force == true){
            addLoader(tabContent.parent());

            $.post('/control/manager/' + managerId, {}, function(data){
                removeLoader(tabContent.parent());
                tabContent.html(data);
                renderVerticalTabsScroll($('.tabs_managers .v-scroll'));
            });
        } else {
            setTimeout(function () {
                renderVerticalTabsScroll($('.tabs_managers .v-scroll'));
            }, 100);
        }
    }
</script>