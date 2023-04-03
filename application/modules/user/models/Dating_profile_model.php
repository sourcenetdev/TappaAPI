<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Kyrandia CMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2020, Impero Consulting (Pty) Ltd., all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 */

/**
 * Kyrandia CMS Dating Profile module
 *
 * This file is the main model for the Dating Profile module.
 *
 * @package     Impero
 * @subpackage  Modules
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 */
class Dating_profile_model extends CI_Model
{
    protected $tables = [];
    public function __construct()
    {
        parent::__construct();

        // Tables used in this module.
        $this->tables = [
            'user' => _cfg('db_prefix') . 'user',
            'dating_profile' => _cfg('db_prefix') . 'dating_profile'
        ];
    }

    /**
     * get_dating_profile
     *
     * Queries the database for a user, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     *
     * @return array
     */
    public function get_dating_profile($field, $value)
    {
        $this->db->select($this->user_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['dating_profile'] . ' dp');
        return $this->db->get()->result_array();
    }

    /**
     * edit_dating_profile
     *
     * Changes a dating profile.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    function edit_dating_profile($data)
    {
        $update_data['nickname'] = $data['nickname'];
        $update_data['active'] = $data['active'];
        $update_data['moddate'] = date('Y-m-d H:i:s');
        $this->db->where('id', $data['id']);
        $this->db->update($this->tables['dating_profile'], $update_data);
        $update_data['affected_rows'] = $this->db->affected_rows();
        return $update_data;
    }
}
