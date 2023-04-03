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
require_once(APPPATH . 'helpers/replace_helper.php');

/**
 * KyrandiaCMS Display Override Hook
 *
 * This is the display override hook file for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Hooks
 * @category    Hooks
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

    /**
     * function replace_debug()
     *
     * Function to debug information if needed along with actual replacement.
     *
     * @access  public
     *
     * @param string $data
     * @param string $value
     * @param string $replace
     *
     * @return string
     */
    if (!function_exists('replace_debug')) {
        function replace_debug(&$data, $value, $replace)
        {
            if (config_item('debug')) {
                $data = str_replace($value, $replace, $data);
            } else {
                $data = str_replace($value, '', $data);
            }
            return $data;
        }
    }

    /**
     * function arbitrary_replacements()
     *
     * Function to do a placeholder replace on arbitrary placeholder (used in views or final output).
     *
     * TODO: Make these strings database driven.
     *
     * @access public
     *
     * @param bool $echo
     * @param bool $profiler
     *
     * @return string
     */
    if (!function_exists('arbitrary_replacements')) {
        function arbitrary_replacements($string, $echo = true)
        {
            $ci =& get_instance();
            $string = str_replace('__BASE__', base_url(), $string);
            $string = str_replace('__APP__', APPPATH, $string);
            $string = str_replace('__TWITTER__', config_item('twitter_handle'), $string);
            $string = str_replace('__FBAPPID__', config_item('fb_app_id'), $string);
            $string = str_replace('__FBAPPSECRET__', config_item('fb_app_secret'), $string);
            $string = str_replace('__SITEDESCRIPTION__', config_item('site_description'), $string);
            $string = str_replace('__SITEAUTHOR__', config_item('site_author'), $string);
            $string = str_replace('__SITENAME__', config_item('sitename'), $string);
            $string = str_replace('__URI__', uri_string(), $string);
            $string = str_replace('__CURRYEAR__', date('Y'), $string);
            if ($echo) {
                echo $string;
            } else {
                return $string;
            }
        }
    }

    /**
     * function do_replace()
     *
     * Function to do a placeholder replace on all placeholders found in the HTML output.
     *
     * @access public
     *
     * @return  void
     */
    function do_replace()
    {
        global $placeholders;
        $ci =& get_instance();
        $html = $ci->output->get_output();
        if (!empty($html)) {

            // This next line will be removed once all placeholder code has been converted from regex to DOMDocument.
            $html = replace_holder($html);

            // Each type of content gets called here. To handle in config, maybe, so that code needs not to be touched for new types.
            $placeholders['variable'] = get_variables();
            $placeholders['menu'] = get_menus();
            $placeholders['block'] = get_blocks();

            // Start replacement.
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            $xpath = new DOMXpath($dom);
            foreach ($xpath->query(".//*[not(self::textarea or self::select or self::input or ancestor::textarea or ancestor::select or ancestor::input) and contains(., '{{{')]/text()") as $node) {
                $node->nodeValue = preg_replace_callback('~{{{([^:]+):([^}]+)}}}~', function($m) use ($placeholders) {
                    return $placeholders[$m[1]][$m[2]] ?? '';
                },
                $node->nodeValue);
            }

            // TODO: This is hacky. Need to build recursion mechanism.
            foreach ($xpath->query(".//*[not(self::textarea or self::select or self::input or ancestor::textarea or ancestor::select or ancestor::input) and contains(., '{{{')]/text()") as $node) {
                $node->nodeValue = preg_replace_callback('~{{{([^:]+):([^}]+)}}}~', function($m) use ($placeholders) {
                    return $placeholders[$m[1]][$m[2]] ?? '';
                },
                $node->nodeValue);
            }
            $html = $dom->saveHTML();

            // Maybe even consider replacing __ style strings with {{{ style and variables, now that this is working better.
            // Some of them were moved to variables, but inside HTML tags we still have some encoding issues. To revisit.
            echo arbitrary_replacements(html_entity_decode($html), false, false);
        }
    }

    /**
     * function replace_holder()
     *
     * Function to do a placeholder replace on a particular placeholder (used in views or final output).
     *
     * @access public
     *
     * @param string $data
     *
     * @return  void
     */
    function replace_holder($data = '')
    {
        $matches = [];
        if (!empty($data)) {

            // Regex patterns for all placeholders currently supported in {{{placeholder}}} syntax.
            // We are slowly migrating away from regexes to use DOMDocument. These ones are the remaining ones to be converted.

            // Headtag
            $patterns['headtag_pattern'] = "/{{{headtag:(.*?)}}}/i";
            preg_match_all($patterns['headtag_pattern'], $data, $matches['headtag_matches']);
            $data = replace_headtag($matches, $data);

            // Headtags
            $patterns['headtags_pattern'] = "/{{{headtags}}}/i";
            preg_match_all($patterns['headtags_pattern'], $data, $matches['headtags_matches']);
            $data = replace_headtags($matches, $data);

            // Templatedata
            $patterns['templatedata_pattern'] = "/{{{templatedata:(.*?)}}}/i";
            preg_match_all($patterns['templatedata_pattern'], $data, $matches['templatedata_matches']);
            $data = replace_template_data($matches, $data);

            // Templatecontent
            $patterns['templatecontent_pattern'] = "/{{{templatecontent:(.*?):(.*?)}}}/i";
            preg_match_all($patterns['templatecontent_pattern'], $data, $matches['templatecontent_matches']);
            $data = replace_template_content($matches, $data);

            return $data;
        }
    }

?>
