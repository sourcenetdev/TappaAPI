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
 * @version   7.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Cornerstone Library - Database Functions
 *
 * The kernel of KyrandiaCMS.
 *
 * @package     Impero
 * @subpackage  Core
 * @category    Libraries
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

class CSDatabase
{

    /**
     * function __construct()
     *
     * Initializes the library
     *
     * @access public
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Function setDBOrder()
     *
     * Sets the ORDER BY clause
     *
     * @access public
     *
     * @param string $order
     *
     * @return void
     */
    public function setDBOrder($order)
    {
        $ci =& get_instance();
        if (!empty($order)) {
            $ci->db->order_by($order);
        }
    }

    /**
     * Function setDBWhere()
     *
     * Sets a WHERE clause
     *
     * @access public
     *
     * @param bool $condition
     * @param array $fields
     *
     * @return void
     */
    public function setDBWhere($condition, $fields)
    {
        $ci =& get_instance();
        if ($condition && !empty($fields) && is_array($fields)) {
            foreach ($fields as $k => $v) {
                $ci->db->where($k, $v);
            }
        }
    }

    /**
     * Function setDBOrLike()
     *
     * Sets the OR_LIKE group
     *
     * @access public
     *
     * @param string $search
     * @param array $fields
     * @param string $match
     *
     * @return void
     */
    public function setDBOrLike($search, $fields, $match = 'both')
    {
        if (!empty($search) && !empty($fields) && is_array($fields)) {
            $ci =& get_instance();
            $ci->db->group_start();
            $counter = 0;
            foreach ($fields as $v) {
                if ($counter == 0) {
                    $ci->db->like($v, $search, $match);
                } else {
                    $ci->db->or_like($v, $search, $match);
                }
                $counter++;
            }
            $ci->db->group_end();
        }
    }

    /**
     * Function updateDBField()
     *
     * Updates a field value in a table.
     *
     * @access public
     *
     * @param array $data
     * @param string $theme
     *
     * @return void
     */
    function updateDBField($data, $theme)
    {
        $ci =& get_instance();
        if (!empty($data['is_confirmed'])) {
            $counter = 0;
            $ci->db->trans_start();
            foreach ($data['field_info']['items'] as $k => $v) {
                $update_data[$v['field']] = $v['value'];
                $ci->db->where($data['field_info']['id_field'], $data['field_info']['id_value']);
                $ci->db->update($v['table'], $update_data);
                unset($update_data);
                $counter++;
            }
            $ci->db->trans_complete();
            if ($counter < count($data['field_info']['items']) || $ci->db->trans_status() === false) {
                _sess_set('error', $data['messages']['error']);
                $ci->session->mark_as_flash('error');
                $ci->db->trans_rollback();
            } else {
                _sess_set('success', $data['messages']['success']);
                $ci->session->mark_as_flash('success');
                $ci->db->trans_commit();
            }
            if (!empty($data['process']['redirect'])) {
                redirect($data['process']['redirect']);
            }
        } else {
            if (!empty($data['process']['view'])) {
                $view_data['data'] = $data;
                _render($theme, $data['process']['view'], $view_data);
            }
        }
    }

    /**
     * Function deleteFromDB()
     *
     * Wrapper for bootstrap function delete_items - mainly for consistency.
     *
     * TODO: Separate the logic from presentation stuff here. The redirect and render should not happen here.
     *
     * @access public
     *
     * @param array $data
     *
     * @return string
     */
    public function deleteFromDB($data, $theme = 'theme_admin')
    {
        $ci =& get_instance();
        $posts = $ci->input->post();
        if (!empty($posts['can_delete'])) {
            $counter = 0;
            if ($data['process']['delete_type'] == 'hard') {
                $ci->db->trans_start();
                foreach ($data['delete_info'] as $v) {
                    $ci->db->where($v['field'], $v['value']);
                    $ci->db->delete($v['table']);
                    $counter++;
                }
                $ci->db->trans_complete();
                if ($counter < count($data['delete_info']) || $ci->db->trans_status() === false) {
                    $ci->session->set_userdata('error', $data['messages']['error']);
                    $ci->session->mark_as_flash('error');
                    $ci->db->trans_rollback();
                } else {
                    $ci->session->set_userdata('success', $data['messages']['success']);
                    $ci->session->mark_as_flash('success');
                    $ci->db->trans_commit();
                }
            } else {
                $ci->db->trans_start();
                foreach ($data['delete_info'] as $v) {
                    $update_data = [
                        'active' => 'No',
                        'deleted' => 'Yes'
                    ];
                    $ci->db->where($v['field'], $v['value']);
                    $ci->db->update($v['table'], $update_data);
                    unset($update_data);
                    $counter++;
                }
                $ci->db->trans_complete();
                if ($counter < count($data['delete_info']) || $ci->db->trans_status() === false) {
                    $ci->session->set_userdata('error', $data['messages']['error']);
                    $ci->session->mark_as_flash('error');
                    $ci->db->trans_rollback();
                } else {
                    $ci->session->set_userdata('success', $data['messages']['success']);
                    $ci->session->mark_as_flash('success');
                    $ci->db->trans_commit();
                }
            }
            if (!empty($data['process']['redirect'])) {
                redirect($data['process']['redirect']);
            }
        } else {
            $view_data['data'] = $data;
            _render($theme, $data['process']['view'], $view_data);
        }
    }

    /**
     * Function fieldValue()
     *
     * Checks if a field with a value exists in the database, returns that value.
     *
     * @access public
     *
     * @param string $value
     * @param array $criteria
     *
     * @return string
     */
    public function fieldValue($value, $criteria)
    {
        $ci =& get_instance();
        if (!empty($criteria['field']) && !empty($criteria['table'])) {
            $ci->db->select($criteria['field']);
            $ci->db->from(_cfg('db_prefix') . $criteria['table']);
            $ci->db->where($criteria['field'], $value);
            if (!empty($criteria['exclude'])) {
                $ci->db->not_like($criteria['exclude']['field'], $criteria['exclude']['value']);
            }
            $exists = $ci->db->get()->row_array();
            return $exists[$criteria['field']];
        }
        return '';
    }

    /**
     * Function fieldValueExists()
     *
     * Checks if a field with a value exists in the database, returns true or false.
     *
     * @access public
     *
     * @param string $value
     * @param array $criteria
     *
     * @return bool
     */
    public function fieldValueExists($value, $criteria)
    {
        $ci =& get_instance();
        if (!empty($criteria['field']) && !empty($criteria['table'])) {
            $ci->db->select($criteria['field']);
            $ci->db->from(_cfg('db_prefix') . $criteria['table']);
            $ci->db->where($criteria['field'], $value);
            if (!empty($criteria['exclude'])) {
                $ci->db->not_like($criteria['exclude']['field'], $criteria['exclude']['value']);
            }
            $exists = $ci->db->get()->row_array();
            return !empty($exists[$criteria['field']]);
        }
        return false;
    }
}
