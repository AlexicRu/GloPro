<?/*?>
<script>
    $(function () {
        $('.sub_menu_title').on('click', function () {
            var t = $(this);

            t.closest('.sub_menu').find('.sub_menu_items').slideToggle();
        });
    });
</script>
<?*/?>

<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <?
                foreach($menu as $link => $item){
                    if(Access::allow($link.'_index', true)) {

                        $isActiveController = Text::camelCaseToDashed(Request::current()->controller()) == $link ;

                        if (!empty($item['children'])) {
                            foreach($item['children'] as $child => $name){
                                if(Access::deny($link.'_'.$child, true)) {
                                    unset($item['children'][$child]);
                                }
                            }
                        }

                        if(empty($item['children'])){
                            echo '<li><a class="waves-effect waves-dark '. ($isActiveController ? 'active' : '') .' menu_item_'. $link .'" href="/'. $link .'"><i><span class="'. $item['icon'] .'"></span></i> <span class="hide-menu">'. $item['title'] .'</span></a></li>';
                            continue;
                        }

                        ?>
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false"><i><span class=" <?=$item['icon']?>"></span></i> <span class="hide-menu"><?=$item['title']?></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <?foreach($item['children'] as $child => $name) {
                                    $isActiveAction = Text::camelCaseToDashed(Request::current()->action()) == $child && $isActiveController;

                                    if(Access::allow($link.'_'.$child, true)) {?>
                                        <li><a href="/<?=$link?><?=($child == 'index' ? '' : '/'.$child)?>" class="menu_item_<?=$link?>_<?=$child?> <?=($isActiveAction ? 'active' : '')?>"><?=$name?></a></li>
                                    <?}
                                }?>
                            </ul>
                        </li>
                        <?
                    }
                }
                ?>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <?if ($user['AGENT_GROUP_ID'] == 0) {?>
        <div class="copyright">
            &copy; GloPro 2015-<?=date('Y')?>
        </div>
    <?}?>
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->