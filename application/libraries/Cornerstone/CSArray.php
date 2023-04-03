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
 * KyrandiaCMS Cornerstone Library - Array Functions
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

class CSArray
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
     * Function arrayDifference()
     *
     * Determines the difference between two arrays.
     *
     * @access public
     *
     * @param array $array1
     * @param array $array2
     *
     * @return bool
     */
    public function arrayDifference($array1, $array2)
    {
        $difference = [];
        foreach($array1 as $key => $value) {
            if (is_array($value)) {
                if (!isset($array2[$key]) || !is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = $this->arrayDifference($value, $array2[$key]);
                    if (!empty($new_diff)) {
                        $difference[$key] = $new_diff;
                    }
                }
            } elseif (!array_key_exists($key,$array2) || $array2[$key] !== $value) {
                $difference[$key] = $value;
            }
        }

        return $difference;
    }

    /**
     * Function compareArrayRecursive()
     *
     * Compares whether two multi dimensional arrays are identical.
     *
     * @access public
     *
     * @param array $a1
     * @param array $a2
     *
     * @return bool
     */
    public function compareArrayRecursive($a1, $a2)
    {
        if (is_array($a1) && !is_array($a2)) {
            return false;
        }
        if (!is_array($a1) && is_array($a2)) {
            return false;
        }
        if (!count($a1) == count($a2)) {
            return false;
        }
        foreach ($a1 as $key => $val) {
            if (!array_key_exists($key, $a2)) {
                return false;
            } elseif (is_array($val) && is_array($a2[$key])) {
                if (!$this->compareArrayRecursive($val, $a2[$key])) {
                    return false;
                }
            } elseif (!($val === $a2[$key])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Function intersectArray()
     *
     * Determines the intersection of two arrays.
     *
     * @access public
     *
     * @param array $original_data
     * @param array $with_data
     *
     * @return array
     */
    public function intersectArray($original_data, $with_data)
    {
        $with_keys = array_keys($with_data);
        $intersect_data = array_filter(
            $original_data, function ($key) use ($with_keys) {
                return in_array($key, $with_keys);
            },
            ARRAY_FILTER_USE_KEY
        );
        return $intersect_data;
    }

    /**
     * Function explodeWith
     *
     * Tries to explode a string with an array of delimiters.
     *
     * TODO: DOES THIS EVEN WORK?
     *
     * @access public
     *
     * @param string $string
     * @param array $delimiters
     *
     * @return array
     */
    public function explodeWith($string, $delimiters)
    {
        $array = $string;
        foreach ($delimiters as $delimiter) {
            $array = explode($delimiter, $string);
            if (count($array) === 1) {
                continue;
            } else {
                return $array;
            }
        }
        return $array;
    }

    /**
     * Function allMatch
     *
     * Returns true if the provided function returns true for all elements of an array, false otherwise.
     *
     * @access public
     *
     * @param array $items
     * @param string $func
     *
     * @return array
     */
    public function allMatch($items, $func)
    {
        return count(array_filter($items, $func)) === count($items);
    }

    /**
     * Function allMatch
     *
     * Returns true if the provided function returns true for at least one of the elements of an array, false otherwise.
     *
     * @access public
     *
     * @param array $items
     * @param string $func
     *
     * @return array
     */
    public function anyMatch($items, $func)
    {
        return count(array_filter($items, $func)) > 0;
    }

}
