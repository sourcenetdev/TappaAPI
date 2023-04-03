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
 * KyrandiaCMS Cornerstone Library - Input Functions
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

class CSInput
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
     * Function get()
     *
     * Returns a get variable. Wrapper for $this->input->get().
     *
     * @access public
     *
     * @param string $variable
     *
     * @return array
     */
    function get($variable)
    {
        $ci =& get_instance();
        if (!empty($variable)) {
            return $ci->input->get($variable);
        }
        return $ci->input->get();
    }

    /**
     * Function post()
     *
     * Returns a post varable. Wrapper for $this->input->post().
     *
     * @access public
     *
     * @param string $variable
     *
     * @return array
     */
    function post($variable = '')
    {
        $ci =& get_instance();
        if (!empty($variable)) {
            return $ci->input->post($variable);
        }
        return $ci->input->post();
    }

    /**
     * chooseFromInput
     *
     * Choose between various options whether they are set, in order POST, set_value, and raw data.
     *
     * @access public
     *
     * @param string $post
     * @param string $value
     * @param string $item
     *
     * @return string
     */
    public function chooseFromInput($post, $value, $item, $post_first = true)
    {
        if (!empty($post_first)) {
            return isset($post) ? $post : (set_value($value) ? set_value($value) : $item);
        }
        return isset($value) ? set_value($value) : (isset($post) ? $post : $item);
    }
}
