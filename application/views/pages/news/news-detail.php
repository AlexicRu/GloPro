<?if(Access::allow('news_news-edit') && ($detail['AGENT_ID'] != 0 || ($detail['AGENT_ID'] == 0 && $user['AGENT_ID'] == 0))){?>
    <div class="text-right m-b-30">
        <a href="#" class="<?=Text::BTN?> btn-outline-primary" data-toggle="modal" data-target="#news_edit"><i class="fa fa-pencil-alt"></i> Редактировать новость</a>
    </div>
<?}?>

<h2><?if($detail['AGENT_ID'] == 0){?><i class="fal fa-user fa-lg"></i> <?}?><?=$detail['TITLE']?></h2>

<div class="p-20 bg-white">
    <div class="text-muted m-b-10"><?=$detail['DATE_CREATE_WEB']?></div>
    <?if(!empty($detail['PICTURE'])){?>
        <div class="n_img_detail m-b-20"><img src="<?=$detail['PICTURE']?>"></div>
    <?}?>
    <div class="n_body">
        <?=$detail['CONTENT']?>
    </div>
</div>

<?if(Access::allow('news_news-edit')){?>
    <?=$popupNewsEdit?>
<?}?>