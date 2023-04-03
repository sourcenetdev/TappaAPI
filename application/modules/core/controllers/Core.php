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
 * @version   6.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Core Module
 *
 * Contains the core features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Core extends MX_Controller
{
    public $search_engines = [];
    public $count = 0;
    public $send_error_mails = false;
    public $log_everything = false;
    public $settings = [];
    public $delete_type = 'hard';
    public $page_limit = 25;
    public $active_view = [];

    /**
     * __construct
     *
     * Initializes the module by loading language files, other modules, models, and also checking dependencies.
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {

        // Executes the parent's constructor.
        parent::__construct();

        // Loads this module's resources
        _modules_load(['syslog', 'metadata', 'variable']);
        _models_load(['core/core_model']);
        _languages_load(['core/core']);
        _helpers_load(['core/core']);

        // Sets the settings for this module.
        _settings_check('core');

        // Delete type
        if (empty($this->delete_type)) {
            $this->delete_type = $this->get_variable('delete_type');
            if (empty($this->delete_type)) {
                $this->delete_type = 'soft';
            }
        }
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Core' => [
                'actions' => [
                ]
            ]
        ];
    }

    /**
     * index
     *
     * This function invokes the content view function.
     *
     * @access public
     *
     * @param string $slug
     *
     * @return void
     */
    public function index($slug = 'welcome')
    {
        $this->view($slug);
    }

    /**
     * function get_page_data
     *
     * This function retrieves the basic information about a page from the database.
     *
     * @access  public
     * @param   string $page
     * @return  The array of data for the page.
     */
    public function get_page_data($page = '')
    {

        // We have not specified a page, so we try to retrieve it from the URI
        if ($page == '') {
            $uri = uri_string();

            // Retrieves the default slug as a failsafe.
            $def = _var('default_slug');

            // Sets the default slug for normal content pages.
            if ($uri == '' || $uri == 'content/view/' . $def) {
                $slug = $def;
            } else {

                // Defines the slug for non-content pages. Uses the last parameter of the uri string.
                $page = explode('/', $uri);
                for ($i = 0; $i <= count($page); $i++) {
                    if (!empty($page[$i])) {
                        $slug = $page[$i];
                    }
                }
            }
        } else {

            // We have specified the page that we want.
            $slug = $page;
        }

        // Retrieves the data and returns it for manipulation.
        $page_data = $this->core_model->get_page_data($slug);
        return $page_data;
    }

    /**
     * function get_page_headtag_data
     *
     * This function is a wrapper function to retrieve all of a page's <head> tags from the database.
     *
     * @access public
     *
     * @param integer $page_id
     *
     * @return array
     */
    public function get_page_headtag_data($page_id)
    {
        return $this->core_model->get_page_headtag_data($page_id);
    }

    /**
     * function get_page_default_headtags
     *
     * This function is a wrapper function to retrieve all the default <head> tags from the database.
     *
     * @access public
     *
     * @return array
     */
    public function get_page_default_headtags()
    {
        return $this->core_model->get_page_default_headtags();
    }

    /**
     * go_away_bot
     *
     * This function is used to show spam bots the middle finger. It happens when the honeypot was triggered. If redirect is passed, then do a silent failure as opposed to hard failure with headers.
     *
     * @access public
     *
     * @param string $value
     * @param string $redirect
     * @param bool $showerror
     *
     * @return void
     */
    public function go_away_bot($value, $redirect = '', $showerror = false)
    {

        // The honeypot was triggered, so invoke some serious ass kicking (potentially, anyway... :P)
        if (!empty($value)) {

            // Log the data.
            $this->syslog->log_405('system', 'Possible bot detected.');

            // If the redirect is blank, it means that the developer wanted to do a hard failure - i.e. send headers, and show error page.
            if ($showerror) {
                header("HTTP/1.1 405 Method Not Allowed");
                show_error(lang('core_bad_bot'), 405);
            }

            // A URI was specified, so the developer wanted to do a silent failure as if the submission was a success, and show a regular page.
            if ($redirect) {
                if ($this->log_everything) {
                    $this->syslog->log_200('system', 'Redirected to ' . $redirect);
                }
                redirect($redirect);
            }
        }
    }

    /**
     * set_form_validation_rules
     *
     * This function sets the validation rules for a particular field set.
     *
     * @access public
     *
     * @param array $data
     *
     * @return void
     */
    public function set_form_validation_rules($data)
    {
        $return = [];
        foreach ($data as $field) {
            if (!empty($field['validation']['rules'])) {
                if (!is_array($field['validation']['rules'])) {
                    $return[] = $field['name'] . ' - ' . $field['label'] . ': ' . $field['validation']['rules'];
                    if (!empty($field['validation']['errors'][$field['validation']['rules']])) {
                        $validation_messages = explode('|', $field['validation']['rules']);
                        $temp = [];
                        if (!empty($validation_messages)) {
                            foreach ($validation_messages as $k => $v) {
                                $temp[$v] = $field['validation']['errors'][$field['validation']['rules']];
                            }
                        }
                        $this->form_validation->set_rules(
                            $field['name'], $field['label'], $field['validation']['rules'],
                            $temp
                        );
                        unset($temp);
                        unset($validation_messages);
                    } else {
                        $this->form_validation->set_rules($field['name'], $field['label'], $field['validation']['rules']);
                    }
                } else {
                    foreach ($field['validation']['rules'] as $fv) {
                        $return[] = $field['name'] . ' - ' . $field['label'] . ': ' . $fv;
                        $this->form_validation->set_rules($field['name'], $field['label'], $fv);
                    }
                }
            }
        }
        return $return;
    }

    /**
     * set_nuggets
     *
     * Sets nuggets for display in summernote editors.
     *
     * @access public
     *
     * @param array $nuggets
     *
     * @return void
     */
    public function set_nuggets($nuggets)
    {

        // If nuggets are set, build up heading and content for use in views.
        if (!empty($nuggets) && is_array($nuggets)) {
            $data['heads'] = '';
            $data['content'] = '';
            foreach ($nuggets as $k => $v) {
                $data['heads'] .= ", '" . $v[0] . "'";
                $data['content'] .= $v[0] . ": {\nlist: [\n";
                if (!empty($v[2]) && !empty($v[1])) {
                    foreach ($v[2] as $key => $val) {
                        $data['content'] .= "'" . $val[$v[1]] . "',\n";
                    }
                }
                $data['content'] = rtrim($data['content'], ",\n");
                $data['content'] .= "\n]\n},\n";
            }
            $data['content'] = rtrim($data['content'], ",\n") . "\n";
            return $data;
        }
        return false;
    }

    /**
     * map_fields
     *
     * Used for grid listings dropdowns to map values of arrays to key => value maps.
     *
     * @access public
     *
     * @param array $data
     * @param array $maps
     * @param bool $as_options
     *
     * @return void
     */
    public function map_fields($data, $maps, $as_options = false)
    {
        $return = [];
        if (!empty($data) && !empty($maps)) {
            $counter = 0;
            foreach ($data as $k => $v) {
                if ($as_options){
                    $return[$counter]['value'] = trim($v[$maps[0]]);
                    $return[$counter]['display'] = trim($v[$maps[1]]);

                    // TODO: Allow for disabled items.
                    $return[$counter]['disabled'] = '';
                } else {
                    $return[trim($v[$maps[0]])] = trim($v[$maps[1]]);
                }
                $counter++;
            }
        }
        return $return;
    }

    /**
     * map_selected
     *
     * Currently unused, I think. To investigate.
     *
     * @access public
     *
     * @param array $data
     *
     * @return void
     */
    public function map_selected($data) {
        $return = [];
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $kk => $vv) {
                        $return[] = $vv;
                    }
                } else {
                    $return[] = $v;
                }
            }
        }
        return $return;
    }

    /**
     * function view
     *
     * This function is the main function that facilitates content for display on the site.
     *
     * @access public
     *
     * @param string $slug
     * @param string $method
     *
     * @return void
     */
    public function view($slug = 'welcome', $method = '')
    {
        $pagedata = $this->core_model->get_page_leadin($slug);
        $data = array();
        $err = _sess_get('errors');
        if (!empty($err)) {
            $data['errors'] = $err;
        }
        if (!empty($pagedata)) {
            _render(_cfg('current_theme'), 'core/layouts/' . $pagedata[0]['layout_file'], $data, $method);
        } else {
            _redir('error', '', 'nucleus/page_404');
        }
    }
}
