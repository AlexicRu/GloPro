<script src="<?=Common::getAssetsLink()?>js/reports/reports.js"></script>

<?if(empty($reports)){?>
    <div class="error_block text-center p-5">Нет доступных отчетов</div>
<?}else{?>

    <div class="card-body border-bottom d-lg-none">
        <div class="row">
            <div class="col-12">
                <span class="btn btn-info" toggle_class="report_list">
                    <i class="fa fa-bars"></i> Список отчетов
                </span>
            </div>
        </div>
    </div>

    <div class="vtabs customvtab tabs_reports tabs-floating">
        <ul class="nav nav-tabs tabs-vertical p-t-10" role="tablist" toggle_block="report_list">
            <?foreach($reports as $reportGroupId => $reportsList){?>
                <li class="nav-item" tab="<?=$reportGroupId?>">
                    <a class="nav-link nowrap" data-toggle="tab" href="#reports<?=$reportGroupId?>" role="tab">
                        <span class="<?=Model_Report::$reportGroups[$reportGroupId]['icon']?> m-r-5"></span> <?=Model_Report::$reportGroups[$reportGroupId]['name']?>
                    </a>
                </li>
            <?}?>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content webtour-reports">
            <?foreach($reports as $reportGroupId => $reportsList){?>
                <div class="tab-pane" id="reports<?=$reportGroupId?>" role="tabpanel">

                    <div class="form">
                        <div class="form-group row">
                            <div class="col-md-4 text-muted">
                                <div class="hidden-sm-down text-right">Шаблон отчета:</div>
                                <div class="hidden-md-up">Шаблон отчета:</div>
                            </div>
                            <div class="col-md-8 with-mb">
                                <select class="report_select custom-select">
                                    <?foreach($reportsList as $report){?>
                                        <option value="<?=$report['REPORT_ID']?>"><?=$report['WEB_NAME']?></option>
                                    <?}?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <?foreach($reportsList as $report){?>
                        <div class="report_template_block" report="<?=$report['REPORT_ID']?>"></div>
                    <?}?>
                </div>
            <?}?>
        </div>
    </div>
<?}?>

<script>
    $(function(){
        $('.tabs_reports .nav-link:first').click();

        $(".tabs_reports .report_select").on('change', function(){
            var t = $(this);
            var reportId = t.val();

            loadReport(reportId);
        });

        $(".tabs_reports [tab]").on('click', function(){
            var t = $(this);
            var tab = t.attr('tab');

            $('#reports' + tab + ' .report_select').trigger('change');
        });

        var clicked = false;
        $(".tabs_reports [tab]").each(function(){
            if(clicked){
                return;
            }
            var t = $(this);

            if(!t.attr('style')){
                clicked = true;
                t.click();
            }
        });
    });

    function loadReport(reportId, force)
    {
        var tabsBlock = $(".tabs_reports");

        var block = $('.report_template_block[report='+ reportId +']');

        $('.report_template_block').hide();

        block.show();

        if(block.text() == '' || force == true){
            addLoader(block);

            $.post('/reports/load-report-template/' + reportId, {}, function(data){
                removeLoader(block);
                block.html(data);
            });
        }
    }
</script>

