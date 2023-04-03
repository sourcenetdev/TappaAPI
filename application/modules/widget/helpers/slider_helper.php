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
 * KyrandiaCMS Slider Helper
 *
 * Use this file to define all functions used specifically by the Slider module or modules using its features.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

 /**
 * _get_slider()
 *
 * Retrieves a slider.
 *
 * @access public
 *
 * @param int $slider_id
 *
 * @return array
 */
if (!function_exists('_get_slider')) {
    function _get_slider($slider_id)
    {
        $ci =& get_instance();
        $ci->load->model('widget/slider_model');
        return $ci->slider_model->get_slider_by_id($slider_id);
    }
}

 /**
 * _get_slider_items()
 *
 * Retrieves a slider's items.
 *
 * @access public
 *
 * @param int $slider_id
 *
 * @return array
 */
if (!function_exists('_get_slider_items')) {
    function _get_slider_items($slider_id)
    {
        $ci =& get_instance();
        $ci->load->model('widget/slider_model');
        return $ci->slider_model->get_slider_items_by_id($slider_id);
    }
}

 /**
 * _show_slider()
 *
 * Displays a slider
 *
 * @access public
 *
 * @param int $slug
 *
 * @return array
 */
if (!function_exists('_show_slider')) {
    function _show_slider($slug)
    {
        $ci =& get_instance();
        $ci->load->model('widget/slider_model');
        $slider_data['slider'] = $ci->slider_model->get_slider_by_slug($slug);
        $slider_data['slider_items'] = $ci->slider_model->get_slider_item_list($slider_data['slider'][0]['id'], 0, null);
        echo $ci->load->view('widget/sliders/view_slider', $slider_data);
    }
}
