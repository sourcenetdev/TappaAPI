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
 * KyrandiaCMS Core Hook
 *
 * This is the core hook file for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Hooks
 * @category    Hooks
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

    /**
     * function get_module_js()
     *
     * Loads the required module's JS files
     *
     * @access  public
     *
     * @param   string $module - the module whose JS file must be loaded.
     *
     * @return  void
     */
    function get_module_js($module = '')
    {
        global $themename;
        $ci =& get_instance();
        $ci->load->module('module');
        if ($module == '' && $themename != '') {

            // No module CSS exists, so load system JS for the template.
            _execute_system_js($themename);
        } elseif ($module == 'all') {

            // Loads all active modules' JS files.
            $mods = $ci->module_model->get_all_modules(true);
            if (!empty($mods)) {
                foreach ($mods as $mod) {
                    _execute_module_js($mod);
                }
            }
        } else {

            // Alternatively, load the specific module's JS files.
            $mod = $ci->module_model->get_module_by_slug($module, true);
            if (!empty($mod)) {
                _execute_module_js($module);
            }
        }
    }

    /**
     * function get_module_css()
     *
     * Loads the required module's CSS files
     *
     * @access  public
     *
     * @param   string $module - the module whose CSS file must be loaded.
     *
     * @return  void
     */
    function get_module_css($module = '')
    {
        global $themename;
        $ci =& get_instance();
        $ci->load->module('module');
        if ($module == '' && $themename != '') {

            // No module CSS exists, so load system CSS for the template.
            _execute_system_css($themename);
        } elseif ($module == 'all') {

            // Loads all active modules' CSS files.
            $mods = $ci->module_model->get_all_modules(true);
            if (!empty($mods)) {
                foreach ($mods as $mod) {
                    _execute_module_css($mod);
                }
            }
        } else {

            // Alternatively, load the specific module's CSS files.
            $mod = $ci->module_model->get_module_by_slug($module, true);
            if (!empty($mod)) {
                _execute_module_css($module);
            }
        }
    }

    /**
     * function _execute_module_js()
     *
     * Build up the script tags for a module.
     *
     * @access  public
     *
     * @param   string $module - the module whose JS files must be loaded.
     * @param   string $namespace - a unique name space for the JS files, to ensure uniqueness.
     *
     * @return  void
     */
    function _execute_module_js($module = '', $namespace = '')
    {
        $ci =& get_instance();
        $namespace = $namespace . '_' . $module['slug'] . '_module_script_';
        $module_root = APPPATH . 'modules/' . $module['slug'] . '/';

        // First check if a include config file exists, and if so, include it.
        if (file_exists($module_root . 'config/includes.php')) {
            include ($module_root . 'config/includes.php');

            // If any scripts are defined, process the $scripts array accordingly.
            if (!empty($scripts)) {
                foreach ($scripts as $sk => $sv) {

                    // Check if the path is defined, if not, default to assets/js
                    if (!isset($sv['path'])) {
                        $scripts[$sk]['path'] = $module_root . '/assets/js/';
                    } else {
                        $scripts[$sk]['path'] = $module_root . '/assets/js/' . $scripts[$sk]['path'];
                    }

                    // Checks if the location is defined, if not, defaults to the <body> tag
                    if (!isset($scripts[$sk]['place'])) {
                        $scripts[$sk]['place'] = 'body';
                    }

                    // Checks if the method of inclusion is defined, if not, defaults to including as a link and not inline
                    if (!isset($scripts[$sk]['method'])) {
                        $scripts[$sk]['method'] = 'link';
                    }

                    // Checks if the type is defined, if not, defaults to nothing
                    if (!isset($scripts[$sk]['type'])) {
                        $scripts[$sk]['type'] = '';
                    } else {
                        $scripts[$sk]['type'] = ' type="' . $scripts[$sk]['type'] . '"';
                    }

                    // Retrieves the script's name so that the template data can be set
                    $scripts[$sk]['script'] = $sk;

                    // The code to generate the necessary include depends on the linking method
                    if ($scripts[$sk]['method'] == 'link') {
                        $script['key'] = md5($namespace . $sk);
                        $script['value'] = '<script' . $scripts[$sk]['type'] . ' src="' . $scripts[$sk]['path'] . $scripts[$sk]['script'] . '"></script>';
                    } else {
                        $script['key'] = md5($namespace . $sk);
                        $script['value'] = '<script' . $scripts[$sk]['type'] . '>' . "\r\n" . file_get_contents($scripts[$sk]['path'] . $scripts[$sk]['script']) . "\r\n" . '</script>';
                    }

                    // Sets the variable in the template for inclusion
                    $ci->template->set($script['key'], $script['value'], $scripts[$sk]['place']);
                }
            }
        }
    }

    /**
     * function _execute_module_css()
     *
     * Build up the CSS tags for a module.
     *
     * @access  public
     *
     * @param   string $module - the module whose CS files must be loaded.
     * @param   string $namespace - a unique name space for the CSS files, to ensure uniqueness.
     *
     * @return  void
     */
    function _execute_module_css($module = '', $namespace = '')
    {
        $ci =& get_instance();
        $namespace = $namespace . '_' . $module['slug'] . '_css_';

        // First check if a include config file exists, and if so, include it.
        if (file_exists(APPPATH . 'modules/' . $module['slug'] . '/' . 'config/includes.php')) {
            include (APPPATH . 'modules/' . $module['slug'] . '/' . 'config/includes.php');

            // If any scripts are defined, process the $scripts array accordingly.
            if (!empty($css)) {
                foreach ($css as $sk => $sv) {

                    // Checks if the path is defined, if not, defaults to assets/css
                    if (!isset($css[$sk]['path'])) {
                        $css[$sk]['path'] = base_url() . 'application/modules/' . $module['slug'] . '/assets/css/';
                    } else {
                        $css[$sk]['path'] = base_url() . $css[$sk]['path'];
                    }

                    // Checks if the location is defined, if not, defaults to the <head> tag
                    if (!isset($css[$sk]['place'])) {
                        $css[$sk]['place'] = 'head';
                    }

                    // Checks if the method of inclusion is defined, if not, defaults to including as a link and not inline
                    if (!isset($css[$sk]['method'])) {
                        $css[$sk]['method'] = 'link';
                    }

                    // Checks if the type is defined, if not, defaults to nothing, and adds the "rel" attribute when included as a link
                    if (!isset($css[$sk]['type'])) {
                        $css[$sk]['type'] = ' rel="stylesheet"';
                    } else {
                        if ($css[$sk]['method'] == 'link') {
                            $css[$sk]['type'] = ' rel="stylesheet"';
                        } else {
                            $css[$sk]['type'] = '';
                        }
                    }

                    // Retrieves the css file's name so that the template data can be set
                    $css[$sk]['css'] = $sk;

                    // The code to generate the necessary include depends on the linking method
                    if ($css[$sk]['method'] == 'link') {
                        $css['key'] = md5($namespace . $sk);
                        $css['value'] = '<link' . $css[$sk]['type'] . ' href="' . $css[$sk]['path'] . $css[$sk]['css'] . '">';
                    } else {
                        $css['key'] = md5($namespace . $sk);
                        $css['value'] = '<style' . $css[$sk]['type'] . '>' . "\r\n" . file_get_contents($css[$sk]['path'] . $css[$sk]['css']) . "\r\n" . '</style>';
                    }

                    // Sets the variable in the template for inclusion
                    $ci->template->set($css['key'], $css['value'], $css[$sk]['place']);
                }
            }
        }
    }

    /**
     * function _execute_system_js()
     *
     * Build up the script tags for the template.
     *
     * @access  public
     *
     * @param   string $template - the template whose JS files must be loaded.
     *
     * @return  void
     */
    function _execute_system_js($template = '')
    {
        $ci =& get_instance();
        $namespace = '_system_script_';

        // First check if a include config file exists, and if so, include it.
        if (file_exists(APPPATH . 'config/kcms_includes.php')) {
            include (APPPATH . 'config/kcms_includes.php');
            $template_scripts = $scripts[$template];

            // If any scripts are defined, process the $scripts array accordingly.
            if (!empty($template_scripts)) {
                foreach ($template_scripts as $sk => $sv) {

                    // Checks if the path is defined, if not, defaults to assets/js
                    if (!isset($sv['path'])) {
                        $template_scripts[$sk]['path'] = base_url() . 'assets/js';
                    } else {
                        $template_scripts[$sk]['path'] = base_url() . $template_scripts[$sk]['path'];
                    }

                    // Checks if the location is defined, if not, defaults to the <body> tag
                    if (!isset($template_scripts[$sk]['place'])) {
                        $template_scripts[$sk]['place'] = 'body';
                    }

                    // Checks if the method of inclusion is defined, if not, defaults to including as a link and not inline
                    if (!isset($scripts[$sk]['method'])) {
                        $template_scripts[$sk]['method'] = 'link';
                    }

                    // Checks if the type is defined, if not, defaults to nothing
                    if (!isset($scripts[$sk]['type'])) {
                        $template_scripts[$sk]['type'] = '';
                    } else {
                        $template_scripts[$sk]['type'] = ' type="' . $template_scripts[$sk]['type'] . '"';
                    }

                    // Retrieves the script's name so that the template data can be set
                    $template_scripts[$sk]['script'] = $sk;

                    // The code to generate the necessary include depends on the linking method
                    if ($sv['method'] == 'link') {
                        $script['key'] = md5($namespace . $sk);
                        $script['value'] = '<script' . $template_scripts[$sk]['type'] . ' src="' . $template_scripts[$sk]['path'] . $template_scripts[$sk]['script'] . '"></script>';
                    } else {
                        $script['key'] = md5($namespace . $sk);
                        $script['value'] = '<script' . $template_scripts[$sk]['type'] . '>' . "\r\n" . file_get_contents($template_scripts[$sk]['path'] . $template_scripts[$sk]['script']) . "\r\n" . '</script>';
                    }

                    // Sets the variable in the template for inclusion
                    _set_template_data($script['key'], $script['value'], $template_scripts[$sk]['place']);
                }
            }
        }
    }

    /**
     * function _execute_system_css()
     *
     * Build up the CSS tags for the template.
     *
     * @access  public
     *
     * @param   string $template - the template whose CSS files must be loaded.
     *
     * @return  void
     */
    function _execute_system_css($template = '')
    {
        $ci =& get_instance();
        $namespace = 'system_css_';

        // First check if a include config file exists, and if so, include it.
        if (file_exists(APPPATH . 'config/kcms_includes.php')) {
            include (APPPATH . 'config/kcms_includes.php');
            $template_css = $css[$template];

            // If any scripts are defined, process the $scripts array accordingly.
            if (!empty($template_css)) {
                foreach ($template_css as $sk => $sv) {

                    // Checks if the path is defined, if not, defaults to assets/css
                    if (!isset($template_css[$sk]['path'])) {
                        $template_css[$sk]['path'] = base_url() . 'assets/css/';
                    } else {
                        $template_css[$sk]['path'] = base_url() . $template_css[$sk]['path'];
                    }

                    // Checks if the location is defined, if not, defaults to the <head> tag
                    if (!isset($template_css[$sk]['place'])) {
                        $template_css[$sk]['place'] = 'head';
                    }

                    // Checks if the method of inclusion is defined, if not, defaults to including as a link and not inline
                    if (!isset($template_css[$sk]['method'])) {
                        $template_css[$sk]['method'] = 'link';
                    }

                    // Checks if the type is defined, if not, defaults to nothing, and adds the "rel" attribute when included as a link
                    if (!isset($template_css[$sk]['type'])) {
                        $template_css[$sk]['type'] = ' rel="stylesheet"';
                    } else {
                        if ($template_css[$sk]['method'] == 'link') {
                            $template_css[$sk]['type'] = ' rel="stylesheet"';
                        } else {
                            $template_css[$sk]['type'] = '';
                        }
                    }

                    // Retrieves the css file's name so that the template data can be set
                    $template_css[$sk]['css'] = $sk;

                    // The code to generate the necessary include depends on the linking method
                    if ($sv['method'] == 'link') {
                        $template_css['key'] = md5($namespace . $sk);
                        $template_css['value'] = '<link' . $template_css[$sk]['type'] . ' href="' . $template_css[$sk]['path'] . $template_css[$sk]['css'] . '">';
                    } else {
                        $template_css['key'] = md5($namespace . $sk);
                        $template_css['value'] = '<style' . $template_css[$sk]['type'] . '>' . "\r\n" . file_get_contents($template_css[$sk]['path'] . $template_css[$sk]['css']) . "\r\n" . '</style>';
                    }

                    // Sets the variable in the template for inclusion
                    _set_template_data($template_css['key'], $template_css['value'], $template_css[$sk]['place']);
                }
            }
        }
    }

    // This may need to be adjusted to be really useful. I am just putting it here for conceptual record.
    function bootstrap()
    {
        $ci =& get_instance();

        // Load modules that are required by the system - do not leave it by chance.
        $modules = modules_required();
        if (!empty($modules)) {
            foreach ($modules as $module) {
                $ci->load->module($module['slug']);
            }
        }

        // Set some global settings (which may be overridden by modules for their own use).
        if (empty($ci->nucleus->delete_type)) {
            $ci->delete_type = _var('delete_type');
            if (empty($ci->nucleus->delete_type)) {
                $ci->nucleus->delete_type = 'soft';
            }
        }
        if (empty($ci->nucleus->log_everything)) {
            $ci->log_everything = _var('log_everything');
            if (empty($ci->nucleus->log_everything)) {
                $ci->nucleus->log_everything = false;
            }
        }
    }

?>
