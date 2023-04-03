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
 * KyrandiaCMS Settings Hook
 *
 * This is invoke settings hooks for KyrandiaCMS modules
 *
 * @package     Impero
 * @subpackage  Hooks
 * @category    Hooks
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

/**
 * function permissions_hook
 *
 * Invoke permissions hooks to allow custom permissions on a per module basis.
 *
 * @access public
 *
 * @return void
 */
if (!function_exists('permissions_hook')) {
    function permissions_hook()
    {
        global $access;
        $ci =& get_instance();
        $temp = modules_active();
        $access = [];
        if (!empty($temp)) {
            foreach ($temp as $k => $v) {
                $ci->load->module($v['slug']);
                if (
                    is_array(get_class_methods(strtolower($v['slug']))) &&
                    in_array('permissions_hook', array_map('strtolower', get_class_methods(strtolower($v['slug']))))
                ) {
                    $access += $ci->{$v['slug']}->permissions_hook();
                }
            }
        }
        return $access;
    }
}

/**
 * function admin_menu_hook
 *
 * Invoke admin menu items hooks to allow automated admin menu additions.
 *
 * @access public
 *
 * @return void
 */
if (!function_exists('admin_menu_hook')) {
    function admin_menu_hook()
    {
        $ci =& get_instance();
        $temp = modules_active();
        $temp3 = [];
        $temp4 = [];

        if (!empty($temp)) {
            foreach ($temp as $k => $v) {
                $ci->load->module($v['slug']);
                if (
                    is_array(get_class_methods(strtolower($v['slug']))) &&
                    in_array('admin_menu_hook', array_map('strtolower', get_class_methods(strtolower($v['slug']))))
                ) {
                    $temp2 = $ci->{$v['slug']}->admin_menu_hook();
                    $theme = config_item('admin_color');
                    if (!empty($temp2)) {
                        if (
                            (!empty($temp2['roles']) && user_has_any_role($temp2['roles'])) ||
                            (!empty($temp2['permissions']) && user_has_any_permission($temp2['permissions']))
                        ) {
                            $temp3 = [
                                'sub_menu_class' => $theme['sub_menu_class'],
                                'text' => (!empty($temp2['text']) ? $temp2['text'] : 'Check menu text'),
                                'module' => $v['slug'],
                                'link' => (!empty($temp2['link']) ? $temp2['link'] : 'Check menu link'),
                                'icon' => (!empty($temp2['icon']) ? $temp2['icon'] : 'chevron-right'),
                                'type' => (!empty($temp2['type']) ? $temp2['type'] : ''),
                                'order' => (!empty($temp2['order']) ? $temp2['order'] : ''),
                                'target' => (!empty($temp2['target']) ? trim($temp2['target'], '_') : ''),
                                'roles' => (!empty($temp2['roles']) ? $temp2['roles'] : []),
                                'permissions' => (!empty($temp2['permissions']) ? $temp2['permissions'] : []),
                            ];
                            if (!empty($temp2['sub_menu_items'])) {
                                foreach ($temp2['sub_menu_items'] as $kk => $vv) {
                                    $temp3['sub_menu_items'][$kk]['text'] = (!empty($vv['text']) ? $vv['text'] : 'Check sub menu text');
                                    $temp3['sub_menu_items'][$kk]['link'] = (!empty($vv['link']) ? $vv['link'] : 'Check sub menu link');
                                    $temp3['sub_menu_items'][$kk]['icon'] = (!empty($vv['icon']) ? $vv['icon'] : 'chevron-right');
                                    $temp3['sub_menu_items'][$kk]['type'] = (!empty($vv['type']) ? $vv['type'] : '');
                                    $temp3['sub_menu_items'][$kk]['order'] = (!empty($vv['order']) ? $vv['order'] : 0);
                                    $temp3['sub_menu_items'][$kk]['target'] = (!empty($vv['target']) ? trim($vv['target'], '_') : '');
                                    $temp3['sub_menu_items'][$kk]['roles'] = (!empty($vv['roles']) ? $vv['roles'] : []);
                                    $temp3['sub_menu_items'][$kk]['permissions'] = (!empty($vv['permissions']) ? $vv['permissions'] : []);
                                }
                            }
                            $temp4[] = $temp3;
                        }
                    }
                }
            }
        }
        usort($temp4, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        $final = '';
        if (!empty($temp4)) {
            foreach ($temp4 as $v) {
                $x['data'] = $v;
                $final .= $ci->load->view('menu/admin_menu_item', $x, true);
            }
        }
        echo $final;
        unset($temp, $temp2, $temp3, $temp4, $final);
    }
}

/**
 * function themes_hook
 *
 * Invoke theme hooks to allow theme customization.
 *
 * @access public
 *
 * @return void
 */
if (!function_exists('themes_hook')) {
    function themes_hook()
    {
        global $theme;
        $theme_name = config_item('current_theme');
        $theme_path = config_item('themes_path');
        if (file_exists(APPPATH . 'views/' . $theme_path . '/' . $theme_name . '/' . ucfirst($theme_name) . '.php')) {
            require_once(APPPATH . 'views/' . $theme_path . '/' . $theme_name . '/' . ucfirst($theme_name) . '.php');
        }
        if (in_array('settings_hook', array_map('strtolower', get_class_methods(strtolower($theme_name))))) {
            $theme_callable = new $theme_name();
            $temp['fields'] = $theme_callable->settings_hook();
        }
        if (!empty($temp)) {
            foreach ($temp as $k => $v) {
                foreach ($v as $kk => $vv) {
                    foreach ($vv as $kkk => $vvv) {
                        if (!in_array($kkk, ['field_type', 'tab_name'])) {
                            $theme['fields'][$kk][$kkk] = $vvv;
                        } else {
                            $theme['form_info'][$kk][$kkk] = $vvv;
                            $theme['form_info'][$kk]['field_id'] = $vv['id'];
                        }
                    }
                }
            }
        }
    }
}

/**
 * function settings_hook
 *
 * Retrieves all active modules
 *
 * @access public
 *
 * @return void
 */
if (!function_exists('settings_hook')) {
    function settings_hook()
    {
        global $modules;
        $ci =& get_instance();
        $temp = modules_active();
        if (!empty($temp)) {
            foreach ($temp as $k => $v) {
                $ci->load->module($v['slug']);
                if (
                    is_array(get_class_methods(strtolower($v['slug']))) &&
                    in_array('settings_hook', array_map('strtolower', get_class_methods(strtolower($v['slug']))))
                ) {
                    $temp2 = $ci->{$v['slug']}->settings_hook();
                    if (!empty($temp2)) {
                        foreach ($temp2 as $kk => $vv) {
                            $temp3['fields'][$kk] = $vv;
                        }
                    }
                }
            }
            if (!empty($temp3)) {
                foreach ($temp3 as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        foreach ($vv as $kkk => $vvv) {
                            if (!in_array($kkk, ['field_type', 'tab_name'])) {
                                $modules['fields'][$kk][$kkk] = $vvv;
                            } else {
                                $modules['form_info'][$kk][$kkk] = $vvv;
                                $modules['form_info'][$kk]['field_id'] = $vv['id'];
                            }
                        }
                    }
                }
            }
        }
        unset($temp, $temp2, $temp3);
    }
}
