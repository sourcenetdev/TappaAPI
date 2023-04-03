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
 * Contains the language strings for the Core module of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Config
 * @category    Language
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
$lang['core_bad_bot'] = 'You are a silly little robot, aren\'t you?';
$lang['core_possible_spambot'] = 'Possible bot actions blocked.';
$lang['core_404_broken_link_on_site'] = '<p>It looks like we have a broken link on the site (%s)</p><p>The address you have tried to reach is: %s.</p><p>We have been notified and we\'ll get it fixed as soon as possible.</p><p>Please use your browser\'s back button to return to the referring page.</p>';
$lang['core_404_another_site'] = '<p>It looks like you came from another site with a broken link</p><p>We have been notified and we\'ll try to get hold of %s\'s owners to get it fixed as soon as possible.</p><p>Please use your browser\'s back button to return to the referring page.</p>';
$lang['core_404_search_engine'] = '<p>It looks like you came from a search engine with a broken link</p><p>We have been notified and we\'ll get it fixed as soon as possible.</p><p>Please use your browser\'s back button to return to the referring page.</p>';
$lang['core_404_direct'] = '<p>It looks like you came directly to this page (%s%s), either by typing the URL or from a bookmark.</p><p>Please make sure the address you have typed or bookmarked is correct - if it is, then unfortunately the page is no longer available.</p><p>Please use your browser\'s back button to return to the referring page.</p>';
$lang['core_404_title'] = 'Sorry, but the page you requested was not found';
$lang['core_browser_non_html'] = "Your e-mail reader does not support HTML mails.";
$lang['core_page_not_found'] = '404 - Sorry, but the page you requested was not found';
$lang['core_label_origin'] = 'Origin';
$lang['core_405'] = '405 - Method not allowed: A dependency on module %s for module %s has failed. Please check the configuration files for the particular module to troubleshoot.';
$lang['core_dependency_error'] = 'Dependency error';
$lang['core_dependency_error_1'] = 'There is a dependency problem with the %s module.';
$lang['core_dependency_error_2'] = 'The following modules did not meet the minimum requirements. Please check your modules\' configuration files.';
$lang['core_dependency_error_possible_reasons'] = 'Possible reasons for this include:';
$lang['core_dependency_error_inactive'] = 'The module is not active';
$lang['core_dependency_error_missing_settings'] = 'The module is missing its <strong>settings.php</strong> file at';
$lang['core_dependency_error_incorrect_version'] = 'The module that this module depends upon is the incorrect version';
$lang['core_dependency_error_dependent_inactive'] = 'One of the modules that this module depends on, may be inactive';
$lang['core_dependency_error_cta'] = 'This page can not be displayed until this error is rectified.';
$lang['core_page_actions'] = 'Page actions';
$lang['core_page_actions_head'] = 'The following actions are available to you:';
$lang['core_errors_exist'] = 'There are errors in your form. Please check below and rectify to continue.';
$lang['core_return_cpanel'] = 'Return to Control Panel';
$lang['core_return_referrer'] = 'Return to %s';
$lang['core_actions_name'] = 'Actions';
$lang['core_view_more_label'] = 'View %d more';
$lang['core_submit_submit'] = 'Submit';
$lang['core_delete_warn'] = 'This will affect all features depending of this item, everywhere it is used, including relative data, and depending on your CMS setup, this action may have consequences that cannot be undone. <strong>Are you sure you want to continue?</strong>';
$lang['core_yes'] = 'Yes';
$lang['core_no'] = 'No';
$lang['core_value'] = 'Value';
$lang['core_slug'] = 'Slug';
$lang['core_version'] = 'Version';
$lang['core_name'] = 'Name';
$lang['core_link'] = 'Link';
$lang['core_username'] = 'Username';
$lang['core_description'] = 'Description';
$lang['core_email'] = 'Email address';
$lang['core_password'] = 'Password';
$lang['core_self'] = 'Same window (_self)';
$lang['core_blank'] = 'New window (_blank)';
$lang['core_confirm_password'] = 'Confirm password';
$lang['core_select_at_least'] = 'Enter at least %1$d character(s).';
$lang['core_test_email_active'] = 'Email sending is set to test mode, which means that all emails sent by the system will send to your test email address. No actual user will receive any email communication in test mode.';
$lang['core_please_select'] = 'Please select...';