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
 * KyrandiaCMS Permission Module
 *
 * Contains the permission features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Permission_model extends CI_Model
{
    protected $tables = [];

    // Permissions.
    private $permission_common_fields = 'p.id, p.permission, p.active, p.deleted, p.createdate, p.moddate';
    private $permission_list_fields = 'p.id, p.permission, p.active, p.deleted, p.createdate AS `date_created`, p.moddate AS `date_modified`';
    private $permission_search_fields = ['p.permission', 'p.active', 'p.deleted'];

    // Role permissions.
    private $role_permission_common_fields = 'p.id, p.permission, rp.role_id, rp.permission_id';

    public function __construct()
    {
        parent::__construct();

        // Tables used in this module.
        $this->tables = [
            'user' => _cfg('db_prefix') . 'user',
            'permission' => _cfg('db_prefix') . 'permission',
            'metadata' => _cfg('db_prefix') . 'metadata',
            'user_session_log' => _cfg('db_prefix') . 'user_session_log',
            'user_role' => _cfg('db_prefix') . 'user_role',
            'role' => _cfg('db_prefix') . 'role',
            'role_permission' => _cfg('db_prefix') . 'role_permission'
        ];
    }

    /**
     * get_permission_count
     *
     * Gets the number of permissions in the database
     *
     * @access public
     *
     * @param bool $active_only
     * @param string $search
     *
     * @return array
     */
    public function get_permission_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['permission'] . ' p');
        _set_db_where($active_only, ['p.active' => 'Yes', 'p.deleted' => 'No']);
        _set_db_or_like($search, $this->permission_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_permission_list
     *
     * Gets a list of permissions for display in ajax listings.
     *
     * @access public
     *
     * @param int $start
     * @param int $end
     * @param string $search
     * @param string $order
     *
     * @return array
     */
    public function get_permission_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->permission_list_fields);
        $this->db->from($this->tables['permission'] . ' p');
        _set_db_or_like($search, $this->permission_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * get_permission
     *
     * Queries the database for a permission, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_permission($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->permission_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['permission'] . '  p');
        return $this->db->get()->result_array();
    }

    /**
     * get_permission_by_id
     *
     * Queries the database for a permission, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_permission_by_id($id, $active_only = false)
    {
        return $this->get_permission('p.id', $id, $active_only);
    }

    /**
     * get_permission_by_name
     *
     * Queries the database for a permission, and returns it (by name).
     *
     * @access public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return array
     */
    public function get_permission_by_name($name, $active_only = false)
    {
        return $this->get_permission('p.permission', $name, $active_only);
    }

    /**
     * add_permission
     *
     * Adds a permission
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_permission($data)
    {
        $update_data = [
            'permission' => $data['permission'],
            'slug' => _slugify(
                $data['permission'],
                true, [
                    'table' => 'permission',
                    'field' => 'slug'
                ]
            ),
            'active' => $data['active'],
            'deleted' => 'No',
            'createdate' => date('Y-m-d H:i:s'),
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($update_data['active'] == 'Yes') {
            $update_data['deleted'] = 'No';
        }
        if ($update_data['deleted'] == 'Yes') {
            $update_data['active'] = 'No';
        }
        $this->db->insert($this->tables['permission'], $update_data);
        return $this->db->insert_id();
    }

    /**
     * get_all_permissions
     *
     * Retrieves permissions with a possibility of exclusions
     *
     * @access public
     *
     * @param bool $active_only
     * @param array $excludes
     *
     * @return array
     */
    public function get_all_permissions($active_only = 'Yes', $excludes = array())
    {
        if (!empty($excludes)) {
            foreach ($excludes as $v) {
                $this->db->not_like('p.permission', $v, 'after');
            }
        }
        _set_db_where($active_only, ['p.active' => 'Yes', 'p.deleted' => 'No']);
        return $this->db->get($this->tables['permission'] . ' p')->result_array();
    }

    /**
     * edit_permission
     *
     * Changes a permission
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_permission($data)
    {
        $update_data = [
            'permission' => $data['permission'],
            'slug' => _slugify(
                $data['permission'],
                true, [
                    'table' => 'permission',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'active' => $data['active'],
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($update_data['active'] == 'Yes') {
            $update_data['deleted'] = 'No';
        }
        if ($update_data['deleted'] == 'Yes') {
            $update_data['active'] = 'No';
        }
        $this->db->where('id', $data['id']);
        $this->db->update($this->tables['permission'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * get_role_permissions
     *
     * Retrieves permissions from a role.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function get_role_permissions($rid)
    {
        $this->db->select($this->role_permission_common_fields);
        $this->db->from($this->tables['permission'] . ' p');
        $this->db->join($this->tables['role_permission'] . ' rp', 'p.id = rp.permission_id', 'left');
        $this->db->where('p.active', 'Yes');
        $this->db->where('rp.role_id', $rid);
        return $this->db->get()->result_array();
    }
}
