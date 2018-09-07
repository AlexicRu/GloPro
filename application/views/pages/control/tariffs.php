<div class="card">
    <div class="card-body border-bottom d-lg-none">
        <div class="row">
            <div class="col-12">
                <span class="btn btn-info" toggle_class="tariffs_list">
                    <i class="fa fa-bars"></i> <span class="d-none d-sm-inline-block">Список тарифов</span>
                </span>
            </div>
        </div>
    </div>

    <div class="vtabs customvtab tabs_tariffs tabs-floating">
        <ul class="nav nav-tabs tabs-vertical p-t-10" role="tablist" toggle_block="tariffs_list">
            <li class="nav-item no_content before_scroll">
                <form class="p-r-10 p-l-10 p-b-10 border-bottom m-b-10">
                    <input type="text" name="filter[search]" class="form-control input_messages" placeholder="Поиск..." value="<?=(empty($filter['search']) ? '' : $filter['search'])?>">
                </form>
            </li>

            <div class="v-scroll">
                <li class="nav-item no_content" tab="tariff-1">
                    <a class="nav-link nowrap" href="#tariff-1" data-toggle="tab"><i class="fa fa-plus"></i> Добавить тариф</a>
                </li>
                <?if(empty($tariffs)){?>
                    <li class="nav-item">
                        <a class="nav-link nowrap" href="#">
                            <span class="text-muted">Тарифы не найдены</span>
                        </a>
                    </li>
                <?}else{?>
                    <?foreach($tariffs as $key => $tariff){?>
                        <li class="nav-item" tab="tariff<?=$tariff['TARIF_ID']?>" version="<?=$tariff['LAST_VERSION']?>">
                            <a class="nav-link nowrap" data-toggle="tab" href="#tariff<?=$tariff['TARIF_ID']?>" role="tab">
                                <span class="text-muted">[<?=$tariff['TARIF_ID']?>]</span>
                                <?=$tariff['TARIF_NAME']?>
                            </a>
                        </li>
                    <?}?>
                <?}?>

            </div>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane" id="tariff-1" role="tabpanel"></div>
            <?if(!empty($tariffs)){?>
                <?foreach($tariffs as $key => $tariff){?>
                    <div class="tab-pane" id="tariff<?=$tariff['TARIF_ID']?>" role="tabpanel"></div>
                <?}?>
            <?}?>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.tabs_tariffs :not(.before_scroll) .nav-link').on('click', function(){
            var t = $(this);

            loadTariff(t);

            //костыль.. так как вложенность табов не сохраняется из-за постраничности
            $('.tabs_tariffs > .nav-tabs .nav-link.active').not(t).removeClass('active show');
        });

        $('.tabs_tariffs .nav-item:not(.before_scroll):not(.no_content):first .nav-link').click();
    });

    function loadTariff(t, force)
    {
        var tab = t.closest('[tab]');
        var tabsBlock = $(".tabs_tariffs");
        var tariffId = tab.attr('tab').replace('tariff', '');
        var tabContent = $(t.attr('href'), tabsBlock);

        if(tabContent.text() == '' || force == true){
            tabContent.empty().parent().addClass('block_loading');

            $.post('/control/load-tariff/' + tariffId, { version: tab.attr('version') }, function(data){
                tabContent.html(data).parent().removeClass('block_loading');
                renderVerticalTabsScroll($('.tabs_tariffs .v-scroll'));
            });
        } else {
            setTimeout(function () {
                renderVerticalTabsScroll($('.tabs_tariffs .v-scroll'));
            }, 100);
        }
    }
</script>