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
 * KyrandiaCMS Cornerstone Library - Date Functions
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

class CSDate
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
     * Function diffDate()
     *
     * Returns the difference between two dates.
     *
     * @access public
     *
     * @param string $d1
     * @param string $d2;
     * @param string $format;
     *
     * @return string
     */
    public function diffDate($d1, $d2, $format)
    {
        $datetime1 = date_create($d1);
        $datetime2 = date_create($d2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($format);
    }
}
