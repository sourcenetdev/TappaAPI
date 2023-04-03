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
 * KyrandiaCMS Dating Theme
 *
 * This is the main class file for the Hielo theme
 *
 * @package     Impero
 * @subpackage  Themes
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

class Dating
{
    public function __construct()
    {
        $ci =& get_instance();
        $ci->load->module('nucleus');
    }

    public function show_slider($slug)
    {
        $ci =& get_instance();
        $ci->load->helper('widget/slider');
        if (function_exists('_show_slider')) {
            echo _show_slider($slug);
        }
    }

    public function show_info_block($slug)
    {
        $ci =& get_instance();
        $ci->load->helper('widget/info_block');
        if (function_exists('_show_info_block')) {
            echo _show_info_block($slug);
        }
    }

    public function show_info_blocks($group)
    {
        $ci =& get_instance();
        $ci->load->helper('widget/info_block');
        if (function_exists('_show_info_blocks')) {
            echo _show_info_blocks($group);
        }
    }

    public function show_parallax_div($slug)
    {
        $ci =& get_instance();
        $ci->load->helper('widget/parallax_div');
        if (function_exists('_show_parallax_div')) {
            echo _show_parallax_div($slug);
        }
    }
}
