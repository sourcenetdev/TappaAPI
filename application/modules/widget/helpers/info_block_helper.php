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
 * KyrandiaCMS Info Block Helper
 *
 * Use this file to define all functions used specifically by the Info Block module or modules using its features.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

 /**
 * _get_info_block()
 *
 * Retrieves an info block.
 *
 * @access public
 *
 * @param int $info_block_id
 *
 * @return array
 */
if (!function_exists('_get_info_block')) {
    function _get_info_block($info_block_id)
    {
        $ci =& get_instance();
        $ci->load->model('widget/info_block_model');
        return $ci->info_block_model->get_info_block_by_id($info_block_id);
    }
}

/**
 * _show_info_block()
 *
 * Displays an info block.
 *
 * @access public
 *
 * @param int $slug
 *
 * @return array
 */
if (!function_exists('_show_info_block')) {
    function _show_info_block($slug)
    {
        $ci =& get_instance();
        $ci->load->model('widget/info_block_model');
        $info_block_data['info_block'] = $ci->info_block_model->get_info_block_by_slug($slug);
        echo $ci->load->view('widget/info_blocks/view_info_block', $info_block_data);
    }
}

/**
 * _show_info_blocks()
 *
 * Displays a group of info blocks.
 *
 * @access public
 *
 * @param int $group
 *
 * @return array
 */
if (!function_exists('_show_info_blocks')) {
    function _show_info_blocks($group)
    {
        $ci =& get_instance();
        $ci->load->model('widget/info_block_model');
        $info_block_data['info_block'] = $ci->info_block_model->get_info_blocks_by_group($group);
        echo $ci->load->view('widget/info_blocks/view_info_blocks', $info_block_data);
    }
}