<script src="<?=Common::getAssetsLink() . 'js/clients/cards.js'?>"></script>


<div class="card-body border-bottom">
    <div class="row font-20 align-items-center">
        <div class="col-xl-4 col-xxl-2">
            <span class="text-muted">Всего карт:</span>
            <?/* todo php7?><a href="#" onclick="cardsFilter('all')"><?=($cardsCounter['ALL_CARDS'] ?? 0)?></a><?*/?>
            <a href="#" onclick="cardsFilter('all')"><?=(!empty($cardsCounter['ALL_CARDS']) ? $cardsCounter['ALL_CARDS'] : 0)?>
        </div>
        <div class="col-xl-4 col-xxl-2">
            <span class="text-muted">В работе:</span>
            <?/* todo php7?><a href="#" onclick="cardsFilter('work')" class="cards_cnt_in_work"><?=($cardsCounter['CARDS_IN_WORK'] ?? 0)?></a><?*/?>
            <a href="#" onclick="cardsFilter('work')" class="cards_cnt_in_work"><?=(!empty($cardsCounter['CARDS_IN_WORK']) ? $cardsCounter['CARDS_IN_WORK'] : 0)?></a>
        </div>
        <div class="col-xl-4 col-xxl-2">
            <span class="text-muted">В блоке:</span>
            <?/* todo php7?><a href="#" onclick="cardsFilter('disabled')" class="cards_cnt_blocked"><?=($cardsCounter['CARDS_NOT_WORK'] ?? 0)?></a><?*/?>
            <a href="#" onclick="cardsFilter('disabled')" class="cards_cnt_in_work"><?=(!empty($cardsCounter['CARDS_NOT_WORK']) ? $cardsCounter['CARDS_NOT_WORK'] : 0)?></a>
        </div>
        <div class="col-xl-6 col-xxl-3 with-mt">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-sort-amount-up"></i></span>
                </div>
                <select class="custom-select" name="cards-sort" onchange="cardsFilter();">
                    <option way="desc" sort="card">Номер карты &downarrow;</option>
                    <option way="asc" sort="card">Номер карты &uparrow;</option>
                    <option way="desc" sort="holder">Держатель &downarrow;</option>
                    <option way="asc" sort="holder">Держатель &uparrow;</option>
                    <?/* todo #985?>
                    <option way="desc" sort="change">Дата использования &downarrow;</option>
                    <option way="asc" sort="change">Дата использования &uparrow;</option>
                    <?*/?>
                </select>
            </div>
        </div>
        <div class="col-xl-6 col-xxl-3 with-mt">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control cards_search" placeholder="Поиск..." value="<?=(!empty($params['query']) ? $params['query'] : '')?>">
            </div>
        </div>
    </div>
</div>

<div class="card-body border-bottom d-lg-none">
    <div class="row">
        <div class="col-4">
            <span class="<?=Text::BTN?> btn-info" toggle_class="card_list"><i class="fa fa-bars"></i> <span class="d-none d-sm-inline-block">Список карт</span></span>
        </div>
        <div class="col-8 text-right">
            <?if(Access::allow('clients_card-add')){?>
                <a class="<?=Text::BTN?> btn-outline-primary" href="#" data-toggle="modal" data-target="#card_add"><i class="fa fa-plus"></i> Добавить карту</a>
            <?}?>
        </div>
    </div>
</div>

<div class="vtabs customvtab tabs_cards tabs-floating">
    <ul class="nav nav-tabs tabs-vertical bg-light p-t-10" role="tablist" toggle_block="card_list">
        <?if(Access::allow('clients_card-add')){?>
            <li class="nav-item no_content d-none d-md-block before_scroll">
                <a class="nav-link nowrap" href="#" data-toggle="modal" data-target="#card_add"><i class="fa fa-plus"></i> Добавить карту</a>
            </li>
        <?}?>
        <?include('cards/list.php')?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content"></div>
</div>

<?if(Access::allow('clients_card-add')){?>
    <?=$popupCardAdd?>
<?}?>