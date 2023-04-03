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
 * KyrandiaCMS Role Module
 *
 * Contains the role features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Role_model extends CI_Model
{
    protected $tables = [];

    // Roles.
    private $role_common_fields = 'r.id, r.role, r.active, r.deleted, r.createdate, r.moddate';
    private $role_list_fields = 'r.id, r.role, r.active, r.deleted, r.createdate, r.moddate';
    private $role_search_fields = ['r.role', 'r.active', 'r.deleted'];

    // User roles.
    private $user_role_common_fields = 'r.role, ur.role_id, ur.user_id, ur.access_given_by, ur.access_revoked_by, ur.active, ur.active_until';

    public function __construct()
    {
        parent::__construct();

        // Tables used in this module.
        $this->tables = [
            'user_role' => _cfg('db_prefix') . 'user_role',
            'role' => _cfg('db_prefix') . 'role',
            'role_permission' => _cfg('db_prefix') . 'role_permission'
        ];
    }

    /**
     * get_role_count
     *
     * Gets the number of roles in the database
     *
     * @access public
     *
     * @param bool $active_only
     * @param string $search
     *
     * @return array
     */
    public function get_role_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['role'] . ' r');
        _set_db_where($active_only, ['r.active' => 'Yes', 'r.deleted' => 'No']);
        _set_db_or_like($search, $this->role_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_role_list
     *
     * Gets a list of roles for display in ajax listings.
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
    public function get_role_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->role_list_fields);
        $this->db->from($this->tables['role'] . ' r');
        _set_db_or_like($search, $this->role_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * get_role
     *
     * Queries the database for a role, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_role($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['r.active' => 'Yes', 'r.deleted' => 'No']);
        $this->db->select($this->role_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['role'] . ' r');
        return $this->db->get()->result_array();
    }

    /**
     * get_role_by_id
     *
     * Queries the database for a role, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_role_by_id($id, $active_only = false)
    {
        return $this->get_role('r.id', $id, $active_only);
    }

    /**
     * get_role_by_name
     *
     * Queries the database for a role, and returns it (by name).
     *
     * @access public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return array
     */
    public function get_role_by_name($name, $active_only = false)
    {
        return $this->get_role('r.role', $name, $active_only);
    }

    /**
     * add_role
     *
     * Adds a role.
     *
     * @access public
     *
     * @param array $data
     *
     * @return array
     */
    public function add_role($data)
    {
        $update_data = [
            'role' => $data['role'],
            'slug' => _slugify(
                $data['role'],
                true, [
                    'table' => 'role',
                    'field' => 'slug'
                ]
            ),
            'active' => $data['active'],
            'createdate' => date('Y-m-d H:i:s'),
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($update_data['active'] == 'Yes') {
            $update_data['deleted'] = 'No';
        }
        if ($update_data['deleted'] == 'Yes') {
            $update_data['active'] = 'No';
        }
        $this->db->insert($this->tables['role'], $update_data);
        return $this->db->insert_id();
    }

    /**
     * add_role_permission
     *
     * Adds a permission to a role.
     *
     * @access public
     *
     * @param int $id
     * @param int $permission
     *
     * @return array
     */
    public function add_role_permission($id, $permission)
    {
        $update_data['role_id'] = $id;
        $update_data['permission_id'] = $permission;
        $update_data['createdate'] = date('Y-m-d H:i:s');
        $update_data['moddate'] = date('Y-m-d H:i:s');
        $this->db->insert($this->tables['role_permission'], $update_data);
        return $this->db->insert_id();
    }

    /**
     * get_all_roles
     *
     * Retrieves roles with a possibility of exclusions
     *
     * @access public
     *
     * @param bool $active_only
     * @param array $excludes
     *
     * @return array
     */
    public function get_all_roles($active_only = 'Yes', $excludes = array())
    {
        if (!empty($excludes)) {
            foreach ($excludes as $v) {
                $this->db->not_like('r.role', $v, 'after');
            }
        }
        _set_db_where($active_only, ['r.active' => 'Yes', 'r.deleted' => 'No']);
        return $this->db->get($this->tables['role'] . ' r')->result_array();
    }

    /**
     * edit_role
     *
     * Changes a role
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_role($data)
    {
        $update_data = [
            'role' => $data['role'],
            'slug' => _slugify(
                $data['role'],
                true, [
                    'table' => 'role',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'active' => $data['active'],
            'deleted' => 'No',
            'moddate' => date('Y-m-d H:i:s')
        ];
        if ($update_data['active'] == 'Yes') {
            $update_data['deleted'] = 'No';
        }
        if (isset($data['deleted']) && $update_data['deleted'] == 'Yes') {
            $update_data['active'] = 'No';
        }
        $this->db->where('id', $data['id']);
        $this->db->update($this->tables['role'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * delete_role_permissions
     *
     * Deletes prior links between roles and permissions
     *
     * @access public
     *
     * @param int $id
     *
     * @return int
     */
    public function delete_role_permissions($id)
    {
        $this->db->where('role_id', $id);
        $this->db->from($this->tables['role_permission']);
        $this->db->delete();
        return $this->db->affected_rows();
    }

    /**
     * get_user_roles
     *
     * Gets all of a user's roles.
     *
     * @access public
     *
     * @param int $id
     *
     * @return int
     */
    public function get_user_roles($id, $active_only = true)
    {
        $this->db->select($this->user_role_common_fields);
        $this->db->from($this->tables['role'] .  ' r');
        $this->db->join($this->tables['user_role'] . ' ur', 'ur.role_id = r.id', 'left');
        $this->db->where('ur.user_id', $id);
        $this->db->where('ur.active_until >', date('Y-m-d H:i:s'));
        _set_db_where($active_only, ['ur.active' => 'Yes', 'ur.deleted' => 'No']);
        return $this->db->get()->result_array();
    }

    /**
     * delete_user_roles
     *
     * Deletes prior links between users and roles
     *
     * @access public
     *
     * @param int $id
     *
     * @return int
     */
    public function delete_user_roles($id)
    {
        $this->db->where('user_id', $id);
        $this->db->from($this->tables['user_role']);
        $this->db->delete();
        return $this->db->affected_rows();
    }

    /**
     * add_user_role
     *
     * Adds a user role.
     *
     * @access public
     *
     * @param int $id
     * @param array $data
     *
     * @return int
     */
    public function add_user_role($id, $rid)
    {
        $role_validity = _cfg('user_role_validity');
        $role_validity = (!empty($role_validity) ? $role_validity : 86400 * 365 * 5);
        $insert['access_given_by'] = $this->session->userdata('id');
        $insert['access_revoked_by'] = 0;
        $insert['active_until'] = date('Y-m-d H:i:s', strtotime('+ ' . $role_validity . ' second'));
        $insert['access_date'] = date('Y-m-d H:i:s');
        $insert['active'] = 'Yes';
        $insert['createdate'] = date('Y-m-d H:i:s');
        $insert['moddate'] = date('Y-m-d H:i:s');
        $insert['role_id'] = $rid;
        $insert['user_id'] = $id;
        $this->db->insert($this->tables['user_role'], $insert);
        return $this->db->affected_rows();
    }
}
