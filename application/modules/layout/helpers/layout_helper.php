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
 * KyrandiaCMS Layout Helper
 *
 * Use this file to define all functions used specifically by the Layout module or modules using its features.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

 /**
 * _get_layouts()
 *
 * Retrieves all layouts for use by other modules.
 *
 * @access public
 *
 * @return array
 */
if (!function_exists('_get_layouts')) {
    function _get_layouts()
    {
        $ci =& get_instance();
        $ci->load->model('layout/layout_model');
        $themes = $ci->layout_model->get_layout_list(0, null);
        return $themes;
    }
}

/**
 * _set_layout_area_editors()
 *
 * Creates summernote editors for content areas of a layout.
 *
 * @access public
 *
 * @return array
 */
if (!function_exists('_set_layout_area_editors')) {
    function _set_layout_area_editors()
    {
        $return = [];
        $layouts = _get_layouts();
        if (!empty($layouts)) {
            foreach ($layouts as $k => $v) {
                $areas = explode(',', $v['areas']);
                if (!empty($areas) && is_array($areas)) {
                    foreach ($areas as $kk => $vv) {
                        $return['layout_' . $v['id'] . '_area_' . $vv] = [
                            'parent_id' => $v['id'],
                            'layout' => $v['name'],
                            'layout_slug' => $v['slug'],
                            'area' => $vv,
                            'id'  => 'layout_' . $v['id'] . '_area_' . $vv,
                            'name'  => 'layout_' . $v['id'] . '_area_' . $vv,
                        ];
                    }
                }
            }
        }
        return $return;
    }
}

/**
 * _get_layouts_mapped()
 *
 * Retrieves all layouts for use by other modules, mapped by a key/value pair.
 *
 * @access public
 *
 * @param bool $placeholder
 * @param array $map
 *
 * @return array
 */
if (!function_exists('_get_layouts_mapped')) {
    function _get_layouts_mapped($placeholder = false, $map = ['id', 'name'])
    {
        $ci =& get_instance();
        $layouts = _get_layouts();
        $layouts_map = $ci->core->map_fields($layouts, [$map[0], $map[1]]);
        if ($placeholder) {
            $layouts_map = [lang('core_please_select')] + $layouts_map;
        }
        unset($layouts);
        return $layouts_map;
    }
}
