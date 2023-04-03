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
 * KyrandiaCMS Cornerstone Library - Oauth2 Functions
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

class CSOauth2 {

    public $provider;
    protected $token;
    protected $ci;
    public $user;

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
        $this->ci =& get_instance();
        $this->ci->load->config('oauth2');
        $this->token = NULL;
        $this->provider = NULL;
        $this->user = NULL;
    }

    /**
     * function get_user()
     *
     * Retrieves the user's data.
     *
     * @access public
     *
     * @return void
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * function set_provider_tribalwars()
     *
     * Sets Tribalwars as the authentication provider.
     *
     * @access public
     *
     * @return void
     */
    public function setProviderTribalwars()
    {

        // Initialize
        $this->provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId' => _cfg('tribalwars_client_id'),
            'clientSecret' => _cfg('tribalwars_client_secret'),
            'redirectUri' => _cfg('tribalwars_redirect_url'),
            'urlAuthorize' => _cfg('tribalwars_authorize_url'),
            'urlAccessToken' => _cfg('tribalwars_access_token_url'),
            'urlResourceOwnerDetails' => _cfg('tribalwars_resource_owner_url')
        ]);

        // Check for auth code.
        $code = $this->ci->input->get('code');
        $state = $this->ci->input->get('state');
        if (empty($code)) {

            // If we don't have an authorization code then get one
            $authUrl = $this->provider->getAuthorizationUrl();
            _sess_set('oauth2state', $this->provider->getState());
            $link['link'] = '<a class="btn btn-primary" href="' . $authUrl . '">Log in with Tribalwars</a>';
            $link['state'] = 'button';
            return $link;
        } elseif (empty($state) || ($state !== _sess_get('oauth2state'))) {

            // Check given state against previously stored one to mitigate CSRF attack
            $this->ci->session->unset_userdata('oauth2state');
            echo '<div class="alert alert-danger">Invalid state - cannot generate login button.</div>';
        } else {

            // Try to get an access token (using the authorization code grant)
            try {
                if (!empty($code)) {
                    $this->token = $this->provider->getAccessToken('authorization_code', ['code' => $code]);
                }
                $this->user = (array)$this->get_provider_tribalwars_userdata();
                return $this->user["\0*\0" . 'response'];
            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

                // Failed to get the access token or user details.
                exit($e->getMessage());
            }
        }
    }

    /**
     * function getProviderTribalwarsUserdata()
     *
     * Retrieves the user's Tribalwars data.
     *
     * @access public
     *
     * @return void
     */
    public function getProviderTribalwarsUserdata()
    {
        try {
            return $this->provider->getResourceOwner($this->token);
        } catch (\Exception $e) {
            exit('We do not have any information on the user. Oh dear...');
        }
    }

    /**
     * function setProviderFacebook()
     *
     * Sets Facebook as the authentication provider.
     *
     * @access public
     *
     * @return void
     */
    public function setProviderFacebook()
    {

        // Initialize
        $this->provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId' => _cfg('facebook_app_id'),
            'clientSecret' => _cfg('facebook_app_secret'),
            'redirectUri' => _cfg('facebook_callback_url'),
            'graphApiVersion' => _cfg('facebook_graph_api_version'),
        ]);

        // Check for auth code.
        $code = $this->ci->input->get('code');
        $state = $this->ci->input->get('state');
        if (empty($code)) {

            // If we don't have an authorization code then get one
            $authUrl = $this->provider->getAuthorizationUrl([
                'scope' => ['email', 'public_profile'],
            ]);
            _sess_set('oauth2state', $this->provider->getState());
            echo '<a class="btn btn-primary" href="' . $authUrl . '">Log in with Facebook</a>';
        } elseif (empty($state) || ($state !== _sess_get('oauth2state'))) {

            // Check given state against previously stored one to mitigate CSRF attack
            $this->session->unset_userdata('oauth2state');
            echo '<div class="alert alert-danger">Invalid FB state - cannot generate login button.</div>';
        }

        // Try to get an access token (using the authorization code grant)
        if (!empty($code)) {
            $this->token = $this->provider->getAccessToken('authorization_code', ['code' => $code]);
        }
    }

    /**
     * function getProviderFacebookUserdata()
     *
     * Retrieves the user's Facebook data.
     *
     * @access public
     *
     * @return void
     */
    public function getProviderFacebookUserdata()
    {
        try {
            $user = $this->provider->getResourceOwner($this->token);
            return $user;
        } catch (\Exception $e) {
            exit('We do not have any information on the user. Oh dear...');
        }
    }
}
