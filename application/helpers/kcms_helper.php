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
 * KyrandiaCMS Common Helper
 *
 * Contains a list of common functions used in the system.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

/**
 * _get_ip
 *
 * Gets the caller's IP address
 *
 * @return string
 */
if (!function_exists('_get_ip')) {
    function _get_ip() {
        $ci =& get_instance();
        return $ci->cornerstone->kUtils->getIPAddress();
    }
}

/**
 * Function _clean_string
 *
 * Cleans a string from XSS vulnerabilities, and additionally running other PHP single parameter functions on it.
 *
 * @access public
 *
 * @param string $variable
 * @param bool $trim
 * @param string $extra
 *
 * @return array
 */
if (!function_exists('_clean_string')) {
    function _clean_string($variable, $trim = false, $extra = '')
    {
        $ci =& get_instance();
        return $ci->cornerstone->kSecurity->cleanString($variable, $trim, $extra);
    }
}

/**
 * Function clean_array()
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
if (!function_exists('_clean_array')) {
    function _clean_array($variable, $trim = false, $extra = '')
    {
        $ci =& get_instance();
        return $ci->cornerstone->kSecurity->cleanArray($variable, $trim, $extra);
    }
}

/**
 * Function _grid_close
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
if (!function_exists('_grid_close')) {
    function _grid_close($check, $items, $count)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kGrid->bootgridClose($check, $items, $count);
    }
}

/**
 * Function _grid_flags()
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
if (!function_exists('_grid_flags')) {
    function _grid_flags($start = 0, $page_limit = 0)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kGrid->bootgridFlags($start, $page_limit);
    }
}

/**
 * Function _grid_open()
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
if (!function_exists('_grid_open')) {
    function _grid_open($separator_open = '`', $separator_close = '`', $page_limit = 0)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kGrid->bootgridOpen($separator_open, $separator_close, $page_limit);
    }
}

/**
 * choose
 *
 * Choose between various options whether they are set, in order POST, set_value, and raw data.
 *
 * @access public
 *
 * @param string $post
 * @param string $value
 * @param string $item
 *
 * @return string
 */
if (!function_exists('_choose')) {
    function _choose($post, $value, $item)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kInput->chooseFromInput($post, $value, $item);
    }
}

/**
 * Function _out()
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
if (!function_exists('_out')) {
    function _out($data, $json = 'echo')
    {
        $ci =& get_instance();
        return $ci->cornerstone->kOutput->returnOutput($data, $json);
    }
}

/**
 * Function _prep()
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
if (!function_exists('_prep')) {
    function _prep($query, $variables)
    {
        $ci =& get_instance();
        $ci->cornerstone->kOutput->prepareOutput($query, $variables);
    }
}

/**
 * Function _highlight()
 *
 * A function to create a highlighted piece of text in searches, preserving case.
 *
 * @access public
 *
 * @param string $needle
 * @param string $haystack
 * @param string $color
 *
 * @return string The haystack with the needle highligthed, with preserved case.
 */
if (!function_exists('_highlight')) {
    function _highlight($needle, $haystack, $color = 'yellow')
    {
        $ci =& get_instance();
        return $ci->cornerstone->kOutput->highlightInString($needle, $haystack, $color);
    }
}

/**
 * Function _preint()
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
if (!function_exists('_preint')) {
    function _preint($data, $minimal = false, $silent = false, $class = '', $style = '')
    {
        $ci =& get_instance();
        $ci->cornerstone->kOutput->verboseOutput($data, $minimal, $silent, $class, $style);
    }
}

/**
 * Function preint()
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
if (!function_exists('preint')) {
    function preint($data, $minimal = false, $silent = false, $class = '', $style = '')
    {
        $ci =& get_instance();
        $ci->cornerstone->kOutput->verboseOutput($data, $minimal, $silent, $class, $style);
    }
}

/**
 * Function _has_ssl
 *
 * Determine if SSL is used.
 *
 * @return bool
 */
if (!function_exists('_has_ssl')) {
    function _has_ssl() {
        $ci =& get_instance();
        return $ci->cornerstone->kUtils->requestIsOverSSL();
    }
}

/**
 * Function _random_str()
 *
 * Generates a random string
 *
 * @access public
 *
 * @param string $length
 *
 * @return string
 */
if (!function_exists('_random_str')) {
    function _random_str($length = 32)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kString->randomString($length);
    }
}

/**
 * Function _ord()
 *
 * Convert numbers to ordinal numbers.
 *
 * @access public
 *
 * @param $start
 * @param $end;
 *
 * @return array
 */
if (!function_exists('_ord')) {
    function _ord($start, $end)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kInflection->ordinalRange($start, $end);
    }
}

/**
 * Function _mask()
 *
 * Puts a mask on a field in the event of it containing sensitive data.
 *
 * @access public
 *
 * @param int $len
 * @param string $char
 * @param string $string
 *
 * @return string
 */
if (!function_exists('_mask')) {
    function _mask($len = 8, $char = '*', $string = '')
    {
        if (!empty($string)) {
            $ci =& get_instance();
            return $ci->cornerstone->kString->maskString($len, $char, $string);
        }
        return '';
    }
}

/**
 * Function _strtrim()
 *
 * Removes $strip from the end of a string.
 *
 * @access public
 *
 * @param string $message
 * @param string $strip
 *
 * @return string The string without the $strip part from the end.
 */
if (!function_exists('_strtrim')) {
    function _strtrim($message, $strip) {
        $ci =& get_instance();
        return $ci->cornerstone->kString->rtrimString($message, $strip);
    }
}

/**
 * Function _shorten()
 *
 * A function to truncate a string based on various options
 *
 * @access public
 *
 * @param string $string
 * @param int $limit
 * @param bool $chars
 * @param string $ellipsis
 * @param int $start
 *
 * @return string reformatted string according to options specified
 */
if (!function_exists('_shorten')) {
    function _shorten($string, $limit = 60, $chars = false, $ellipsis = '...', $start = 0)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kString->shortenString($string, $limit, $chars, $ellipsis, $start);
    }
}

/**
 * Function _chars()
 *
 * A wrapper for _shorten() function tailored to characters, with sensible defaults.
 *
 * @access public
 *
 * @param string $string
 * @param int $length
 * @param string $ellipsis
 * @param int $start
 *
 * @return string The shortened string
 */
if (!function_exists('_chars')) {
    function _chars($string, $length = 60, $ellipsis = '...', $start = 0): string
    {
        $ci =& get_instance();
        return $ci->cornerstone->kString->shortenString($string, $length, true, $ellipsis, $start);
    }
}

/**
 * Function _words()
 *
 * A wrapper for _shorten() function tailored to words, with sensible defaults.
 *
 * @access public
 *
 * @param string $string
 * @param int $length
 * @param string $ellipsis
 * @param int $start
 *
 * @return string The shortened string
 */
if (!function_exists('_words')) {
    function _words($string, $length = 60, $ellipsis = '...', $start = 0): string
    {
        $ci =& get_instance();
        return $ci->cornerstone->kString->shortenString($string, $length, false, $ellipsis, $start);
    }
}

/**
 * Function _append_if()
 *
 * Returns conditional text that can be appended to a string.
 *
 * @access public
 *
 * @param string $condition
 * @param string $text
 *
 * @return string
 */
if (!function_exists('_append_if')) {
    function _append_if($condition, $value)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kString->appendString($condition, $value);
    }
}

/**
 * Function _explode_with()
 *
 * Tries to explode a string with an array of delimiters.
 *
 * @access public
 *
 * @param string $string
 * @param array $delimiters
 *
 * @return array
 */
if (!function_exists('_explode_with')) {
    function _explode_with($string, $delimiters)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kArray->explodeWith($string, $delimiters);
    }
}

/**
 * Function _array_diff()
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
if (!function_exists('_array_diff')) {
    function _array_diff($array1, $array2)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kArray->arrayDifference($array1, $array2);
    }
}

/**
 * Function _compare_array_recursive()
 *
 * Compares whether two multi dimensioonal arrays are identical.
 *
 * @access public
 *
 * @param array $a1
 * @param array $a2
 *
 * @return bool
 */
if (!function_exists('_compare_array_recursive')) {
    function _comprare_array_recursive($condition, $value)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kArray->compareArrayRecursive($condition, $value);
    }
}

/**
 * Function _array_intersect()
 *
 * Determines the intersection of two arrays.
 *
 * @access public
 *
 * @param array $original_data
 * @param array $modified_keys
 *
 * @return array
 */
if (!function_exists('_array_intersect')) {
    function _array_intersect($original_data, $with_data)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kArray->intersectArray($original_data, $with_data);
    }
}

/**
 * Function _datediff()
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
if (!function_exists('_datediff')) {
    function _datediff($d1, $d2, $format = '%a'): string
    {
        $ci =& get_instance();
        return $ci->cornerstone->kDate->diffDate($d1, $d2, $format);
    }
}

/**
 * Function _sess_get()
 *
 * This function returns the value of a session variable. Wrapper for $this->session->userdata().
 *
 * @access public
 *
 * @param string $var
 *
 * @return string
 */
if (!function_exists('_sess_get')) {
    function _sess_get($variable = '')
    {
        $ci =& get_instance();
        return $ci->cornerstone->kSession->getSession($variable);
    }
}

/**
 * Function _sess_set()
 *
 * Sets a session variable. Wrapper for $this->session->userdata().
 *
 * @access public
 *
 * @param string $var
 * @param mixed $val
 *
 * @return string
 */
if (!function_exists('_sess_set')) {
    function _sess_set($variable, $value)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kSession->setSession($variable, $value);
    }
}

/**
 * Function _sess_unset()
 *
 * Unsets a session variable. Wrapper for $this->session->userdata().
 *
 * @access public
 *
 * @param string $var
 *
 * @return string
 */
if (!function_exists('_sess_unset')) {
    function _sess_unset($variable)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kSession->unsetSession($variable);
    }
}

/**
 * Function _add_tax
 *
 * @param float $amount
 * @param float $tax_rate
 *
 * @access public
 *
 * @return float
 */
if (!function_exists('_add_tax')) {
    function _add_tax($amount, $tax_rate)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kMath->addTaxToAmount($amount, $tax_rate);
    }
}

/**
 * Function _deduct_tax
 *
 * @param float $amount
 * @param float $tax_rate
 *
 * @access public
 *
 * @return float
 */
if (!function_exists('_deduct_tax')) {
    function _deduct_tax($amount, $tax_rate)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kMath->deductTaxFromAmount($amount, $tax_rate);
    }
}

/**
 * Function _clamp_number
 *
 * @param float $num
 * @param float $a
 * @param float $b
 *
 * @access public
 *
 * @return int
 */
if (!function_exists('_clamp_number')) {
    function _clamp_number($num, $a, $b)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kMath->clampNumber($num, $a, $b);
    }
}

/**
 * Function _average_of_items
 *
 * @param float $items
 *
 * @access public
 *
 * @return int
 */
if (!function_exists('_average_of_items')) {
    function _average_of_items(...$items)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kMath->averageOfItems($items);
    }
}

/**
 * Function _approximately_equal
 *
 * @param float $items
 *
 * @access public
 *
 * @return int
 */
if (!function_exists('_approximately_equal')) {
    function _approximately_equal($number1, $number2, $epsilon = 0.001)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kMath->approximatelyEqual($number1, $number2, $epsilon);
    }
}

/**
 * Function _hash()
 *
 * Hashes a string
 *
 * @access public
 *
 * @param string $input
 * @param string $salt;
 *
 * @return string
 */
if (!function_exists('_hash')) {
    function _hash($input, $salt)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kBCrypt->hash($input, $salt);
    }
}

/**
 * Function verify()
 *
 * Verify a hashed string
 *
 * @access public
 *
 * @param string $input
 * @param string $existingHash;
 *
 * @return bool
 */
if (!function_exists('_verify')) {
    function _verify($input, $existingHash)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kBCrypt->verify($input, $existingHash);
    }
}

/**
 * Function _get_salt()
 *
 * Returns the generated salt
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('_get_salt')) {
    function _get_salt()
    {
        $ci =& get_instance();
        return $ci->cornerstone->kBCrypt->returnSalt();
    }
}

/**
 * Function _get_template_dtaa()
 *
 * Returns the template data
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('_get_template_data')) {
    function _get_template_data()
    {
        $ci =& get_instance();
        return $ci->cornerstone->kTemplate->getTemplateData();
    }
}

/**
 * Function _set_template_data()
 *
 * Sets the template data
 *
 * @access public
 *
 * @param string $name
 * @param string $value
 * @param string $sub
 *
 * @return string
 */
if (!function_exists('_set_template_data')) {
    function _set_template_data($name, $value, $sub = '')
    {
        $ci =& get_instance();
        $ci->cornerstone->kTemplate->setTemplateData($name, $value, $sub);
    }
}

/**
 * Function _load_template()
 *
 * Sets the template data
 *
 * @access public
 *
 * @param string $template
 * @param string $view
 * @param array $view_data
 * @param bool $return
 *
 * @return string
 */
if (!function_exists('_load_template')) {
    function _load_template($template, $view, $view_data = [], $return = false)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kTemplate->loadTemplate($template, $view, $view_data, $return);
    }
}

/**
 * Function _set_provider_facebook()
 *
 * Sets the Facebook provider
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('_set_provider_facebook')) {
    function _set_provider_facebook()
    {
        $ci =& get_instance();
        return $ci->cornerstone->kOAth2->setProviderFacebook();
    }
}

/**
 * Function _set_provider_tribalwars()
 *
 * Sets the Tribalwars provider
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('_set_provider_tribalwars')) {
    function _set_provider_tribalwars()
    {
        $ci =& get_instance();
        return $ci->cornerstone->kOAth2->setProviderTribalwars();
    }
}

/**
 * Function _get_provider_facebook_data()
 *
 * Gets the Facebook provider data
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('_get_provider_facebook_data')) {
    function _get_provider_facebook_data()
    {
        $ci =& get_instance();
        return $ci->cornerstone->kOAth2->getProviderFacebookData();
    }
}

/**
 * Function _set_provider_tribalwars_data()
 *
 * Gets the Tribalwars provider
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('_get_provider_tribalwars_data')) {
    function _get_provider_tribalwars_data()
    {
        $ci =& get_instance();
        return $ci->cornerstone->kOAth2->getProviderTribalwarsData();
    }
}

/**
 * Function _set_db_order()
 *
 * Sets the ORDER BY clause
 *
 * @access public
 *
 * @param string $order
 *
 * @return void
 */
if (!function_exists('_set_db_order')) {
    function _set_db_order($order)
    {
        $ci =& get_instance();
        $ci->cornerstone->kDatabase->setDBOrder($order);
    }
}

/**
 * Function _set_db_where()
 *
 * Sets a WHERE clause
 *
 * @access public
 *
 * @param bool $condition
 * @param array $fields
 *
 * @return void
 */
if (!function_exists('_set_db_where')) {
    function _set_db_where($condition, $fields)
    {
        $ci =& get_instance();
        $ci->cornerstone->kDatabase->setDBWhere($condition, $fields);
    }
}

/**
 * Function _set_db_or_like()
 *
 * Sets the OR_LIKE group
 *
 * @access public
 *
 * @param string $search
 * @param array $fields
 * @param string $match
 *
 * @return void
 */
if (!function_exists('_set_db_or_like')) {
    function _set_db_or_like($search, $fields, $match = 'both')
    {
        $ci =& get_instance();
        $ci->cornerstone->kDatabase->setDBOrLike($search, $fields, $match);
    }
}

/**
 * Function _update_db_field()
 *
 * Updates a field value in a table.
 * TODO: Make more portable.
 *
 * @access public
 *
 * @param array $data
 * @param string $theme
 *
 * @return void
 */
if (!function_exists('_update_db_field')) {
    function _update_db_field($data, $theme = 'admin')
    {
        $ci =& get_instance();
        $ci->cornerstone->kDatabase->updateDBField($data, $theme);
   }
}

/**
 * Function _delete()
 *
 * Deletes an item from the database, optionally, based on data passed, renders a view.
 * TODO: Make more portable.
 *
 * @access public
 *
 * @param array $data
 * @param string $theme
 *
 * @return string
 */
if (!function_exists('_delete')) {
    function _delete($data, $theme = 'admin')
    {
        $ci =& get_instance();
        $ci->cornerstone->kDatabase->deleteFromDB($data, $theme);
    }
}

/**
 * Function _explode()
 *
 * Tries to explode a string with an array of delimiters.
 *
 * @access public
 *
 * @param string $string
 * @param array $delimiters
 *
 * @return array
 */
if (!function_exists('_explode')) {
    function _explode($data, $delimiters)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kArray->explodeWith($data, $delimiters);
    }
}

/**
 * Function _from_XML()
 *
 * Converts data from XML.
 *
 * @access public
 *
 * @param string $xml
 *
 * @return array
 */
if (!function_exists('_from_XML')) {
    function _from_XML($xml)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kCast->fromXML($xml);
    }
}

/**
 * Function _to_CSV()
 *
 * Converts data to CSV.
 *
 * @access public
 *
 * @param string $data
 * @param bool $hasHeaders
 *
 * @return array
 */
if (!function_exists('_to_CSV')) {
    function _to_CSV($data, $hasHeaders)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kCast->toCSV($data, $hasHeaders);
    }
}

/**
 * Function _from_CSV()
 *
 * Converts data from CSV.
 *
 * @access public
 *
 * @param string $data
 * @param bool $hasHeaders
 *
 * @return array
 */
if (!function_exists('_from_CSV')) {
    function _from_CSV($data, $hasHeaders)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kCast->fromCSV($data, $hasHeaders);
    }
}

/**
 * Function _from_JSON()
 *
 * Converts data from JSON.
 *
 * @access public
 *
 * @param string $data
 *
 * @return array
 */
if (!function_exists('_from_JSON')) {
    function _from_JSON($data)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kCast->fromJSON($data);
    }
}

/**
 * Function _to_JSON()
 *
 * Converts data to JSON.
 *
 * @access public
 *
 * @param string $data
 *
 * @return array
 */
if (!function_exists('_to_JSON')) {
    function _to_JSON($data)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kCast->toJSON($data);
    }
}

/**
 * Function _to_array()
 *
 * Converts data to array.
 *
 * @access public
 *
 * @param string $data
 *
 * @return array
 */
if (!function_exists('_to_array')) {
    function _to_array($data)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kCast->toArray($data);
    }
}

/**
 * Function _to_string()
 *
 * Converts data to string.
 *
 * @access public
 *
 * @param string $data
 * @param string $format
 *
 * @return array
 */
if (!function_exists('_to_string')) {
    function _to_string($data, $format = 'JSON')
    {
        $ci =& get_instance();
        return $ci->cornerstone->kCast->toString($data, $format);
    }
}

/**
 * Function _to_integer()
 *
 * Converts data to integer.
 *
 * @access public
 *
 * @param string $data
 * @param bool $report_lengths
 *
 * @return array
 */
if (!function_exists('_to_integer')) {
    function _to_integer($data, $report_lengths = false)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kCast->toInteger($data, $report_lengths);
    }
}

/**
 * Function _to_object
 *
 * Converts data to object.
 *
 * @access public
 *
 * @param mixed $data
 *
 * @return bool
 */
if (!function_exists('_to_object')) {
    function _to_object($data)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kCast->toObject($data);
    }
}

/**
 * Function _to_boolean
 *
 * Converts data to boolean.
 *
 * @access public
 *
 * @param mixed $data
 *
 * @return bool
 */
if (!function_exists('_to_boolean')) {
    function _to_boolean($data)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kCast->toBoolean($data);
    }
}

/**
 * Function _array_to_csv()
 *
 * Formats an array into CSV format
 *
 * @access public
 *
 * @param array $array
 * @param string $download
 * @param bool $compress
 *
 * @return string The CSV string or downloaded file.
 */
if (!function_exists('_array_to_csv')) {
    function _array_to_csv($array, $download = "", $compress = false)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kFile->arrayToCSV($array, $download, $compress);
    }
}

/**
 * Function _query_to_csv()
 *
 * Formats a CodeIgniter query into an array and then into CSV format
 *
 * @access public
 *
 * @param object $query
 * @param bool $headers
 * @param string $download
 * @param bool $compress
 *
 * @return string The CSV string or downloaded file.
 */
if (!function_exists('_query_to_csv')) {
    function _query_to_csv($query, $headers = TRUE, $download = "", $compress = false)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kFile->queryToCSV($query, $headers, $download, $compress);
    }
}

/**
 * _redir
 *
 * This function redirects to another URL with a status message.
 *
 * @access public
 *
 * @param string $type
 * @param string $message
 * @param string $destination
 *
 * @return void
 */
if (!function_exists('_redir')) {
    function _redir($type, $message, $destination = '')
    {
        $ci =& get_instance();
        $ci->cornerstone->kUtils->redir($type, $message, $destination);
    }
}

/**
 * _render
 *
 * This function allows you to display module output on the screen.
 *
 * @access public
 *
 * @param string $template
 * @param string $view
 * @param array $data
 * @param string $method
 *
 * @return string
 */
if (!function_exists('_render')) {
    function _render($template, $view, $data = [], $method = '', $admin = false)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kUtils->render($template, $view, $data, $method, $admin);
    }
}

/**
 * Function _get()
 *
 * Returns a get varable.
 *
 * @access public
 *
 * @param string $variable
 *
 * @return void
 */
if (!function_exists('_get')) {
    function _get($variable = '')
    {
        $ci =& get_instance();
        return $ci->cornerstone->kInput->get($variable);
    }
}

/**
 * Function _post()
 *
 * Returns a post varable.
 *
 * @access public
 *
 * @param string $variable
 *
 * @return void
 */
if (!function_exists('_post')) {
    function _post($variable = '')
    {
        $ci =& get_instance();
        return $ci->cornerstone->kInput->post($variable);
    }
}

/**
 * Function _cfg()
 *
 * Retrieves a config variable from CI configuration.
 *
 * @access public
 *
 * @param string $variable
 *
 * @return string
 */
if (!function_exists('_cfg')) {
    function _cfg($variable)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kUtils->config($variable);
    }
}

/**
 * Function _field_value_exists()
 *
 * Checks if a field with a value exists in the database, and returns true or false.
 *
 * @access public
 *
 * @param string $value
 * @param array $criteria
 *
 * @return string
 */
if (!function_exists('_field_value_exists')) {
    function _field_value_exists($value, $criteria)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kDatabase->fieldValueExists($value, $criteria);
    }
}

/**
 * Function _field_value()
 *
 * Checks if a field with a value exists in the database, and returns it.
 *
 * @access public
 *
 * @param string $value
 * @param array $criteria
 *
 * @return string
 */
if (!function_exists('_field_value')) {
    function _field_value($value, $criteria)
    {
        $ci =& get_instance();
        return $ci->cornerstone->kDatabase->fieldValue($value, $criteria);
    }
}

/**
 * Function _wordify()
 *
 * Turns a slug into a word or phrase.
 *
 * @access public
 *
 * @param string $slug
 * @param string $caps
 *
 * @return string
 */
if (!function_exists('_wordify')) {
    function _wordify($slug, $caps = 'sentence')
    {
        $ci =& get_instance();
        return $ci->cornerstone->kString->wordify($slug, $caps);
    }
}

/**
 * Function _slugify()
 *
 * Turns a word or phrase to a slug.
 *
 * @access public
 *
 * @param string $title
 * @param bool $check_unique;
 * @param array $check_criteria;
 *
 * @return string
 */
if (!function_exists('_slugify')) {
    function _slugify($title, $check_unique = true, $check_criteria = [])
    {
        $ci =& get_instance();
        return $ci->cornerstone->kString->slugify($title, $check_unique, $check_criteria);
    }
}
