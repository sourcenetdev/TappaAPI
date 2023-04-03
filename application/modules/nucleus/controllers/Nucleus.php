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
 * KyrandiaCMS Nucleus Module
 *
 * Contains the kernel (nucleus) of Kyrandia CMS. Loads all libraries (atoms) that make up the kernel (nucleus).
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Nucleus extends MX_Controller
{
    public $delete_type = 'hard';
    public $page_limit = 25;
    public $search_engines = [];
    public $count = 0;
    public $send_error_mails = false;
    public $log_everything = false;
    public $settings = [];

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
        _models_load(['nucleus/nucleus_model']);
        _languages_load(['nucleus/nucleus']);
        _helpers_load(['nucleus/nucleus']);

        // Sets the settings for this module.
        _settings_check('nucleus');

        // Loads all widgets.
        $this->nucleus_init();

        // Set search engines array.
        $this->search_engines = $this->settings['nucleus']['search_engines'];
    }

    public function nucleus_init()
    {
        $libraries = _list_files(dirname(__FILE__) . '/../libraries/', ['php'], true);
        if (!empty($libraries)) {
            foreach ($libraries as $library) {
                $this->load->library('nucleus/' . $library);
            }
        }
    }

    public function page_404()
    {
        // Sends the 404 header
        header("HTTP/1.1 404 Not Found");
        $data = [];

        // Are we dealing with a referrer?
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
            _404('system', 'Not found: ' . uri_string() . ' - redirected from: ' . $referer);
            $search_engines = $this->search_engines;
            if (strpos($referer, base_url()) !== FALSE) {

                // The referer is a link on our site.
                $data['message'][] = 'You have arrived at a page on ' . base_url() . ' from another link on this site. Our administrators have been notified about the problem.';
            } else {

                // The referer is another site.
                $source_text = 'You have arrived at a page on ' . base_url() . ' from ' . $referer . '. If you know the webmaster of this site, please advise them of this error.';
                foreach ($search_engines as $search_engine) {
                    if (strpos($referer, $search_engine) !== FALSE) {
                        $source_text = 'You have arrived at a page on ' . base_url() . ' from ' . $search_engine . '. Our administrators have been notified about the problem.';
                        break;
                    }
                }
                $data['message'][] = $source_text;
            }

            // Prepares the output for admin email and display.
            $data['title'] = 'Page not found';
            $data['error'] = $this->session->userdata('error');

            // Sends the admin email that a 404 error occurred.
            if ($this->send_error_mails) {
                mail_to(config_item('admin_address'));
                mail_from(config_item('admin_address'), config_item('admin_name'));
                mail_message('html', $data['title'], implode(',', $data['message']), lang('core_browser_non_html'));
                mail_send();
            }
        } else {

            // Visitor arrived at the page directly.
            _404('system', 'Page ' . $_SERVER['REQUEST_URI'] . ' not found: direct visit.');
            $data['title'] = 'Page not found';
            $data['message'][] = 'You have arrived at a page on ' . $_SERVER['REQUEST_URI'] . ' from a direct link or a bookmark. We could, however, not find the page. Sorry.';

            // Sends the admin email that a 404 error occurred.
            if ($this->send_error_mails) {
                mail_to(config_item('admin_address'));
                mail_from(config_item('admin_address'), config_item('admin_name'));
                mail_message('html', $data['title'], implode(',', $data['message']), lang('core_browser_non_html'));
                mail_send();
            }
        }
        _render(_cfg('admin_theme'), 'nucleus/error_404', $data);
    }

    /**
     * log_generic
     *
     * This function allows you to do a generic log entry
     *
     * @access public
     *
     * @param string $module
     * @param string $func
     * @param string $log
     * @param string $message
     * @param string $status
     * @param int $code
     * @param string $type
     * @param string $impact
     * @param array $data
     *
     * @return void
     */
    public function log_generic(
        $log,
        $message = '',
        $status = 'Success',
        $code = 200,
        $type = 'Notice',
        $impact = 'Medium',
        $data = []
    ) {

        // Set the log data.
        $class_data = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        $ip_address = _get_ip();
        $id = $this->session->userdata('id');
        $un = $this->session->userdata('username');
        $status = array(
            'status' => $status,
            'code' => $code,
            'type' => $type,
            'message' => $message,
            'impact' => $impact,
            'class' => $class_data[1]['class'],
            'function' => $class_data[1]['function'],
            'line' => $class_data[1]['line'],
            'data' => $data,
            'user_id' => $id,
            'username' => $un,
            'ip_address' => $ip_address
        );

        // Log the data.
        _log($status, $log . '_');

        // Return the data in case it is needed later.
        return json_encode($status, JSON_PRETTY_PRINT);
    }

    /**
     * log
     *
     * This function allows you to do a generic log entry whereny you can specify a status.
     *
     * @access public
     *
     * @param int $code
     * @param string $log
     * @param string $message
     * @param string $type
     * @param string $impact
     * @param array $data
     *
     * @return void
     */
    public function log($code, $log, $message, $type = 'Notice', $impact = 'Low', $data = [])
    {
        $this->log_generic($log, $message, 'Success', $code, $type, $impact, $data);
    }

    /**
     * log_200
     *
     * This function allows you to do a generic status 200 log entry
     *
     * @access public
     *
     * @param string $log
     * @param string $message
     * @param string $type
     * @param string $impact
     * @param array $data
     *
     * @return void
     */
    public function log_200($log, $message, $type = 'Notice', $impact = 'Low', $data = [])
    {
        $this->log_generic($log, $message, 'Success', 200, $type, $impact, $data);
    }

    /**
     * log_400
     *
     * This function allows you to do a generic status 400 log entry
     *
     * @access public
     *
     * @param string $log
     * @param string $message
     * @param string $type
     * @param string $impact
     * @param array $data
     *
     * @return void
     */
    public function log_400($log, $message, $type = 'Bad request', $impact = 'High', $data = [])
    {
        $this->log_generic($log, $message, 'Error', 400, $type, $impact, $data);
    }

    /**
     * log_401
     *
     * This function allows you to do a generic status 401 log entry
     *
     * @access public
     *
     * @param string $log
     * @param string $message
     * @param string $type
     * @param string $impact
     * @param array $data
     *
     * @return void
     */
    public function log_401($log, $message, $type = 'Unauthorized', $impact = 'High', $data = [])
    {
        $this->log_generic($log, $message, 'Error', 401, $type, $impact, $data);
    }

    /**
     * log_403
     *
     * This function allows you to do a generic status 403 log entry
     *
     * @access public
     *
     * @param string $log
     * @param string $message
     * @param string $type
     * @param string $impact
     * @param array $data
     *
     * @return void
     */
    public function log_403($log, $message, $type = 'Forbidden', $impact = 'High', $data = [])
    {
        $this->log_generic($log, $message, 'Error', 403, $type, $impact, $data);
    }

    /**
     * log_404
     *
     * This function allows you to do a generic status 404 log entry
     *
     * @access public
     *
     * @param string $log
     * @param string $message
     * @param string $type
     * @param string $impact
     * @param array $data
     *
     * @return void
     */
    public function log_404($log, $message, $type = 'Not found', $impact = 'Medium', $data = [])
    {
        $this->log_generic($log, $message, 'Error', 404, $type, $impact, $data);
    }

    /**
     * log_405
     *
     * This function allows you to do a generic status 405 log entry
     *
     * @access public
     *
     * @param string $log
     * @param string $message
     * @param string $type
     * @param string $impact
     * @param array $data
     *
     * @return void
     */
    public function log_405($log, $message, $type = 'Method not allowed', $impact = 'High', $data = [])
    {
        $this->log_generic($log, $message, 'Error', 405, $type, $impact, $data);
    }

    /**
     * log_409
     *
     * This function allows you to do a generic status 409 log entry
     *
     * @access public
     *
     * @param string $log
     * @param string $message
     * @param string $type
     * @param string $impact
     * @param array $data
     *
     * @return void
     */
    public function log_409($log, $message, $type = 'Admin override', $impact = 'Critical', $data = [])
    {
        $this->log_generic($log, $message, 'Error', 409, $type, $impact, $data);
    }

    /**
     * log_500
     *
     * This function allows you to do a generic status 500 log entry
     *
     * @access public
     *
     * @param string $log
     * @param string $message
     * @param string $type
     * @param string $impact
     * @param array $data
     *
     * @return void
     */
    public function log_500($log, $message, $type = 'Internal server error', $impact = 'High', $data = [])
    {
        $this->log_generic($log, $message, 'Error', 500, $type, $impact, $data);
    }
}
