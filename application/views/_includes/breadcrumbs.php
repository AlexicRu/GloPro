<div class="row page-titles">
    <div class="col-md-7 align-self-center">
        <h1><?=end($title)?></h1>
    </div>
    <div class="col-md-5 align-self-center">
        <ol class="breadcrumb">
            <?foreach ($title as $key => $name) {?>
                <?if ($key == 0) {?>
                    <li class="breadcrumb-item"><a href="/"><?=$name?></a></li>
                <?}else{?>
                    <li class="breadcrumb-item <?=($key == count($title)-1 ? 'active' : '')?>"><i class="fa fa-chevron-right"></i> <?=$name?></li>
                <?}?>
            <?}?>
        </ol>
    </div>
</div>
