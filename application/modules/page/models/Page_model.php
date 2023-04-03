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
 * KyrandiaCMS Page Module
 *
 * Contains the page features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Block
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Page_model extends CI_Model
{
    protected $tables;

    // Page content.
    private $page_content_common_fields = 'pc.id, pc.section_type, pc.section_id, pc.section_area, pc.section_content, pc.active, pc.deleted, pc.createdate, pc.moddate';

    // Pages.
    private $page_common_fields = 'p.id, p.name, p.slug, p.theme_id, p.layout_id, p.active, p.deleted, p.createdate, p.moddate';
    private $page_list_fields = 'p.id, p.name, p.slug, p.theme_id AS `theme`, p.layout_id AS `layout`, p.active, p.createdate AS `created`, p.moddate AS `modified`';
    private $page_search_fields = ['p.name', 'p.slug', 'p.active', 'p.deleted'];

    // Page meta.
    private $page_meta_common_fields = 'pm.id, pm.headtag_id, pm.attribute_id, pm.page_id, pm.value, pm.active, pm.deleted, pm.createdate, pm.moddate, h.name';

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
            'page' => config_item('db_prefix') . 'page',
            'page_meta' => config_item('db_prefix') . 'page_meta',
            'page_content' => config_item('db_prefix') . 'page_content',
            'attribute' => config_item('db_prefix') . 'attribute',
            'headtag' => config_item('db_prefix') . 'headtag',
        ];
    }

    /**
     * add_page
     *
     * Adds a page to the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    function add_page($data)
    {
        $insert_data = [
            'id' => '',
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'page',
                    'field' => 'slug'
                ]
            ),
            'theme_id' => $data['theme_id'],
            'layout_id' => $data['layout_id'],
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
        $this->db->insert($this->tables['page'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * edit_page
     *
     * Updates a page in the database
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    function edit_page($data)
    {
        $update_data = [
            'name' => $data['name'],
            'slug' => _slugify(
                $data['name'],
                true, [
                    'table' => 'page',
                    'field' => 'slug',
                    'exclude' => [
                        'field' => 'id',
                        'value' => $data['id']
                    ]
                ]
            ),
            'theme_id' => $data['theme_id'],
            'layout_id' => $data['layout_id'],
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
        $this->db->update($this->tables['page'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * get_page
     *
     * Queries the database for a page, and returns it if found
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return string
     */
    function get_page($id, $active_only = true)
    {
        $this->db->select($this->page_common_fields);
        $this->db->from($this->tables['page'] . ' p');
        $this->db->where('p.id', $id);
        _set_db_where($active_only, ['p.active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_page_by_id
     *
     * Alias for get_page
     *
     * @access  public
     *
     * @param string $id
     * @param bool $active_only
     *
     * @return array
     */
    function get_page_by_id($id, $active_only = false)
    {
        return $this->get_page($id, $active_only);
    }

    /**
     * get_page_by_name
     *
     * Queries the database for a page, and returns it if found
     *
     * @access  public
     *
     * @param string $name
     * @param bool $active_only
     *
     * @return string
     */
    function get_page_by_name($id, $active_only = true)
    {
        $this->db->select($this->page_common_fields);
        $this->db->from($this->tables['page'] . ' p');
        $this->db->where('p.name', $id);
        _set_db_where($active_only, ['p.active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_page_by_slug
     *
     * Queries the database for a page, and returns it if found
     *
     * @access  public
     *
     * @param string $slug
     * @param bool $active_only
     *
     * @return string
     */
    function get_page_by_slug($slug, $active_only = true)
    {
        $this->db->select($this->page_common_fields);
        $this->db->from($this->tables['page'] . ' p');
        $this->db->where('p.slug', $slug);
        _set_db_where($active_only, ['p.active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_pages
     *
     * Queries the database for pages, and returns them if found
     *
     * @access  public
     *
     * @return string
     */
    function get_pages($active_only = true)
    {
        $this->db->select($this->page_common_fields);
        $this->db->from($this->tables['page'] . ' p');
        _set_db_where($active_only, ['p.active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * get_all_pages
     *
     * Queries the database for all pages, and returns them.
     *
     * @access  public
     *
     * @param bool $active_only
     *
     * @return string
     */
    function get_all_pages($active_only = true)
    {
        return $this->get_pages($active_only);
    }

    /**
     * get_page_ontent
     *
     * Gets all content for a page.
     *
     * @access  public
     *
     * @param int $page_id
     * @param bool $rekey
     *
     * @return string
     */
    function get_page_content($page_id, $rekey = false)
    {
        $this->db->select($this->page_content_common_fields);
        $this->db->from($this->tables['page_content'] . ' pc');
        $this->db->where('page_id', $page_id);
        $data = $this->db->get()->result_array();
        $final = [];
        if (!empty($data)) {
            if ($rekey) {
                foreach ($data as $k => $v) {
                    $final[$v['section_type'] . '_' . $v['section_id'] . '_area_' . $v['section_area']] = $v;
                }
            } else {
                $final = $data;
            }
        }
        return $final;
    }

    /**
     * get_page_headtags
     *
     * Gets all headtags for a page.
     *
     * @access  public
     *
     * @param int $page_id
     *
     * @return string
     */
    function get_page_headtags($page_id)
    {
        $this->db->select($this->page_meta_common_fields);
        $this->db->from($this->tables['page_meta'] . ' pm');
        $this->db->join($this->tables['headtag'] . ' h', 'h.id = pm.headtag_id', 'left');
        $this->db->where('page_id', $page_id);
        return $this->db->get()->result_array();
    }

    /**
     * get_page_list
     *
     * Gets a list of pages for administrative screens.
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
    function get_page_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->page_list_fields);
        $this->db->from($this->tables['page'] . ' p');
        _set_db_or_like($search, $this->page_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * get_page_count
     *
     * Gets the number of pages.
     *
     * @access  public
     *
     * @param bool $active_only
     *
     * @return array
     */
    function get_page_count($active_only = true)
    {
        _set_db_where($active_only, ['p.active' => 'Yes']);
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['page'] . ' p');
        return $this->db->get()->result_array();
    }

    /**
     * delete_page_headtags
     *
     * Deletes headtag data for a page to prepare for new inserts.
     *
     * @access  public
     *
     * @param int $page_id
     *
     * @return array
     */
    function delete_page_headtags($page_id)
    {
        $this->db->where('page_id', $page_id);
        $this->db->delete($this->tables['page_meta']);
        return $this->db->affected_rows();
    }

    /**
     * add_page_headtags
     *
     * Adds new headtag data for a page.
     *
     * @access  public
     *
     * @param int $page_id
     * @param array $headtag_keys
     * @param array $headtag_values
     *
     * @return array
     */
    function add_page_headtags($page_id, $headtag_keys, $headtag_values)
    {
        if (!empty($headtag_keys) && is_array($headtag_keys)) {
            foreach ($headtag_keys as $k => $v) {
                if (isset($headtag_values[$v])) {
                    $insert = true;
                    $exists = $this->get_page_headtags($page_id);
                    if (!empty($exists)) {
                        foreach ($exists as $vv) {
                            if ($vv['headtag_id'] == $v) {
                                $insert = false;
                            }
                        }
                    }
                    if ($insert) {
                        $insert_data = [
                            'id' => '',
                            'headtag_id' => $v,
                            'page_id' => $page_id,
                            'active' => 'Yes',
                            'deleted' =>  'No',
                            'createdate' => date('Y-m-d H:i:s'),
                            'moddate' => date('Y-m-d H:i:s')
                        ];
                        foreach ($headtag_values[$v] as $kk => $vv) {
                            $insert_data['attribute_id'] = $kk;
                            $insert_data['value'] = $vv;
                            $this->db->insert($this->tables['page_meta'], $insert_data);
                        }
                    }
                }
            }
        }
    }

    /**
     * add_page_content
     *
     * Adds new content data for a page.
     *
     * @access  public
     *
     * @param int $page_id
     * @param string $section
     * @param int $section_id
     * @param string $section_area
     * @param string $data
     *
     * @return array
     */
    function add_page_content($page_id, $section, $section_id, $section_area, $data)
    {
        $insert_data = [
            'id' => '',
            'page_id' => $page_id,
            'section_type' => $section,
            'section_id' => $section_id,
            'section_area' => $section_area,
            'section_content' => $data
        ];
        $this->db->insert($this->tables['page_content'], $insert_data);
        return $this->db->insert_id();
    }

    /**
     * delete_page_content
     *
     * Deletes a page's content.
     *
     * @access  public
     *
     * @param int $page_id
     *
     * @return array
     */
    function delete_page_content($page_id)
    {
        $this->db->where('page_id', $page_id);
        $this->db->delete($this->tables['page_content']);
        return $this->db->affected_rows();
    }
}
