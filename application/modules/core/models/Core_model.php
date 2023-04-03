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
 * KyrandiaCMS Core Module
 *
 * Contains the core features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Core_model extends CI_Model
{

    protected $tables;

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
            'headtag' => config_item('db_prefix') . 'headtag',
            'attribute' => config_item('db_prefix') . 'attribute',
            'page_headtag' => config_item('db_prefix') . 'page_headtag',
            'global_headtag' => config_item('db_prefix') . 'global_headtag',
            'page_headtag_attribute' => config_item('db_prefix') . 'page_headtag_attribute',
            'page_content_section' => config_item('db_prefix') . 'page_content_section',
            'global_headtag_attribute' => config_item('db_prefix') . 'global_headtag_attribute',
            'theme' => config_item('db_prefix') . 'theme',
            'layout' => config_item('db_prefix') . 'layout'
        ];
    }

    /**
     * function get_page_leadin
     *
     * Retrieves the meta data for a page - template, layout, etc.
     *
     * @access public
     *
     * @param string $slug
     *
     * @return array
     */
    function get_page_leadin($slug)
    {
        $this->db->select('p.*, t.name AS theme_name, t.file AS theme_file, t.id AS tid, l.name AS layout_name, l.file AS layout_file, l.id AS lid');
        $this->db->from($this->tables['page'] . ' p');
        $this->db->join($this->tables['theme'] . ' t', 't.id = p.theme_id', 'left');
        $this->db->join($this->tables['layout'] . ' l', 'l.id = p.layout_id', 'left');
        $this->db->where('p.slug', $slug);
        $this->db->where('p.active', 'Yes');
        return $this->db->get()->result_array();
    }

    /**
     * function get_page_data
     *
     * Queries the database for details of a page, in particular, its metadata, and returns the resulting array (if found)
     *
     * @access public
     *
     * @param string $slug
     *
     * @return array
     */
    function get_page_data($slug)
    {
        $this->db->select('*');
        $this->db->from($this->tables['page']);
        $this->db->where('slug', $slug);
        $this->db->where('active', 'Yes');
        return $this->db->get()->result_array();
    }

    /**
     * function get_page_headtag_data
     *
     * Queries the database for the <head> tags of a page, and returns the resulting array (if found)
     *
     * @access public
     *
     * @param integer $page_id
     *
     * @return array
     */
    function get_page_headtag_data($page_id)
    {
        $this->db->select('
            ph.id AS ph_id, ph.slug AS ph_slug, ph.page_id, ph.headtag_id, ph.active AS ph_active, ph.priority,
            h.name AS h_name, h.type AS h_type, h.active AS h_active,
            a.name AS a_name, a.id AS a_id, a.active AS a_active,
            pha.value
        ');
        $this->db->from($this->tables['page_headtag'] . ' ph');
        $this->db->join($this->tables['headtag'] . ' h', 'h.id = ph.headtag_id', 'left');
        $this->db->join($this->tables['page_headtag_attribute'] . ' pha', 'pha.headtag_id = ph.headtag_id', 'left');
        $this->db->join($this->tables['attribute'] . ' a', 'a.id = pha.attribute_id', 'left');
        $this->db->where('ph.page_id', $page_id);
        $this->db->where('ph.active', 'Yes');
        $this->db->where('h.active', 'Yes');
        $this->db->where('a.active', 'Yes');
        $this->db->order_by('ph.priority', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * function get_page_default_headtags
     *
     * Queries the database for the default <head> tags of the system, and returns the resulting array (if found)
     *
     * @access public
     *
     * @return array
     */
    function get_page_default_headtags()
    {
        $this->db->select('
            ph.id AS ph_id, ph.slug AS ph_slug, ph.headtag_id, ph.active AS ph_active, ph.priority,
            h.name AS h_name, h.type AS h_type, h.active AS h_active,
            a.name AS a_name, a.id AS a_id, a.active AS a_active,
            pha.value
        ');
        $this->db->from($this->tables['global_headtag'] . ' ph');
        $this->db->join($this->tables['headtag'] . ' h', 'h.id = ph.headtag_id', 'left');
        $this->db->join($this->tables['global_headtag_attribute'] . ' pha', 'pha.headtag_id = ph.headtag_id', 'left');
        $this->db->join($this->tables['attribute'] . ' a', 'a.id = pha.attribute_id', 'left');
        $this->db->where('ph.active', 'Yes');
        $this->db->where('h.active', 'Yes');
        $this->db->where('a.active', 'Yes');
        $this->db->order_by('ph.priority', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * function get_page_final_content
     *
     * Retrieves the final content for a page.
     *
     * @access public
     *
     * @param string $section
     * @param string $container
     * @param int $pid
     * @param bool $active_only
     *
     * @return array
     */
    function get_page_final_content($section, $container, $pid, $active_only = false)
    {
        $this->db->select('b.section_content');
        $this->db->from($this->tables['page_content_section'] . ' b');
        $this->db->join($this->tables['page'] . ' p', 'p.id = b.page_id', 'left');
        $this->db->where('b.section_container', $section);
        $this->db->where('b.section_type', $container);
        $this->db->where('p.slug', $pid);
        _set_db_where($active_only, ['b.active' => 'Yes']);
        return $this->db->get()->result_array();
    }

    /**
     * Get any slugs for Summernote.
     *
     * @return  array
     */
    function get_slugs($table, $field = 'slug') {
        $this->db->select($field);
        $this->db->from($table);
        $this->db->where('active', 'Yes');
        $this->db->where('deleted', 'No');
        return $this->db->get()->result_array();
    }
}
