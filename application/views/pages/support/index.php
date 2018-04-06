<h1>Поддержка</h1>

<div class="tabs_block tabs_switcher">
    <div class="tabs">
        <span tab="feedback" class="tab active"><i class="icon-notifications"></i> Обратная связь</span><?if (Access::file('Инструкция_по_работе_с_ЛК_системы_Администратор.docx')){?><span tab="documents" class="tab"><i class="icon-contract"></i> Документы</span><?}?><span tab="polls" class="tab"><i class="icon-analytics"></i> Опросы</span>
    </div>
    <div class="tabs_content">
        <div tab_content="feedback" class="tab_content active">
            <?=$feedbackForm?>
        </div>
        <?if (Access::file('Инструкция_по_работе_с_ЛК_системы_Администратор.docx')){?>
        <div tab_content="documents" class="tab_content">
            <b>Инструкции:</b><br><br>
            <span class="f20">Инструкция по работе с ЛК системы</span> &nbsp; <a href="/file/Инструкция_по_работе_с_ЛК_системы_Администратор.docx" class="btn btn_small"><i class="icon-download icon"></i> Скачать</a>
        </div>
        <?}?>
        <div tab_content="polls" class="tab_content">
            <h2>Новый дизайн:</h2>

            По ссылкам находятся рабочие макеты

            <style>
                .flex{
                    margin-top: 20px; margin-bottom: 30px;
                }
                .flex > div{
                    margin-right: 50px;
                }
                .flex a.fancy{
                    display: inline-block; width: 300px; margin-top: 20px;
                }
                .flex a.fancy img{
                    max-width: 100%;
                }
            </style>

            <div class="flex">
                <div>
                    <a href="/new/minimal/index.html" target="_blank" class="f24"><i class="icon-reply"></i> Вариант 1</a><br>
                    <a href="<?=(Common::getAssetsLink() . 'img/pic/02.jpg')?>" class="fancy" rel="design">
                        <img src="<?=(Common::getAssetsLink() . 'img/pic/02.jpg')?>">
                    </a>
                </div>
                <div>
                    <a href="/new/main/index.html" target="_blank" class="f24"><i class="icon-reply"></i> Вариант 2</a><br>
                    <a href="<?=(Common::getAssetsLink() . 'img/pic/03.jpg')?>" class="fancy" rel="design">
                        <img src="<?=(Common::getAssetsLink() . 'img/pic/03.jpg')?>">
                    </a>
                </div>
                <div>
                    <a href="/new/stylish-menu/index.html" target="_blank" class="f24"><i class="icon-reply"></i> Вариант 3</a><br>
                    <a href="<?=(Common::getAssetsLink() . 'img/pic/04.jpg')?>" class="fancy" rel="design">
                        <img src="<?=(Common::getAssetsLink() . 'img/pic/04.jpg')?>">
                    </a>
                </div>
            </div>

            <!-- Put this script tag to the <head> of your page -->
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?152"></script>

            <script type="text/javascript">
                VK.init({apiId: 6439179, onlyWidgets: true});
            </script>

            <!-- Put this div tag to the place, where the Poll block will be -->
            <div id="vk_poll"></div>
            <script type="text/javascript">
                VK.Widgets.Poll("vk_poll", {width: "300"}, "290971591_d902f1b5b489160862");
            </script>
        </div>
    </div>
</div>