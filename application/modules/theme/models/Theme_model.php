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
 * KyrandiaCMS Theme Module
 *
 * Contains the theme features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Block
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Theme_model extends CI_Model
{
    protected $tables;

    // Themes
    private $theme_common_fields = 'id, slug, name, file, areas, active, deleted, createdate, moddate';
    private $theme_list_fields = 'id, slug, name, file, areas, active, createdate AS `created`, moddate AS `modified`';
    private $theme_search_fields = ['slug', 'name', 'file', 'areas', 'active', 'deleted'];

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
            'theme' => config_item('db_prefix') . 'theme'
        ];
    }

    /**
     * add_theme
     *
     * Adds a theme to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    function add_theme($data)
    {
        $insert_data = [
            'id' => '',
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'theme',
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
        $this->db->insert($this->tables['theme'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_theme
     *
     * Updates a theme in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    function edit_theme($data)
    {
        $update_data = [
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'theme',
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
        $this->db->update($this->tables['theme'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * get_theme
     *
     * Queries the database for a theme, and returns it if found
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return string
     */
    function get_theme($id, $active_only = true)
    {
        $this->db->select($this->theme_common_fields);
        $this->db->from($this->tables['theme']);
        $this->db->where('id', $id);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_theme_by_id
     *
     * Alias for get_theme
     *
     * @access  public
     *
     * @param string $id
     * @param bool $active_only
     *
     * @return array
     */
    function get_theme_by_id($id, $active_only = false)
    {
        return $this->get_theme($id, $active_only);
    }

    /**
     * get_theme_by_name
     *
     * Queries the database for a theme, and returns it if found
     *
     * @access  public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return string
     */
    function get_theme_by_name($id, $active_only = true)
    {
        $this->db->select($this->theme_common_fields);
        $this->db->from($this->tables['theme']);
        $this->db->where('name', $id);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_theme_by_slug
     *
     * Queries the database for a theme, and returns it if found
     *
     * @access  public
     *
     * @param string $slug
     * @param bool $active_only
     *
     * @return string
     */
    function get_theme_by_slug($slug, $active_only = true)
    {
        $this->db->select($this->theme_common_fields);
        $this->db->from($this->tables['theme']);
        $this->db->where('slug', $slug);
        _set_db_where($active_only, ['active' => 'Yes']);
        $data = $this->db->get()->result_array();
        return $data;
    }

    /**
     * get_all_themes
     *
     * Queries the database for all theme, and returns them.
     *
     * @access  public
     *
     * @param bool $active_only
     *
     * @return string
     */
    function get_all_themes($active_only = true)
    {
        $this->db->select($this->theme_common_fields);
        $this->db->from($this->tables['theme']);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_theme_list
     *
     * Gets a list of themes for administrative screens.
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
    function get_theme_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->theme_list_fields);
        $this->db->from($this->tables['theme']);
        _set_db_or_like($search, $this->theme_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * get_theme_count
     *
     * Gets the number of themes.
     *
     * @access  public
     *
     * @param bool $active_only
     *
     * @return array
     */
    function get_theme_count($active_only = true)
    {
        _set_db_where($active_only, ['active' => 'Yes']);
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['theme']);
        return $this->db->get()->result_array();
    }
}
