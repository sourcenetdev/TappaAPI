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
 * KyrandiaCMS Access Helper
 *
 * Use this file to define all functions used specifically to govern access to the system.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

/**
 * Function current_user_can()
 *
 * Checks if the current user can perform a specific action.
 *
 * @access public
 *
 * @param string $class
 * @param string $action
 * @param string $checkpoint
 *
 * @return bool
 */
if (!function_exists('current_user_can')) {
    function current_user_can($checkpoint = '', $class = '', $action = '') {
        global $condition, $access;
        $ci =& get_instance();
        $class_data = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        if (empty($class)) {
            $class = $class_data[1]['class'];
        }
        if (empty($action)) {
            $action = $class_data[1]['function'];
        }
        $type = $class_data[1]['type'];

        // Edit this variable list to manage user access in a central location. Please note, this is NOT where user rights
        // are assigned, but merely to make code changes to modules unnecessary, should requirements for access change.
        if ($type == '->' || $type == '::') {
            $condition = $class . '::';
            $action = $class . '::' . $action;
        } else {
            $condition = '';
        }
        $ci->hooks->call_hook('permissions_settings');
        $has_role = false;
        $has_permission = false;

        // Checking class-level permissions.
        if (empty($action)) {
            if (!empty($access[$class]['roles'])) {
                $has_role = user_has_any_role($access[$class]['roles']);
            }
            if (!empty($access[$class]['permissions'])) {
                $has_permission = user_has_any_permission($access[$class]['permissions']);
            }
            if (user_has_any_role(['Super Administrator'])) {
                $has_role = true;
            }
            return $has_role || $has_permission;
        }

        // Checking action-level (method/function) permissions.
        if (empty($checkpoint)) {
            if (!empty($access[$class]['actions'][$action]['roles'])) {
                $has_role = user_has_any_role($access[$class]['actions'][$action]['roles']);
            }
            if (!empty($access[$class]['actions'][$action]['permissions'])) {
                $has_permission = user_has_any_permission($access[$class]['actions'][$action]['permissions']);
            }
            if (user_has_any_role(['Super Administrator'])) {
                $has_role = true;
            }
            return $has_role || $has_permission;
        }

        // Checking checkpoint-level (inside methods/functions) permissions.
        if (!empty($access[$class]['actions'][$action]['checkpoint'][$checkpoint]['roles'])) {
            $has_role = user_has_any_role($access[$class]['actions'][$action]['checkpoint'][$checkpoint]['roles']);
        }
        if (!empty($access[$class]['actions'][$action]['checkpoint'][$checkpoint]['permissions'])) {
            $has_permission = user_has_any_permission($access[$class]['actions'][$action]['checkpoint'][$checkpoint]['permissions']);
        }
        if (user_has_any_role(['Super Administrator'])) {
            $has_role = true;
        }
        return $has_role || $has_permission;
    }
}

/**
 * Function user_has_any_role()
 *
 * Returns whether the user has a particular role.
 *
 * @access public
 *
 * @param string $roles
 * @param bool $redirect
 *
 * @return bool true or false
 */
if (!function_exists('user_has_any_role')) {
    function user_has_any_role($roles, $redirect = false)
    {
        $sys =& get_instance();
        $sys->load->module('user');
        $user = $sys->session->all_userdata();
        $count = 0;
        if (empty($roles)) {
            if ($redirect) {
                redirect($redirect);
                die();
            }
            return false;
        }

        // Check user roles against specified roles.
        if (!empty($user['user_roles'])) {
            foreach ($roles as $role) {
                foreach ($user['user_roles'] as $r) {
                    if ($role === $r['role']) {
                        $count++;
                    }
                }
            }
        } else {
            if ($redirect) {
                redirect($redirect);
                die();
            }
            return false;
        }
        if ($count > 0) {

            // User has the required role, so redirect or return true.
            if ($redirect) {
                redirect($redirect);
                die();
            }
            return true;
        } else {

            // User does not have the required role, so redirect or return false.
            if ($redirect) {
                redirect($redirect);
                die();
            }
            return false;
        }
    }
}

/**
 * Function user_has_any_permission()
 *
 * Returns whether the user has a particular permission.
 *
 * @access public
 *
 * @param string $perms
 * @param bool $redirect
 *
 * @return bool true or false
 */
if (!function_exists('user_has_any_permission')) {
    function user_has_any_permission($perms, $redirect = false)
    {
        $sys =& get_instance();
        $sys->load->module('user');
        $user = $sys->session->all_userdata();
        $count = 0;
        if (empty($perms)) {
            if ($redirect) {
                redirect($redirect);
                die();
            }
            return false;
        }

        // Check user permissions against specified permissions.
        if (!empty($user['user_permissions'])) {
            foreach ($perms as $perm) {
                foreach ($user['user_permissions'] as $p) {
                    if ($perm === $p['permission']) {
                        $count++;
                    }
                }
            }
        } else {
            if ($redirect) {
                redirect($redirect);
                die();
            }
            return false;
        }
        if ($count > 0) {

            // User has the required permission, so redirect or return true.
            if ($redirect) {
                redirect($redirect);
                die();
            }
            return true;
        } else {

            // User does not have the required role, so redirect or return false.
            if ($redirect) {
                redirect($redirect);
                die();
            }
            return false;
        }
    }
}

/**
 * Function get_current_user_data()
 *
 * Returns the session data of the current user.
 *
 * @access public
 *
 * @param bool $json
 *
 * @return string formatted string.
 */
if (!function_exists('get_current_user_data')) {
    function get_current_user_data($json = false)
    {
        $sys =& get_instance();
        $sess = $sys->session->userdata();
        return _out($sess, $json);
    }
}

/**
 * Function get_current_user_logged_in()
 *
 * Returns the user ID of the current user.
 *
 * @access public
 *
 * @param bool $json
 *
 * @return mixed $uid or false.
 */
if (!function_exists('get_current_user_logged_in')) {
    function get_current_user_logged_in($json = false)
    {
        $sys =& get_instance();
        $uid = $sys->session->userdata('id');
        return _out($uid, $json);
    }
}

/**
 * Function get_current_user_roles()
 *
 * Returns the roles of the logged in user.
 *
 * @access public
 *
 * @param bool $json
 *
 * @return array
 */
if (!function_exists('get_current_user_roles')) {
    function get_current_user_roles($json = false)
    {
        $sys =& get_instance();
        $data = $sys->session->userdata('user_roles');
        return _out($data, $json);
    }
}

/**
 * Function get_current_user_permissions()
 *
 * Returns the roles of the logged in user.
 *
 * @access public
 *
 * @param bool $json
 *
 * @return array
 */
if (!function_exists('get_current_user_permissions')) {
    function get_current_user_permissions($json = false)
    {
        $sys =& get_instance();
        $data = $sys->session->userdata('user_permissions');
        return _out($data, $json);
    }
}

?>
