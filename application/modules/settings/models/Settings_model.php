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
 * KyrandiaCMS Settings Module
 *
 * Contains the settings features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Models
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Settings_model extends CI_Model
{
    private $tables = [];

    // Settings.
    private $settings_common_fields = 'name, value, moddate';

    function __construct()
    {
        parent::__construct();
        $this->tables = [
            'settings' => config_item('db_prefix') . 'settings',
        ];
    }

    /**
     * get_settings
     *
     * Retrieves the system's settings.
     *
     * @access public
     *
     * @return string
     */
    public function get_settings()
    {
        $this->db->select($this->settings_common_fields);
        $this->db->from($this->tables['settings']);
        $temp = $this->db->get()->result_array();
        $final = [];
        if (!empty($temp)) {
            foreach ($temp as $k => $v) {
                $final[$v['name']] = $v;
            }
        }
        return $final;
    }

    /**
     * edit_settings
     *
     * Manages system settings
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function edit_settings($data)
    {
        $counter = 0;
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if ($k != 'submit') {
                    $exists = $this->get_setting($k);
                    if (!empty($exists)) {
                        $update_data['name'] = $k;
                        $update_data['value'] = $v;
                        $update_data['updated_by'] = _sess_get('id');
                        $update_data['moddate'] = date('Y-m-d H:i:s');
                        $this->db->where('name', $k);
                        $this->db->update($this->tables['settings'], $update_data);
                        $counter += 1;
                    } else {
                        $insert_data['name'] = $k;
                        $insert_data['value'] = $v;
                        $insert_data['updated_by'] = _sess_get('id');
                        $insert_data['createdate'] = date('Y-m-d H:i:s');
                        $insert_data['moddate'] = date('Y-m-d H:i:s');
                        $this->db->insert($this->tables['settings'], $insert_data);
                        $counter += 1;
                    }
                }
            }
        }
        return $counter;
    }

    /**
     * get_setting
     *
     * Retrieves a single setting.
     *
     * @access public
     *
     * @param string $name
     *
     * @return int
     */
    public function get_setting($name)
    {
        $this->db->where('name', $name);
        return $this->db->get($this->tables['settings'])->row_array();
    }
}
