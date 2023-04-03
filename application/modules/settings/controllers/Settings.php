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
 * KyrandiaCMS Settings Module
 *
 * Contains the settings of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Settings extends MX_Controller
{
    public $delete_type = 'hard';
    public $page_limit = 25;

    /**
     * function __construct
     *
     * Initializes the module by loading language files, other modules, models, and also checking dependencies.
     *
     * @access public
     * @return void
     */
	function __construct()
	{

	    // Calls the parent's constructor
		parent::__construct();

		// Loads the module's resources
		_modules_load(['core', 'syslog', 'user', 'metadata']);
		_models_load(['settings/settings_model']);
		_languages_load(['settings/settings']);

        // Sets the settings for this module.
		_settings_check('settings');

        // Delete type
        if (empty($this->delete_type)) {
            $this->delete_type = $this->get_variable('delete_type');
            if (empty($this->delete_type)) {
                $this->delete_type = 'soft';
            }
        }
	}

    public function settings_hook()
    {
        $data['settings_name'] = [
            'field_type' => 'kcms_form_input',
            'tab_name' => 'Settings',
            'name' => 'settings_name',
            'id' => 'settings_name',
            'input_class' => 'input-group width-100',
            'label' => lang('settings_name_label'),
            'hint' => lang('settings_name_hint'),
            'placeholder' => lang('settings_name_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required']
        ];
        $data['settings_description'] = [
            'field_type' => 'kcms_form_textarea',
            'tab_name' => 'Settings',
            'id' => 'settings_description',
            'name' => 'settings_description',
            'input_class' => 'input-group-wide width-100',
            'label' => lang('settings_description_label'),
            'hint' => lang('settings_description_hint'),
            'placeholder' => lang('settings_description_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required']
        ];
        return $data;
    }

    public function admin_menu_hook()
    {
        return [
            'text' => 'Settings',
            'link' => 'settings/edit_settings',
            'icon' => 'shield-check',
            'type' => 'relative',
            'target' => 'self',
            'roles' => ['Super Administrator', 'Settings Manager'],
            'permissions' => ['Manage settings', 'Edit settings', 'View settings'],
            'order' => 0,
            'sub_menu_items' => []
        ];
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Settings' => [
                'actions' => [
                    $condition . 'edit_settings' => [
                        'roles' => ['Super Administrator', 'Settings Manager'],
                        'permissions' => ['Manage settings', 'Edit settings'],
                        'checkpoint' => [
                            'edit' => [
                                'roles' => ['Super Administrator']
                            ],
                            'view' => [
                                'roles' => ['Super Administrator', 'Settings Manager', 'Administrator'],
                                'permissions' => ['Manage settings', 'Edit settings', 'View settings']
                            ]
                        ]
                    ],
                ]
            ]
        ];
    }

    /**
     * edit_settings
     *
     * Allows changing of system settings.
     *
     * @access public
     *
     * @return array
     */
    public function edit_settings()
    {
        global $modules;
        global $theme;
		$can_open = current_user_can();
		$can_edit = current_user_can('edit');
        $can_view = current_user_can('view');
        if ($can_open || $can_edit || $can_view) {
            $posts = _post();
            $data['posts'] = $posts;
            $data['items'] = $this->settings_model->get_settings();
            $this->hooks->call_hook('module_settings');
            $this->hooks->call_hook('theme_settings');
            $data['primary']['form_open'] = [
                'id' => 'settings_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['primary']['form_close'] = [];
            $data['primary']['settings_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'label' => lang('settings_edit_button')
            ];
            if (!empty($modules)) {
                foreach ($modules['fields'] as $k => $v) {
                    $data['secondary'][$k] = $modules['fields'][$k];
                    $data['secondary'][$k]['value'] = _choose(
                        @$posts[$v['name']],
                        $v['name'],
                        (!empty($data['items'][$v['name']]['value']) ? $data['items'][$v['name']]['value'] : '')
                    );
                }
            }
            if (!empty($theme)) {
                foreach ($theme['fields'] as $k => $v) {
                    $data['secondary'][$k] = $theme['fields'][$k];
                    $data['secondary'][$k]['value'] = _choose(
                        @$posts[$v['name']],
                        $v['name'],
                        (!empty($data['items'][$v['name']]['value']) ? $data['items'][$v['name']]['value'] : '')
                    );
                }
            }
            if (!empty($theme['form_info'])) {
                $data['form_info'] = array_merge($modules['form_info'], $theme['form_info']);
            } else {
                $data['form_info'] = $modules['form_info'];
            }
            $data['data']['messages'] = [
                'heading' => lang('settings_edit_heading'),
                'prompt' => lang('settings_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to settings',
                        'link' => 'settings/edit_settings'
                    ]
                ]
            ];
            _validate($data['secondary']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $affected = $this->settings_model->edit_settings($data['data']['posts']);
                if ($affected) {
                    $success = lang('settings_edit_success');
                    _redir('success', $success, 'settings/edit_settings');
                } else {
                    $error = sprintf(lang('settings_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'settings/edit_settings');
                }
			}
			$data['success'] = _sess_get('success');
			$data['warning'] = _sess_get('warning');
			$data['notice'] = _sess_get('notice');
			$data['error'] = _sess_get('error');
            _render(_cfg('admin_theme'), 'settings/settings/edit_settings', $data);
        } else {
            _redir('error', lang('settings_edit_denied'), 'core/no_access');
        }
    }
}







