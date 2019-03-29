<!-- Nav tabs -->
<ul class="nav nav-tabs customtab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#feedback" role="tab">
            <i class="far fa-comments fa-lg"></i> <span class="hidden-xs-down m-l-5">Обратная связь</span>
        </a>
    </li>
    <?if (!empty($files)){?>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#documents" role="tab">
            <i class="far fa-file-alt fa-lg"></i> <span class="hidden-xs-down m-l-5">Документы</span>
        </a>
    </li>
    <?}?>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="feedback" role="tabpanel">
        <div class="p-20 bg-white">
            <?=$feedbackForm?>
        </div>
    </div>

    <?if (!empty($files)){?>
    <div class="tab-pane pt-3" id="documents" role="tabpanel">
        <div class="card-columns">
        <?foreach ($files as $block) {?>
            <div class="card">
                <div class="card-body">
                    <h2><?=$block['title']?></h2>

                    <?foreach ($block['items'] as $file) {?>
                        <a href="<?=$file['file']?>" class="info__item row pt-3 pb-3 border-bottom align-items-center hover-bg" target="_blank">
                            <div class="col-2 text-center">
                                <span class="<?=$file['icon']?>"></span>
                            </div>
                            <div class="col-10 col-xxl-8"><?=$file['name']?></div>
                            <div class="col-xxl-2 hidden-xl-down text-right">
                                <i class="fa fa-download info__item-icon"></i>
                            </div>
                        </a>
                    <?}?>
                </div>
            </div>
        <?}?>
        </div>
    </div>
    <?}?>
</div>