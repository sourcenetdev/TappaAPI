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
 * KyrandiaCMS Cornerstone Library - Session Functions
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

class CSSession
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
     * Function getSession()
     *
     * This function returns the value of a session variable. Wrapper for $this->session->userdata().
     *
     * @access public
     *
     * @param string $variable
     *
     * @return string
     */
    public function getSession($variable = '')
    {
        $ci =& get_instance();
        if (!empty($variable)) {
            return $ci->session->userdata($variable);
        }

        return $ci->session->userdata();
    }

    /**
     * Function setSession()
     *
     * Sets a session variable. Wrapper for $this->session->userdata().
     *
     * @access public
     *
     * @param string $variable
     * @param mixed $value
     *
     * @return string
     */
    public function setSession($variable, $value, $asFlash = false)
    {
        $ci =& get_instance();
        $ci->session->set_userdata($variable, $value);
        if (!empty($asFlash)) {
            $ci->session->mark_as_flash($variable);
        }
    }

    /**
     * Function unsetSesion()
     *
     * Unsets a session variable. Wrapper for $this->session->userdata().
     *
     * @access public
     *
     * @param string $variable
     *
     * @return string
     */
    public function unsetSession($variable)
    {
        $ci =& get_instance();
        $ci->session->unset_userdata($variable);
    }

    /**
     * Function setFlash()
     *
     * Sets a session variable as flash data. Wrapper for $this->session->mark_as_flash().
     *
     * @access public
     *
     * @param string $variable
     * @param mixed $value
     *
     * @return string
     */
    public function setFlash($variable, $value)
    {
        $ci =& get_instance();
        $ci->setSession($variable, $value, true);
    }

}
