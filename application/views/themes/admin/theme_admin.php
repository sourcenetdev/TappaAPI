<!doctype html>
<html>
    <head>
        {{{headtags}}}
        {{{templatedata:head}}}
    </head>
    <body>

        <!-- Some initialization -->
        <?php
            $u = $this->session->userdata('username');
            $r = $this->session->userdata('role');
            $uid = $this->session->userdata('id');
            $u = (!empty($u) ? $u : 'Guest');
            $notices = get_system_notices();
            $theme = config_item('admin_color');
            global $help_sections;
            $ci =& get_instance();
        ?>

        <!-- Header section -->
        <header id="header" class="clearfix" data-ma-theme="kyrandia">
            <ul class="h-inner">

                <!-- Mobile menu icon -->
                <li class="hi-trigger ma-trigger" data-ma-action="sidebar-open" data-ma-target="#sidebar">
                    <div class="line-wrap">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>

                <!-- Admin heading -->
                <li class="hi-logo hidden-xs"><a href="<?php echo base_url(); ?>">{{{variable:system_name}}} - System Admin <span style="font-size: 50%">Version: {{{variable:system_version}}}</span></a></li>

                <!-- Notification area -->
                <li class="pull-right">
                    <ul class="hi-menu">

                        <!-- Help -->
                        <?php if (!empty($help_sections)): ?>
                        <li class="hidden-xs ma-trigger" data-ma-action="sidebar-open" data-ma-target="#help">
                            <a href=""><i class="him-icon zmdi zmdi-help"></i></a>
                        </li>
                        <?php endif; ?>

                        <!-- Settings -->
                        <li class="dropdown">
                            <a data-toggle="dropdown" href=""><i class="him-icon zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu dm-icon pull-right">

                                <!-- Theme switcher -->
                                <li class="hidden-xs"><a href="#"><i class="zmdi zmdi-palette"></i> Select backdrop</a></li>
                                <li class="divider hidden-xs"></li>
                                <li class="skin-switch hidden-xs">
                                    <span class="ss-skin bgm-kyrandia" data-ma-action="change-skin" data-ma-skin="kyrandia"></span>
                                    <span class="ss-skin bgm-lightblue" data-ma-action="change-skin" data-ma-skin="lightblue"></span>
                                    <span class="ss-skin bgm-bluegray" data-ma-action="change-skin" data-ma-skin="bluegray"></span>
                                    <span class="ss-skin bgm-cyan" data-ma-action="change-skin" data-ma-skin="cyan"></span>
                                    <span class="ss-skin bgm-teal" data-ma-action="change-skin" data-ma-skin="teal"></span>
                                    <span class="ss-skin bgm-orange" data-ma-action="change-skin" data-ma-skin="orange"></span>
                                    <span class="ss-skin bgm-blue" data-ma-action="change-skin" data-ma-skin="blue"></span>
                                    <span class="ss-skin bgm-red" data-ma-action="change-skin" data-ma-skin="red"></span>
                                    <span class="ss-skin bgm-deeporange" data-ma-action="change-skin" data-ma-skin="deeporange"></span>
                                    <span class="ss-skin bgm-green" data-ma-action="change-skin" data-ma-skin="green"></span>
                                    <span class="ss-skin bgm-lightgreen" data-ma-action="change-skin" data-ma-skin="lightgreen"></span>
                                    <span class="ss-skin bgm-pink" data-ma-action="change-skin" data-ma-skin="pink"></span>
                                </li>
                                <li class="divider hidden-xs"></li>

                                <!-- Full screen -->
                                <li class="hidden-xs"><a data-ma-action="fullscreen" href="#"><i class="zmdi zmdi-fullscreen"></i> Toggle Fullscreen</a></li>
                                {{{menu:Admin}}}
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </header>

        <!-- Main Content Section -->
        <section id="main"">

            <!-- Side bar left -->
            <aside data-ma-theme="kyrandia" id="sidebar" class="sidebar c-overflow">
                <div style="background-size: cover; background-image: url(<?php echo base_url(); ?>assets/images/kcms_login_bg_small.jpg); text-align: center; padding: 20px 0;">
                    <img style="max-width: 160px !important;" src="<?php echo base_url(); ?>assets/images/logo_transparent.png">
                </div>

                <!-- Main menu -->
                <ul data-ma-theme="kyrandia" class="main-menu <?php echo $theme['main_menu_class']; ?>">

                    <?php $ci->hooks->call_hook('admin_menu_settings'); ?>

                    <!-- Administration menu -->
                    <?php $sess = $this->session->all_userdata(); ?>
                    <?php if (user_has_any_role(array('Super Administrator')) || user_has_any_permission(array('Access control panel'))): ?>

                    <!-- Content -->
                    <?php if (user_has_any_role(array('Super Administrator', 'Content Administrator'))): ?>
                    <li class="sub-menu <?php echo $theme['sub_menu_class']; ?>">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-format-subject"></i>Content</a>
                        <ul>
                            <?php if (user_has_any_role(array('Super Administrator', 'Theme Administrator')) || user_has_any_permission(array('Manage themes'))): ?><li><a href="<?php echo base_url(); ?>theme/list_themes"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Themes</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Layout Administrator')) || user_has_any_permission(array('Manage layouts'))): ?><li><a href="<?php echo base_url(); ?>layout/list_layouts"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Layouts</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Block Administrator')) || user_has_any_permission(array('Manage blocks'))): ?><li><a href="<?php echo base_url(); ?>block/list_blocks"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Blocks</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Page Administrator')) || user_has_any_permission(array('Manage pages'))): ?><li><a href="<?php echo base_url(); ?>page/list_pages"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Pages</a></li><?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <!-- Widgets -->
                    <?php if (user_has_any_role(array('Super Administrator', 'Widget Administrator'))): ?>
                    <li class="sub-menu <?php echo $theme['sub_menu_class']; ?>">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-widgets"></i>Widgets</a>
                        <ul>
                            <?php if (user_has_any_role(array('Super Administrator', 'Widget Administrator')) || user_has_any_permission(array('Manage accordions'))): ?><li><a href="<?php echo base_url(); ?>widget/load_widget/accordion/list_accordions"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Accordions</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Widget Administrator')) || user_has_any_permission(array('Manage sliders'))): ?><li><a href="<?php echo base_url(); ?>widget/load_widget/slider/list_sliders"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Sliders</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Widget Administrator')) || user_has_any_permission(array('Manage info blocks'))): ?><li><a href="<?php echo base_url(); ?>widget/load_widget/info_block/list_info_blocks"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Info Blocks</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Widget Administrator')) || user_has_any_permission(array('Manage parallax divs'))): ?><li><a href="<?php echo base_url(); ?>widget/load_widget/parallax_div/list_parallax_divs"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Parallax Divs</a></li><?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <!-- Filter -->
                    <?php if (user_has_any_role(array('Super Administrator', 'Filter Administrator'))): ?>
                    <li class="sub-menu <?php echo $theme['sub_menu_class']; ?>">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-filter-list"></i>Filters</a>
                        <ul>
                            <?php if (user_has_any_role(array('Super Administrator', 'Filter Administrator')) || user_has_any_permission(array('Manage profanities'))): ?><li><a href="<?php echo base_url(); ?>profanity/list_profanities_data"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Profanity filter</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Filter Administrator')) || user_has_any_permission(array('Manage filters'))): ?><li><a href="<?php echo base_url(); ?>pirate/list_pirates_data"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Pirate filter</a></li><?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <!-- Metadata -->
                    <?php if (user_has_any_role(array('Super Administrator', 'Settings Administrator'))): ?>
                    <li class="sub-menu <?php echo $theme['sub_menu_class']; ?>">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-group"></i>Metadata</a>
                        <ul>
                            <?php if (user_has_any_role(array('Super Administrator', 'Settings Administrator')) || user_has_any_permission(array('Manage taxonomies'))): ?><li><a href="<?php echo base_url(); ?>taxonomy/list_taxonomies_data"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Taxonomies</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Settings Administrator')) || user_has_any_permission(array('Manage metadata categories'))): ?><li><a href="<?php echo base_url(); ?>metadata/list_metadata_categories_data"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Metadata categories</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Settings Administrator')) || user_has_any_permission(array('Manage metadata categories'))): ?><li><a href="<?php echo base_url(); ?>metadata/list_metadata_items_data"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Metadata items</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Settings Administrator')) || user_has_any_permission(array('Manage attributes'))): ?><li><a href="<?php echo base_url(); ?>seo/list_attributes"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Attributes</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Settings Administrator')) || user_has_any_permission(array('Manage headtags'))): ?><li><a href="<?php echo base_url(); ?>seo/list_headtags"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Headtags</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Settings Administrator')) || user_has_any_permission(array('Manage headtags'))): ?><li><a href="<?php echo base_url(); ?>seo/list_global_headtags"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Global Headtags</a></li><?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <!-- System -->
                    <?php if (user_has_any_role(array('Super Administrator', 'Settings Administrator'))): ?>
                    <li class="sub-menu <?php echo $theme['sub_menu_class']; ?>">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-settings"></i>System</a>
                        <ul>
                            <?php if (user_has_any_role(array('Super Administrator', 'Settings Administrator')) || user_has_any_permission(array('Manage menus'))): ?><li><a href="<?php echo base_url(); ?>menu/list_menus_data"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Menus</a></li><?php endif; ?>
                            <?php if (user_has_any_role(array('Super Administrator', 'Settings Administrator')) || user_has_any_permission(array('Manage variables'))): ?><li><a href="<?php echo base_url(); ?>variable/list_variables_data"><i class="zmdi f-12 zmdi-caret-right m-r-10"></i>Variables</a></li><?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>

                    <!-- Account menu -->
                    <li class="sub-menu <?php echo $theme['sub_menu_class']; ?>">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-face"></i>My account</a>
                        <ul>

                            <!-- Log in/out -->
                            <?php if (empty($uid)): ?>
                            <li><a href="<?php echo base_url(); ?>login"><i class="zmdi f-12 zmdi-lock-outline m-r-10"></i>Log in</a></li>
                            <li><a href="<?php echo base_url(); ?>register"><i class="zmdi f-12 zmdi-account-add m-r-10"></i>Register</a></li>
                            <li><a href="<?php echo base_url(); ?>forgot-password"><i class="zmdi f-12 zmdi-more m-r-10"></i>Forgot password</a></li>
                            <?php else: ?>
                            <li><a href="<?php echo base_url(); ?>control-panel"><i class="zmdi f-12 zmdi-view-dashboard m-r-10"></i>Control Panel</a></li>
                            <li><a href="<?php echo base_url(); ?>change-password/<?php echo $uid; ?>"><i class="zmdi f-12 zmdi-more m-r-10"></i>Change password</a></li>
                            <li><a href="<?php echo base_url(); ?>logout"><i class="zmdi f-12 zmdi-lock-open m-r-10"></i>Log out</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </aside>

            <!-- Content area -->
            <section id="content">
                <div class="container">
                    <?php if (!empty($notices)): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php foreach($notices as $k => $v): ?>
                            <div class="alert alert-<?php echo $k; ?>">
                            <?php if (count($v) > 1): ?>
                            <ul class="system_notices">
                            <?php endif; ?>
                            <?php foreach ($v as $kk => $vv): ?>
                            <?php if (count($v) > 1): ?>
                            <?php echo '<li>' . $vv . '</li>'; ?>
                            <?php else: ?>
                            <?php echo $vv; ?>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if (count($v) > 1): ?>
                            </ul>
                            <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php echo $contents; ?>
                </div>
            </section>
        </section>

        <footer id="footer">
            <small class="block">&copy; <?php echo date('Y'); ?>, All Rights Reserved <a href="<?php echo base_url(); ?>">__SITENAME__</a>. Designed and developed by <a target="_blank" href="https://www.impero.co.za/">Impero Consulting</a>.</small>
            <ul class="f-menu">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
            </ul>
        </footer>

        <!-- Page Loader -->
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>
                <p>Please wait...</p>
            </div>
        </div>

        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li><a href="http://www.google.com/chrome/"><img src="img/browsers/chrome.png" alt="Chrome"><div>Chrome</div></a></li>
                        <li><a href="https://www.mozilla.org/en-US/firefox/new/"><img src="img/browsers/firefox.png" alt="Firefox"><div>Firefox</div></a></li>
                        <li><a href="http://www.opera.com"><img src="img/browsers/opera.png" alt="Opera"><div>Opera</div></a></li>
                        <li><a href="https://www.apple.com/safari/"><img src="img/browsers/safari.png" alt="Safari"><div>Safari</div></a></li>
                        <li><a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie"><img src="img/browsers/ie.png" alt="Internet Explorer (Latest)"><div>IE (New)</div></a></li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->

        <!-- Load template body data -->
        {{{templatedata:body}}}

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="<?php echo base_url(); ?>application/views/admin/vendors/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
    </body>
</html>
