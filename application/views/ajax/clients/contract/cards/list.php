<div class="ajax_block_cards_list_out"></div>

<script>
    var cardsIcons = {};

    <?foreach (Model_Card::$cardIcons as $template => $icon) {?>
    cardsIcons['<?=$template?>'] = '<?=$icon?>';
    <?}?>

    var findCard = getUrlParameter('card');

    $(function () {
        if (findCard) {
            $(".cards_search").val(findCard);
        }

        cardsFilter();

        $(".cards_search").on('keypress', function(e){
            cardsFilter();
        });
    });

    function renderAjaxPaginationCardsList(data, block)
    {
        var firstLoad = block.find('.nav-item:not(.no_content)').length;

        var contentBlock = block.closest('.tabs_cards').find('.tab-content');

        for (var i in data) {
            var tpl = $('<li class="nav-item">' +
                '<a class="nav-link" data-toggle="tab" href="#card'+ data[i].CARD_ID +'" role="tab">' +
                '   <div class="card-tab">' +
                '       <div class="text-center mr-2">' +
                '           <div pic />' +
                '           <div ban />' +
                '       </div>' +
                '       <div>' +
                '           <div card />' +
                '           <div holder class="text-muted font-14" />' +
                '       </div>' +
                '   </div>' +
                '</a>' +
            '</li>');

            if (cardsIcons[data[i].CARD_TEMPLATE]) {
                tpl.find('[pic]').prepend('<span class="card__picture" style="background-image: url(<?=Common::getAssetsLink()?>img/cards/'+ cardsIcons[data[i].CARD_TEMPLATE] +')"></span>');
            } else {
                tpl.find('[pic]').prepend('<i class="far fa-credit-card-front fa-2x align-middle"></i>');
            }

            tpl.attr('tab', data[i].CARD_ID);
            tpl.find('[card]').text(data[i].CARD_ID);
            if (data[i].HOLDER) {
                tpl.find('[holder]').text(data[i].HOLDER);
            }

            if (data[i].CARD_STATE == <?=Model_Card::CARD_STATE_BLOCKED?>) {
                tpl.find('[ban]').append('<span class="mt-1 badge badge-danger"><i class="fa fa-lock-alt"></i></span>');
            }

            tpl.find('a').on('click', function () {
                var t = $(this);

                //костыль.. так как вложенность табов не сохраняется из-за постраничности
                $('.nav-link.active', block).not(t).removeClass('active show');

                cardLoad(t.closest('.nav-item').attr('tab'));

                $('.tabs_cards > .nav-tabs .nav-link.active').removeClass('active');

                t.tab('show');

                if ($(t.attr('href')).not(':empty')) {
                    renderVerticalTabsScroll(t.closest('.ajax_pagination'));
                }

                return false;
            });

            tpl.appendTo(block);

            contentBlock.append('<div class="tab-pane" id="card'+ data[i].CARD_ID +'" role="tabpanel" />');
        }

        block.find('.nav-item:not(.no_content):first a').click();
    }
</script>