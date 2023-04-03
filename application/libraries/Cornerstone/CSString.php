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
 * KyrandiaCMS Cornerstone Library - String Functions
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

class CSString
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
     * Function highlightInString()
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
    public function highlightInString($needle, $haystack, $color)
    {
        $found = stripos($haystack, $needle);
        $len = strlen($needle);
        if ($found !== false) {
            return
                substr($haystack, 0, $found) .
                '<strong style="background-color: ' . $color . '">' . substr($haystack, $found, $len) . '</strong>' .
                $this->highlightInString($needle, substr($haystack, $found + $len), $color);
        } else {
            return $haystack;
        }
    }

    /**
     * Function maskString()
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
    public function maskString($len, $char, $string)
    {
        $return = '';
        if (!is_numeric($len)) {
            $len = floor(strlen($string) / 2);
        }
        if ($len >= strlen($string)) {
            $return = str_pad($return, strlen($string), $char, STR_PAD_LEFT);
        } elseif ($len == 0) {
            $return = $string;
        } else {
            $return = substr($string, ($len * -1));
            $return = str_pad($return, strlen($string), $char, STR_PAD_LEFT);
        }
        return $return;
    }

    /**
     * Function randomString()
     *
     * Generates a random string
     *
     * @access public
     *
     * @param string $length
     *
     * @return string
     */
    public function randomString($length)
    {
        $pool = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    /**
     * Function rtrimString()
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
    public function rtrimString($message, $strip)
    {
        $lines = explode($strip, $message);
        $last = '';
        do {
            $last = array_pop($lines);
        } while (empty($last) && (count($lines)));
        return implode($strip, array_merge($lines, array($last)));
    }

    /**
     * Function shortenString()
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
    public function shortenString($string, $limit, $chars, $ellipsis, $start)
    {
        if (strlen($string) < $limit) {
            return $string;
        }

        // Breaks string by words defined by $limit, or characters defined by $limit.
        $temp = explode(" ", $string);
        $checkbreak = "";
        if ($chars === false) {
            foreach ($temp as $t) {
                if ((strlen($checkbreak) + strlen($t)) < $limit) {
                    $checkbreak .= $t . " ";
                }
            }
            $checkbreak = trim($checkbreak);
            if (strlen($checkbreak) < strlen($string)) {
                if ($ellipsis !== null) {
                    $checkbreak .= $ellipsis;
                }
            }
        } else {
            $checkbreak = substr($string, $start, $limit);
            if ($ellipsis !== null) {
                $checkbreak .= $ellipsis;
            }
        }
        return $checkbreak;
    }

    /**
     * Function shortenStringToCharacters()
     *
     * A wrapper for shortenString() function tailored to characters, with sensible defaults.
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
    public function shortenStringToCharacters($string, $length = 60, $ellipsis = '...', $start = 0)
    {
        return $this->shortenString($string, $length, true, $ellipsis, $start);
    }

    /**
     * Function shortenStringToWords()
     *
     * A wrapper for shortenString() function tailored to characters, with sensible defaults.
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
    public function shortenStringToWords($string, $length = 60, $ellipsis = '...', $start = 0)
    {
        return $this->shortenString($string, $length, false, $ellipsis, $start);
    }

    /**
     * Function appendString()
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
    public function appendString($condition, $value)
    {
        if ($condition) {
            return $value;
        }
        return '';
    }

    /**
     * Function wordify()
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
    public function wordify($slug, $caps = 'sentence')
    {
        if ($caps == 'sentence') {
            $return = ucfirst(str_replace('_', ' ', $slug));
        } elseif ($caps == 'word') {
            $return = ucwords(str_replace('_', ' ', $slug));
        } elseif ($caps == 'upper') {
            $return = strtoupper(str_replace('_', ' ', $slug));
        } elseif ($caps == 'lower') {
            $return = strtolower(str_replace('_', ' ', $slug));
        } else {
            $return = str_replace(' ', '_', $slug);
        }
        return $return;
    }

    /**
     * Function slugify()
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
    public function slugify($title, $check_unique = true, $check_criteria = [])
    {
        $ci =& get_instance();
        if ($check_unique && !empty($check_criteria['table']) && !empty($check_criteria['field'])) {
            $slug = $this->slugify($title, false);
            $exists = _field_value($slug, $check_criteria);
            if (!empty($exists)) {
                $exp = explode('_', $slug);
                $cnt = count($exp);
                if (empty($exp[$cnt - 1]) || !is_numeric($exp[$cnt - 1])) {
                    $postfix = '_1';
                } else {
                    $postfix = '_' . ($exp[$cnt - 1] + 1);
                    unset($exp[$cnt - 1]);
                }
                $slug = $this->slugify(implode('_', $exp) . $postfix, true, $check_criteria);
            } else {
                $slug = strtolower(str_replace(' ', '_', $title));
            }
        } else {
            $slug = strtolower(str_replace(' ', '_', $title));
        }
        return $slug;
    }

}
