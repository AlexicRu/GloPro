<div class="card-body border-bottom d-lg-none">
    <div class="row">
        <div class="col-4">
            <span class="<?=Text::BTN?> btn-outline-info" toggle_class="agreements_list"><i class="fa fa-bars"></i> <span class="hidden-xs-down">Список соглашений</span></span>
        </div>
        <div class="col-8 text-right">
            <?if(Access::allow('suppliers_agreement-add')){?>
                <a class="<?=Text::BTN?> btn-outline-primary" href="#" data-toggle="modal" data-target="#supplier_agreement_add"><i class="fa fa-plus"></i> Добавить соглашение</a>
            <?}?>
        </div>
    </div>
</div>

<div class="vtabs customvtab tabs_agreements tabs-floating">
    <ul class="nav nav-tabs tabs-vertical bg-light p-t-10" role="tablist" toggle_block="agreements_list">
        <?if(Access::allow('suppliers_agreement-add')){?>
            <li class="nav-item no_content d-none d-md-block before_scroll">
                <a class="nav-link nowrap" href="#" data-toggle="modal" data-target="#supplier_agreement_add"><i class="fa fa-plus"></i> Добавить соглашение</a>
            </li>
        <?}?>
        <?foreach($agreements as $key => $agreement){?>
            <li class="nav-item" tab="<?=$agreement['AGREEMENT_ID']?>">
                <a class="nav-link" data-toggle="tab" href="#agreement<?=$agreement['AGREEMENT_ID']?>" role="tab" onclick="loadAgreement($(this))">
                    <span class="fal fa-file-alt fa-lg m-r-5"></span>
                    [<?=$agreement['AGREEMENT_ID']?>] <span class="agreement_name"><?=$agreement['AGREEMENT_NAME']?></span>
                </a>
            </li>
        <?}?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content p-0">
        <?foreach($agreements as $key => $agreement){?>
            <div class="tab-pane" id="agreement<?=$agreement['AGREEMENT_ID']?>" role="tabpanel"></div>
        <?}?>
    </div>
</div>

<?if(Access::allow('suppliers_agreement-add')){?>
    <?=$popupAgreementAdd?>
<?}?>

<script>
    $(function(){
        $(".tabs_agreements .nav-item[tab]:first .nav-link").click();
    });
</script>