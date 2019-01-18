<?include '_includes/header.php'?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Авторизация</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">

                <form class="form-horizontal" id="login" method="post" action="/login">
                    <div class="form-group row">
                        <div class="col-sm-4 text-muted form__row__title">
                            Логин
                        </div>
                        <div class="col-sm-8 with-mt">
                            <input type="text" placeholder="Логин" name="login" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4 text-muted form__row__title">
                            Пароль
                        </div>
                        <div class="col-sm-8 with-mt">
                            <input type="password" placeholder="Пароль" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group m-b-0 row">
                        <div class="offset-sm-4 col-sm-8">
                            <?/*
                            $config = Kohana::$config->load('config');

                            <button type="submit"
                                    class="g-recaptcha btn btn-info waves-effect waves-light"
                                    data-sitekey="<?=$config['recaptcha_public']?>"
                                    data-callback="onSubmit">
                                Войти
                            </button>

                            <script>
                                function onSubmit(token) {
                                    $('#login').submit();
                                }
                            </script>
                            <?*/?>
                            <button type="submit" class="<?= Text::BTN ?> btn-primary"><i class="far fa-door-open"></i>
                                Войти
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <?
        $messages = Messages::get();
        if(!empty($messages)){
            foreach($messages as $message){?>
                <div class="alert alert-<?=$message['type']?>">
                    <h3 class="text-<?=$message['type']?>"><i class="fa <?=Messages::$messageIcons[$message['type']]?>"></i> Ошибка</h3>
                    <?=$message['text']?>
                </div>
                <?
            }
        }
        ?>

    </div>
</div>

<?include '_includes/footer.php'?>