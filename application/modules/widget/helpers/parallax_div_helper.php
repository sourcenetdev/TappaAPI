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
 * KyrandiaCMS Parallax Div Helper
 *
 * Use this file to define all functions used specifically by the Parallax Div module or modules using its features.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

 /**
 * _get_parallax_div()
 *
 * Retrieves a parallax div.
 *
 * @access public
 *
 * @param int $parallax_div_id
 *
 * @return array
 */
if (!function_exists('_get_parallax_div')) {
    function _get_parallax_div($parallax_div_id)
    {
        $ci =& get_instance();
        $ci->load->model('widget/parallax_div_model');
        return $ci->parallax_div_model->get_parallax_div_by_id($parallax_div_id);
    }
}

/**
 * _show_parallax_div()
 *
 * Displays a parallax div.
 *
 * @access public
 *
 * @param int $slug
 *
 * @return array
 */
if (!function_exists('_show_parallax_div')) {
    function _show_parallax_div($slug)
    {
        $ci =& get_instance();
        $ci->load->model('widget/parallax_div_model');
        $parallax_div_data['parallax_div'] = $ci->parallax_div_model->get_parallax_div_by_slug($slug);
        echo $ci->load->view('widget/parallax_divs/view_parallax_div', $parallax_div_data);
    }
}
