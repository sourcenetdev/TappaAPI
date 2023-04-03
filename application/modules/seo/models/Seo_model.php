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
 * KyrandiaCMS SEO Module
 *
 * Contains the SEO data for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Seo_model extends CI_Model
{
    private $tables = [];

    // Attributes
    private $attribute_common_fields = 'a.id, a.name, a.slug, a.active, a.deleted, a.createdate, a.moddate';
    private $attribute_list_fields = 'a.id, a.name, a.slug, a.active, a.deleted, a.createdate, a.moddate';
    private $attribute_search_fields = ['name', 'slug', 'active', 'deleted'];

    // Headtags
    private $headtag_common_fields = 'id, name, slug, type, active, deleted, createdate, moddate';
    private $headtag_list_fields = 'h.id, h.name, h.slug, h.type, h.active, h.deleted, h.createdate, h.moddate';
    private $headtag_search_fields = ['name', 'slug', 'type', 'active', 'deleted'];

    // Headtag Attributes
    private $headtag_attribute_list_fields = 'a.id, a.name, ha.headtag_id, ha.attribute_id, ha.active, ha.deleted, ha.createdate, ha.moddate';
    private $headtag_attribute_search_fields = ['active', 'deleted'];

    // Global Headtags
    private $global_headtag_common_fields = 'id, headtag_id, attribute_id, value, active, deleted, createdate, moddate';
    private $global_headtag_list_fields = "gm.id, h.name, GROUP_CONCAT(gm.value SEPARATOR ', ') AS attribute_values, gm.active, gm.deleted, gm.createdate, gm.moddate";
    private $global_headtag_search_fields = ['value', 'active', 'deleted'];

    /**
     * __construct
     *
     * Initializes the class
     *
     * @access public
     *
     * @return void
     */
    function __construct()
    {
        parent::__construct();
        $this->tables = [
            'headtag' => config_item('db_prefix') . 'headtag',
            'attribute' => config_item('db_prefix') . 'attribute',
            'headtag_attribute' => config_item('db_prefix') . 'headtag_attribute',
            'global_meta' => config_item('db_prefix') . 'global_meta'
        ];
    }

    /**
     * get_headtag_list
     *
     * Gets a list of headtags for administrative screens.
     *
     * @access public
     *
     * @param int $start
     * @param int $end
     * @param string $search
     * @param string $order
     *
     * @return string
     */
    public function get_headtag_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->headtag_list_fields);
        $this->db->from($this->tables['headtag'] . ' h');
        _set_db_or_like($search, $this->headtag_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * add_headtag
     *
     * Adds a headtag to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_headtag($data)
    {
        $insert_data = [
            'id' => '',
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'headtag',
                    'field' => 'slug'
                ]
            ),
            'type' => $data['type'],
            'active' => $data['active'],
            'createdate' => date('Y-m-d H:i:s'),
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($insert_data['active'] == 'Yes') {
            $insert_data['deleted'] = 'No';
        }
        if ($insert_data['deleted'] == 'Yes') {
            $insert_data['active'] = 'No';
        }
        $this->db->insert($this->tables['headtag'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_headtag
     *
     * Updates a headtag in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_headtag($data)
    {
        $update_data = [
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'headtag',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'type' => $data['type'],
            'active' => $data['active'],
            'deleted' => 'Yes',
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($update_data['active'] == 'Yes') {
            $update_data['deleted'] = 'No';
        }
        if ($update_data['deleted'] == 'Yes') {
            $update_data['active'] = 'No';
        }
        $this->db->where('id', $data['id']);
        $this->db->update($this->tables['headtag'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * get_headtag_count
     *
     * Gets the number of headtags in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_headtag_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['headtag']);
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        _set_db_or_like($search, $this->headtag_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_headtag
     *
     * Queries the database for a headtag, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_headtag($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->headtag_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['headtag'] . ' h');
        return $this->db->get()->result_array();
    }

    /**
     * get_headtag_by_id
     *
     * Queries the database for a headtag, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_headtag_by_id($id, $active_only = false)
    {
        return $this->get_headtag('h.id', $id, $active_only);
    }

    /**
     * get_headtag_by_slug
     *
     * Queries the database for a headtag, and returns it (by slug).
     *
     * @access public
     *
     * @param int $slug
     * @param bool $active_only
     *
     * @return array
     */
    public function get_headtag_by_slug($slug, $active_only = false)
    {
        return $this->get_headtag('h.slug', $slug, $active_only);
    }

    /**
     * get_attribute_list
     *
     * Gets a list of attributes for administrative screens.
     *
     * @access public
     *
     * @param int $start
     * @param int $end
     * @param string $search
     * @param string $order
     *
     * @return string
     */
    public function get_attribute_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->attribute_list_fields);
        $this->db->from($this->tables['attribute'] . ' a');
        _set_db_or_like($search, $this->attribute_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * add_attribute
     *
     * Adds an attribute to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_attribute($data)
    {
        $insert_data = [
            'id' => '',
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'attribute',
                    'field' => 'slug'
                ]
            ),
            'active' => $data['active'],
            'createdate' => date('Y-m-d H:i:s'),
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($insert_data['active'] == 'Yes') {
            $insert_data['deleted'] = 'No';
        }
        if ($insert_data['deleted'] == 'Yes') {
            $insert_data['active'] = 'No';
        }
        $this->db->insert($this->tables['attribute'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_attribute
     *
     * Updates an atttribute in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_attribute($data)
    {
        $update_data = [
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'attribute',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'active' => $data['active'],
            'deleted' => 'Yes',
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($update_data['active'] == 'Yes') {
            $update_data['deleted'] = 'No';
        }
        if ($update_data['deleted'] == 'Yes') {
            $update_data['active'] = 'No';
        }
        $this->db->where('id', $data['id']);
        $this->db->update($this->tables['attribute'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * get_attribute_count
     *
     * Gets the number of attributes in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_attribute_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['attribute']);
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        _set_db_or_like($search, $this->attribute_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_attribute
     *
     * Queries the database for an attribute, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_attribute($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->attribute_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['attribute'] . ' a');
        return $this->db->get()->result_array();
    }

    /**
     * get_attribute_by_id
     *
     * Queries the database for an attribute, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_attribute_by_id($id, $active_only = false)
    {
        return $this->get_attribute('a.id', $id, $active_only);
    }

    /**
     * get_attribute_by_slug
     *
     * Queries the database for an attribute, and returns it (by slug).
     *
     * @access public
     *
     * @param int $slug
     * @param bool $active_only
     *
     * @return array
     */
    public function get_attribute_by_slug($slug, $active_only = false)
    {
        return $this->get_headtag('a.slug', $slug, $active_only);
    }

    /**
     * get_headtag_attribute_list
     *
     * Gets a list of headtag attributes for administrative screens.
     *
     * @access public
     *
     * @param int $headtag_id
     * @param int $start
     * @param int $end
     * @param string $search
     * @param string $order
     *
     * @return string
     */
    public function get_headtag_attribute_list($headtag_id, $start, $end, $search = '', $order = '')
    {
        $this->db->select($this->headtag_attribute_list_fields);
        $this->db->from($this->tables['headtag_attribute'] . ' ha');
        $this->db->join($this->tables['attribute'] . ' a', 'a.id = ha.attribute_id', 'left');
        $this->db->where('ha.headtag_id', $headtag_id);
        _set_db_or_like($search, $this->headtag_attribute_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * delete_headtag_attributes
     *
     * Deletes attributes data for a headtag to prepare for new inserts.
     *
     * @access  public
     *
     * @param int $headtag_id
     *
     * @return array
     */
    function delete_headtag_attributes($headtag_id)
    {
        $this->db->where('headtag_id', $headtag_id);
        $this->db->delete($this->tables['headtag_attribute']);
        return $this->db->affected_rows();
    }

    /**
     * add_headtag_attributes
     *
     * Adds new attribute data for a headtag.
     *
     * @access  public
     *
     * @param int $headtag_id
     * @param array $attributes
     *
     * @return array
     */
    function add_headtag_attributes($headtag_id, $attributes)
    {
        if (!empty($attributes) && is_array($attributes)) {
            $insert_data = [
                'id' => '',
                'headtag_id' => $headtag_id,
                'active' => 'Yes',
                'deleted' =>  'No',
                'createdate' => date('Y-m-d H:i:s'),
                'moddate' => date('Y-m-d H:i:s')
            ];
            foreach ($attributes as $k => $v) {
                $insert_data['attribute_id'] = $v;
                $this->db->insert($this->tables['headtag_attribute'], $insert_data);
            }
        }
    }

    /**
     * get_global_headtag_list
     *
     * Gets a list of globa headtags for administrative screens.
     *
     * @access public
     *
     * @param int $start
     * @param int $end
     * @param string $search
     * @param string $order
     *
     * @return string
     */
    public function get_global_headtag_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->global_headtag_list_fields);
        $this->db->from($this->tables['global_meta'] . ' gm');
        $this->db->join($this->tables['headtag'] . ' h', 'h.id = gm.headtag_id', 'left');
        _set_db_or_like($search, $this->global_headtag_search_fields);
        _set_db_order($order);
        $this->db->group_by('gm.headtag_id');
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * add_global_headtag
     *
     * Adds a global headtag to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_global_headtag($data)
    {
        if (!empty($data['meta_value']) && is_array($data['meta_value'])) {
            $insert_data = [
                'id' => '',
                'headtag_id' => $data['headtag_id'],
                'active' => $data['active'],
                'createdate' => date('Y-m-d H:i:s'),
                'moddate' => date('Y-m-d H:i:s')
            ];
            if ($insert_data['active'] == 'Yes') {
                $insert_data['deleted'] = 'No';
            }
            if (!empty($insert_data['deleted']) && $insert_data['deleted'] == 'Yes') {
                $insert_data['active'] = 'No';
            }
            foreach ($data['meta_value'] as $k => $v) {
                $insert_data['attribute_id'] = $k;
                $insert_data['value'] = $v;
                $this->db->insert($this->tables['global_meta'], $insert_data);
            }
            return $this->db->insert_id();
        }
    }

    /**
     * edit_global_headtag
     *
     * Updates a global headtag in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_global_headtag($data)
    {
        $update_data = [
            'headtag_id' => $data['headtag_id'],
            'active' => $data['active'],
            'deleted' => 'Yes',
            'moddate' => date('Y-m-d H:i:s'),
            'createdate' => date('Y-m-d H:i:s')
        ];
        if ($update_data['active'] == 'Yes') {
            $update_data['deleted'] = 'No';
        }
        if ($update_data['deleted'] == 'Yes') {
            $update_data['active'] = 'No';
        }
        if (!empty($data['attributes'])) {
            $this->db->where('headtag_id', $data['headtag_id']);
            $this->db->delete($this->tables['global_meta']);
            foreach ($data['attributes'] as $k => $v) {
                $update_data['attribute_id'] = $k;
                $update_data['value'] = $v;
                $this->db->insert($this->tables['global_meta'], $update_data);
            }
        }
        return $this->db->affected_rows();
    }

    /**
     * get_global_headtag_count
     *
     * Gets the number of global headtags in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_global_headtag_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['global_meta']);
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        _set_db_or_like($search, $this->global_headtag_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_global_headtag
     *
     * Queries the database for a global headtag, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_global_headtag($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->global_headtag_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['global_meta'] . ' gm');
        $single_row = $this->db->get()->row_array();
        $complete = $single_row;
        if (!empty($single_row)) {
            $this->db->select($this->global_headtag_common_fields);
            $this->db->from($this->tables['global_meta'] . ' gm');
            $this->db->where_in('headtag_id', $single_row['headtag_id']);
            $attributes = $this->db->get()->result_array();
            if (!empty($attributes)) {
                foreach ($attributes as $k => $v) {
                    $attrs = $this->get_attribute_by_id($v['attribute_id']);
                    $complete['attributes'][$attrs[0]['name']] = $v['attribute_id'] . '--' . $v['value'];
                }
            }
            $this->db->select($this->headtag_common_fields);
            $this->db->from($this->tables['headtag'] . ' h');
            $this->db->where_in('id', $single_row['headtag_id']);
            $headtag = $this->db->get()->row_array();
            $complete['value'] = $headtag['name'];
        }
        return $complete;
    }

    /**
     * get_global_headtag_by_id
     *
     * Queries the database for a global headtag, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_global_headtag_by_id($id, $active_only = false)
    {
        return $this->get_global_headtag('gm.id', $id, $active_only);
    }
}
