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
 * @version   6.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Module Helper
 *
 * Use this file to define all functions used specifically by the Module module or modules using its features.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

/**
 * Function module_outdated()
 *
 * Checks whether a module is outdated.
 *
 * @access public
 *
 * @param string $slug
 *
 * @return bool
 */
if (!function_exists('module_outdated')) {
    function module_outdated($slug)
    {
        return module_by($slug, 'status', 'Outdated');
    }
}

/**
 * Function module_maintained()
 *
 * Checks whether a module is maintained.
 *
 * @access public
 *
 * @param string $slug
 *
 * @return bool
 */
if (!function_exists('module_maintained')) {
    function module_maintained($slug)
    {
        return module_by($slug, 'status', 'Maintained');
    }
}

/**
 * Function module_active()
 *
 * Checks whether a module is active or not.
 *
 * @access public
 *
 * @param string $slug
 *
 * @return bool
 */
if (!function_exists('module_active')) {
    function module_active($slug)
    {
        return module_by($slug, 'active', 'Yes');
    }
}

/**
 * Function module_required()
 *
 * Checks whether a module is required or not.
 *
 * @access public
 *
 * @param string $slug
 *
 * @return bool
 */
if (!function_exists('module_required')) {
    function module_required($slug)
    {
        return module_by($slug, 'required', 'Yes');
    }
}

/**
 * Function module_by()
 *
 * Retrieves a module matching specified criteria.
 *
 * @access public
 *
 * @param string $slug
 * @param string $field
 * @param string $value
 *
 * @return bool
 */
if (!function_exists('module_by')) {
    function module_by($slug, $field, $value)
    {
        $ci =& get_instance();
        $temp = [];
        $mod = $ci->module_model->get_module_by_slug($slug);
        if (!empty($mod[0])) {
            if ($mod[0][$field] == $value) {
                $temp[] = $mod[0];
            }
        }
        return $temp;
    }
}

/**
 * Function modules_outdated()
 *
 * Retrieves all modules not being maintained.
 *
 * @access public
 *
 * @return bool
 */
if (!function_exists('modules_outdated')) {
    function modules_outdated()
    {
        return modules_by('status', 'Outdated');
    }
}

/**
 * Function modules_maintained()
 *
 * Retrieves all modules being maintained.
 *
 * @access public
 *
 * @return bool
 */
if (!function_exists('modules_maintained')) {
    function modules_maintained()
    {
        return modules_by('status', 'Maintained');
    }
}

/**
 * Function modules_active()
 *
 * Retrieves all active modules.
 *
 * @access public
 *
 * @return bool
 */
if (!function_exists('modules_active')) {
    function modules_active()
    {
        return modules_by('active', 'Yes');
    }
}

/**
 * Function modules_required()
 *
 * Retrieves all active and required modules.
 *
 * @access public
 *
 * @return bool
 */
if (!function_exists('modules_required')) {
    function modules_required()
    {
        return modules_by('required', 'Yes');
    }
}

/**
 * Function modules_by()
 *
 * Retrieves all modules matching specified criteria.
 *
 * @access public
 *
 * @param string $field
 * @param string $value
 *
 * @return bool
 */
if (!function_exists('modules_by')) {
    function modules_by($field, $value)
    {
        $ci =& get_instance();
        $temp = [];
        $ci->load->model('module/module_model');
        $mods = $ci->module_model->get_all_modules(true);
        if (!empty($mods)) {
            foreach ($mods as $mod) {
                if ($mod[$field] == $value) {
                    $temp[] = $mod;
                }
            }
        }
        return $temp;
    }
}
