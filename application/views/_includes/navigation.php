<!-- ============================================================== -->
<div class="navbar-collapse">
    <!-- ============================================================== -->
    <!-- toggle and nav items -->
    <!-- ============================================================== -->
    <ul class="navbar-nav mr-auto">
        <!-- This is  -->
        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
        <li class="nav-item hidden-sm-down"><?/*?><span><?=(!empty($title) ? array_pop($title) : '')?></span><?*/?></li>
    </ul>
    <!-- ============================================================== -->
    <!-- User profile and search -->
    <!-- ============================================================== -->
    <ul class="navbar-nav my-lg-0">
        <!-- ============================================================== -->
        <!-- Search -->
        <!-- ============================================================== -->
        <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
            <form class="app-search" action="/clients" method="post">
                <input type="text" class="form-control" placeholder="Поиск..." name="search" value="<?=(!empty($_REQUEST['search']) ? Text::quotesForForms($_REQUEST['search']) : '')?>"> <a class="srh-btn"><i class="ti-close"></i></a>
            </form>
        </li>
        <!-- ============================================================== -->
        <!-- Messages -->
        <!-- ============================================================== -->
        <li class="nav-item dropdown">
            <?if(count($notices)){?>
                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                </a>
                <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
                    <ul>
                        <li>
                            <div class="drop-title">У вас <?=count($notices)?> новых <a href="/messages">сообщений</a></div>
                        </li>
                        <li>
                            <div class="message-center">
                                <?foreach($notices as $notice){?>
                                    <!-- Message -->
                                    <a href="#">
                                        <div class="mail-contnet">
                                            <h6><?=$notice['NOTE_TITLE']?></h6>
                                            <span class="mail-desc"><?=$notice['NOTE_BODY']?></span>
                                        </div>
                                    </a>
                                <?}?>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link text-center mark_read" href="#"> <i class="fa fa-check"></i> <strong>Отметить прочитанными</strong></a>
                        </li>
                    </ul>
                </div>
            <?}else{?>
                <a class="nav-link waves-effect waves-dark" href="/messages"> <i class="mdi mdi-email"></i></a>
            <?}?>
        </li>
        <!-- ============================================================== -->
        <!-- End Messages -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Profile -->
        <!-- ============================================================== -->
        <li class="nav-item dropdown webtour-profile">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?=Common::getAssetsLink().'img/user.png'?>" alt="user" class="profile-pic" /></a>
            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                <ul class="dropdown-user">
                    <li>
                        <div class="dw-user-box">
                            <div class="u-img"><img src="<?=Common::getAssetsLink().'img/user.png'?>" alt="user"></div>
                            <div class="u-text">
                                <h4><?=User::getName($user)?></h4>
                            </div>
                        </div>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/managers/settings"><i class="ti-user"></i> Профиль</a></li>
                    <li><a href="/messages"><i class="ti-email"></i> Сообщения</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="webtour-setting"><a href="/managers/settings"><i class="ti-settings"></i> Настройки</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/logout"><i class="fa fa-power-off"></i> Выход</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>