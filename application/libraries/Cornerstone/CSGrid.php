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
 * KyrandiaCMS Cornerstone Library - Grid Functions
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

class CSGrid
{

    // The Code Igniter Super Object
    private $CI;

    // Global page limit for Ajax Bootstrap listings.
    private $page_limit = 15;

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
        $this->CI =& get_instance();
    }

    /**
     * bootgridClose
     *
     * Sets the closing parameters for an ajax grid
     *
     * @access public
     *
     * @param string $check
     * @param array $items
     * @param int $count
     *
     * @return array
     */
    public function bootgridClose($check, $items, $count)
    {
        $list = [
            'current' => $check['current'],
            'rowCount' => $check['rows'],
            'rows' => [],
            'total' => ($count[0]['count'] ?? 0)
        ];
        if (!empty($items)) {
            foreach ($items as $k => $v) {
                $list['rows'][$k] = $v;
            }
        }
        return json_encode($list, JSON_PRETTY_PRINT);
    }

    /**
     * Function bootgridFlags()
     *
     * Sets up the flags for listing pages.
     *
     * @access public
     *
     * @param int $start
     * @param int $page_limit
     *
     * @return array
     */
    public function bootgridFlags($start = 0, $page_limit = 0)
    {
        if ($page_limit == 0) {
            $page_limit = $this->page_limit;
        }
        $data = [
            'error' => $this->CI->session->flashdata('error'),
            'warning' => $this->CI->session->flashdata('warning'),
            'notice' => $this->CI->session->flashdata('notice'),
            'success' => $this->CI->session->flashdata('success'),
            'page_limit' => $page_limit,
            'tabledata' => [
                'actions_label' => 'core_actions_name',
                'start' => $start,
                'userdata' => '',
                'page_limit' => $page_limit
            ]
        ];
        return $data;
    }

    /**
     * Function bootgridOpen()
     *
     * Sets the initialization parameters for an ajax grid
     *
     * @access public
     *
     * @param string $separator_open
     * @param string $separator_close
     * @param int $page_limit
     *
     * @return string
     */
    public function bootgridOpen($separator_open = '`', $separator_close = '`', $page_limit = 0)
    {
        if ($page_limit == 0) {
            $page_limit = $this->page_limit;
        }
        $data['search'] = '';
        $data['order'] = '';
        $data['current'] = 1;
        $data['rows'] = $page_limit;
        $data['start'] = 0;
        $data['end'] = $data['rows'];
        if (!empty($_REQUEST['sort']) && is_array($_REQUEST['sort'])) {
            foreach ($_REQUEST['sort'] as $k => $v) {
                $data['order'] .= ' ' . $separator_open . $k . $separator_close . ' ' . $v;
            }
        }
        if (!empty($_REQUEST['searchPhrase']) && strlen($_REQUEST['searchPhrase']) > 2) {
            $data['search'] = trim($_REQUEST['searchPhrase']);
        }
        if (!empty($_REQUEST['rowCount'])) {
            $data['rows'] = (int)$_REQUEST['rowCount'];
        }
        if (!empty($_REQUEST['current'])) {
            $data['current'] = (int)$_REQUEST['current'];
            $data['start'] = (int)($data['current'] * $data['rows']) - $data['rows'];
            $data['end'] = (int)$data['rows'];
        }
        return $data;
    }
}
