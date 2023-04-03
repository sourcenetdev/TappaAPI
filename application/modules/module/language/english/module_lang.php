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
 * KyrandiaCMS Module Module
 *
 * Contains the language strings for the Module module of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Config
 * @category    Language
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

$lang['module_module_edit_button'] = 'Edit module';
$lang['module_module_edit_heading'] = 'Edit module';
$lang['module_module_edit_prompt'] = 'Please complete all the fields to edit this module.';
$lang['module_module_edit_success'] = 'You have successfully edited the module <strong>%1$s</strong> (ID: %2$d).';
$lang['module_module_edit_error'] = 'We could not edit the module <strong>%1$s</strong>. If this persists, please contact an administrator.';
$lang['module_module_edit_denied'] = 'You do not have permission to edit modules.';
$lang['module_module_add_button'] = 'Add module';
$lang['module_module_add_heading'] = 'Add module';
$lang['module_module_add_prompt'] = 'Please complete all the fields to add a module.';
$lang['module_module_add_success'] = 'You have successfully added the module <strong>%1$s</strong> (ID: %2$d).';
$lang['module_module_add_error'] = 'We could not add the module <strong>%1$s</strong>. If this persists, please contact an administrator.';
$lang['module_module_add_denied'] = 'You do not have permission to add modules.';
$lang['module_module_delete_button'] = 'Delete module';
$lang['module_module_delete_heading'] = 'Delete module';
$lang['module_module_delete_prompt'] = 'Are you sure you want to delete this module?';
$lang['module_module_delete_success'] = 'The module was successfully deleted.';
$lang['module_module_delete_error'] = 'The module could not be deleted.';
$lang['module_module_delete_denied'] = 'You do not have permission to delete modules';
$lang['module_module_delete_return'] = 'Go back to the modules listing.';
$lang['module_module_manage_heading'] = 'Manage modules';
$lang['module_module_manage_hint'] = 'Here is a list of modules. You can add new modules by clicking on the Add button below, or edit or delete existing ones by clicking its corresponding Edit or Delete icon.';
$lang['module_module_manage_empty'] = 'We could not find any modules to list.';
$lang['module_module_manage_denied'] = 'You do not have permission to manage modules';
$lang['module_module_system_modules_export'] = 'System modules export';
$lang['module_module_field_active_label'] = 'Active';
$lang['module_module_field_active_hint'] = 'Select whether this module is active or not.';
$lang['module_module_field_active_placeholder'] = 'Click to select';
$lang['module_module_field_required_label'] = 'Required?';
$lang['module_module_field_required_hint'] = 'Select whether this module is required or not - if required, it cannot be disabled.';
$lang['module_module_field_required_placeholder'] = 'Click to select';
$lang['module_module_field_slug_label'] = 'Slug';
$lang['module_module_field_slug_placeholder'] = 'Enter the module\'s slug here.';
$lang['module_module_field_slug_hint'] = 'A slug is a name that is unique for a module. Like a name space, for example, this module\'s slug is "module".';
$lang['module_module_field_version_placeholder'] = 'Enter the version of the module in semantic versioning style, e.g., 6.0.1.';
$lang['module_module_field_description_placeholder'] = 'Enter the module description here.';
$lang['module_module_field_name_placeholder'] = 'Enter the module name here.';
$lang['module_module_field_author_label'] = 'Author';
$lang['module_module_field_author_hint'] = 'Enter at least 1 character.';
$lang['module_module_field_author_placeholder'] = 'Enter the author\'s name here.';
$lang['module_module_field_author_site_label'] = 'Author website';
$lang['module_module_field_author_site_hint'] = 'Enter at least 1 character.';
$lang['module_module_field_author_site_placeholder'] = 'Enter the author\'s website here.';
$lang['module_module_field_author_contact_label'] = 'Author primary contact';
$lang['module_module_field_author_contact_hint'] = 'Enter at least 1 character.';
$lang['module_module_field_author_contact_placeholder'] = 'Enter the author\'s primary contact details here.';
$lang['module_module_field_status_label'] = 'Status';
$lang['module_module_field_status_hint'] = 'Select the module\'s status';
$lang['module_module_field_status_placeholder'] = 'Choose the module\'s current status.';
$lang['module_module_field_category_label'] = 'Category';
$lang['module_module_field_category_hint'] = 'Select the module\'s category';
$lang['module_module_field_category_placeholder'] = 'Choose the module\'s primary category.';
$lang['module_module_return_button'] = 'Return to module listing';
$lang['module_module_item_list_button'] = 'List menu items for this module.';
$lang['module_module_disable_heading'] = 'Disable module';
$lang['module_module_disable_button'] = 'Disable module';
$lang['module_module_disable_prompt'] = 'Are you sure you want to disable this module?';
$lang['module_module_disable_success'] = 'The module was successfully disabled.';
$lang['module_module_disable_error'] = 'The module could not be disabled.';
$lang['module_module_disable_denied'] = 'You do not have permission to disable modules.';
$lang['module_module_disable_return'] = 'Go back to the modules listing.';
$lang['module_module_disable_warn'] = 'A disabled module will be cause modules depending on it to possibly malfunction. <strong>Are you sure you want to continue?</strong>';
$lang['module_module_enable_heading'] = 'Enable module';
$lang['module_module_enable_button'] = 'Enable module';
$lang['module_module_enable_prompt'] = 'Are you sure you want to enable this module?';
$lang['module_module_enable_success'] = 'The module was successfully enabled.';
$lang['module_module_enable_error'] = 'The module could not be enabled.';
$lang['module_module_enable_denied'] = 'You do not have permission to enable modules.';
$lang['module_module_enable_return'] = 'Go back to the modules listing.';
$lang['module_module_enable_warn'] = 'An enabled module may cause issues if not in "Maintained" state, causing modules depending on it to possibly malfunction. <strong>Are you sure you want to continue?</strong>';
