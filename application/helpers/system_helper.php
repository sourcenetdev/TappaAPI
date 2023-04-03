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
 * KyrandiaCMS System Helper
 *
 * Contains a list of system base functions used in the system.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

 /**
 * Function get_system_notices()
 *
 * Retrieves the system notices from the session data.
 *
 * @access public
 *
 * @param string $which
 * @param string $type
 *
 * @return array
 */
if (!function_exists('get_system_notices')) {
    function get_system_notices($which = 'all', $type = '')
    {
        $ci =& get_instance();
        $notices = $ci->session->userdata('notices');
        if ($which == 'all') {
            if (!empty($type)) {
                $final = [];
                foreach ($notices as $k => $v) {
                    if (!empty($v[$type])) {
                        $final[$type][$k] = $v[$type];
                    }
                }
                return $final;
            } else {
                $final = [];
                if (!empty($notices)) {
                    foreach ($notices as $k => $v) {
                        foreach ($v as $kk => $vv) {
                            $final[$kk][$k] = $vv;
                        }
                    }
                }
                return $final;
            }
        } else {
            if (!empty($notices[$which])) {
                if (!empty($notices[$which][$type])) {
                    return $notices[$which][$type];
                } else {
                    return [];
                }
            } else {
                return [];
            }
        }
    }
}

/**
 * Function set_system_notice()
 *
 * Retrieves the system notices from the session data.
 *
 * @access public
 *
 * @param string $identifier
 * @param string $message
 * @param string $notice_type
 * @param bool $overwrite_if_exists
 *
 * @return bool
 */
if (!function_exists('set_system_notice')) {
    function set_system_notice($identifier, $message, $notice_type = 'info', $overwrite_if_exists = true)
    {
        $ci =& get_instance();
        $notices = $ci->session->userdata('notices');
        if (!empty($notices[$identifier]) && $overwrite_if_exists !== false) {
            $notices[$identifier][$notice_type] = $message;
        } elseif (empty($notices[$identifier])) {
            $notices[$identifier][$notice_type] = $message;
        }
        $ci->session->set_userdata('notices', $notices);
    }
}

/**
 * Function unset_system_notice()
 *
 * Unsets a system notice or notices.
 *
 * @access public
 *
 * @param string $identifier
 * @param string $type
 *
 * @return bool
 */
if (!function_exists('unset_system_notice')) {
    function unset_system_notice($identifier, $type = 'all')
    {
        $ci =& get_instance();
        $notices = $ci->session->userdata('notices');
        if ($identifier == 'all') {
            if ($type == 'all') {
                $ci->session->unset_userdata('notices');
            } else {
                foreach ($notices as $k => $v) {
                    unset($notices[$k][$type]);
                }
                $ci->session->set_userdata('notices', $notices);
            }
        } else {
            if ($type == 'all') {
                unset($notices[$identifier]);
                $ci->session->set_userdata('notices', $notices);
            } else {
                unset($notices[$identifier][$type]);
                $ci->session->set_userdata('notices', $notices);
            }
        }
    }
}

/**
 * Function _libraries_load()
 *
 * Loads an array of libraries.
 *
 * @access public
 *
 * @param array $libraries
 *
 * @return void
 */
if (!function_exists('_libraries_load')) {
    function _libraries_load($libraries)
    {
        $ci =& get_instance();
        if (!is_array($libraries)) {
            $libraries = (array)$libraries;
        }
        if (!empty($libraries)) {
            foreach ($libraries as $library) {
                $ci->load->library($library);
            }
        }
    }
}

/**
 * Function _helpers_load()
 *
 * Loads an array of helpers.
 *
 * @access public
 *
 * @param array $helpers
 *
 * @return void
 */
if (!function_exists('_helpers_load')) {
    function _helpers_load($helpers)
    {
        $ci =& get_instance();
        if (!is_array($helpers)) {
            $helpers = (array)$helpers;
        }
        if (!empty($helpers)) {
            foreach ($helpers as $helper) {
                $ci->load->helper($helper);
            }
        }
    }
}

/**
 * Function _languages_load()
 *
 * Loads an array of languages.
 *
 * @access public
 *
 * @param array $languages
 *
 * @return void
 */
if (!function_exists('_languages_load')) {
    function _languages_load($languages)
    {
        $ci =& get_instance();
        if (!is_array($languages)) {
            $languages = (array)$languages;
        }
        if (!empty($languages)) {
            foreach ($languages as $language) {
                $ci->load->language($language);
            }
        }
    }
}

/**
 * Function _models_load()
 *
 * Loads an array of models.
 *
 * @access public
 *
 * @param array $models
 *
 * @return void
 */
if (!function_exists('_models_load')) {
    function _models_load($models)
    {
        $ci =& get_instance();
        if (!is_array($models)) {
            $models = (array)$models;
        }
        if (!empty($models)) {
            foreach ($models as $model) {
                $ci->load->model($model);
            }
        }
    }
}

/**
 * Function _modules_load()
 *
 * Loads an array of modules.
 *
 * @access public
 *
 * @param array $modules
 *
 * @return void
 */
if (!function_exists('_modules_load')) {
    function _modules_load($modules)
    {
        $ci =& get_instance();
        if (!is_array($modules)) {
            $modules = (array)$modules;
        }
        if (!empty($modules)) {
            foreach ($modules as $module) {
                $ci->load->module($module);
            }
        }
    }
}

/**
 * Function _validate()
 *
 * This function sets the validation rules for a particular field set. Wrapper for $this->core->set_form_validation_rules().
 *
 * @access public
 *
 * @param array $data
 *
 * @return void
 */
if (!function_exists('_validate')) {
    function _validate($data)
    {
        $ci =& get_instance();
        return $ci->core->set_form_validation_rules($data);
    }
}

/**
 * Function _var()
 *
 * Returns a variable value. Wrapper for $this->core->get_variable().
 *
 * @access public
 *
 * @param string $variable
 * @param string $default
 * @param bool $json
 *
 * @return string
 */
if (!function_exists('_var')) {
    function _var($variable, $default = '', $json = false)
    {
        $ci =& get_instance();
        $response = $ci->variable_model->get_variable($variable, $default);
        if ($ci->nucleus->log_everything) {
            _200('system', 'Variable ' . $variable . ' retrieved with value ' . $response);
        }
        if ($json) {
            if (!empty($response)) {
                $result = [
                    'status' => 200,
                    'result' => $response
                ];
            } else {
                $result = [
                    'status' => 404,
                    'result' => ''
                ];
            }
            return json_encode($result);
        } else {
            return $response;
        }
    }
}
