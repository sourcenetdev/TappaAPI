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
 * KyrandiaCMS Theme Helper
 *
 * Use this file to define all functions used specifically by the Theme module or modules using its features.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

/**
 * _get_themes()
 *
 * Retrieves all themes for use by other modules.
 *
 * @access public
 *
 * @return array
 */
if (!function_exists('_get_themes')) {
    function _get_themes()
    {
        $ci =& get_instance();
        $ci->load->model('theme/theme_model');
        $themes = $ci->theme_model->get_theme_list(0, null);
        return $themes;
    }
}

/**
 * _set_theme_area_editors()
 *
 * Creates summernote editors for content areas of a theme.
 *
 * @access public
 *
 * @return array
 */
if (!function_exists('_set_theme_area_editors')) {
    function _set_theme_area_editors()
    {
        $return = [];
        $themes = _get_themes();
        if (!empty($themes)) {
            foreach ($themes as $k => $v) {
                $areas = explode(',', $v['areas']);
                if (!empty($areas) && is_array($areas)) {
                    foreach ($areas as $kk => $vv) {
                        $return['theme_' . $v['id'] . '_area_' . $vv] = [
                            'parent_id' => $v['id'],
                            'theme' => $v['name'],
                            'theme_slug' => $v['slug'],
                            'area' => $vv,
                            'id'  => 'theme_' . $v['id'] . '_area_' . $vv,
                            'name'  => 'theme_' . $v['id'] . '_area_' . $vv,
                        ];
                    }
                }
            }
        }
        return $return;
    }
}

/**
 * _get_themes_mapped()
 *
 * Retrieves all themes for use by other modules, mapped by a key/value pair.
 *
 * @access public
 *
 * @param bool $placeholder
 * @param array $map
 *
 * @return array
 */
if (!function_exists('_get_themes_mapped')) {
    function _get_themes_mapped($placeholder = false, $map = ['id', 'name'])
    {
        $ci =& get_instance();
        $themes = _get_themes($placeholder);
        $themes_map = $ci->core->map_fields($themes, [$map[0], $map[1]]);
        if ($placeholder) {
            $themes_map = [lang('core_please_select')] + $themes_map;
        }
        unset($themes);
        return $themes_map;
    }
}
