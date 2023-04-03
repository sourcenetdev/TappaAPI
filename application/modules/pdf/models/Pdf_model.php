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
 * @author      Elsabe Bester
 * @link        https://www.lessink.co.za
 * @version     6.0.0
 */
class Pdf_model extends CI_Model
{

    protected $tables;

    /**
     * __construct
     *
     * Initializes the class
     *
     * @access public
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->tables = [];
    }

    /**
     * get_table_data
     *
     * Retrieves data from a table
     *
     * @access public
     *
     * @param array $data
     *
     * @return array
     */
    function get_table_data($module = '', $model = '', $function = '', $parameters = [])
    {
        $params['search'] = '';
        $params['order'] = '';
        $params['nopretty'] = 1;
        if (!isset($parameters['start'])) {
            $params['start'] = 0;
        }
        if (!isset($parameters['end'])) {
            $params['end'] = null;
        }
        if (!empty($parameters['search'])) {
            $params['search'] = $parameters['search'];
        }
        if (!empty($parameters['order'])) {
            $params['order'] = $parameters['order'];
        }
        if (!empty($parameters['nopretty'])) {
            $params['nopretty'] = $parameters['nopretty'];
        }
        if ($module) {
            $this->load->model($module . '/' . $model);
        } else {
            $this->load->model($model);
        }
        if (isset($parameters['base'])) {
            $params['base'] = $parameters['base'];
        }
        if (isset($params['base'])) {
            $data = $this->{$model}->{$function}($params['base'], $params['start'], $params['end'], $params['search'], $params['order'], $params['nopretty']);
        } else {
            $data = $this->{$model}->{$function}($params['start'], $params['end'], $params['search'], $params['order'], $params['nopretty']);
        }
        return $data;
    }

}
