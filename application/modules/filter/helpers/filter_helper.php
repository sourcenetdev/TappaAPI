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
 * KyrandiaCMS Filter Helper
 *
 * Use this file to define all functions used specifically by the Filter module or modules using its features.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

/**
 * Function _filter()
 *
 * This function is called on all modules implementing filters.
 *
 * @access public
 *
 * @param string $content_to_filter
 *
 * @return array
 */
if (!function_exists('_filter')) {
    function _filter($content_to_filter)
    {
        $data = $content_to_filter;
        $ci =& get_instance();
        $modules = modules_active();
        if (!empty($modules)) {
            foreach ($modules as $v) {
                $ci->load->module($v['slug']);
                if (is_callable([strtolower($v['slug']), 'filter_hook'])) {
                    $data = $ci->{$v['slug']}->filter_hook($data);
                }
            }
        }
        return $data;
    }
}
