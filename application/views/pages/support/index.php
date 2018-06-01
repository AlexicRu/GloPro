<!-- Nav tabs -->
<ul class="nav nav-tabs customtab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#feedback" role="tab">
            <i class="fa fa-comments fa-lg"></i> <span class="hidden-xs-down m-l-5">Обратная связь</span>
        </a>
    </li>
    <?if (Access::file('Инструкция_по_работе_с_ЛК_системы_Администратор.docx')){?>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#documents" role="tab">
            <i class="fa fa-file-alt fa-lg"></i> <span class="hidden-xs-down m-l-5">Документы</span>
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
    <?if (Access::file('Инструкция_по_работе_с_ЛК_системы_Администратор.docx')){?>
    <div class="tab-pane" id="documents" role="tabpanel">
        <div class="p-20 bg-white">
            <div class="m-b-10"><b class="font-18">Инструкции:</b></div>
            <i class="fa fa-file-word fa-lg m-r-5"></i> <span class="f20">Инструкция по работе с ЛК системы</span> &nbsp; <a href="/file/Инструкция_по_работе_с_ЛК_системы_Администратор.docx" class="<?=Text::BTN?> btn-sm btn-primary"><i class="fa fa-download"></i> Скачать</a>
        </div>
    </div>
    <?}?>
</div>