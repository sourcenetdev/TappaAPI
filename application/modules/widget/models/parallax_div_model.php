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
 * KyrandiaCMS Parallax Div Module
 *
 * Contains the parallax div features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Parallax_div_model extends CI_Model
{

    protected $tables;

    // Parallax Divs
    private $parallax_div_common_fields = '
        id, slug, name, description, image_path, image_file, image_text, image_heading, section_class, section_id, active, deleted, createdate, moddate
    ';
    private $parallax_div_list_fields = '
        id, slug, name, description, active, deleted, createdate, moddate
    ';
    private $parallax_div_search_fields = [
        'name', 'slug', 'description', 'image_path', 'image_file', 'image_text', 'image_heading', 'section_class', 'section_id', 'active', 'deleted'
    ];

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
            'parallax_div' => config_item('db_prefix') . 'parallax_div',
        ];
    }

    /* PARALLAX DIVS */

    /**
     * get_parallax_div_list
     *
     * Gets a list of parallax divs for administrative screens.
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
    public function get_parallax_div_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->parallax_div_list_fields);
        $this->db->from($this->tables['parallax_div']);
        _set_db_or_like($search, $this->parallax_div_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * add_parallax_div
     *
     * Adds an parallax div.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_parallax_div($data)
    {
        $insert_data = [
            'id' => '',
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'parallax_div',
                    'field' => 'slug'
                ]
            ),
            'name' => $data['name'],
            'image_path' => $data['image_path'],
            'image_file' => $data['image_file'],
            'description' => $data['description'],
            'image_text' => $data['image_text'],
            'image_heading' => $data['image_heading'],
            'section_class' => $data['section_class'],
            'section_id' => $data['section_id'],
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
        $this->db->insert($this->tables['parallax_div'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_parallax_div
     *
     * Updates an parallax div.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_parallax_div($data)
    {
        $update_data = [
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'parallax_div',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'name' => $data['name'],
            'image_path' => $data['image_path'],
            'image_file' => $data['image_file'],
            'description' => $data['description'],
            'image_text' => $data['image_text'],
            'image_heading' => $data['image_heading'],
            'section_class' => $data['section_class'],
            'section_id' => $data['section_id'],
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
        $this->db->update($this->tables['parallax_div'], $update_data);
        return $this->db->affected_rows();
    }

     /**
     * get_parallax_div_count
     *
     * Gets the number of parallax divs in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_parallax_div_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['parallax_div']);
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        _set_db_or_like($search, $this->parallax_div_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_all_parallax_divs
     *
     * Queries the database for all parallax divs, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_all_parallax_div($active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->parallax_div_common_fields);
        $this->db->from($this->tables['parallax_div'] . ' a');
        return $this->db->get()->result_array();
    }

    /**
     * get_parallax_div
     *
     * Queries the database for an parallax div, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_parallax_div($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->parallax_div_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['parallax_div'] . ' i');
        return $this->db->get()->result_array();
    }

    /**
     * get_parallax_div_by_id
     *
     * Queries the database for an parallax div, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_parallax_div_by_id($id, $active_only = false)
    {
        return $this->get_parallax_div('i.id', $id, $active_only);
    }

    /**
     * get_parallax_div_by_name
     *
     * Queries the database for an parallax div, and returns it (by name).
     *
     * @access public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return array
     */
    public function get_parallax_div_by_name($name, $active_only = false)
    {
        return $this->get_parallax_div('i.name', $name, $active_only);
    }

    /**
     * get_parallax_div_by_slug
     *
     * Queries the database for an parallax div, and returns it (by slug).
     *
     * @access public
     *
     * @param string $slug
     * @param bool $active_only
     *
     * @return array
     */
    public function get_parallax_div_by_slug($slug, $active_only = false)
    {
        return $this->get_parallax_div('i.slug', $slug, $active_only);
    }
}
