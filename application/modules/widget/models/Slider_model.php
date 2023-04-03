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
 * KyrandiaCMS Slider Module
 *
 * Contains the slider features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Slider_model extends CI_Model
{
    protected $tables;

    // Sliders
    private $slider_common_fields = 'id, slug, name, description, image_path, section_class, active, deleted, createdate, moddate';
    private $slider_list_fields = 'id, slug, name, description, image_path, section_class, active, deleted, createdate, moddate';
    private $slider_search_fields = ['name', 'slug', 'description', 'image_path', 'section_class', 'active', 'deleted'];

    // Slider items
    private $slider_item_common_fields = 'id, name, slug, image_div_class, image, title, image_text, image_heading, active, deleted, createdate, moddate';
    private $slider_item_list_fields = 'si.id, si.name, si.image, si.slug, si.image_div_class, si.title, si.image_text, si.image_heading, si.active, si.deleted, si.createdate, si.moddate';
    private $slider_item_search_fields = ['si.name', 'si.slug', 'si.image_div_class', 'si.image', 'si.title', 'si.image_text', 'si.image_heading',  'si.active', 'si.deleted'];

    /**
     * __construct
     *
     * Initializes the class
     *
     * @access public
     *
     * @return int
     */
    public function __construct()
    {
        parent::__construct();
        $this->tables = [
            'slider' => config_item('db_prefix') . 'slider',
            'slider_item' => config_item('db_prefix') . 'slider_item'
        ];
    }

    /* ACCORDIONS */

    /**
     * get_slider_list
     *
     * Gets a list of sliders for administrative screens.
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
    public function get_slider_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->slider_list_fields);
        $this->db->from($this->tables['slider']);
        _set_db_or_like($search, $this->slider_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * add_slider
     *
     * Adds an slider.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_slider($data)
    {
        $insert_data = [
            'id' => '',
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'slider',
                    'field' => 'slug'
                ]
            ),
            'name' => $data['name'],
            'image_path' => $data['image_path'],
            'section_class' => $data['section_class'],
            'description' => $data['description'],
            'active' => $data['active'],
            'deleted' => 'No',
            'createdate' => date('Y-m-d H:i:s'),
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($insert_data['active'] == 'Yes') {
            $insert_data['deleted'] = 'No';
        }
        if ($insert_data['deleted'] == 'Yes') {
            $insert_data['active'] = 'No';
        }
        $this->db->insert($this->tables['slider'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_slider
     *
     * Updates an slider.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_slider($data)
    {
        $update_data = [
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'slider',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'name' => $data['name'],
            'image_path' => $data['image_path'],
            'section_class' => $data['section_class'],
            'description' => $data['description'],
            'active' => $data['active'],
            'deleted' => 'No',
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($update_data['active'] == 'Yes') {
            $update_data['deleted'] = 'No';
        }
        if ($update_data['deleted'] == 'Yes') {
            $update_data['active'] = 'No';
        }
        $this->db->where('id', $data['id']);
        $this->db->update($this->tables['slider'], $update_data);
        return $this->db->affected_rows();
    }

     /**
     * get_slider_count
     *
     * Gets the number of sliders in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_slider_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['slider']);
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        _set_db_or_like($search, $this->slider_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_all_sliders
     *
     * Queries the database for all sliders, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_all_sliders($active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->slider_common_fields);
        $this->db->from($this->tables['slider'] . ' s');
        return $this->db->get()->result_array();
    }

    /**
     * get_slider
     *
     * Queries the database for an slider, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_slider($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->slider_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['slider'] . ' s');
        return $this->db->get()->result_array();
    }

    /**
     * get_slider_by_id
     *
     * Queries the database for an slider, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_slider_by_id($id, $active_only = false)
    {
        return $this->get_slider('s.id', $id, $active_only);
    }

    /**
     * get_slider_by_name
     *
     * Queries the database for an slider, and returns it (by name).
     *
     * @access public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return array
     */
    public function get_slider_by_name($name, $active_only = false)
    {
        return $this->get_slider('s.name', $name, $active_only);
    }

    /**
     * get_slider_by_slug
     *
     * Queries the database for an slider, and returns it (by slug).
     *
     * @access public
     *
     * @param int $slug
     * @param bool $active_only
     *
     * @return array
     */
    public function get_slider_by_slug($slug, $active_only = false)
    {
        return $this->get_slider('s.slug', $slug, $active_only);
    }

    /* ACCORDION ITEMS */

    /**
     * get_menu_item_list
     *
     * Gets a list of sliders for administrative screens.
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
    public function get_slider_item_list($slider_id, $start, $end, $search = '', $order = '')
    {
        $this->db->select($this->slider_item_list_fields);
        $this->db->from($this->tables['slider_item'] . ' si');
        $this->db->join($this->tables['slider'] . ' s', 'si.slider_id = s.id', 'left');
        $this->db->where('si.slider_id', $slider_id);
        _set_db_or_like($search, $this->slider_item_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * add_slider_item
     *
     * Adds a slider item to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_slider_item($data)
    {
        $insert_data = [
            'id' => '',
            'slider_id' => $data['slider_id'],
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'slider_item',
                    'field' => 'slug'
                ]
            ),
            'image_div_class' => $data['image_div_class'],
            'image' => $data['image'],
            'title' => $data['title'],
            'image_heading' => $data['image_heading'],
            'image_text' => $data['image_text'],
            'active' => $data['active'],
            'deleted' => 'No',
            'createdate' => date('Y-m-d H:i:s'),
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($insert_data['active'] == 'Yes') {
            $insert_data['deleted'] = 'No';
        }
        if ($insert_data['deleted'] == 'Yes') {
            $insert_data['active'] = 'No';
        }
        $this->db->insert($this->tables['slider_item'], $insert_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    /**
     * edit_slider_item
     *
     * Updates an slider item in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_slider_item($data)
    {
        $update_data = [
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'slider_item',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'image_div_class' => $data['image_div_class'],
            'image' => $data['image'],
            'title' => $data['title'],
            'image_heading' => $data['image_heading'],
            'image_text' => $data['image_text'],
            'active' => $data['active'],
            'deleted' => 'No',
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($update_data['active'] == 'Yes') {
            $update_data['deleted'] = 'No';
        }
        if ($update_data['deleted'] == 'Yes') {
            $update_data['active'] = 'No';
        }
        $this->db->where('id', $data['id']);
        $this->db->update($this->tables['slider_item'], $update_data);
        return $this->db->affected_rows();
    }

     /**
     * get_slider_item_count
     *
     * Gets the number of slider items in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_slider_item_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['slider_item']);
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        _set_db_or_like($search, $this->slider_item_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_slider_item
     *
     * Queries the database for an slider item, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_slider_item($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->slider_item_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['slider_item'] . ' si');
        return $this->db->get()->result_array();
    }

    /**
     * get_slider_item_by_id
     *
     * Queries the database for an slider item, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_slider_item_by_id($id, $active_only = false)
    {
        return $this->get_slider_item('si.id', $id, $active_only);
    }

    /**
     * get_slider_item_by_name
     *
     * Queries the database for an slider item, and returns it (by name).
     *
     * @access public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return array
     */
    public function get_slider_item_by_name($name, $active_only = false)
    {
        return $this->get_slider_item('si.name', $name, $active_only);
    }

    /**
     * get_slider_item_by_slug
     *
     * Queries the database for an slider item, and returns it (by slug).
     *
     * @access public
     *
     * @param string $slug
     * @param bool $active_only
     *
     * @return array
     */
    public function get_slider_item_by_slug($slug, $active_only = false)
    {
        return $this->get_slider_item('si.slug', $slug, $active_only);
    }
}
