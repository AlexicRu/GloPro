<div class="ajax_block_cards_list_out"></div>

<script>
    var cardsIcons = {};

    <?foreach (Model_Card::$cardIcons as $template => $icon) {?>
    cardsIcons['<?=$template?>'] = '<?=$icon?>';
    <?}?>

    var findCard = getUrlParameter('card');
    var foundCard = false;

    $(function () {
        cardsReload();

        $(".cards_search").on('keypress', function(e){
            cardsFilter();
        });
    });

    function renderAjaxPaginationCardsList(data, block)
    {
        var firstLoad = block.find('.nav-item:not(.no_content)').length;

        var contentBlock = block.closest('.tabs_cards').find('.tab-content');

        for (var i in data) {
            var tpl = $('<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#card'+ data[i].CARD_ID +'" role="tab"><span class="nowrap" /></a></li>');

            if (cardsIcons[data[i].CARD_TEMPLATE]) {
                tpl.find('span').prepend('<span class="card__picture m-r-10" style="background-image: url(<?=Common::getAssetsLink()?>img/cards/'+ cardsIcons[data[i].CARD_TEMPLATE] +')"></span>');
            } else {
                tpl.find('span').prepend('<i class="fa fa-credit-card-front m-r-10"></i>');
            }

            tpl.attr('tab', data[i].CARD_ID);
            tpl.find('.nowrap').append(data[i].CARD_ID);
            if (data[i].HOLDER) {
                tpl.find('a').append('<div><small holder>' + data[i].HOLDER + '</small></div>');
            }

            if (data[i].CARD_STATE == <?=Model_Card::CARD_STATE_BLOCKED?>) {
                tpl.find('a').append('<div><span class="label label-danger label_small"><i class="fa fa-lock-alt"></i></span></div>');
            }

            tpl.find('a').on('click', function () {
                var t = $(this);

                //костыль.. так как вложенность табов не сохраняется из-за постраничности
                $('.nav-link.active', block).not(t).removeClass('active show');

                cardLoad(t.closest('.nav-item').attr('tab'));

                $('.tabs_cards .tabs-floating .nav-tabs').removeClass('active');

                t.tab('show');

                if ($(t.attr('href')).not(':empty')) {
                    renderVerticalTabsScroll(t.closest('.ajax_pagination'));
                }

                return false;
            });

            tpl.appendTo(block);

            contentBlock.append('<div class="tab-pane" id="card'+ data[i].CARD_ID +'" role="tabpanel" />');

            if (findCard == data[i].CARD_ID) {
                foundCard = true;
            }
        }

        if (findCard) {
            if (!foundCard) {
                block.parent().find('.ajax_block_load').click();
            } else {
                block.find('.nav-item[tab="'+ findCard +'"] a').click();
            }
        } else if (!firstLoad) {
            block.find('.nav-item:not(.no_content):first a').click();
        }
    }
</script>