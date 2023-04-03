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
 * KyrandiaCMS Authentication Hook
 *
 * This is invoke authentication hooks for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Hooks
 * @category    Hooks
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

global $auth_enabled;

/**
 * function get_auth_source
 *
 * Retrieves the source hook file for the chosen 2FA.
 *
 * @access  public
 *
 * @return  void
 */
if (!function_exists('get_auth_source')) {
    function get_auth_source()
    {
        global $auth_enabled;
        $location = _cfg($auth_enabled . '_location');
        $filename = _cfg($auth_enabled . '_file');
        $source = $location . $filename;
        if (file_exists($source)) {
            include_once($source);
        }
        return file_exists($source);
    }
}

/**
 * function which_auth
 *
 * Determines from the configuration which 2FA we are using.
 *
 * @access  public
 *
 * @return  void
 */
if (!function_exists('which_auth')) {
    function which_auth()
    {
        global $auth_enabled;
        $which = _cfg('which_auth');
        $chosen = _cfg($which . '_enabled');
        if ($chosen) {
            $auth_enabled = $which;
        } else {
            $auth_enabled = null;
        }
    }
}

/**
 * function auth_hook_initialize
 *
 * Runs the auth initialization for the selected 2FA.
 *
 * @access  public
 *
 * @param array $params
 *
 * @return  void
 */
if (!function_exists('auth_hook_initialize')) {
    function auth_hook_initialize($params)
    {
        global $auth_enabled;
        which_auth();
        if (!empty($auth_enabled)) {
            $source = get_auth_source();
            if ($source) {
                $func = $auth_enabled . '_initialize';
                call_user_func_array($func, $params);
            }
        }
    }
}

/**
 * function auth_hook_execute
 *
 * Runs the main auth functionality for the selected 2FA.
 *
 * @access  public
 *
 * @param array $params
 *
 * @return  void
 */
if (!function_exists('auth_hook_execute')) {
    function auth_hook_execute($params)
    {
        global $auth_enabled;
        which_auth();
        if (!empty($auth_enabled)) {
            $source = get_auth_source();
            if ($source) {
                $func = $auth_enabled . '_execute';
                call_user_func_array($func, $params);
            }
        }
    }
}

/**
 * function auth_hook_get
 *
 * Retrieves the auth data for the chosen 2FA.
 *
 * @access  public
 *
 * @param array $params
 *
 * @return  void
 */
if (!function_exists('auth_hook_get')) {
    function auth_hook_get($params)
    {
        global $auth_enabled;
        which_auth();
        if (!empty($auth_enabled)) {
            $source = get_auth_source();
            if ($source) {
                $func = $auth_enabled . '_get';
                call_user_func_array($func, $params);
            }
        }
    }
}

/**
 * function auth_hook_complete
 *
 * Disposes of the chosen 2FA data on logout.
 *
 * @access  public
 *
 * @param array $params
 *
 * @return  void
 */
if (!function_exists('auth_hook_complete')) {
    function auth_hook_complete($params)
    {
        global $auth_enabled;
        which_auth();
        if (!empty($auth_enabled)) {
            $source = get_auth_source();
            if ($source) {
                $func = $auth_enabled . '_complete';
                call_user_func_array($func, $params);
            }
        }
    }
}