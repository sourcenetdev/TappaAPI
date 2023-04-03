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
 * KyrandiaCMS Cornerstone Library - Inflection Functions
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

class CSInflection
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
     * Function ordinalRange()
     *
     * Convert a range of numbers to ordinal numbers.
     *
     * @access public
     *
     * @param $start
     * @param $end;
     *
     * @return array
     */
    public function ordinalRange($start, $end)
    {
        $list = [];
        for ($i = $start; $i <= $end; $i++) {
            $str = (string)$i;
            if ($i % 10 == 1 && substr($str, -2) != 11) {
                $list[$i] = $i . 'st';
            } elseif ($i % 10 == 2 && substr($str, -2) != 12) {
                $list[$i] = $i . 'nd';
            } elseif ($i % 10 == 3 && substr($str, -2) != 13) {
                $list[$i] = $i . 'rd';
            } else {
                $list[$i] = $i . 'th';
            }
        }
        unset($str);
        return $list;
    }
}
