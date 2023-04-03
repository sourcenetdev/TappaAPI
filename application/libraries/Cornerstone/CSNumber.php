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
 * KyrandiaCMS Cornerstone Library - Number Functions
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

class CSNumber
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
     * Function calculateTaxFromInclusive
     *
     * Calculates the amount before tax from the inclusive amount.
     *
     * @param float $inclusive_amount
     * @param float $tax_rate
     *
     * @access public
     *
     * @return float
     */
    public function calculateOriginalAmountFromInclusiveAmount($inclusive_amount, $tax_rate = 0.15)
    {
        $tax_amount = $inclusive_amount / (1 + $tax_rate);
        return $inclusive_amount - $tax_amount;
    }

    /**
     * Function calculateTaxFromExclusive
     *
     * Calculates the amount after
     *
     * @param float $exclusive_amount
     * @param float $tax_rate
     *
     * @access public
     *
     * @return float
     */
    public function calculateTaxFromExclusive($exclusive_amount, $tax_rate = 0.15)
    {
        $tax_amount = $exclusive_amount * (1 + $tax_rate);
        return $tax_amount - $exclusive_amount;
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
    public function addTaxToAmount($amount, $tax_rate = 0.15)
    {
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
        return $amount / (1 + $tax_rate);
    }
}
