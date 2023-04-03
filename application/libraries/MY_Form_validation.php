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
 * KyrandiaCMS Form Validation Extension Library
 *
 * This library extends the CI form validation library with additional functions.
 *
 * @package     Impero
 * @subpackage  Hooks
 * @category    Hooks
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

class MY_Form_validation extends CI_Form_validation
{
    protected $CI;

	public function __construct($config = [])
	{
        $this->CI =& get_instance();
		parent::__construct($config);
	}

    public function run($module = '', $group = '')
    {
        (is_object($module)) AND $this->CI = &$module;
        return parent::run($group);
    }

    public function get_validation_rules($field = '')
    {
        if (!empty($field) && isset($this->_field_data[$field])) {
            return $this->_field_data[$field];
        }
        return $this->_field_data;
    }

    /**
     * Validates that a URL is accessible. Also takes ports into consideration.
     *
     * Note: If you see "php_network_getaddresses: getaddrinfo failed: nodename nor servname provided, or not known" then you are having DNS resolution issues and need to fix Apache.
     *
     * @access public
     * @param string
     * @return string
     */
    public function url_exists($url)
    {
        $url_data = parse_url($url);
        if (!fsockopen($url_data['host'], isset($url_data['port']) ? $url_data['port'] : 80)) {
            $this->set_message('url_exists', 'The URL you have entered is not accessible.');
            return false;
        }
        return true;
    }

	/**
	 * Show the rules present for a field.
	 *
	 * @param	string	the field name
     *
	 * @return	bool
	 */
	public function show_rules($field)
	{
        if (!empty($this->_field_data[$field]['rules'])) {
            return $this->_field_data[$field]['rules'];
        }
        return [];
	}

    public function validate_username_unique()
    {
        $id = $this->CI->input->post('id');
        $username = $this->CI->input->post('username');
        $exists = $this->CI->user_model->get_field_unique('username', $username);
        if (empty($id)) {
            if (!empty($exists)) {
                $this->CI->form_validation->set_message('validate_username_unique', 'The username must be unique. This one is already in use.');
                return false;
            }
            return true;
        } else {
            if (!empty($exists)) {
                if ($id !== $exists[0]['id']) {
                    $this->CI->form_validation->set_message('validate_username_unique', 'The username must be unique. This one is already in use.');
                    return false;
                }
                return true;
            }
            return true;
        }
    }

    public function validate_email_unique()
    {
        $id = $this->CI->input->post('id');
        $email = $this->CI->input->post('email');
        $exists = $this->CI->user_model->get_field_unique('email', $email);
        if (empty($id)) {
            if (!empty($exists)) {
                $this->CI->form_validation->set_message('validate_email_unique', 'The email address must be unique. This one is already in use.');
                return false;
            }
            return true;
        } else {
            if (!empty($exists)) {
                if ($id !== $exists[0]['id']) {
                    $this->CI->form_validation->set_message('validate_email_unique', 'The email address must be unique. This one is already in use.');
                    return false;
                }
                return true;
            }
            return true;
        }
    }

    public function validate_date_YmdHis($date)
    {
        //$data = (bool)preg_match('/^(19|20)\d{2}\-(0[1-9]|1[0-2])\-(0[1-9]|[12][0-9]|3[01]) ([01]\d{1}|2[0-3]):(0\d{1}|[2345]\d{1}):(0\d{1}|[2345]\d{1})$/', $date);
        $data = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        if (empty($date)) {
            return true;
        }
        if ($data === false) {
            $this->CI->form_validation->set_message('validate_date_YmdHis', 'You have entered an invalid date in {field}. Expected a date in format Y-m-d H:i:s. Received: ' . $date);
        }
        return $data;
    }

    public function validate_date_Ymd($date)
    {
        //$data = (bool)preg_match('/^(19|20)\d{2}\-(0[1-9]|1[0-2])\-(0[1-9]|[12][0-9]|3[01])$/', $date);
        $data = DateTime::createFromFormat('Y-m-d', $date);
        if (empty($date)) {
            return true;
        }
        if ($data === false) {
            $this->CI->form_validation->set_message('validate_date_Ymd', 'You have entered an invalid date in {field}. Expected a date in format Y-m-d. Received: ' . $date);
        }
        return $data;
    }

    public function validate_password()
    {
        $username = $this->CI->input->post('username');
        $pass = $this->CI->input->post('password');
        if (empty($pass)) {
            $pass = $this->CI->input->post('new_password');
        }
        $policies = [
            'min' => _cfg('password_min_length'),
            'max' => _cfg('password_max_length'),
            'upper' => _cfg('password_uses_capitals'),
            'lower' => _cfg('password_uses_lowercase'),
            'special' => _cfg('password_uses_specials'),
            'nouser' => _cfg('password_no_username'),
            'num' => _cfg('password_uses_numbers')
        ];
        $errs = [];
        $has_errors = false;
        $msg = '';
        if (array_key_exists('min', $policies)) {
            if (strlen($pass) < $policies['min']) {
                $errs[] = 'Your password must have at least ' . $policies['min'] . ' characters.';
                $has_errors = true;
            }
        }
        if (array_key_exists('max', $policies)) {
            if (strlen($pass) > $policies['max']) {
                $errs[] = 'Your password must have less than ' . $policies['max'] . ' characters.';
                $has_errors = true;
            }
        }
        if (array_key_exists('upper', $policies) && strtolower($pass) === $pass) {
            $errs[] = 'Your password must have at least 1 upper case character.';
            $has_errors = true;
        }
        if (array_key_exists('lower', $policies) && strtoupper($pass) === $pass) {
            $errs[] = 'Your password must have at least 1 lower case character.';
            $has_errors = true;
        }
        if (array_key_exists('num', $policies)) {
            if (strcspn($pass, '0123456789') == strlen($pass)) {
                $errs[] = 'Your password must have at least 1 numeric value.';
                $has_errors = true;
            }
        }
        if (array_key_exists('nouser', $policies)) {
            if (strpos($pass, chr($username)) === true) {
                $errs[] = 'Your password may not contain your username.';
                $has_errors = true;
            }
        }
        if ($has_errors) {
            $msg = 'You have errors in your password: <ul>';
            if (!empty($errs)) {
                foreach ($errs as $err) {
                    $msg .= '<li class="error-text">' . $err . '</li>';
                }
            }
            $msg .= '</ul>';
            $this->CI->form_validation->set_message('validate_password', $msg);
            return false;
        }
        return true;
    }
}
