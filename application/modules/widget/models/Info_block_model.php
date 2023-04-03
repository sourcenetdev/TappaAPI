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
 * KyrandiaCMS Info Block Module
 *
 * Contains the info block features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Info_block_model extends CI_Model
{

    protected $tables;

    // Info Blocks
    private $info_block_common_fields = '
        id, slug, name, info_group, description, image_path, image_file, image_text, image_heading, button_class, button_text,
        section_class, section_id, body_text, active, deleted, createdate, moddate
    ';
    private $info_block_list_fields = '
        id, slug, name, info_group, description, active, deleted, createdate, moddate
    ';
    private $info_block_search_fields = [
        'name', 'slug', 'description', 'image_path', 'image_file', 'image_text', 'image_heading', 'button_class',
        'button_text', 'section_class', 'section_id', 'info_group', 'body_text', 'active', 'deleted'
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
            'info_block' => config_item('db_prefix') . 'info_block',
        ];
    }

    /* INFO BLOCKS */

    /**
     * get_info_block_list
     *
     * Gets a list of info blocks for administrative screens.
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
    public function get_info_block_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->info_block_list_fields);
        $this->db->from($this->tables['info_block']);
        _set_db_or_like($search, $this->info_block_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * add_info_block
     *
     * Adds an info block.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function add_info_block($data)
    {
        $insert_data = [
            'id' => '',
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'info_block',
                    'field' => 'slug'
                ]
            ),
            'name' => $data['name'],
            'info_group' => $data['info_group'],
            'image_path' => $data['image_path'],
            'image_file' => $data['image_file'],
            'description' => $data['description'],
            'body_text' => $data['body_text'],
            'image_text' => $data['image_text'],
            'image_heading' => $data['image_heading'],
            'button_text' => $data['button_text'],
            'button_class' => $data['button_class'],
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
        $this->db->insert($this->tables['info_block'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_info_block
     *
     * Updates an info block.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_info_block($data)
    {
        $update_data = [
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'info_block',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'name' => $data['name'],
            'info_group' => $data['info_group'],
            'image_path' => $data['image_path'],
            'image_file' => $data['image_file'],
            'description' => $data['description'],
            'body_text' => $data['body_text'],
            'image_text' => $data['image_text'],
            'image_heading' => $data['image_heading'],
            'button_text' => $data['button_text'],
            'button_class' => $data['button_class'],
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
        $this->db->update($this->tables['info_block'], $update_data);
        return $this->db->affected_rows();
    }

     /**
     * get_info_block_count
     *
     * Gets the number of info blocks in the database
     *
     * @access public
     *
     * @param bool $active_only
     *
     * @return array
     */
    public function get_info_block_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['info_block']);
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        _set_db_or_like($search, $this->info_block_search_fields);
        return $this->db->get()->result_array();
    }

    /**
     * get_all_info_blocks
     *
     * Queries the database for all info blocks, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_all_info_block($active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->info_block_common_fields);
        $this->db->from($this->tables['info_block'] . ' a');
        return $this->db->get()->result_array();
    }

    /**
     * get_info_block
     *
     * Queries the database for an info block, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_info_block($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->info_block_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['info_block'] . ' i');
        return $this->db->get()->result_array();
    }

    /**
     * get_info_block_by_id
     *
     * Queries the database for an info block, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_info_block_by_id($id, $active_only = false)
    {
        return $this->get_info_block('i.id', $id, $active_only);
    }

    /**
     * get_info_block_by_name
     *
     * Queries the database for an info block, and returns it (by name).
     *
     * @access public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return array
     */
    public function get_info_block_by_name($name, $active_only = false)
    {
        return $this->get_info_block('i.name', $name, $active_only);
    }

    /**
     * get_info_block_by_slug
     *
     * Queries the database for an info block, and returns it (by slug).
     *
     * @access public
     *
     * @param string $slug
     * @param bool $active_only
     *
     * @return array
     */
    public function get_info_block_by_slug($slug, $active_only = false)
    {
        return $this->get_info_block('i.slug', $slug, $active_only);
    }

    /**
     * get_info_blocks_by_group
     *
     * Queries the database for a group of info blocks, and returns them (by group).
     *
     * @access public
     *
     * @param string $group
     * @param bool $active_only
     *
     * @return array
     */
    public function get_info_blocks_by_group($group, $active_only = false)
    {
        return $this->get_info_block('i.info_group', $group, $active_only);
    }
}
