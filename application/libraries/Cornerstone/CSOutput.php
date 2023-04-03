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
 * KyrandiaCMS Cornerstone Library - Output Functions
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

class CSOutput
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
     * Function returnOutput()
     *
     * Returns the data in either raw format, or json encoded, or empty string if empty.
     *
     * @access public
     *
     * @param mixed $data
     * @param string $json
     *
     * @return mixed
     */
    public function returnOutput($data, $json = 'echo')
    {
        if (!empty($data)) {
            if ($json == 'echo') {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } elseif ($json == 'return') {
                return json_encode($data, JSON_PRETTY_PRINT);
            } else {
                return $data;
            }
        }
        return '';
    }

    /**
     * Function prepareOutput()
     *
     * A function to prepare a database query for inserting into the log by replacing placeholders with their actual values.
     *
     * @access public
     *
     * @param string $query
     * @param array $variables
     *
     * @return string The query with replaced variables for insert into log table or debug use.
     */
    public function prepareOutput($query, $variables): string
    {
        foreach ($variables as $k => $v) {
            $query = preg_replace('/\?/', "'" . $variables[$k] . "'", $query, 1);
        }
        return $query;
    }

    /**
     * Function verboseOutput()
     *
     * Formats a string to a specific class, preserving white space. Useful for printing out arrays.
     *
     * @access public
     *
     * @param string $data
     * @param bool $minimal
     * @param bool $silent
     * @param string $class
     * @param string $style
     *
     * @return void
     *
     */
    public function verboseOutput($data, $minimal = false, $silent = false, $class = '', $style = '')
    {
        $o = '';
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }

        if (!$minimal) {
            $o = "<div" . $class . $style . ">";
        }

        // Makes output silent (in <!-- --> tags)
        if ($silent) {
            $o .= "<!--";
        }

        if (!$minimal) {
            $o .= '<pre style="color: #333333; background-color: #fafafa; border: 1px solid #dddddd; border-radius: 0 12px; padding: 12px">';
        } else {
            $o .= '<pre>';
        }

        // Does the data check.
        if (isset($data)) {
            if (!$minimal) {
                if (is_array($data)) {
                    $o .= print_r($data, true);
                } elseif (is_numeric($data)) {
                    $o .= 'Numeric: ' . $data;
                } elseif (is_string($data)) {
                    $o .= 'String: "' . $data . '"';
                } elseif (is_bool($data)) {
                    if ($data) {
                        $o .= 'Boolean: true';
                    } else {
                        $o .= 'Boolean: false';
                    }
                } elseif (is_null($data)) {
                    $o .= 'Null: ' . $data;
                } elseif (is_object($data)) {
                    $o .= print_r($data, true);
                } else {
                    $o .= 'Undefined type (' . $$data . '):<br>';
                    $o .= print_r($data, true);
                }
            } else {
                $o .= print_r($data, true);
            }
        }

        $o .= "</pre>";

        // Makes output silent (in <!-- --> tags)
        if ($silent) {
            $o .= "-->";
        }

        // Finalize and do output.
        if (!$minimal) {
            $o .= '</div>';
        }
        print $o;
    }
}
