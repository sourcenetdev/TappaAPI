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
 * KyrandiaCMS Cornerstone Library - Template Functions
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

class CSTemplate
{
    public $template_data = [];

    /**
     * function set()
     *
     * Sets a template variable
     *
     * @access public
     *
     * @param string $name
     * @param string $value
     * @param string $sub
     *
     * @return void
     */
    public function setTemplateData($name, $value, $sub = '')
    {
        if ($sub == '') {
            $this->template_data[$name] = $value;
        } else {
            $this->template_data[$sub][$name] = $value;
        }
    }

    /**
     * function getThemeBySlug($slug)
     *
     * Loads a theme from the database by its slug.
     *
     * @access public
     *
     * @param string $slug
     *
     * @return string
     */
    public function getThemeBySlug($slug)
    {
        $this->CI =& get_instance();
        $this->CI->load->model('theme/theme_model');
        $theme = $this->CI->theme_model->get_theme_by_slug($slug);
        if (!empty($theme[0])) {
            return $theme[0]['file'];
        }
        return null;
    }

    /**
     * function loadTheme()
     *
     * Loads a theme and its content.
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
    public function loadTheme($template = '', $view = '', $view_data = [], $return = false)
    {
        $this->CI =& get_instance();
        global $themename;
        $themename = 'theme_' . $view_data['db_slug'];
        unset($view_data['db_slug']);
        $this->setTemplateData('contents', $this->CI->load->view($view, $view_data, true));
        return $this->CI->load->view($template, $this->template_data, $return);
    }

    /**
     * function getTemplateData()
     *
     * Gets the template data
     *
     * @access public
     *
     * @return array
     */
    public function getTemplateData()
    {
        return $this->template_data;
    }
}
