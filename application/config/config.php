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
 * This is the core config file for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Configs
 * @category    Configs
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

// Basic
$config['domain'] =  'api.tappa.co.za';
$config['sitename'] = 'Kyrandia CMS 7.0 Demo';
$config['site_description'] = 'Demo';
$config['admin_name'] = 'Kobus Myburgh';
$config['admin_address'] = 'kobus.myburgh@impero.co.za';
$config['no_reply_address'] = 'no-reply@impero.co.za';
$config['no_reply_address_name'] = $config['sitename'];
$config['charset'] = 'UTF-8';
$config['site_author'] = 'Impero Consulting';
$config['encryption_key'] = 'uUl$XnCt?]p0J8C<FWCv1iq4(]/Pf?Hk';
$config['use_https'] = FALSE;
$config['db_prefix'] = 'kcms_';

// Admin
$config['user_role_validity'] = 86400 * 365 * 10;
$config['show_effective_permissions'] = false;

// Themes path is relative to APPPATH . 'views';
$config['themes_path'] = 'themes';
$config['current_theme'] = 'askgogo';
$config['admin_theme'] = 'admin';
$config['login_theme'] = 'login';

// Color schemes for admin - front-end you make your own theme (for now). This is not yet fully functional.
$config['light'] = [
    'primary' => 'blue',
    'secondary' => 'cyan',
    'header_back' => '#12587A',
    'sidebar_back' => '#ffffff',
    'sidebar_front' => '#3333333',
    'main_menu_class' => 'main-menu',
    'sub_menu_class' => 'sub-menu-light'
];
$config['dark'] = [
    'primary' => 'blue',
    'secondary' => 'cyan',
    'header_back' => '#222222',
    'sidebar_back' => '#222222',
    'body_back' => '#f0f0f0',
    'sidebar_front' => '#ffffff',
    'main_menu_class' => 'main-menu-dark',
    'sub_menu_class' => 'sub-menu-dark'
];
$config['admin_color'] = $config['dark'];

// Social
$config['fb_app_id'] = '';
$config['fb_app_secret'] = '';
$config['twitter_handle'] = '';

// SMS Portal
$config['smsportal_url'] = 'http://www.mymobileapi.com/api5/http5.aspx';
$config['smsportal_password'] = 'xxx';
$config['smsportal_username'] = 'impero';
$config['smsportal_short_code'] = '44541';
$config['smsportal_connect_error'] = 'Could not connect to the SMS service.';

// Hooks
$config['which_auth'] = 'auth0';

// Auth0
$config['auth0_enabled'] = false;
$config['auth0_location'] = APPPATH . 'modules/user/hooks/';
$config['auth0_file'] = 'auth0_hook.php';
$config['auth0_domain'] = 'dev-lq7p8rps.auth0.com';
$config['auth0_client_id'] = 'mFY048Q2PAQfiOrQUWwt6D07G2xiTngc';
$config['auth0_client_secret'] = 'zaaAaO_7sdwELo6IeA6nEbzaQ1oHHpAMzbrHucpOzqhDqtBzQcpYjC3hYqPV_sWu';
$config['auth0_redirect_uri'] = 'https://www.kyrandia.co.za/control-panel';
$config['auth0_scope'] = 'openid profile email';


// NO NEED TO EDIT BELOW THIS POINT, UNLESS YOU ABSOLUTELY DESIRE TO DO SO AND KNOW WHAT YOU ARE DOING.


// Modules
$config['modules_locations'] = array(APPPATH . 'modules/' => '../modules/');

// General
$config['protocol'] = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";

// CodeIgniter
$config['base_url'] = $config['protocol'] . $config['domain'] . '/';
$config['index_page'] = '';
$config['uri_protocol']	= 'AUTO';
$config['url_suffix'] = '';
$config['allow_get_array'] = TRUE;
$config['error_views_path'] = '';
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['enable_hooks'] = TRUE;
$config['subclass_prefix'] = 'MY_';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-=+,';

// Logging
$config['log_threshold'] = 1;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

// Caching
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;

// Sessions
$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'icmssession';
$config['sess_expiration'] = 86400;
$config['sess_save_path'] = $config['db_prefix'] . 'session';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = TRUE;
$config['sess_table_name'] = $config['db_prefix'] . 'session';

// Cookies
$config['cookie_domain'] = $config['domain'];
$config['cookie_path'] = '/';
$config['cookie_secure'] = $config['use_https'];

// Composer
$config['composer_autoload'] = APPPATH . '../vendor/autoload.php';

// CSRF
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = FALSE;
$config['csrf_protection'] = FALSE;
$config['csrf_exclude_uris'] = ['api/[a-zA-Z0-9_-]+', '[a-zA-Z0-9_-]*list_[a-zA-Z0-9_-]*'];
$config['csrf_token_name'] = 'csrfkcmstoken';
$config['csrf_cookie_name'] = 'csrfkcmscookie';

// Other
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
$config['language']	= 'en';
$config['cache_placeholders'] = FALSE;

// Passwords and security
$config['rounds'] = 8;
$config['password_uses_numbers'] = true;
$config['password_uses_capitals'] = true;
$config['password_uses_lowercase'] = true;
$config['password_uses_specials'] = true;
$config['password_min_length'] = 6;
$config['password_max_length'] = 64;
$config['password_no_username'] = true;
$config['password_length'] = 8;

// Error handling and debugging
$config['debug'] = TRUE;
$config['error_log_errors'] = TRUE;
$config['error_show_errors'] = TRUE;
$config['error_show_error_detail'] = 5;
$config['error_log_error_detail'] = 5;
$config['error_show_args'] = FALSE;
$config['error_trace_level'] = 5;
$config['error_skip_keys'] = ['type'];


// GO ON FROM HERE!


// PASSWORD SETTINGS
$config['password_attempts'] = 6;
$config['temp_password_validity'] = 4;
$config['registration_roles'] = array(2);
$config['registration_type'] = 'User';
$config['audit'] = 'Yes';
$config['login_redirect'] = 'login';

// Some variables for use in code. Could've used CONSTANTS, but using config variables as there is then just one file to edit...
$config['subfolder'] = '';
$config['header_color'] = '#333333';

// DEPRECATED
$config['url_key'] = 'Dx++Rf';
$config['languages_string'] = 'en:english|af:afrikaans'; // MUST HAVE! Most complete language must be listed first, as incompleted languages are filled from there. Thinking of a way to combine these two without convolution.
$config['language_codes'] = 'en|af'; // Most complete language must be listed first, as incompleted languages are filled from there
$config['lame_numeric_scrambler'] = 1357924680;
$config['password_refused_list'] = 'god:dog:password:qwerty:1234:12345:123456:pass:p@ssw0rd:p@55w0rd'; // Unused at the moment.
$config['password_force_duration'] = 90; // Unused at the moment.
$config['password_specials'] = '*@. ,|;:()[]{}+=!$#%^&-_?<>'; // Unused at the moment.
$config['password_period'] = 12; // Unused at the moment.
