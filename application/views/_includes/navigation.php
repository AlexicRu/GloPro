<!-- ============================================================== -->
<div class="navbar-collapse">
    <!-- ============================================================== -->
    <!-- toggle and nav items -->
    <!-- ============================================================== -->
    <ul class="navbar-nav mr-auto">
        <!-- This is  -->
        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="fa-fw far fa-bars"></i></a> </li>
        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="fa-fw far fa-bars"></i></a> </li>

        <?if (!empty($user['managers_binds'])) {
            $currentManager = reset($user['managers_binds']);
            ?>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle waves-effect waves-dark" data-toggle="dropdown">
                    <span class="font-20">
                        <i class="far fa-user"></i>
                        <span class="hidden-sm-down m-l-5"><?=$currentManager['WEB_NAME_CURRENT']?></span>
                    </span>
                </a>

                <div class="dropdown-menu dropdown-menu-left animated bounceInDown mailbox clients_switch_list bg-white">
                    <div class="message-center">
                    <?foreach ($user['managers_binds'] as $manager) {?>
                        <a href="/force-login/<?=Common::encrypt($user['MANAGER_ID'] . ' ' . $manager['MANAGER_TO'])?>">
                            <div class="mail-contnet">
                                <h5><i class="far fa-sign-in-alt fa-lg m-r-5"></i> <?=$manager['WEB_NAME_TO']?></h5>
                            </div>
                        </a>
                    <?}?>
                    </div>
                </div>
            </li>
        <?}?>
    </ul>
    <!-- ============================================================== -->
    <!-- User profile and search -->
    <!-- ============================================================== -->
    <ul class="navbar-nav my-lg-0">
        <!-- ============================================================== -->
        <!-- Search -->
        <!-- ============================================================== -->
        <? if (Access::allow('clients_index')) { ?>
            <li class="nav-item search-box">
                <form class="app-search" action="/clients" method="post">
                    <input type="text" class="form-control" placeholder="Поиск..." name="search" value="<?=(!empty($_REQUEST['search']) ? Text::quotesForForms($_REQUEST['search']) : '')?>"> <a class="srh-btn"><i class="far fa-times"></i></a>
                </form>
                <a class="nav-link waves-effect waves-dark hidden-lg-up" href="javascript:void(0)"><i class="far fa-search"></i></a>
                <div class="nav-link waves-effect waves-dark hidden-md-down text-white"><i class="far fa-search"></i></div>
            </li>
        <? } ?>
        <!-- ============================================================== -->
        <!-- Messages -->
        <!-- ============================================================== -->
        <? if (Access::allow('news_index')) { ?>
            <li class="nav-item dropdown">
                <?if(count($notices)){?>
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-toggle="dropdown"> <i class="fas fa-envelope"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown">
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
                    <a class="nav-link waves-effect waves-dark" href="/messages"> <i class="fas fa-envelope"></i></a>
                <?}?>
            </li>
        <? } ?>
        <!-- ============================================================== -->
        <!-- End Messages -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Profile -->
        <!-- ============================================================== -->
        <li class="nav-item dropdown webtour-profile">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-toggle="dropdown"><img src="<?=Common::getAssetsLink().'img/user.png'?>" alt="user" class="profile-pic" /></a>
            <div class="dropdown-menu dropdown-menu-right animated bounceInDown">
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
                    <? if (Access::allow('news_index')) { ?>
                        <li><a href="/messages"><i class="fa-fw far fa-envelope"></i> Сообщения</a></li>
                    <? } ?>
                    <? if (Access::allow('manager_setting')) { ?>
                        <li class="webtour-settings"><a href="/managers/settings"><i class="fa-fw far fa-cog"></i>
                                Настройки</a></li>
                    <li role="separator" class="divider"></li>
                    <? } ?>
                    <li><a href="/logout"><i class="fa-fw fa fa-power-off"></i> Выход</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>