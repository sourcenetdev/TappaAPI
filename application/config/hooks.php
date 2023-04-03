<?php
/**
 * KyrandiaCMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2020, Impero, all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 * @version   7.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Config
 *
 * This is the hooks config file for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Configs
 * @category    Configs
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

// Module and system CSS.
$hook['post_controller'][] = [
    'class' => '',
    'function' => 'get_module_css',
    'filename' => 'kcms.php',
    'filepath' => 'hooks',
    'params' => ''
];

$hook['post_controller'][] = [
    'class' => '',
    'function' => 'get_module_css',
    'filename' => 'kcms.php',
    'filepath' => 'hooks',
    'params' => 'all'
];

// Module and system JS
$hook['post_controller'][] = [
    'class' => '',
    'function' => 'get_module_js',
    'filename' => 'kcms.php',
    'filepath' => 'hooks',
    'params' => ''
];

$hook['post_controller'][] = [
    'class' => '',
    'function' => 'get_module_js',
    'filename' => 'kcms.php',
    'filepath' => 'hooks',
    'params' => 'all'
];

// Invoke system and other functionality for iCMS - currently mostly pre-loading of modules and settings.
$hook['post_controller'][] = [
    'class' => '',
    'function' => 'bootstrap',
    'filename' => 'kcms.php',
    'filepath' => 'hooks',
    'params' => ''
];

// Affects all text replacements prior to output. Will deal with short codes, language filters, etc.
$hook['display_override'][] = [
    'class' => '',
    'function' => 'do_replace',
    'filename' => 'replace_holder_hook.php',
    'filepath' => 'hooks',
    'params' => ''
];

// KCMS custom hooks - Module settings
$hook['module_settings'][] = [
    'class' => '',
    'function' => 'settings_hook',
    'filename' => 'settings_hook.php',
    'filepath' => 'hooks',
    'params' => []
];

// KCMS custom hooks - Admin menu settings
$hook['admin_menu_settings'][] = [
    'class' => '',
    'function' => 'admin_menu_hook',
    'filename' => 'settings_hook.php',
    'filepath' => 'hooks',
    'params' => []
];

// KCMS custom hooks - Permissions settings
$hook['permissions_settings'][] = [
    'class' => '',
    'function' => 'permissions_hook',
    'filename' => 'settings_hook.php',
    'filepath' => 'hooks',
    'params' => []
];

// KCMS custom hooks - Theme settings
$hook['theme_settings'][] = [
    'class' => '',
    'function' => 'themes_hook',
    'filename' => 'settings_hook.php',
    'filepath' => 'hooks',
    'params' => []
];

// KCMS custom hooks - Authentication
$hook['auth_init'][] = [
    'class' => '',
    'function' => 'auth_hook_initialize',
    'filename' => 'auth_hook.php',
    'filepath' => 'hooks',
    'params' => []
];

$hook['auth_execute'][] = [
    'class' => '',
    'function' => 'auth_hook_execute',
    'filename' => 'auth_hook.php',
    'filepath' => 'hooks',
    'params' => []
];

$hook['auth_get'][] = [
    'class' => '',
    'function' => 'auth_hook_get',
    'filename' => 'auth_hook.php',
    'filepath' => 'hooks',
    'params' => []
];

$hook['auth_complete'][] = [
    'class' => '',
    'function' => 'auth_hook_complete',
    'filename' => 'auth_hook.php',
    'filepath' => 'hooks',
    'params' => []
];
