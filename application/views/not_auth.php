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
                <div class="d-flex">

                    <form class="form-horizontal" id="login" method="post" action="/login">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 text-right control-label col-form-label">Логин</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Логин" name="login" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 text-right control-label col-form-label">Пароль</label>
                            <div class="col-sm-8">
                                <input type="password" placeholder="Пароль" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group m-b-0 row">
                            <div class="col-sm-4">&nbsp;</div>
                            <div class="col-sm-8">
                                <?/*
                                $config = Kohana::$config->load('config');

                                <button type="submit"
                                        class="g-recaptcha btn btn-info waves-effect waves-light"
                                        data-sitekey="<?=$config['recaptcha_public']?>"
                                        data-callback="onSubmit">
                                    Войти
                                </button>
                                <?*/?>
                                <button type="submit" class="btn btn-info waves-effect waves-light">Войти</button>
                            </div>
                        </div>
                    </form>

                </div>
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