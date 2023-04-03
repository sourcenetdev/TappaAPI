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
 * KyrandiaCMS Module Module
 *
 * Contains the module features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Module_model extends CI_Model
{

    protected $tables;

    // Module
    private $module_common_fields = 'id, category_id, status, required, disabled, name, description, slug, version, author, author_site, author_contact, active, deleted, createdate, moddate';
    private $module_list_fields = 'id, name, description, slug, required, disabled, version, author, status, active, deleted, createdate, moddate';
    private $module_search_fields = ['name', 'version', 'required', 'disabled', 'description', 'slug', 'author', 'author_site', 'author_contact', 'status', 'active', 'deleted'];

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
            'module' => config_item('db_prefix') . 'module',
        ];
    }

    /**
     * get_module_list
     *
     * Gets a list of modules for administrative screens.
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
    public function get_module_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->module_list_fields);
        $this->db->from($this->tables['module']);
        _set_db_or_like($search, $this->module_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * add_module
     *
     * Adds a module to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_module($data)
    {
        $insert_data = [
            'id' => '',
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'module',
                    'field' => 'slug'
                ]
            ),
            'description' => $data['description'],
            'version' => $data['version'],
            'status' => $data['status'],
            'required' => $data['required'],
            'category_id' => $data['category_id'],
            'author' => $data['author'],
            'author_site' => $data['author_site'],
            'author_contact' => $data['author_contact'],
            'active' => $data['active'],
            'createdate' => date('Y-m-d H:i:s'),
            'deleted' => 'No',
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($insert_data['active'] == 'Yes') {
            $insert_data['deleted'] = 'No';
        }
        if ($insert_data['deleted'] == 'Yes') {
            $insert_data['active'] = 'No';
        }
        $this->db->insert($this->tables['module'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_module
     *
     * Updates a module in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_module($data)
    {
        $update_data = [
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'module',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'description' => $data['description'],
            'version' => $data['version'],
            'status' => $data['status'],
            'required' => $data['required'],
            'category_id' => $data['category_id'],
            'author' => $data['author'],
            'author_site' => $data['author_site'],
            'author_contact' => $data['author_contact'],
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
        $this->db->update($this->tables['module'], $update_data);
        return $this->db->affected_rows();
    }

     /**
     * get_modules_count
     *
     * Gets the number of modules in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_modules_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['module']);
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        _set_db_or_like($search, $this->module_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_all_modules
     *
     * Queries the database for all modules, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_all_modules($active_only = false)
    {
        _set_db_where($active_only, ['disabled' => 'No', 'active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->module_common_fields);
        $this->db->from($this->tables['module'] . '  m');
        return $this->db->get()->result_array();
    }

    /**
     * get_module
     *
     * Queries the database for a module, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_module($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No', 'disabled' => 'No']);
        $this->db->select($this->module_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['module'] . '  m');
        return $this->db->get()->result_array();
    }

    /**
     * get_module_by_id
     *
     * Queries the database for a module, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_module_by_id($id, $active_only = false)
    {
        return $this->get_module('id', $id, $active_only);
    }

    /**
     * get_module_by_name
     *
     * Queries the database for a module, and returns it (by name).
     *
     * @access public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return array
     */
    public function get_module_by_name($name, $active_only = false)
    {
        return $this->get_module('name', $name, $active_only);
    }

    /**
     * get_module_by_slug
     *
     * Queries the database for a module, and returns it (by slug).
     *
     * @access public
     *
     * @param string $slug
     * @param bool $active_only
     *
     * @return array
     */
    public function get_module_by_slug($slug, $active_only = false)
    {
        return $this->get_module('slug', $slug, $active_only);
    }

    /**
     * get_module_by_author
     *
     * Queries the database for a module, and returns it (by author).
     *
     * @access public
     *
     * @param string $slug
     * @param bool $active_only
     *
     * @return array
     */
    public function get_module_by_author($author, $active_only = false)
    {
        return $this->get_module('author', $author, $active_only);
    }

    /**
     * get_module_by_version
     *
     * Queries the database for a module, and returns it (by version).
     *
     * @access public
     *
     * @param string $version
     * @param bool $active_only
     *
     * @return array
     */
    public function get_module_by_version($version, $active_only = false)
    {
        return $this->get_module('version', $version, $active_only);
    }
}
