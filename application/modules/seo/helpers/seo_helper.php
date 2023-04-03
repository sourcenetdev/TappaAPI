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
 * KyrandiaCMS SEO Helper
 *
 * Use this file to define all functions used specifically by the SEO module or modules using its features.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

 /**
 * _get_headtag_id()
 *
 * Retrieves a headtag's ID.
 *
 * @access public
 *
 * @param string $slug
 *
 * @return array
 */
if (!function_exists('_get_headtag_id')) {
    function _get_headtag_id($slug)
    {
        $ci =& get_instance();
        $ci->load->model('seo/seo_model');
        $headtag = $ci->seo_model->get_headtag_by_slug($slug);
        if (!empty($headtag)) {
            return $headtag[0]['id'];
        }
        return '';
    }
}

 /**
 * _get_headtags()
 *
 * Retrieves all headtags for use by other modules.
 *
 * @access public
 *
 * @return array
 */
if (!function_exists('_get_headtags')) {
    function _get_headtags()
    {
        $ci =& get_instance();
        $ci->load->model('seo/seo_model');
        $headtags = $ci->seo_model->get_headtag_list(0, null);
        return $headtags;
    }
}

/**
 * _get_headtags_mapped()
 *
 * Retrieves all headtags for use by other modules, mapped by a key/value pair.
 *
 * @access public
 *
 * @param bool $placeholder
 * @param array $map
 *
 * @return array
 */
if (!function_exists('_get_headtags_mapped')) {
    function _get_headtags_mapped($placeholder = false, $map = ['id', 'name'])
    {
        $ci =& get_instance();
        $headtags = _get_headtags();
        $headtags_map = $ci->core->map_fields($headtags, [$map[0], $map[1]]);
        if ($placeholder) {
            $headtags_map = [lang('core_please_select')] + $headtags_map;
        }
        unset($headtags);
        return $headtags_map;
    }
}

/**
 * _get_headtag_id()
 *
 * Retrieves an attribute's ID.
 *
 * @access public
 *
 * @param string $slug
 *
 * @return array
 */
if (!function_exists('_get_attribute_id')) {
    function _get_attribute_id($slug)
    {
        $ci =& get_instance();
        $ci->load->model('seo/seo_model');
        $attribute = $ci->seo_model->get_attribute_by_slug($slug);
        if (!empty($attribute)) {
            return $attribute[0]['id'];
        }
        return '';
    }
}

 /**
 * _get_attributes()
 *
 * Retrieves all attributes for use by other modules.
 *
 * @access public
 *
 * @return array
 */
if (!function_exists('_get_attributes')) {
    function _get_attributes()
    {
        $ci =& get_instance();
        $ci->load->model('seo/seo_model');
        $attributes = $ci->seo_model->get_attribute_list(0, null);
        return $attributes;
    }
}

/**
 * _get_attributes_mapped()
 *
 * Retrieves all attributes for use by other modules, mapped by a key/value pair.
 *
 * @access public
 *
 * @param bool $placeholder
 * @param array $map
 *
 * @return array
 */
if (!function_exists('_get_attributes_mapped')) {
    function _get_attributes_mapped($placeholder = false, $map = ['id', 'name'])
    {
        $ci =& get_instance();
        $attributes = _get_attributes();
        $attributes_map = $ci->core->map_fields($attributes, [$map[0], $map[1]]);
        if ($placeholder) {
            $attributes_map = [lang('core_please_select')] + $attributes_map;
        }
        unset($attributes);
        return $attributes_map;
    }
}

 /**
 * _get_headtag_attributes()
 *
 * Retrieves all headtag attributes for use by other modules.
 *
 * @access public
 *
 * @param int $headtag_id
 *
 * @return array
 */
if (!function_exists('_get_headtag_attributes')) {
    function _get_headtag_attributes($headtag_id)
    {
        $ci =& get_instance();
        $ci->load->model('seo/seo_model');
        $headtag_attributes = $ci->seo_model->get_headtag_attribute_list($headtag_id, 0, null);
        return $headtag_attributes;
    }
}

/**
 * _get_headtag_attributes_mapped()
 *
 * Retrieves all attributes for a headtag for use by other modules, mapped by a key/value pair.
 *
 * @access public
 *
 * @param int $headtag_id
 * @param bool $placeholder
 * @param array $map
 *
 * @return array
 */
if (!function_exists('_get_headtag_attributes_mapped')) {
    function _get_headtag_attributes_mapped($headtag_id = null, $placeholder = false, $map = ['id', 'name'])
    {
        $ci =& get_instance();
        if (!empty($headtag_id)) {
            $headtag_attributes = _get_headtag_attributes($headtag_id);
        } else {
            $headtag_attributes = _get_attributes();
        }
        $headtag_attributes_map = $ci->core->map_fields($headtag_attributes, [$map[0], $map[1]]);
        if ($placeholder) {
            $headtag_attributes_map = [lang('core_please_select')] + $headtag_attributes_map;
        }
        unset($headtag_attributes);
        return $headtag_attributes_map;
    }
}

/**
 * _get_headtag_attribute_ids()
 *
 * Retrieves all the attribute IDs for a headtag.
 *
 * @access public
 *
 * @param int $headtag_id
 *
 * @return array
 */
if (!function_exists('_get_headtag_attribute_ids')) {
    function _get_headtag_attribute_ids($headtag_id)
    {
        $final = [];
        $headtag_attributes = _get_headtag_attributes($headtag_id);
        if (!empty($headtag_attributes)) {
            foreach ($headtag_attributes as $k => $v) {
                $final[] = $v['attribute_id'];
            }
        }
        unset($headtag_attributes);
        return $final;
    }
}