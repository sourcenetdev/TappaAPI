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
 * KyrandiaCMS Replacement Helper
 *
 * Contains a list of replacement functions used in the system.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

/**
 * function replace_template_data()
 *
 * Function to do a placeholder replace on {{{template_data}}} placeholders
 *
 * @access public
 *
 * @param array $matches
 * @param string $data
 *
 * @return string
 */
if (!function_exists('replace_template_data')) {
    function replace_template_data($matches, $data)
    {
        $ci =& get_instance();
        if (!empty($matches['templatedata_matches'])) {
            $head = '';
            $body = '';

            // Retrieves all data set to the template. The replacement values are set in hooks/icms.php.
            $template_data = _get_template_data();
            if (!empty($template_data)) {

                // Processes <head> items.
                if (!empty($template_data['head'])) {
                    foreach ($template_data['head'] as $tk => $tv) {
                        $head .= '        ' . $tv . "\r\n";
                    }
                }

                // Processes <body> items.
                if (!empty($template_data['body'])) {
                    foreach ($template_data['body'] as $tk => $tv) {
                        $body .= '        ' . $tv . "\r\n";
                    }
                }

                // Now does the actual replacement.
                foreach ($matches['templatedata_matches'][0] as $key => $val) {
                    if ($matches['templatedata_matches'][1][$key] == 'head') {
                        $data = str_replace($val, ltrim($head), $data);
                    } elseif ($matches['templatedata_matches'][1][$key] == 'body') {
                        $data = str_replace($val, ltrim($body), $data);
                    }
                }
            }
        }
        return $data;
    }
}

/**
 * function replace_template_content()
 *
 * Function to do a placeholder replace on {{{template_content}}} placeholders
 *
 * @access public
 *
 * @param array $matches
 * @param string $data
 *
 * @return string
 */
if (!function_exists('replace_template_content')) {
    function replace_template_content($matches, $data)
    {
        $ci =& get_instance();
        if (!empty($matches['templatecontent_matches'])) {
            $pid = explode('/', uri_string());
            if ($pid[0] == 'content' && $pid[1] == 'view') {
                foreach ($matches['templatecontent_matches'][0] as $key => $val) {
                    $items = explode(':', $val);
                    $template_content = $ci->core_model->get_page_final_content($items[1], rtrim($items[2], '}}}'), $pid[2], true);
                    if (!empty($template_content[0]['section_content'])) {
                        $data = str_replace($val, $template_content[0]['section_content'], $data);
                    } else {
                        $data = str_replace($val, '', $data);
                    }
                }
            } else {
                foreach ($matches['templatecontent_matches'][0] as $key => $val) {
                    $data = str_replace($val, '', $data);
                }
            }
        }
        return $data;
    }
}

/**
 * function replace_headtag()
 *
 * Function to do a placeholder replace on {{{headtag}}} placeholders
 *
 * @access public
 *
 * @param array $matches
 * @param string $data
 *
 * @return string
 */
if (!function_exists('replace_headtag')) {
    function replace_headtag($matches, $data)
    {
        $ci =& get_instance();
        if (!empty($matches['headtag_matches'])) {
            $ci->load->module('block');
            $final_meta = array();
            $metas = array();

            // Gets the page data (title, slug, id, etc.)
            $page_data = $ci->core->get_page_data();
            if (!empty($page_data)) {

                // If page data is set, now get the page's metadata as defined in the database.
                $page_headtags = $ci->core->get_page_headtag_data($page_data[0]['id']);
            } else {
                $page_headtags = array();
            }

            // Gets the default metadata which will be processed first. If a default value is set, and it is not overridden by the page, it will be retained.
            $page_default_headtags = $ci->core->get_page_default_headtags();

            // Compiles the preliminary list of <head> tags. Processes default <head> tags first, and if better data exists in the content, replace it later.
            if (!empty($page_default_headtags)) {
                foreach ($page_default_headtags as $key => $value) {
                    $final_meta[$value['h_name']][$value['a_name']] = $value;
                }
            }

            // Compiles the final list of <head> tags.
            if (!empty($page_headtags)) {
                foreach ($page_headtags as $key => $value) {
                    $final_meta[$value['h_name']][$value['a_name']] = $value;
                }
            }

            // Now get the array in the correct order for accuracy purposes: charset has to be first, title second.
            $charset = $final_meta['charset'];
            $title = $final_meta['title'];
            unset ($final_meta['charset'], $final_meta['title']);
            array_unshift($final_meta, $charset, $title);

            // Processes the final list of <head> tags to generate the <head> content.
            if (!empty($final_meta)) {
                foreach ($final_meta as $fm_val1) {
                    reset($fm_val1);
                    $first = current($fm_val1);
                    if ($first['h_type'] == 'Meta') {

                        // Processes <meta> items.
                        $out = "<meta";
                        if (is_array($fm_val1) && !empty($fm_val1)) {
                            foreach ($fm_val1 as $fm_val2) {
                                $out .= ' ' . $fm_val2['a_name'] . '="' . $fm_val2['value'] . '"';
                            }
                        }
                        $out .= ">";
                        $metas[$first['h_name']][] = $out;
                    } elseif ($first['h_type'] == 'Link') {

                        // Processes <link> items.
                        $out = "<link";
                        if (is_array($fm_val1) && !empty($fm_val1))
                        {
                            foreach ($fm_val1 as $fm_val2)
                            {
                                $out .= ' ' . $fm_val2['a_name'] . '="' . $fm_val2['value'] . '"';
                            }
                        }
                        $out .= ">";
                        $metas[$first['h_name']][] = $out;
                    } elseif ($first['h_type'] == 'Title') {

                        // Processes <title> items.
                        $out = "<title>" . $first['value'] . "</title>";
                        $metas[$first['h_name']][] = $out;
                    }
                }
            }

            // Now do the actual replacement.
            foreach ($matches['headtag_matches'][0] as $key => $val) {
                $backup = $data;
                if (!empty($metas[$matches['headtag_matches'][1][$key]][0])) {
                    $data = str_replace($val, $metas[$matches['headtag_matches'][1][$key]][0], $data);
                }
            }
        }
        return $data;
    }
}

/**
 * function replace_headtags()
 *
 * Function to do a placeholder replace on {{{headtags}}} placeholders
 *
 * @access public
 *
 * @param array $matches
 * @param string $data
 *
 * @return string
 */
if (!function_exists('replace_headtags')) {
    function replace_headtags($matches, $data)
    {
        $ci =& get_instance();
        if (!empty($matches['headtags_matches'])) {
            $ci->load->module('content');
            $final_meta = array();
            $metas = array();

            // Gets the page data (title, slug, id, etc.)
            $page_data = $ci->core->get_page_data();
            if (!empty($page_data)) {

                // If page data is set, now get the page's metadata as defined in the database.
                $page_headtags = $ci->core->get_page_headtag_data($page_data[0]['id']);
            } else {
                $page_headtags = array();
            }

            // Gets the default metadata which will be processed first. If a default value is set, and it is not overridden by the page, it will be retained.
            $page_default_headtags = $ci->core->get_page_default_headtags();

            // Compiles the preliminary list of <head> tags. Processes default <head> tags first, and if better data exists in the content, replace it later.
            if (!empty($page_default_headtags)) {
                foreach ($page_default_headtags as $key => $value) {
                    $final_meta[$value['h_name']][$value['a_name']] = $value;
                }
            }

            // Compiles the final list of <head> tags.
            if (!empty($page_headtags)) {
                foreach ($page_headtags as $key => $value) {
                    $final_meta[$value['h_name']][$value['a_name']] = $value;
                }
            }

            // Now get the array in the correct order for accuracy purposes: charset has to be first, title second.
            $charset = $final_meta['charset'];
            $title = $final_meta['title'];
            unset ($final_meta['charset'], $final_meta['title']);
            array_unshift($final_meta, $charset, $title);

            // Processes the final list of <head> tags to generate the <head> content.
            if (!empty($final_meta)) {
                foreach ($final_meta as $fm_val1) {
                    reset($fm_val1);
                    $first = current($fm_val1);
                    if ($first['h_type'] == 'Meta') {

                        // Processes <meta> items.
                        $out = "<meta";
                        if (is_array($fm_val1) && !empty($fm_val1)) {
                            foreach ($fm_val1 as $fm_key2 => $fm_val2) {
                                $out .= ' ' . $fm_val2['a_name'] . '="' . $fm_val2['value'] . '"';
                            }
                        }
                        $out .= ">";
                        $metas[$first['h_name']][] = $out;
                    } elseif ($first['h_type'] == 'Link') {

                        // Processes <link> items.
                        $out = "<link";
                        if (is_array($fm_val1) && !empty($fm_val1)) {
                            foreach ($fm_val1 as $fm_key2 => $fm_val2) {
                                $out .= ' ' . $fm_val2['a_name'] . '="' . $fm_val2['value'] . '"';
                            }
                        }
                        $out .= ">";
                        $metas[$first['h_name']][] = $out;
                    } elseif ($first['h_type'] == 'Title') {

                        // Processes <title> items.
                        $out = "<title>" . $first['value'] . "</title>";
                        $metas[$first['h_name']][] = $out;
                    }
                }
            }

            // Now do the actual replacement.
            $display_meta = '';
            foreach ($metas as $key => $val) {
                $display_meta .= '        ' . $val[0] . "\r\n";
            }
            if (!empty(trim($display_meta))) {
                $data = str_replace('{{{headtags}}}', ltrim($display_meta), $data);
            } else {
                replace_debug($data, '{{{headtags}}}', '<!-- No <head> tags found to display in template. -->');
            }
        }
        return $data;
    }
}

/**
 * function get_variables()
 *
 * Function to get all variables that need to be replaced.
 *
 * @access public
 *
 * @return string
 */
function get_variables()
{
    $ci =& get_instance();
    $ci->load->module('variable');
    $variables = $ci->variable_model->get_all_variables(true);
    $return = [];
    if (!empty($variables)) {
        foreach ($variables as $v) {
            $return[$v['name']] = $v['value'];
        }
    }
    return $return;
}

/**
 * function get_menus()
 *
 * Function to get all blocks that need to be replaced.
 *
 * @access public
 *
 * @return string
 */
function get_menus()
{
    $ci =& get_instance();
    $ci->load->module('menu');
    $menus = $ci->menu_model->get_all_menus(true);
    $return = [];
    if (!empty($menus)) {
        foreach ($menus as $vv) {
            $temp['menu'] = $ci->menu_model->get_menu_item_list($vv['id'], 0, null);
            if (!empty($temp['menu'])) {
                $return[$vv['name']] = '';
                foreach ($temp['menu'] as $v) {
                    $return[$vv['name']] .= '<li class="' . $v['class'] . '"><a href="' . base_url() . $v['link']. '"><i class="zmdi zmdi-' . $v['icon'] . '"></i> ' . $v['name'] . '</a></li>';
                }
            }
        }
    }
    return $return;
}

/**
 * function get_blocks()
 *
 * Function to get all blocks that need to be replaced.
 *
 * @access public
 *
 * @return string
 */
function get_blocks()
{
    $ci =& get_instance();
    $ci->load->module('block');
    $blocks = $ci->block_model->get_all_blocks(true);
    $return = [];
    if (!empty($blocks)) {
        foreach ($blocks as $v) {
            $temp['block'] = $ci->block_model->get_block_by_slug($v['slug']);
            if (!empty($temp['block'])) {
                $view = 'block';
                if (!empty($temp['block'][0]['view'])) {
                    $view = $temp['block'][0]['view'];
                }
                $temp['block_view'] = $ci->load->view('block/blocks/' . $view, $temp['block'][0], true);
                if (!empty($temp['block_view'])) {
                    $return[$v['slug']] = $temp['block_view'];
                }
            }
        }
    }
    return $return;
}

?>
