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
 * KyrandiaCMS Block Module
 *
 * Contains the block features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Block
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Block_model extends CI_Model
{

    protected $tables;

    // Blocks
    private $block_common_fields = 'id, name, slug, title, author, body, foot, view, region, block_class, title_class, content_class, foot_class, active, deleted, createdate, moddate';
    private $block_list_fields = 'id, name, slug, title, author, body, view, active, createdate AS `created`, moddate AS `modified';
    private $block_search_fields = ['name', 'slug', 'author', 'body', 'foot', 'view', 'region', 'block_class', 'content_class', 'foot_class', 'active', 'deleted'];

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
            'block' => config_item('db_prefix') . 'block'
        ];
    }

    /**
     * add_block
     *
     * Adds a block to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    function add_block($data)
    {
        $insert_data = [
            'id' => '',
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'block',
                    'field' => 'slug'
                ]
            ),
            'title' => $data['title'],
            'author' => $data['author'],
            'body' => $data['body'],
            'foot' => $data['foot'],
            'view' => $data['view'],
            'region' => $data['region'],
            'block_class' => $data['block_class'],
            'title_class' => $data['title_class'],
            'content_class' => $data['content_class'],
            'foot_class' => $data['foot_class'],
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
        $this->db->insert($this->tables['block'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_block
     *
     * Updates a block in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    function edit_block($data)
    {
        $update_data = [
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'block',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'title' => $data['title'],
            'author' => $data['author'],
            'body' => $data['body'],
            'foot' => $data['foot'],
            'view' => $data['view'],
            'region' => $data['region'],
            'block_class' => $data['block_class'],
            'title_class' => $data['title_class'],
            'content_class' => $data['content_class'],
            'foot_class' => $data['foot_class'],
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
        $this->db->update($this->tables['block'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * get_block
     *
     * Queries the database for a block, and returns it if found
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return string
     */
    function get_block($id, $active_only = true)
    {
        $this->db->select($this->block_common_fields);
        $this->db->from($this->tables['block']);
        $this->db->where('id', $id);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_block_by_id
     *
     * Alias for get_block
     *
     * @access  public
     *
     * @param string $id
     * @param bool $active_only
     *
     * @return array
     */
    function get_block_by_id($id, $active_only = false)
    {
        return $this->get_block($id, $active_only);
    }

    /**
     * get_block_by_name
     *
     * Queries the database for a block, and returns it if found
     *
     * @access  public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return string
     */
    function get_block_by_name($id, $active_only = true)
    {
        $this->db->select($this->block_common_fields);
        $this->db->from($this->tables['block']);
        $this->db->where('name', $id);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_block_by_slug
     *
     * Queries the database for a block, and returns it if found
     *
     * @access  public
     *
     * @param string $slug
     * @param bool $active_only
     *
     * @return string
     */
    function get_block_by_slug($slug, $active_only = true)
    {
        $this->db->select($this->block_common_fields);
        $this->db->from($this->tables['block']);
        $this->db->where('slug', $slug);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_blocks
     *
     * Queries the database for a region's blocks, and returns them if found
     *
     * @access  public
     *
     * @param string $region
     *
     * @return string
     */
    function get_blocks($region, $active_only = true)
    {
        $this->db->select($this->block_common_fields);
        $this->db->from($this->tables['block']);
        $this->db->where('region', $region);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_all_blocks
     *
     * Queries the database for all blocks, and returns them.
     *
     * @access  public
     *
     * @param bool $active_only
     *
     * @return string
     */
    function get_all_blocks($active_only = true)
    {
        $this->db->select($this->block_common_fields);
        $this->db->from($this->tables['block']);
        _set_db_where($active_only, ['active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_blocks_by_region
     *
     * Alias for get_blocks.
     *
     * @access  public
     *
     * @param string $region
     * @param bool $active_only
     *
     * @return string
     */
    function get_blocks_by_region($region, $active_only)
    {
        return $this->get_blocks($region, $active_only);
    }

    /**
     * get_block_list
     *
     * Gets a list of blocks for administrative screens.
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
    function get_block_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->block_list_fields);
        $this->db->from($this->tables['block']);
        _set_db_or_like($search, $this->block_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * get_block_count
     *
     * Gets the number of blocks.
     *
     * @access  public
     *
     * @param bool $active_only
     *
     * @return array
     */
    function get_block_count($active_only = true)
    {
        _set_db_where($active_only, ['active' => 'Yes']);
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['block']);
        return $this->db->get()->result_array();
    }
}
