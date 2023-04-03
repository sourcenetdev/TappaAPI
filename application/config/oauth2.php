<?php
/**
 * KyrandiaCMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2020, Impero, all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 * @version   7.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Config
 *
 * This is the OAuth2 config file for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Configs
 * @category    Configs
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

// Facebook OAuth2
$config['facebook_app_id'] = '514423402512431';
$config['facebook_app_secret'] = '057a314f72f10608f791fbc7b6e5ef3a';
$config['facebook_callback_url'] = 'https://www.bliksempie.net/tribalwars/tools/fbauth/';
$config['facebook_graph_api_version'] = 'v4.0';

// Tribalwars OAuth2
$config['tribalwars_authorize_url'] = 'https://www.tribalwars.net/oauth2/authorize';
$config['tribalwars_access_token_url'] = 'https://www.tribalwars.net/oauth2/token';
$config['tribalwars_resource_owner_url'] = 'https://www.tribalwars.net/oauth2/user';
$config['tribalwars_client_id'] = 'bliksempie';
$config['tribalwars_client_secret'] = '4Ndr0m3d4TW!';
$config['tribalwars_redirect_url'] = 'https://www.bliksempie.net/tribalwars/tools/playerhome';

// Example of generated URL for TW.
// $config['tribalwars_generated_url'] = 'https://www.tribalwars.net/en-dk/oauth2/authorize?state=123&response_type=code&approval_prompt=auto&client_id=bliksempie'
