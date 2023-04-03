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

require 'vendor/autoload.php';
use Auth0\SDK\Auth0;

global $auth0;
global $auth_enabled;

/**
 * KyrandiaCMS Auth0 Hook
 *
 * Use this file to define hooks for the Auth0 functionality of the User module.
 *
 * @package     Impero
 * @subpackage  Hooks
 * @category    Hooks
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

/**
 * function auth0_initialize
 *
 * Initializes auth0 2FA provider
 *
 * @access  public
 *
 * @return  void
 */
if (!function_exists('auth0_initialize')) {
    function auth0_initialize()
    {
        global $auth0, $auth_enabled;
        if (!empty($auth_enabled)) {
            $auth0 = new Auth0([
                'domain' => _cfg('auth0_domain'),
                'client_id' => _cfg('auth0_client_id'),
                'client_secret' => _cfg('auth0_client_secret'),
                'redirect_uri' => _cfg('auth0_redirect_uri'),
                'scope' => _cfg('auth0_scope'),
            ]);
        }
    }
}

/**
 * function auth0_execute
 *
 * Executes the auth0 2FA authentication.
 *
 * @access  public
 *
 * @return  void
 */
if (!function_exists('auth0_execute')) {
    function auth0_execute()
    {
        global $auth0, $auth_enabled;
        if (!empty($auth_enabled)) {
            $auth0->login();
        }
    }
}

/**
 * function auth0_get
 *
 * Retrieves the auth0 user information.
 *
 * @access  public
 *
 * @return  void
 */
if (!function_exists('auth0_get')) {
    function auth0_get()
    {
        global $auth0, $auth_enabled;
        $user_info = [];
        if (!empty($auth_enabled)) {
            $user_info = $auth0->getUser();
        }
        return $user_info;
    }
}

/**
 * function auth0_complete
 *
 * Completes the auth0 logout process.
 *
 * @access  public
 *
 * @return  void
 */
if (!function_exists('auth0_complete')) {
    function auth0_complete()
    {
        global $auth0, $auth_enabled;
        if (!empty($auth_enabled)) {
            $auth0->logout();
            $return_to = base_url() . 'login';
            $logout_url = sprintf(
                'http://%s/v2/logout?client_id=%s&returnTo=%s',
                _cfg($auth_enabled . '_domain'),
                _cfg($auth_enabled . '_client_id'),
                $return_to
            );
            header('Location: ' . $logout_url);
        }
    }
}
