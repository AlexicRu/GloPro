<div class="card">
    <div class="card-body border-bottom d-lg-none">
        <div class="row">
            <div class="col-12">
                <span class="<?=Text::BTN?> btn-outline-info" toggle_class="tariffs_list">
                    <i class="fa fa-bars"></i> <span class="d-none d-sm-inline-block">Список тарифов</span>
                </span>
            </div>
        </div>
    </div>

    <div class="vtabs customvtab tabs_tariffs tabs-floating">
        <ul class="nav nav-tabs tabs-vertical bg-light p-t-10" role="tablist" toggle_block="tariffs_list">
            <li class="nav-item no_content before_scroll">
                <form class="p-r-10 p-l-10 p-b-10 border-bottom m-b-10">
                    <input type="text" name="filter[search]" class="form-control input_messages" placeholder="Поиск..." value="<?=(empty($filter['search']) ? '' : $filter['search'])?>">
                </form>
            </li>

            <div class="v-scroll">
                <li class="nav-item no_content" tab="tariff_-1">
                    <a class="nav-link nowrap" href="#tariff_-1" data-toggle="tab"><i class="fa fa-plus"></i> Добавить тариф</a>
                </li>
                <?if(empty($tariffs)){?>
                    <li class="nav-item">
                        <a class="nav-link nowrap" href="#">
                            <span class="text-muted">Тарифы не найдены</span>
                        </a>
                    </li>
                <?}else{?>
                    <?foreach($tariffs as $key => $tariff){?>
                        <li class="nav-item" tab="tariff_<?=$tariff['TARIF_ID']?>" version="<?=$tariff['LAST_VERSION']?>">
                            <a class="nav-link" data-toggle="tab" href="#tariff_<?=$tariff['TARIF_ID']?>" role="tab">
                                <?=$tariff['TARIF_NAME']?>
                                <span class="text-muted float-right">[<?=$tariff['TARIF_ID']?>]</span>
                            </a>
                        </li>
                    <?}?>
                <?}?>

            </div>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane" id="tariff_-1" role="tabpanel"></div>
            <?if(!empty($tariffs)){?>
                <?foreach($tariffs as $key => $tariff){?>
                    <div class="tab-pane" id="tariff_<?=$tariff['TARIF_ID']?>" role="tabpanel"></div>
                <?}?>
            <?}?>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.tabs_tariffs :not(.before_scroll) .nav-link').on('click', function(){
            var t = $(this);

            loadTariff(t.closest('[tab]').attr('tab').replace('tariff_', ''));

            //костыль.. так как вложенность табов не сохраняется из-за постраничности
            $('.tabs_tariffs > .nav-tabs .nav-link.active').not(t).removeClass('active show');
        });

        $('.tabs_tariffs .nav-item:not(.before_scroll):not(.no_content):first .nav-link').click();
    });
</script>