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
 * KyrandiaCMS Cornerstone Library - Utility Functions
 *
 * The kernel of KyrandiaCMS.
 *
 * @package     Impero
 * @subpackage  Core
 * @category    Libraries
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

class CSUtils
{

    /**
     * function __construct()
     *
     * Initializes the library
     *
     * @access public
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Function getIPAddress
     *
     * Gets the caller's IP address
     *
     * @access public
     *
     * @return string
     */
    public function getIPAddress()
    {
        return isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    }

    /**
     * Funtion requestIsOverSSL
     *
     * Determines if the request is served over an SSL/TLS connection
     *
     * @access public
     *
     * @return bool
     */
    public function requestIsOverSSL()
    {
        if (isset($_SERVER['HTTPS'])) {
            if ('on' === strtolower($_SERVER['HTTPS']) || '1' === $_SERVER['HTTPS']) {
                return true;
            }
        } elseif (isset($_SERVER['SERVER_PORT']) && ('443' === $_SERVER['SERVER_PORT'])) {
            return true;
        }
        return false;
    }

    /**
     * redir
     *
     * This function redirects to another URL with a status message.
     *
     * @access public
     *
     * @param string $type
     * @param string $message
     * @param string $destination
     *
     * @return void
     */
    public function redir($type, $message, $destination = '')
    {
        $ci =& get_instance();
        $ci->session->set_flashdata($type, $message);
        if (!empty($destination)) {
            redirect($destination);
        }
    }

    /**
     * render
     *
     * This function allows you to display module output on the screen.
     *
     * @access public
     *
     * @param string $template
     * @param string $view
     * @param array $data
     * @param string $method
     * @param bool $admin
     *
     * @return string
     */
    public function render($template, $view, $data = [], $method = '', $admin = false)
    {
        $ci =& get_instance();
        $db_template = $ci->cornerstone->kTemplate->getThemeBySlug($template);
        $data['db_slug'] = $template;
        if ($method == '') {
            $ci->cornerstone->kTemplate->loadTheme($db_template, $view, $data);
        } elseif ($method == 'full') {
            return $ci->cornerstone->kTemplate->loadTheme($db_template, $view, $data, true);
        } elseif ($method == 'return') {
            return $ci->load->view($view, $data, true);
        } elseif ($method == 'echo') {
            echo $ci->load->view($view, $data, true);
        }
    }

    /**
     * Function config()
     *
     * Retrieves a config variable from CI configuration.
     *
     * @access public
     *
     * @param string $variable
     *
     * @return string
     */
    public function config($variable)
    {
        $ci =& get_instance();
        return $ci->config->item($variable);
    }
}
