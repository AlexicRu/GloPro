<?if (empty($reports)) {?>
    <div class="line_inner">Отчеты не найдены</div>
<?} else {?>
    <div class="card-columns">
    <?foreach ($reports as $report) {?>
        <div class="card" manager_id="<?=$managerId?>" report_id="<?=$report['REPORT_ID']?>">
            <div class="card-body bg-light">
                <div class="float-right p-l-10">
                    <a href="#" class="text-danger" onclick="delManagersReport($(this))"><i class="fa fa-trash-alt"></i></a>
                </div>

                <span class="badge m-r-5 <?=Model_Report::$reportGlobalTypesNames[$report['REPORT_TYPE_ID']]['label']?>">
                    <?=Model_Report::$reportGlobalTypesNames[$report['REPORT_TYPE_ID']]['name']?>
                </span>

                <b><?=$report['WEB_NAME']?></b>
            </div>
        </div>
    <?}?>
    </div>
<?}?>