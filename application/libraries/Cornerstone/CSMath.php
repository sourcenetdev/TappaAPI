<?php
/**
 * KyrandiaCMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2021, Impero Consulting (Pty) Ltd., all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 * @version   7.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Cornerstone Library - Math Functions
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

class CSMath
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
     * Function approximatelyEqual
     *
     * @param float $number1
     * @param float $number2
     * @param float $epsilon
     *
     * @access public
     *
     * @return bool
     */
    public function approximatelyEqual($number1, $number2, $epsilon = 0.001)
    {
        if (!is_numeric($number1) || !is_numeric($number2)) {
            return false;
        }

        return abs($number1 - $number2) < $epsilon;
    }

    /**
     * Function averageOfItems
     *
     * @param float $items
     *
     * @access public
     *
     * @return float || bool
     */
    public function averageOfItems(...$items)
    {
        if (count($items) === count(array_filter($items, 'is_numeric'))) {
            $count = count($items);
            return $count === 0 ? 0 : array_sum($items) / $count;
        }

        return false;
    }

    /**
     * Function clampNumber
     *
     * Clamps $num within the inclusive range specified by the boundary values $a and $b.
     * If $num falls within the range, return $num, otherwise, return the nearest number in the range, using min() and max().
     *
     * @param float $num
     * @param float $a
     * @param float $b
     *
     * @access public
     *
     * @return float
     */
    public function clampNumber($num, $a, $b)
    {
        return max(min($num, max($a, $b)), min($a, $b));
    }


    /**
     * Function addTaxToAmount
     *
     * @param float $amount
     * @param float $tax_rate
     *
     * @access public
     *
     * @return float || bool
     */
    public function addTaxToAmount($amount, $tax_rate = 0.15)
    {
        if  (!is_numeric($amount) || !is_numeric($tax_rate)) {
            return false;
        }

        return $amount * (1 + $tax_rate);
    }

    /**
     * Function addTaxToAmount
     *
     * @param float $amount
     * @param float $tax_rate
     *
     * @access public
     *
     * @return float
     */
    public function deductTaxFromAmount($amount, $tax_rate = 0.15)
    {
        if  (!is_numeric($amount) || !is_numeric($tax_rate) || $tax_rate - 1 == 0) {
            return false;
        }

        return $amount / (1 + $tax_rate);
    }
}
