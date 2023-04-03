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
 * KyrandiaCMS Accordion Module
 *
 * Contains the accordion features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Accordion_model extends CI_Model
{

    protected $tables;

    // Accordions
    private $accordion_common_fields = 'id, slug, name, region, description, outer_class, first_open, active, deleted, createdate, moddate';
    private $accordion_list_fields = 'id, slug, name, region, description, outer_class, active, deleted, createdate, moddate';
    private $accordion_search_fields = ['name', 'slug', 'description', 'outer_class', 'region', 'active', 'deleted'];

    // Accordion items
    private $accordion_item_common_fields = 'id, name, slug, body, class, icon, active, deleted, createdate, moddate';
    private $accordion_item_list_fields = 'ai.id, ai.name, ai.body, ai.slug, ai.class, ai.icon, ai.active, ai.deleted, ai.createdate, ai.moddate';
    private $accordion_item_search_fields = ['ai.name', 'ai.slug', 'ai.body', 'ai.class', 'ai.icon', 'ai.active', 'ai.deleted'];

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
            'accordion' => config_item('db_prefix') . 'accordion',
            'accordion_item' => config_item('db_prefix') . 'accordion_item'
        ];
    }

    /* ACCORDIONS */

    /**
     * get_accordion_list
     *
     * Gets a list of accordions for administrative screens.
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
    public function get_accordion_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->accordion_list_fields);
        $this->db->from($this->tables['accordion']);
        set_db_or_like($search, $this->accordion_search_fields);
        set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * add_accordion
     *
     * Adds an accordion.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_accordion($data)
    {
        $insert_data = [
            'id' => '',
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'accordion',
                    'field' => 'slug'
                ]
            ),
            'name' => $data['name'],
            'region' => $data['region'],
            'outer_class' => $data['outer_class'],
            'description' => $data['description'],
            'active' => $data['active'],
            'first_open' => $data['first_open'],
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
        $this->db->insert($this->tables['accordion'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_accordion
     *
     * Updates an accordion.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_accordion($data)
    {
        $update_data = [
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'accordion',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'name' => $data['name'],
            'region' => $data['region'],
            'outer_class' => $data['outer_class'],
            'description' => $data['description'],
            'active' => $data['active'],
            'first_open' => $data['first_open'],
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
        $this->db->update($this->tables['accordion'], $update_data);
        return $this->db->affected_rows();
    }

     /**
     * get_accordion_count
     *
     * Gets the number of accordions in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_accordion_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['accordion']);
        set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        set_db_or_like($search, $this->accordion_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_all_accordions
     *
     * Queries the database for all accordions, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_all_accordions($active_only = false)
    {
        set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->accordion_common_fields);
        $this->db->from($this->tables['accordion'] . ' a');
        return $this->db->get()->result_array();
    }

    /**
     * get_accordion
     *
     * Queries the database for an accordion, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_accordion($field, $value, $active_only = false)
    {
        set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->accordion_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['accordion'] . ' a');
        return $this->db->get()->result_array();
    }

    /**
     * get_accordion_by_id
     *
     * Queries the database for an accordion, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_accordion_by_id($id, $active_only = false)
    {
        return $this->get_accordion('a.id', $id, $active_only);
    }

    /**
     * get_accordion_by_name
     *
     * Queries the database for an accordion, and returns it (by name).
     *
     * @access public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return array
     */
    public function get_accordion_by_name($name, $active_only = false)
    {
        return $this->get_accordion('a.name', $name, $active_only);
    }

    /* ACCORDION ITEMS */

    /**
     * get_menu_item_list
     *
     * Gets a list of accordions for administrative screens.
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
    public function get_accordion_item_list($accordion_id, $start, $end, $search = '', $order = '')
    {
        $this->db->select($this->accordion_item_list_fields);
        $this->db->from($this->tables['accordion_item'] . ' ai');
        $this->db->join($this->tables['accordion'] . ' a', 'ai.accordion_id = a.id', 'left');
        $this->db->where('ai.accordion_id', $accordion_id);
        set_db_or_like($search, $this->accordion_item_search_fields);
        set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * add_accordion_item
     *
     * Adds a accordion item to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_accordion_item($data)
    {
        $insert_data = [
            'id' => '',
            'accordion_id' => $data['accordion_id'],
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'accordion_item',
                    'field' => 'slug'
                ]
            ),
            'body' => $data['body'],
            'class' => $data['class'],
            'icon' => $data['icon'],
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
        $this->db->insert($this->tables['accordion_item'], $insert_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    /**
     * edit_accordion_item
     *
     * Updates an accordion item in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_accordion_item($data)
    {
        $update_data = [
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'accordion_item',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'body' => $data['body'],
            'class' => $data['class'],
            'icon' => $data['icon'],
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
        $this->db->update($this->tables['accordion_item'], $update_data);
        return $this->db->affected_rows();
    }

     /**
     * get_accordion_item_count
     *
     * Gets the number of accordion items in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_accordion_item_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['accordion_item']);
        set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        set_db_or_like($search, $this->accordion_item_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_accordion_item
     *
     * Queries the database for an accordion item, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_accordion_item($field, $value, $active_only = false)
    {
        set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->accordion_item_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['accordion_item'] . ' ai');
        return $this->db->get()->result_array();
    }

    /**
     * get_accordion_by_id
     *
     * Queries the database for an accordion, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_accordion_item_by_id($id, $active_only = false)
    {
        return $this->get_accordion_item('ai.id', $id, $active_only);
    }

    /**
     * get_accordion_item_by_name
     *
     * Queries the database for an accordion item, and returns it (by name).
     *
     * @access public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return array
     */
    public function get_accordion_item_by_name($name, $active_only = false)
    {
        return $this->get_accordion_item('ai.name', $name, $active_only);
    }
}
