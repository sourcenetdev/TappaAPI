<?php
/**
 * KyrandiaCMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero Consulting
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2020, Impero Consulting (Pty) Ltd., all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 * @version   6.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Theme Module
 *
 * This module enables the creation of themes on the site.
 *
 * @package     Impero Consulting
 * @subpackage  Modules
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Theme extends MX_Controller
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

        // Initializes the class
        parent::__construct();

        // Loads the module's resources.
        _models_load(['theme/theme_model']);
        _languages_load(['theme/theme']);
        _helpers_load(['theme/theme']);

        // Sets the settings for this module.
        _settings_check('theme');
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Theme' => [
                'actions' => [
                    $condition . 'list_themes' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage themes'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add themes', 'Manage themes']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Edit themes', 'Manage themes']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete themes', 'Manage themes']
                            ]
                        ]
                    ],
                    $condition . 'add_theme' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add themes', 'Manage themes']
                    ],
                    $condition . 'edit_theme' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit themes', 'Manage themes']
                    ],
                    $condition . 'get_themes' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage themes']
                    ],
                    $condition . 'delete_theme' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete themes', 'Manage themes']
                    ],
                    $condition . 'export_themes' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Export themes', 'Manage themes']
                    ]
                ]
            ],
        ];
    }

    /**
     * list_themes
     *
     * Lists all themes
     *
     * @access public
     *
     * @param int $start
     *
     * @return void
     */
    public function list_themes($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->theme_model->get_theme_count(false);
            $data['hint'] = [
                'heading' => lang('theme_manage_heading'),
                'message' => lang('theme_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('theme_manage_empty'),
                'button' => lang('theme_add_button')
            ];
            $data['tabledata']['page_data'] = $this->theme_model->get_theme_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'theme_list';
            $data['tabledata']['url'] = 'theme/get_themes';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'theme/add_theme',
                    'access' => current_user_can('add'),
                    'title' => lang('theme_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'theme/edit_theme',
                    'access' => current_user_can('edit'),
                    'title' => lang('theme_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'theme/delete_theme',
                    'access' => current_user_can('delete'),
                    'title' => lang('theme_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'theme',
                'model' => 'theme_model',
                'function' => 'get_theme_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('theme_system_themes_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'theme/themes/list_themes', $data);
        } else {
            _redir('error', lang('theme_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_theme
     *
     * Adds a theme to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_theme()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_theme_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['theme_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('theme_name_label'),
                'hint' => lang('theme_name_hint'),
                'placeholder' => lang('theme_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['theme_file'] = [
                'name' => 'file',
                'id' => 'file',
                'input_class' => 'input-group width-100',
                'label' => lang('theme_file_label'),
                'hint' => lang('theme_file_hint'),
                'placeholder' => lang('theme_file_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['file'], 'file', '')
            ];
            $data['fields']['theme_areas'] = [
                'name' => 'areas',
                'id' => 'areas',
                'input_class' => 'input-group width-100',
                'label' => lang('theme_areas_label'),
                'hint' => lang('theme_areas_hint'),
                'placeholder' => lang('theme_areas_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['areas'], 'areas', '')
            ];
            $data['fields']['theme_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('theme_active_placeholder'),
                'label' => lang('theme_active_label'),
                'hint' => lang('theme_active_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => [
                    lang('core_yes') => lang('core_yes'),
                    lang('core_no') => lang('core_no')
                ],
                'value' => _choose(@$data['data']['posts']['active'], 'active', '')
            ];
            $data['fields']['theme_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('theme_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('theme_add_heading'),
                'prompt' => lang('theme_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to theme listing',
                        'link' => 'theme/list_themes'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->theme_model->add_theme($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('theme_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'theme/list_themes');
                } else {
                    $error = sprintf(lang('theme_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'theme/list_themes');
                }
            }
            _render(_cfg('admin_theme'), 'theme/themes/add_theme', $data);
        } else {
            _redir('error', lang('theme_add_denied'), 'theme/list_themes');
        }
    }

    /**
     * edit_theme
     *
     * Modifies a theme.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_theme($id)
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['item'] = $this->theme_model->get_theme_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'edit_theme_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['theme_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('theme_name_label'),
                'hint' => lang('theme_name_hint'),
                'placeholder' => lang('theme_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['theme_file'] = [
                'name' => 'file',
                'id' => 'file',
                'input_class' => 'input-group width-100',
                'label' => lang('theme_file_label'),
                'hint' => lang('theme_file_hint'),
                'placeholder' => lang('theme_file_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['file'], 'file', $data['item'][0]['file'])
            ];
            $data['fields']['theme_areas'] = [
                'name' => 'areas',
                'id' => 'areas',
                'input_class' => 'input-group width-100',
                'label' => lang('theme_areas_label'),
                'hint' => lang('theme_areas_hint'),
                'placeholder' => lang('theme_areas_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['areas'], 'areas', $data['item'][0]['areas'])
            ];
            $data['fields']['theme_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('theme_active_placeholder'),
                'label' => lang('theme_active_label'),
                'hint' => lang('theme_active_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => [
                    lang('core_yes') => lang('core_yes'),
                    lang('core_no') => lang('core_no')
                ],
                'value' => _choose(@$data['data']['posts']['active'], 'active', $data['item'][0]['active'])
            ];
            $data['fields']['theme_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('theme_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('theme_edit_heading'),
                'prompt' => lang('theme_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to theme listing',
                        'link' => 'theme/list_themes'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts']['id'] = $id;
                $affected = $this->theme_model->edit_theme($data['data']['posts']);
                if (!empty($affected)) {
                    $success = sprintf(lang('theme_edit_success'), $data['data']['posts']['name'], $id);
                    _redir('success', $success, 'theme/list_themes');
                } else {
                    $error = sprintf(lang('theme_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'theme/list_themes');
                }
            }
            _render(_cfg('admin_theme'), 'theme/themes/edit_theme', $data);
        } else {
            _redir('error', lang('theme_edit_denied'), 'theme/list_themes');
        }
    }

     /**
     * delete_theme
     *
     * Deletes a theme from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_theme($id)
    {
        if (current_user_can()) {
            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['theme_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('theme_delete_button'),
                'input_class' => 'btn-primary',
            ];
            $data['id'] = $id;
            $data['item'] = $this->theme_model->get_theme_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => _cfg('db_prefix') . 'theme',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Theme' => 'name',
                'Slug' => 'slug',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to theme listing',
                        'link' => 'theme/list_themes'
                    ]
                ],
                'view' => 'theme/themes/delete_confirm',
                'redirect' => 'theme/list_themes',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('theme_delete_heading'),
                'prompt' => lang('theme_delete_prompt'),
                'success' => lang('theme_delete_success'),
                'error' => lang('theme_delete_error'),
                'warning' => lang('theme_delete_warn'),
                'return' => lang('theme_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('theme_delete_denied'), 'theme/list_themes');
        }
    }

    /**
     * function get_themes
     *
     * Retrieves all themes for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_themes()
    {
        $check = _grid_open();
        $themes = $this->theme_model->get_theme_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->theme_model->get_theme_count(false, $check['search']);
        $final = _grid_close($check, $themes, $count);
        echo $final;
    }
}
