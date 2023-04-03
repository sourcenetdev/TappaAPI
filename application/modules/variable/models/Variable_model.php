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
 * KyrandiaCMS Variable Module
 *
 * Contains the variable features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Variable_model extends CI_Model
{
    protected $tables;

    // Variables.
    private $variable_common_fields = 'id, name, value, active, deleted, createdate, moddate';
    private $variable_list_fields = 'id, name, value, active, deleted, createdate, moddate';
    private $variable_search_fields = ['name', 'value', 'active', 'deleted'];

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
            'variable' => config_item('db_prefix') . 'variable'
        ];
    }

    /**
     * add_variable
     *
     * Adds a variable to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_variable($data)
    {
        $insert_data = [
            'id' => '',
            'name' => $data['name'],
            'value' => $data['value'],
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
        $this->db->insert($this->tables['variable'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_variable
     *
     * Updates a variable in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_variable($data)
    {
        $update_data = [
            'name' => $data['name'],
            'value' => $data['value'],
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
        $this->db->update($this->tables['variable'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * get_variable
     *
     * Queries the database for a variable, and returns the variable or sensible default if provided
     *
     * @access public
     *
     * @param string $variable
     * @param string $default
     *
     * @return string
     */
    public function get_variable($variable, $default = '')
    {
        $this->db->select('value');
        $this->db->where('name', $variable);
        $this->db->from($this->tables['variable']);
        $t = $this->db->get()->result_array();
        return (!empty($t[0]['value']) ? $t[0]['value'] : $default);
    }

    /**
     * get_variable_by_name
     *
     * Alias for get_variable
     *
     * @access public
     *
     * @param string $variable
     * @param string $default
     *
     * @return string
     */
    public function get_variable_by_name($variable, $default = '')
    {
        return $this->get_variable($variable, $default);
    }

    /**
     * get_all_variables
     *
     * Queries the database for all variables.
     *
     * @access public
     *
     * @param bool $active
     *
     * @return array
     */
    public function get_all_variables($active = true)
    {
        $this->db->select($this->variable_common_fields);
        $this->db->from($this->tables['variable']);
        _set_db_where($active, ['active' => 'Yes', 'deleted' => 'No']);
        return $this->db->get()->result_array();
    }

    /**
     * get_variable_by_id
     *
     * Queries the database for a variable by ID, and returns the variable.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function get_variable_by_id($id)
    {
        $this->db->select($this->variable_common_fields);
        $this->db->from($this->tables['variable']);
        $this->db->where('id', $id);
        return $this->db->get()->result_array();
    }

    /**
     * get_variable_list
     *
     * Gets a list of variables for administrative screens.
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
    public function get_variable_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->variable_list_fields);
        $this->db->from($this->tables['variable']);
        _set_db_or_like($search, $this->variable_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * get_variable_count
     *
     * Gets the number of variables in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_variable_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['variable']);
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        _set_db_or_like($search, $this->variable_search_fields);
        return $this->db->get()->result_array();
    }
}
