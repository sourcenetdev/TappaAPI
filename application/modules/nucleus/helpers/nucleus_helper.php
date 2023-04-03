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
 * KyrandiaCMS Nucleus Helper
 *
 * Use this file to define all functions used specifically by the nucleus library or modules using its features.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

/**
 * Function _list_files()
 *
 * Lists files in a directory (not iteratively by default)
 *
 * @access public
 *
 * @param string $path
 * @param array $mask
 * @param bool $no_extension
 * @param bool $recursive
 *
 * @return string
 */
if (!function_exists('_list_files')) {
    function _list_files($path, $mask = [], $no_extension = false, $recursive = false)
    {
        $return = [];
        if (!$recursive) {
            $fileSystemIterator = new FilesystemIterator($path);
            foreach ($fileSystemIterator as $file) {
                $ext = $file->getExtension();
                $fil = $file->getFilename();
                if (!empty($mask) && is_array($mask)) {
                    if (in_array($ext, $mask)) {
                        if ($no_extension) {
                            $return[] = _strtrim($fil, '.' . $ext);
                        } else {
                            $return[] = $fil;
                        }
                    }
                } else {
                    if ($no_extension) {
                        $return[] = _strtrim($fil, '.' . $ext);
                    } else {
                        $return[] = $fil;
                    }
                }
            }
        } else {
            $it = new RecursiveDirectoryIterator($path);
            foreach(new RecursiveIteratorIterator($it) as $file) {
                $ext = $file->getExtension();
                $fil = $file->getFilename();
                if (!empty($mask) && is_array($mask)) {
                    if (in_array($ext, $mask)) {
                        if ($no_extension) {
                            $return[] = _strtrim($fil, '.' . $ext);
                        } else {
                            $return[] = $fil;
                        }
                    }
                } else {
                    if ($no_extension) {
                        $return[] = _strtrim($fil, '.' . $ext);
                    } else {
                        $return[] = $fil;
                    }
                }
            }
        }
        return $return;
    }
}

/**
 * Function _log()
 *
 * Logs the data specified to the general system log of the system.
 *
 * @access public
 *
 * @param array $data
 * @param string $log
 *
 * @return int
 */
if (!function_exists('_log')) {
    function _log($data, $log = '')
    {
        $ci =& get_instance();
        set_on($data['status'], 'notset', '');
        set_on($data['code'], 'notset', '');
        set_on($data['type'], 'notset', 'Notice');
        set_on($data['message'], 'notset', '');
        set_on($data['impact'], 'notset', 'Normal');
        set_on($data['class'], 'notset', '');
        set_on($data['function'], 'notset', '');
        set_on($data['line'], 'notset', '');
        set_on($data['data'], 'notset', '');
        set_on($data['user_id'], 'notset', (_sess_get('id') ? _sess_get('id') : -1));
        set_on($data['username'], 'notset', (_sess_get('username') ? _sess_get('username') : 'Logged out user'));
        set_on($data['ip_address'], 'notset', $_SERVER['REMOTE_ADDR']);
        $insert_data = [
            'status' => $data['status'],
            'code' => $data['code'],
            'type' => $data['type'],
            'message' => $data['message'],
            'impact' => $data['impact'],
            'class' => $data['class'],
            'function' => $data['function'],
            'line' => $data['line'],
            'data' => json_encode($data['data']),
            'user_id' => $data['user_id'],
            'username' => $data['username'],
            'ip_address' => $data['ip_address'],
            'createdate' => date('Y-m-d H:i:s')
        ];
        $ci->db->insert(_cfg('db_prefix') . $log . 'log', $insert_data);
        return $ci->db->insert_id();
    }
}

/**
 * Function _200()
 *
 * This function allows you to do a generic status 200 log entry. Wrapper for $this->syslog->log_200().
 *
 * @access public
 *
 * @param string $log
 * @param string $message
 * @param array $data
 *
 * @return void
 */
if (!function_exists('_200')) {
    function _200($log, $message, $data = [])
    {
        $ci =& get_instance();
        $ci->nucleus->log_200($log, $message, 'Notice', 'Low', $data);
    }
}

/**
 * Function _400()
 *
 * This function allows you to do a generic status 400 log entry. Wrapper for $this->syslog->log_400().
 *
 * @access public
 *
 * @param string $log
 * @param string $message
 * @param array $data
 *
 * @return void
 */
if (!function_exists('_400')) {
    function _400($log, $message, $data = [])
    {
        $ci =& get_instance();
        $ci->nucleus->log_400($log, $message, 'Bad request', 'High', $data);
    }
}

/**
 * Function _401()
 *
 * This function allows you to do a generic status 401 log entry. Wrapper for $this->syslog->log_401().
 *
 * @access public
 *
 * @param string $log
 * @param string $message
 * @param array $data
 *
 * @return void
 */
if (!function_exists('_401')) {
    function _401($log, $message, $data = [])
    {
        $ci =& get_instance();
        $ci->nucleus->log_401($log, $message, 'Unauthorized', 'High', $data);
    }
}

/**
 * Function _403()
 *
 * This function allows you to do a generic status 403 log entry. Wrapper for $this->syslog->log_403().
 *
 * @access public
 *
 * @param string $log
 * @param string $message
 * @param array $data
 *
 * @return void
 */
if (!function_exists('_403')) {
    function _403($log, $message, $data = [])
    {
        $ci =& get_instance();
        $ci->nucleus->log_403($log, $message, 'Forbidden', 'High', $data);
    }
}

/**
 * Function _404()
 *
 * This function allows you to do a generic status 404 log entry. Wrapper for $this->syslog->log_404().
 *
 * @access public
 *
 * @param string $log
 * @param string $message
 * @param array $data
 *
 * @return void
 */
if (!function_exists('_404')) {
    function _404($log, $message, $data = [])
    {
        $ci =& get_instance();
        $ci->nucleus->log_404($log, $message, 'Not found', 'Medium', $data);
    }
}

/**
 * Function _405()
 *
 * This function allows you to do a generic status 405 log entry. Wrapper for $this->syslog->log_405().
 *
 * @access public
 *
 * @param string $log
 * @param string $message
 * @param array $data
 *
 * @return void
 */
if (!function_exists('_405')) {
    function _405($log, $message, $data = [])
    {
        $ci =& get_instance();
        $ci->nucleus->log_405($log, $message, 'Method not allowed', 'Medium', $data);
    }
}

/**
 * Function _409()
 *
 * This function allows you to do a generic status 409 log entry. Wrapper for $this->syslog->log_409().
 *
 * @access public
 *
 * @param string $log
 * @param string $message
 * @param array $data
 *
 * @return void
 */
if (!function_exists('_409')) {
    function _409($log, $message, $data = [])
    {
        $ci =& get_instance();
        $ci->nucleus->log_409($log, $message, 'Admin override', 'Medium', $data);
    }
}

/**
 * Function _500()
 *
 * This function allows you to do a generic status 500 log entry. Wrapper for $this->syslog->log_500().
 *
 * @access public
 *
 * @param string $log
 * @param string $message
 * @param array $data
 *
 * @return void
 */
if (!function_exists('_500')) {
    function _500($log, $message, $data = [])
    {
        $ci =& get_instance();
        $ci->nucleus->log_500($log, $message, 'Internal server error', 'Medium', $data);
    }
}

/**
 * Function _settings_check()
 *
 * Checks a module's settings.
 *
 * @access public
 *
 * @param string $module
 *
 * @return string
 */
if (!function_exists('_settings_check')) {
    function _settings_check($module)
    {
        $ci =& get_instance();
        $ci->load->module('nucleus');

        // Check if module settings are correct
        $settings = _check_settings($module);
        if ($settings['status'] != 200) {
            die($settings['message']);
        }

        // We check the module's dependencies.
        $status = _check_dependencies($module);
        if ($status['status'] != 200) {
            die($status['message']);
        }
    }
}

/**
 * Function _check_settings
 *
 * This function checks a module's settings, logs the status and returns the status.
 *
 * @access public
 *
 * @param string $mod
 * @param bool $json
 *
 * @return boolean
 */
if (!function_exists('_check_settings')) {
    function _check_settings($mod = 'core', $json = false)
    {

        // This can be expanded for more rigorous checks... For now PoC.
        $check_set = _get_settings($mod);
        if (!empty($check_set)) {
            if ($check_set['required'] == 'Yes' && $check_set['active'] == 'No') {
                $data['error'] = 'The ' . $mod . ' module is required but not active. Check settings file in module config.';
                $status = [
                    'status' => 500,
                    'message' => $data['error']
                ];
            } else {
                $data['status'] = 'The ' . $mod . ' module passed its settings check.';
                $status = [
                    'status' => 200,
                    'message' => $data['status']
                ];
            }
        } else {
            $data['error'] = 'The ' . $mod . ' module settings are incorrect.';
            $status = [
                'status' => 500,
                'message' => $data['error']
            ];
        }
        if ($json) {
            return json_encode($status);
        }
        return $status;
    }
}

/**
 * check_dependencies
 *
 * This function checks a module's dependencies, logs the status and returns the status.
 *
 * @access public
 *
 * @param string $mod
 * @param bool $json
 *
 * @return boolean
 */
if (!function_exists('_check_dependencies')) {
    function _check_dependencies($mod = 'core', $json = false)
    {
        $ci =& get_instance();
        $ci->load->module('nucleus');
        if ($ci->nucleus->log_everything) {
            _200('system', 'Dependencies checked');
        }
        $check_dep = _get_dependencies($mod);
        $check_set = _get_settings($mod);

        // Check if all dependencies are active.
        $not_active = [];
        if (!empty($check_dep)) {
            foreach ($check_dep as $k => $v) {
                $act_check[$k] = _get_active($mod);
                if (!$act_check[$k]) {
                    $not_active[] = $k;
                }
            }
            if (count($not_active) != 0) {
                $status = [
                    'status' => 500,
                    'message' => 'Not all prerequisite modules for this module is active. Missing ' . implode(', ', $not_active) . '.'
                ];
                return json_encode($status);
            }
        }

        // Check if all dependencies are the correct versions.
        $versions = [];
        if (!empty($check_set['dependencies']) && !empty($check_dep)) {
            foreach ($check_set['dependencies'] as $k => $v) {
                $versions[$k] = _get_version($k);
            }
            $temp = [];
            $failed = [];
            $passed = [];
            if (!empty($versions)) {
                foreach ($check_dep as $k => $v) {
                    $temp = explode(' ', $v['version']);
                    if (!empty($temp[0]) && !empty($temp[1])) {
                        if ($temp[0] == '=') {

                            // Check for exact version match.
                            if (!empty($temp[1]) && $temp[1] != $versions[$k]) {
                                $failed[$k] = $k;
                            } else {
                                $passed[$k] = $k;
                            }
                        } elseif ($temp[0] == '<') {

                            // Check for version less-than match.
                            if (!empty($temp[1]) && $versions[$k] >= $temp[1]) {
                                $failed[$k] = $k;
                            } else {
                                $passed[$k] = $k;
                            }
                        } elseif ($temp[0] == '>') {

                            // Check for version greater-than match.
                            if (!empty($temp[1]) && $versions[$k] <= $temp[1]) {
                                $failed[$k] = $k;
                            } else {
                                $passed[$k] = $k;
                            }
                        } elseif ($temp[0] == '>=') {

                            // Check for version greater-than-or-equal-to match.
                            if (!empty($temp[1]) && $versions[$k] < $temp[1]) {
                                $failed[$k] = $k;
                            } else {
                                $passed[$k] = $k;
                            }
                        } elseif ($temp[0] == '<=') {

                            // Check for version less-than-or-equal-to match.
                            if (!empty($temp[1]) && $versions[$k] > $temp[1]) {
                                $failed[$k] = $k;
                            } else {
                                $passed[$k] = $k;
                            }
                        } else {

                            // No rules matched, so dependencies fail.
                            $failed[$k] = $k;
                        }
                    }
                }
            }
        }
        if (!empty($failed)) {
            $data['error'] = 'Some modules required by this module are the incorrect versions. Please check modules ' . implode(', ', $failed) . '.';
            $status = [
                'status' => 500,
                'message' => $data['error']
            ];
            if ($this->log_everything) {
                _500('system', $data['error']);
            }
            if ($json) {
                return json_encode($status);
            }
            return $status;
        }
        $data['success'] = 'The requirements for this module has been met.';
        $status =  [
            'status' => 200,
            'message' => $data['success']
        ];
        if ($json) {
            return json_encode($status);
        }
        return $status;
    }
}

/**
 * get_settings
 *
 * This function checks a module's folder for its settings config file, and includes it if it exists,
 * and finally setting it's settings in the $settings variable.
 *
 * @access public
 *
 * @param string $module
 * @param bool $headers
 *
 * @return mixed
 */
if (!function_exists('_get_settings')) {
    function _get_settings($module = 'core', $headers = false)
    {
        $ci =& get_instance();
        $ci->load->module('nucleus');
        if (file_exists(APPPATH . 'modules/' . $module . '/config/settings.php')) {

            // The file exists, so it loads it and sets the module's settings in the global core settings array.
            include(APPPATH . 'modules/' . $module . '/config/settings.php');
            if (!empty($settings)) {
                if (!empty($settings[$module])) {
                    $ci->nucleus->settings[$module] = $settings[$module];
                    $sess = $ci->session->userdata('settings_' . $module);
                    if (!$sess) {
                        $ci->session->set_userdata('settings_' . $module, $settings[$module]);
                    }
                    return $settings[$module];
                }
            }
            if ($ci->nucleus->log_everything) {
                _200('system', 'Settings retrieved for module ' . $module);
            }
        } else {
            if ($this->log_everything) {
                _404('system', 'Settings could not be retrieved for module ' . $module);
            }
            return false;
        }
    }
}

/**
 * Function _get_attribute
 *
 * This function checks if an attribute for the module's is set, and then returns it.
 *
 * @access public
 *
 * @param string $module
 * @param bool $headers
 * @param bool $json
 *
 * @return string || bool
 */
if (!function_exists('_get_attribute')) {
    function _get_attribute($attribute, $module = 'core', $headers = false, $json = false)
    {
        $ci =& get_instance();
        if (!empty($ci->nucleus->settings[$module][$attribute])) {

            // The version is set, so we return it.
            if ($ci->nucleus->log_everything) {
                _200('system', ucfirst($attribute) . ' retrieved for module ' . $module);
            }

            // Return the response.
            if ($json) {
                $response = [
                    'status' => 200,
                    'module' => $module,
                    'response' => $this->settings[$module][$attribute]
                ];
                return json_encode($response);
            } else {
                return $ci->nucleus->settings[$module][$attribute];
            }
        } else {

            // The version is not set, so handle the error.
            if ($this->log_everything) {
                _500('system', ucfirst($attribute) . ' not retrieved for module ' . $module);
            }

            // Return the response.
            if ($json) {
                $response = [
                    'status' => 500,
                    'response' => false
                ];
                return json_encode($response);
            } else {
                return false;
            }
        }
    }
}

/**
 * Function _get_version
 *
 * This function checks if the module's version is set, and then returns it.
 *
 * @access public
 *
 * @param string $module
 * @param bool $headers
 * @param bool $json
 *
 * @return string || bool
 */
if (!function_exists('_get_version')) {
    function _get_version($module = 'core', $headers = false, $json = false)
    {
        return _get_attribute('version', $module, $headers, $json);
    }
}

/**
 * Function _get_required
 *
 * This function checks if the module is required.
 *
 * @access public
 *
 * @param string $module
 * @param bool $headers
 * @param bool $json
 *
 * @return mixed
 */
if (!function_exists('_get_required')) {
    function _get_required($module = 'core', $headers = false, $json = false)
    {
        return _get_attribute('required', $module, $headers, $json);
    }
}

/**
 * Function _get_active
 *
 * This function checks if the module is active.
 *
 * @access public
 *
 * @param string $module
 * @param bool $headers
 * @param bool $json
 *
 * @return mixed
 */
if (!function_exists('_get_active')) {
    function _get_active($module = 'core', $headers = false, $json = false)
    {
        return _get_attribute('active', $module, $headers, $json);
    }
}

/**
 * Function _get_dependencies
 *
 * This function checks if the module has dependencies, and then returns the array of dependencies.
 *
 * @access public
 *
 * @param string $module
 * @param bool $json
 *
 * @return mixed
 */
if (!function_exists('_get_dependencies')) {
    function _get_dependencies($module = 'nucleus', $json = false)
    {
        $ci =& get_instance();
        $ci->load->module('nucleus');
        if (!empty($ci->nucleus->settings[$module]['dependencies'])) {

            // Dependencies are set, so handle it.
            if ($ci->nucleus->log_everything) {
                _200('system', 'Dependencies retrieved for module ' . $module);
            }
            if ($json) {
                return json_encode($this->settings[$module]['dependencies']);
            }
            return $ci->nucleus->settings[$module]['dependencies'];
        } else {

            // No dependencies set, so handle it appropriately.
            if ($ci->nucleus->log_everything) {
                _404('system', 'Dependencies could not be retrieved for module ' . $module);
            }
            return false;
        }
    }
}

/**
 * Function _dependency_fail
 *
 * This function logs and renders a dependency fail page, and optionally returns a JSON array of the data.
 *
 * @access public
 *
 * @param bool $json
 *
 * @return mixed
 */
if (!function_exists('_dependency_fail')) {
    function _dependency_fail($json = false)
    {

        // Log the error and render the view.
        $ci =& get_instance();
        header("HTTP/1.1 500 Internal server error");
        _500('system', 'Dependency error');
        $data['error'] = $ci->session->userdata('error');
        _render(_cfg('admin_theme'), 'nucleus/error_dependency', $data);

        // Return JSON response if requested.
        if ($json) {
            $response = [
                'status' => 500,
                'message' => 'Dependency error.'
            ];
            return json_encode($response);
        }
    }
}

/**
 * Function _no_access
 *
 * This function logs and renders an access denied page, and optionally returns a JSON array of the data.
 *
 * @access public
 *
 * @param bool $json
 *
 * @return mixed
 */
if (!function_exists('_no_access')) {
    function _no_access($json = false)
    {

        // Log the error and render the view.
        $ci =& get_instance();
        header("HTTP/1.1 403 Forbidden");
        _403('system', 'Access denied');
        $data['error'] = $ci->session->userdata('error');
        _render(_cfg('admin_theme'), 'nucleus/error_access', $data);

        // Return JSON response if requested.
        if ($json) {
            $response = [
                'status' => 403,
                'message' => 'Access denied.'
            ];
            return json_encode($response);
        }
    }
}

/**
 * four_oh_four
 *
 * This function sends a 404 header and displays a content page indicating that the page requested was not found.
 *
 * @todo make it more useful, perhaps? What about a search box? What about switching off administrator mails?
 * @todo Also triggers for missing files such as favicon. To revisit later.
 *
 * @access  public
 *
 * @return  void
 */
if (!function_exists('_page_404')) {
    function _page_404()
    {
        $ci =& get_instance();
        $ci->page_404();
    }
}

/**
 * Function _attr()
 *
 * Adds an attribute and associated value to a html tag. Wrapper for add_tag_attribute().
 *
 * @access public
 *
 * @param bool $attribute
 * @param string $value
 *
 * @return string
 */
if (!function_exists('_attr')) {
    function _attr($attribute, $value)
    {
        return add_tag_attribute($attribute, $value);
    }
}
