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
 * KyrandiaCMS Cornerstone Library - Casting Functions
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

class CSCast
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
     * Function toBoolean
     *
     * Converts data to boolean.
     *
     * @access public
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function toBoolean($data)
    {
        return (bool)$data;
    }

    /**
     * Function toObject
     *
     * Converts data to object.
     *
     * @access public
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function toObject($data)
    {
        return (object)$data;
    }

    /**
     * Function toInteger
     *
     * Converts data to integer.
     *
     * @access public
     *
     * @param mixed $data
     * @param bool $report_lengths
     *
     * @return bool
     */
    public function toInteger($data, $report_lengths)
    {

        // Returns size of arrays - if $report_lengths is enabled.
        if (is_array($data) && $report_lengths) {
            return count($data);
        }

        // Returns size of strings - if $report_lengths is enabled.
        if (is_string($data) && !preg_match('/[0-9. ,]+/', $data) && $report_lengths) {
            return strlen($data);
        }
        return (int)$data;
    }

    /**
     * Function toString
     *
     * Converts data to string.
     *
     * @access public
     *
     * @param mixed $data
     * @param string $format
     *
     * @return bool
     */
    public function toString($data, $format = 'JSON')
    {
        if (is_object($data) and method_exists($data, 'toString')) {
            return $data->toString();
        }
        if (is_array($data)) {
            if ($format == 'JSON') {
                return $this->toJSON($data);
            }
            return serialize($data);
        }
        return (string)$data;
    }

    /**
     * Function toArray
     *
     * Converts data to array.
     *
     * @access public
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function toArray($data)
    {
        if (is_object($data) and method_exists($data, 'toArray')) {
            return $data->toArray();
        }
        return (array)$data;
    }

    /**
     * Function toJSON
     *
     * Converts data to JSON.
     *
     * @access public
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function toJSON($data)
    {
        return json_encode($data);
    }

    /**
     * Function fromJSON
     *
     * Converts data from JSON.
     *
     * @access public
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function fromJSON($data)
    {
        return json_decode($data, true);
    }

    /**
     * Function fromCSV
     *
     * Converts data from CSV.
     *
     * @access public
     *
     * @param string $data
     * @param bool $hasHeaders
     *
     * @return mixed
     */
    public function fromCSV($data, $hasHeaders = false)
    {
        $data = trim($data);

        // Explodes rows
        $data = $this->cornerstone->explodeWith($data, [PHP_EOL, "\r", "\n"]);
        $data = array_map(function ($row) {
            return $this->cornerstone->explodeWith($row, [';', "\t", ',']);
        }, $data);

        // Get headers
        $headers = $hasHeaders ? $data[0] : array_keys($data[0]);
        if ($hasHeaders) {
            array_shift($data);
        }

        // Parse the columns in each row
        $array = [];
        foreach ($data as $row => $columns) {
            foreach ($columns as $columnNumber => $column) {
                $array[$row][$headers[$columnNumber]] = $column;
            }
        }
        return $array;
    }

    /**
     * Function toCSV
     *
     * Converts data from CSV.
     *
     * @access public
     *
     * @param string $data
     * @param bool $hasHeaders
     *
     * @return mixed
     */
    public function toCSV($data, $hasHeaders = false)
    {
        $data = trim($data);

        // Explodes rows
        $data = $this->cornerstone->explodeWith($data, [PHP_EOL, "\r", "\n"]);
        $data = array_map(function ($row) {
            return $this->cornerstone->explodeWith($row, [';', "\t", ',']);
        }, $data);

        // Get headers
        $headers = $hasHeaders ? $data[0] : array_keys($data[0]);
        if ($hasHeaders) {
            array_shift($data);
        }

        // Parse the columns in each row
        $array = [];
        foreach ($data as $row => $columns) {
            foreach ($columns as $columnNumber => $column) {
                $array[$row][$headers[$columnNumber]] = $column;
            }
        }
        return $array;
    }

    /**
     * Function fromXML
     *
     * Converts data from XML.
     *
     * @access public
     *
     * @param string $xml
     *
     * @return bool
     */
    public function fromXML($xml)
    {
        $xml = simplexml_load_string($xml);
        $xml = json_encode($xml);
        $xml = json_decode($xml, true);
        return $xml;
    }
}
