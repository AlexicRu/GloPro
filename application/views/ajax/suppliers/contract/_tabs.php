<!-- Nav tabs -->
<ul class="nav nav-tabs customtab">
    <?foreach($tabs as $tabId => $tab){
        if ($tabActive == $tabId) {
            ?><li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="<?=$tab['icon']?>"></i> <span class="hidden-xs-down d-inline-block m-l-5"><?=$tab['name']?></span>
                </a>
            </li><?
        } else {
            ?><li class="nav-item">
                <a class="nav-link <?=($tabActive == $tabId ? 'active' : '')?>" href="#" ajax_tab="contract" onclick="loadSupplierContract('<?=$tabId?>')">
                    <i class="<?=$tab['icon']?>"></i> <span class="hidden-xs-down d-inline-block m-l-5"><?=$tab['name']?></span>
                </a>
            </li><?
        }
    }?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active">
        <div class="bg-white">
            <?=$content?>
        </div>
    </div>
</div>