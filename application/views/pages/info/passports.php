<div class="card-columns">
    <?foreach ($files as $block) {?>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><span class="lstick"></span><?=$block['title']?></h3>

                <?foreach ($block['items'] as $file) {?>
                    <a href="<?=$file['file']?>" class="info__item row pt-3 pb-3 border-bottom align-items-center hover-bg" target="_blank">
                        <div class="col-2 text-center">
                            <span class="<?=$file['icon']?>"></span>
                        </div>
                        <div class="col-10 col-xxl-8"><?=$file['name']?></div>
                        <div class="col-xxl-2 hidden-xl-down text-right">
                            <i class="far fa-download info__item-icon"></i>
                        </div>
                    </a>
                <?}?>
            </div>
        </div>
    <?}?>
</div>