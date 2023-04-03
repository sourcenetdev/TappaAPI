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
 * KyrandiaCMS Cornerstone Library - Security Functions
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

class CSSecurity
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
	 * Function cleanString()
	 *
	 * Cleans a string, optionally trim it, and run additional functions that only takes the string as parameter.
     *
	 * @access public
     *
	 * @param string $var
     * @param bool $trim
     * @param string $extra
     *
	 * @return mixed
	 */
    public function cleanString($var, $trim = false, $extra = '')
    {

        // Clean it
        $out = xss_clean($var);

        // We do not want to perform a trim on empty/null/boolean values.
        if (!empty($trim) && !is_null($out) && !is_bool($out) && !empty($out)) {
            $out = trim($out);
        }

        // Process it further, if provided, with single-parameter functions.
        $functions = explode('|', $extra);
        if (is_array($functions) && !empty($functions)) {
            foreach ($functions as $function) {
                if (!empty($function) && function_exists($function)) {
                    $out = $function($out);
                }
            }
        } else {
            if (function_exists($extra)) {
                $out = $extra($out);
            }
        }
        return $out;
    }

	/**
	 * Function cleanArray()
	 *
	 * Cleans an array of strings, optionally trim them, and run additional functions that only takes the string as parameter.
     *
	 * @access public
     *
	 * @param string $var
     * @param bool $trim
     * @param string $extra
     *
	 * @return mixed
	 */
    public function cleanArray($variable, $trim = false, $extra = '')
    {
        if (is_array($variable) && !empty($variable)) {
            foreach ($variable as $var) {
                $this->cleanArray($var, $trim, $extra);
            }
        }
        return $this->cleanString($variable, $trim, $extra);
    }
}
