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
 * KyrandiaCMS Email Helper
 *
 * Contains a list of email-related functions used in the system.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

	// Set to test mode or not.
	defined('TEST_MODE') or define('TEST_MODE', 1);
	defined('TEST_USER') or define('TEST_USER', 'kobus.myburgh@impero.co.za');

	/**
	 * Function mail_send()
	 *
	 * Sends a mail
	 *
	 * @access public
    *
	 * @return bool true or false
	 */
	if (!function_exists('mail_send')) {
		function mail_send()
		{
			$ci =& get_instance();
			$ci->load->library('email');
			if (!$ci->email->send()) {
				return false;
			}
			return true;
		}
	}

	/**
	 * Function mail_attach()
	 *
	 * Attaches files to a mail
	 *
	 * @access public
	 *
	 * @param mixed $items
	 *
	 * @return void
	 */
	if (!function_exists('mail_attach')) {
		function mail_attach($items = '')
		{
			$ci =& get_instance();
			$ci->load->library('email');
			if (is_array($items)) {
				foreach ($items as $item) {
					if (file_exists(trim($item))) {
						$ci->email->attach(trim($item));
					}
				}
			} else {
				if (trim($items) !== "") {
					if (file_exists(trim($items))) {
						$ci->email->attach(trim($items));
					}
				}
			}
		}
	}

	/**
	 * Function valid_email()
	 *
	 * Tests an e-mail address for validity.
	 *
	 * @access public
	 *
	 * @param string $address
	 *
	 * @return bool true or false
	 */
	if (!function_exists('valid_email')) {
		function valid_email($address)
		{
			return filter_var($address, FILTER_VALIDATE_EMAIL);
		}
	}

	/**
	 * Function mail_to()
	 *
	 * Sets the to addresses for the mail, either string or array.
	 *
	 * @access public
	 *
	 * @param mixed $to
	 * @param mixed $cc
	 * @param mixed $bc
	 *
	 * @return int The number of valid and invalid addresses found.
	 */
	if (!function_exists('mail_to')) {
		function mail_to($to = '', $cc = '', $bc = '')
		{
			$ci =& get_instance();
			$ci->load->library('email');
			$data['invalid'] = 0;
			$data['valid'] = 0;
			$sendto = array();
			$sendcc = array();
			$sendbc = array();

			// If in test mode, end processing after setting test user.
			if (TEST_MODE == 1) {
				$ci->email->to(TEST_USER);
				$data['valid']++;
				return $data;
			}

			// Handle TO recipients
			if (is_array($to)) {
				foreach ($to as $t) {
					if (valid_email(trim($t))) {
						$data['valid']++;
						$sendto[] = $t;
					} else {
						$data['invalid']++;
					}
				}
			} elseif (valid_email(trim($to)) && trim($to) !== '') {
				$data['valid']++;
				$sendto[] = $to;
			}

			// Handle CC recipients
			if (is_array($cc)) {
				foreach ($cc as $c) {
					if (valid_email(trim($c))) {
						$data['valid']++;
						$sendcc[] = $c;
					} else {
						$data['invalid']++;
					}
				}
			} elseif (valid_email(trim($cc)) && trim($cc) !== '') {
				$data['valid']++;
				$sendcc[] = $cc;
			}

			// Handle BC recipients
			if (is_array($bc)) {
				foreach ($bc as $b) {
					if (valid_email(trim($b))) {
						$data['valid']++;
						$sendbc[] = $b;
					} else {
						$data['invalid']++;
					}
				}
			} elseif (valid_email(trim($bc)) && trim($bc) !== "") {
				$data['valid']++;
				$sendbc[] = $bc;
			}

			// Set the addresses
			if (count($sendto) > 0) {
				$ci->email->to($sendto);
			}
			if (count($sendcc) > 0) {
				$ci->email->cc($sendcc);
			}
			if (count($sendbc) > 0) {
				$ci->email->bcc($sendbc);
			}
			return $data;
		}
	}

	/**
	 * Function mail_replyto()
	 *
	 * Sets the reply-to address for the mail.
	 *
	 * @access public
	 *
	 * @param string $address
	 * @param string $name
	 *
	 * @return void
	 */
	if (!function_exists('mail_reply_to')) {
		function mail_reply_to($address, $name)
		{
			$ci =& get_instance();
			$ci->load->library('email');
			$ci->email->reply_to($address, $name);
		}
	}

	/**
	 * Function mail_from()
	 *
	 * Sets the from address for the mail.
	 *
	 * @access public
	 *
	 * @param string $address
	 * @param string $name
	 *
	 * @return void
	 */
	if (!function_exists('mail_from')) {
		function mail_from($address, $name)
		{
			$ci =& get_instance();
			$ci->load->library('email');
			$ci->email->from($address, $name);
		}
	}

	/**
	 * Function mail_clear()
	 *
	 * Clears the mail, with option attachments clearing.
	 *
	 * @access public
	 *
	 * @param bool $clearattachments
	 *
	 * @return void
	 */
	if (!function_exists('mail_clear')) {
		function mail_clear($clearattachments = false)
		{
			$ci =& get_instance();
			$ci->load->library('email');
			if ($clearattachments) {
				$ci->email->clear(true);
			} else {
				$ci->email->clear();
			}
		}
	}

	/**
	 * Function mail_message()
	 *
	 * Sets the message for the mail, either HTML or TEXT.
	 *
	 * @access public
	 *
	 * @param string $type
	 * @param string $subject
	 * @param string $message
	 * @param string $alt_message
	 *
	 * @return void
	 */
	if (!function_exists('mail_message')) {
		function mail_message($type = 'html', $subject = '', $message = '', $alt_message = '')
		{
            if (empty($message) && !empty($subject)) {
                $ci =& get_instance();
                $ci->load->library('email');
                $ci->email->subject($subject);
                if ($type == 'html') {
                    $ci->email->message($message);
                    if (!empty($alt_message)) {
                        $ci->email->set_alt_message($alt_message);
                    }
                } else {
                    $ci->email->message($alt_message);
                    if (!empty($alt_message)) {
                        $ci->email->set_alt_message($alt_message);
                    }
                }
                return true;
            }
            return false;
		}
	}

	/**
	 * Function mail_debugger()
	 *
	 * Echos out the mail debugger on request.
	 *
	 * @access public
	 *
	 * @return void
	 */
	if (!function_exists('mail_debugger')) {
		function mail_debugger()
		{
			$ci =& get_instance();
			$ci->load->library('email');
			echo $ci->email->print_debugger();
		}
	}

?>
