<?php
/**
 * KyrandiaCMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2020, Impero Consulting (Pty) Ltd., all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 * @version   7.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Themes Config
 *
 * This is the main config file for KyrandiaCMS' themes.
 *
 * @package     Impero
 * @subpackage  Themes
 * @category    Themes
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

// Template Admin - JS
$scripts['theme_admin'] = [
    'jquery.min.js' => [
        'path' => 'application/views/themes/admin/vendors/jquery/dist/',
        'place' => 'head',
        'method' => 'link'
    ],
    'jquery-ui-1.10.3.custom.min.js' => [
        'path' => 'application/views/themes/admin/js/jquery-ui/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'bootstrap.min.js' => [
        'path' => 'application/views/themes/admin/vendors/bootstrap/dist/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'moment.min.js' => [
        'path' => 'application/views/themes/admin/vendors/moment/src/',
        'place' => 'body',
        'method' => 'link'
    ],
    'bootstrap-datetimepicker.min.js' => [
        'path' => 'application/views/themes/admin/vendors/eonasdan-bootstrap-datetimepicker/build/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'fullcalendar.min.js' => [
        'path' => 'application/views/themes/admin/vendors/fullcalendar/dist/',
        'place' => 'body',
        'method' => 'link'
    ],
    'waves.min.js' => [
        'path' => 'application/views/themes/admin/vendors/waves/dist/',
        'place' => 'body',
        'method' => 'link'
    ],
    'bootstrap-growl.min.js' => [
        'path' => 'application/views/themes/admin/vendors/bootstrap-growl/',
        'place' => 'body',
        'method' => 'link'
    ],
    'sweetalert.min.js' => [
        'path' => 'application/views/themes/admin/vendors/sweetalert/dist/',
        'place' => 'body',
        'method' => 'link'
    ],
    'jquery.mCustomScrollbar.concat.min.js' => [
        'path' => 'application/views/themes/admin/vendors/malihu-custom-scrollbar-plugin/',
        'place' => 'body',
        'method' => 'link'
    ],
    'chosen.jquery.js' => [
        'path' => 'application/views/themes/admin/vendors/chosen/',
        'place' => 'body',
        'method' => 'link'
    ],
    'select2.full.min.js' => [
        'path' => 'application/views/themes/admin/vendors/select2/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'jquery.bootgrid.updated.min.js' => [
        'path' => 'application/views/themes/admin/vendors/bootgrid/',
        'place' => 'body',
        'method' => 'link'
    ],
    'autosize.min.js' => [
        'path' => 'application/views/themes/admin/vendors/autosize/dist/',
        'place' => 'body',
        'method' => 'link'
    ],
    'summernote.min.js' => [
        'path' => 'application/views/themes/admin/vendors/summernote/',
        'place' => 'body',
        'method' => 'link'
    ],
    'summernote-ext-nugget.js' => [
        'path' => 'application/views/themes/admin/vendors/summernote/plugin/nugget/',
        'place' => 'body',
        'method' => 'link'
    ],
    'app.js' => [
        'path' => 'application/views/themes/admin/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'moment.min.js' => [
        'path' => 'application/views/themes/admin/vendors/moment/src/',
        'place' => 'body',
        'method' => 'link'
    ],
    'bootstrap-datetimepicker.min.js' => [
        'path' => 'application/views/themes/admin/vendors/datetimepicker/',
        'place' => 'body',
        'method' => 'link'
    ],
    'jquery.bootstrap.wizard.min.js' => [
        'path' => 'application/views/themes/admin/vendors/bootstrap-wizard/',
        'method' => 'link'
    ],
    'jquery.flot.js' => [
        'path' => 'application/views/themes/admin/vendors/flot/',
        'method' => 'link'
    ],
    'jquery.flot.resize.js' => [
        'path' => 'application/views/themes/admin/vendors/flot/',
        'method' => 'link'
    ],
    'curvedLines.js' => [
        'path' => 'application/views/themes/admin/vendors/flot.curvedlines/',
        'method' => 'link'
    ],
    'jquery.sparkline.min.js' => [
        'path' => 'application/views/themes/admin/vendors/sparklines/',
        'method' => 'link'
    ],
    'jquery.easypiechart.min.js' => [
        'path' => 'application/views/themes/admin/vendors/jquery.easy-pie-chart/dist/',
        'method' => 'link'
    ],
    'fileinput.min.js' => [
        'path' => 'application/views/themes/admin/vendors/fileinput/',
        'place' => 'body',
        'method' => 'link'
    ]
];

// Template Admin - CSS
$css['theme_admin'] = [
    'fullcalendar.min.css' => [
        'path' => 'application/views/themes/admin/vendors/fullcalendar/dist/',
        'method' => 'link'
    ],
    'animate.min.css' => [
        'path' => 'application/views/themes/admin/vendors/animate.css/',
        'method' => 'link'
    ],
    'sweetalert.css' => [
        'path' => 'application/views/themes/admin/vendors/sweetalert/dist/',
        'method' => 'link'
    ],
    'material-design-iconic-font.min.css' => [
        'path' => 'application/views/themes/admin/vendors/material-design-iconic-font/dist/css/',
        'method' => 'link'
    ],
    'material-design-color-palette.min.css' => [
        'path' => 'application/views/themes/admin/vendors/material-design-iconic-font/dist/css/',
        'method' => 'link'
    ],
    'jquery.mCustomScrollbar.min.css' => [
        'path' => 'application/views/themes/admin/vendors/malihu-custom-scrollbar-plugin/',
        'method' => 'link'
    ],
    'chosen.css' => [
        'path' => 'application/views/themes/admin/vendors/chosen/',
        'method' => 'link'
    ],
    'select2.css' => [
        'path' => 'application/views/themes/admin/vendors/select2/css/',
        'method' => 'link'
    ],
    'jquery.bootgrid.min.css' => [
        'path' => 'application/views/themes/admin/vendors/bootgrid/',
        'method' => 'link'
    ],
    'bootstrap-datetimepicker.min.css' => [
        'path' => 'application/views/themes/admin/vendors/eonasdan-bootstrap-datetimepicker/build/css/',
        'method' => 'link'
    ],
    'app.css' => [
        'path' => 'application/views/themes/admin/css/',
        'method' => 'link'
    ],
    'summernote.css' => [
        'path' => 'application/views/themes/admin/vendors/summernote/',
        'method' => 'link'
    ],
    'all.css' => [
        'path' => 'application/views/themes/kyrandia/lib/fontawesome/css/',
        'method' => 'link'
    ],
    'checkbox.css' => [
        'path' => 'application/views/themes/admin/vendors/elcheckbox/css/',
        'method' => 'link'
    ],
    'bootstrap-datetimepicker.min.css' => [
        'path' => 'application/views/themes/admin/vendors/datetimepicker/',
        'method' => 'link'
    ],
    'common.css' => [
        'path' => 'assets/css/',
        'method' => 'link'
    ]
];

// Login Template
$scripts['theme_login'] = [
    'jquery.min.js' => [
        'path' => 'application/views/themes/admin/vendors/jquery/dist/',
        'place' => 'head',
        'method' => 'link'
    ],
    'bootstrap.min.js' => [
        'path' => 'application/views/themes/admin/vendors/bootstrap/dist/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'app.js' => [
        'path' => 'application/views/themes/admin/js/',
        'place' => 'body',
        'method' => 'link'
    ]
];

$css['theme_login'] = [
    'app.css' => [
        'path' => 'application/views/themes/admin/css/',
        'method' => 'link'
    ],
    'common.css' => [
        'path' => 'assets/css/',
        'method' => 'link'
    ]
];

// Template Kyrandia - JS
$scripts['theme_kyrandia'] = [
    'jquery.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/jquery/',
        'place' => 'head',
        'method' => 'link'
    ],
    'jquery.easing.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/jquery-easing/',
        'place' => 'head',
        'method' => 'link'
    ],
    'bootstrap.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/bootstrap/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'waves.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/waves/dist/',
        'place' => 'body',
        'method' => 'link'
    ],
    'summernote.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/summernote/',
        'place' => 'body',
        'method' => 'link'
    ],
    'summernote-ext-nugget.js' => [
        'path' => 'application/views/themes/kyrandia/lib/summernote/plugin/nugget/',
        'place' => 'body',
        'method' => 'link'
    ],
    'select2.full.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/select2/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'jquery.bootgrid.updated.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/bootgrid/',
        'place' => 'head',
        'method' => 'link'
    ],
    'moment.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/moment/',
        'place' => 'body',
        'method' => 'link'
    ],
    'bootstrap-datetimepicker.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/datetimepicker/',
        'place' => 'body',
        'method' => 'link'
    ],
    'fileinput.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/fileinput/',
        'place' => 'body',
        'method' => 'link'
    ],
    'jquery.bootstrap.wizard.min.js' => [
        'path' => 'application/views/themes/kyrandia/lib/bootstrap-wizard/',
        'method' => 'link'
    ],
    'custom.js' => [
        'path' => 'application/views/themes/kyrandia/js/',
        'place' => 'body',
        'method' => 'link'
    ]
];

// Template Kyrandia - CSS
$css['theme_kyrandia'] = [
    'bootstrap.min.css' => [
        'path' => 'application/views/themes/kyrandia/lib/bootstrap/css/',
        'method' => 'link'
    ],
    'animate.min.css' => [
        'path' => 'application/views/themes/kyrandia/lib/animate.css/',
        'method' => 'link'
    ],
    'select2.css' => [
        'path' => 'application/views/themes/kyrandia/lib/select2/css/',
        'method' => 'link'
    ],
    'jquery.bootgrid.min.css' => [
        'path' => 'application/views/themes/kyrandia/lib/bootgrid/',
        'method' => 'link'
    ],
    'checkbox.css' => [
        'path' => 'application/views/themes/kyrandia/lib/elcheckbox/css/',
        'method' => 'link'
    ],
    'style.css' => [
        'path' => 'application/views/themes/kyrandia/css/',
        'method' => 'link'
    ],
    'bootstrap-datetimepicker.min.css' => [
        'path' => 'application/views/themes/kyrandia/lib/datetimepicker/',
        'method' => 'link'
    ],
    'material-design-iconic-font.min.css' => [
        'path' => 'application/views/themes/kyrandia/lib/material-design-iconic-font/dist/css/',
        'method' => 'link'
    ],
    'material-design-color-palette.min.css' => [
        'path' => 'application/views/themes/kyrandia/lib/material-design-iconic-font/dist/css/',
        'method' => 'link'
    ],
    'all.css' => [
        'path' => 'application/views/themes/kyrandia/lib/fontawesome/css/',
        'method' => 'link'
    ],
    'summernote.css' => [
        'path' => 'application/views/themes/kyrandia/lib/summernote/',
        'method' => 'link'
    ],
    'common.css' => [
        'path' => 'assets/css/',
        'method' => 'link'
    ]
];

// Template MaxAPI - JS
$scripts['theme_maxapi'] = [
    'jquery-1.12.4.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/vendor/',
        'place' => 'body',
        'method' => 'link'
    ],
    'modernizr-3.7.1.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/vendor/',
        'place' => 'body',
        'method' => 'link'
    ],
    'popper.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'bootstrap.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'plugins.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'slick.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'waypoints.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'jquery.counterup.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'jquery.appear.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'wow.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'headroom.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'jquery.nav.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'scrollIt.min.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'main.js' => [
        'path' => 'application/views/themes/maxapi/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ]
];

// Template MaxAPI - CSS
$css['theme_maxapi'] = [
    'slick.css' => [
        'path' => 'application/views/themes/maxapi/assets/css/',
        'method' => 'link'
    ],
    'font-awesome.min.css' => [
        'path' => 'application/views/themes/maxapi/assets/css/',
        'method' => 'link'
    ],
    'LineIcons.css' => [
        'path' => 'application/views/themes/maxapi/assets/css/',
        'method' => 'link'
    ],
    'animate.css' => [
        'path' => 'application/views/themes/maxapi/assets/css/',
        'method' => 'link'
    ],
    'bootstrap.min.css' => [
        'path' => 'application/views/themes/maxapi/assets/css/',
        'method' => 'link'
    ],
    'default.css' => [
        'path' => 'application/views/themes/maxapi/assets/css/',
        'method' => 'link'
    ],
    'style.css' => [
        'path' => 'application/views/themes/maxapi/assets/css/',
        'method' => 'link'
    ]
];

// Theme Hielo - JS
$scripts['theme_hielo'] = [
    'jquery.min.js' => [
        'path' => 'application/views/themes/hielo/assets/js/',
        'method' => 'link',
        'place' => 'head'
    ],
    'jquery.scrollex.min.js' => [
        'path' => 'application/views/themes/hielo/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'skel.min.js' => [
        'path' => 'application/views/themes/hielo/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'util.js' => [
        'path' => 'application/views/themes/hielo/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'bootstrap.min.js' => [
        'path' => 'application/views/themes/hielo/assets/js/bootstrap/js/',
        'place' => 'body',
        'method' => 'link'
    ],
    'main.js' => [
        'path' => 'application/views/themes/hielo/assets/js/',
        'place' => 'body',
        'method' => 'link'
    ],
];

// Theme Hielo - CSS
$css['theme_hielo'] = [
    'bootstrap.css' => [
        'path' => 'application/views/themes/hielo/assets/js/bootstrap/css/',
        'method' => 'link'
    ],
    'main.css' => [
        'path' => 'application/views/themes/hielo/assets/css/',
        'method' => 'link'
    ],
];

$scripts['theme_hielo_generic'] = $scripts['theme_hielo'];
$css['theme_hielo_generic'] = $css['theme_hielo'];
$scripts['theme_hielo_distribution'] = $scripts['theme_hielo'];
$css['theme_hielo_distribution'] = $css['theme_hielo'];

// Dating theme
$scripts['theme_dating'] = $scripts['theme_hielo'];
$css['theme_dating'] = $css['theme_hielo'];

// AskGogo theme
$scripts['theme_askgogo'] = $scripts['theme_hielo'];
$css['theme_askgogo'] = $css['theme_hielo'];