<?if(Access::allow('news_news-edit', true) && ($detail['MANAGER_ID'] != 0 || ($detail['MANAGER_ID'] == 0 && $user['MANAGER_ID'] == 0))){?>
    <div class="text-right m-b-30">
        <a href="#" class="<?=Text::BTN?> btn-outline-primary" data-toggle="modal" data-target="#news_edit"><i class="fa fa-pen"></i> Редактировать новость</a>
    </div>
<?}?>

<h2><?if($detail['MANAGER_ID'] == 0){?><i class="fal fa-user fa-lg"></i> <?}?><?=$detail['NOTE_TITLE']?></h2>

<div class="p-20 bg-white">
    <div class="text-muted m-b-10"><?=$detail['NOTE_DATE']?></div>
    <?if(!empty($detail['PICTURE'])){?>
        <div class="n_img_detail m-b-20"><img src="<?=$detail['PICTURE']?>"></div>
    <?}?>
    <div class="n_body">
        <?=$detail['NOTE_BODY']?>
    </div>
</div>

<?if(Access::allow('news_news-edit', true)){?>
    <?=$popupNewsEdit?>
<?}?>