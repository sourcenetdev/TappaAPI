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
 * KyrandiaCMS Layout Module
 *
 * Contains the layout features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Block
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Layout_model extends CI_Model
{

    protected $tables;

    // Layout
    private $layout_common_fields = 'id, slug, name, file, areas, active, deleted, createdate, moddate';
    private $layout_list_fields = 'id, slug, name, file, areas, active, createdate AS `created`, moddate AS `modified`';
    private $layout_search_fields = ['slug', 'name', 'file', 'areas', 'active', 'deleted'];

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
            'layout' => config_item('db_prefix') . 'layout'
        ];
    }

    /**
     * add_layout
     *
     * Adds a layout to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    function add_layout($data)
    {
        $insert_data = [
            'id' => '',
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'layout',
                    'field' => 'slug'
                ]
            ),
            'file' => $data['file'],
            'areas' => $data['areas'],
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
        $this->db->insert($this->tables['layout'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_layout
     *
     * Updates a layout in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    function edit_layout($data)
    {
        $update_data = [
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'layout',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'file' => $data['file'],
            'areas' => $data['areas'],
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
        $this->db->update($this->tables['layout'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * get_layout
     *
     * Queries the database for a layout, and returns it if found
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return string
     */
    function get_layout($id, $active_only = true)
    {
        $this->db->select($this->layout_common_fields);
        $this->db->from($this->tables['layout']);
        $this->db->where('id', $id);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_layout_by_id
     *
     * Alias for get_layout
     *
     * @access  public
     *
     * @param string $id
     * @param bool $active_only
     *
     * @return array
     */
    function get_layout_by_id($id, $active_only = false)
    {
        return $this->get_layout($id, $active_only);
    }

    /**
     * get_layout_by_name
     *
     * Queries the database for a layout, and returns it if found
     *
     * @access  public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return string
     */
    function get_layout_by_name($id, $active_only = true)
    {
        $this->db->select($this->layout_common_fields);
        $this->db->from($this->tables['layout']);
        $this->db->where('name', $id);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_layout_by_slug
     *
     * Queries the database for a layout, and returns it if found
     *
     * @access  public
     *
     * @param string $slug
     * @param bool $active_only
     *
     * @return string
     */
    function get_layout_by_slug($slug, $active_only = true)
    {
        $this->db->select($this->layout_common_fields);
        $this->db->from($this->tables['layout']);
        $this->db->where('slug', $slug);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_all_layouts
     *
     * Queries the database for all layout, and returns them.
     *
     * @access  public
     *
     * @param bool $active_only
     *
     * @return string
     */
    function get_all_layouts($active_only = true)
    {
        $this->db->select($this->layout_common_fields);
        $this->db->from($this->tables['layout']);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_layout_list
     *
     * Gets a list of layouts for administrative screens.
     *
     * @access  public
     *
     * @param int $start
     * @param int $end
     * @param string $search
     * @param string $order
     *
     * @return string
     */
    function get_layout_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->layout_list_fields);
        $this->db->from($this->tables['layout']);
        _set_db_or_like($search, $this->layout_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * get_layout_count
     *
     * Gets the number of layouts.
     *
     * @access  public
     *
     * @param bool $active_only
     *
     * @return array
     */
    function get_layout_count($active_only = true)
    {
        _set_db_where($active_only, ['active' => 'Yes']);
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['layout']);
        return $this->db->get()->result_array();
    }
}
