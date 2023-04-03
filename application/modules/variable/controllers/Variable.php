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
 * KyrandiaCMS Variable Module
 *
 * Contains the variable features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Variable extends MX_Controller
{
    public $delete_type = 'hard';
    public $page_limit = 25;

    /**
     * __construct
     *
     * Initializes the module by loading language files, other modules, models, and also checking dependencies.
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {

        // Executes the parent's constructor.
        parent::__construct();

        // Loads this module's resources
        _modules_load(['syslog', 'metadata', 'core']);
        _models_load(['variable/variable_model']);
        _languages_load(['core/core', 'variable/variable']);
        _helpers_load(['variable/variable']);

        // Sets the settings for this module.
        _settings_check('variable');

        // Delete type
        if (empty($this->delete_type)) {
            $this->delete_type = $this->get_variable('delete_type');
            if (empty($this->delete_type)) {
                $this->delete_type = 'soft';
            }
        }
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Variable' => [
                'actions' => [
                    $condition . 'list_variables_data' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage variables'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add variables', 'Manage variables']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add variables', 'Manage variables']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete variables', 'Manage variables']
                            ]
                        ]
                    ],
                    $condition . 'add_variable' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add variables', 'Manage variables']
                    ],
                    $condition . 'edit_variable' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit variables', 'Manage variables']
                    ],
                    $condition . 'get_variables' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage variables']
                    ],
                    $condition . 'delete_variable' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete variables', 'Manage variables']
                    ]
                ]
            ]
        ];
    }

    /**
     * add_variable
     *
     * Adds a variable to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_variable()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_variable_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['variable_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('core_name'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('variable_variable_field_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['variable_value'] = [
                'id' => 'value',
                'name' => 'value',
                'placeholder' => lang('variable_variable_field_value_placeholder'),
                'input_class' => 'input-group-wide width-100',
                'label' => lang('core_value'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['value'], 'value', '')
            ];
            $data['fields']['variable_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('variable_variable_field_active_placeholder'),
                'label' => lang('variable_variable_field_active_label'),
                'hint' => lang('variable_variable_field_active_hint'),
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
            $data['fields']['variable_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('variable_variable_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('variable_variable_add_heading'),
                'prompt' => lang('variable_variable_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to variable listing',
                        'link' => 'variable/list_variables_data'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->variable_model->add_variable($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('variable_variable_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'variable/list_variables_data');
                } else {
                    $error = sprintf(lang('variable_variable_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'variable/list_variables_data');
                }
            }
            _render(_cfg('admin_theme'), 'variable/variables/add_variable', $data);
        } else {
            _redir('error', lang('variable_variable_add_denied'), 'variable/list_variables_data');
        }
    }

    /**
     * edit_variable
     *
     * Edits a variable in the database.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_variable($id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] = $posts;
            $data['item'] = $this->variable_model->get_variable_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'add_variable_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['variable_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('core_name'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('variable_variable_field_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['variable_value'] = [
                'id' => 'value',
                'name' => 'value',
                'placeholder' => lang('variable_variable_field_value_placeholder'),
                'input_class' => 'input-group-wide width-100',
                'label' => lang('core_value'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['value'], 'value', $data['item'][0]['value'])
            ];
            $data['fields']['variable_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('variable_variable_field_active_placeholder'),
                'label' => 'Active',
                'hint' => lang('variable_variable_field_active_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['active'], 'active', $data['item'][0]['active']),
                'options' => [
                    lang('core_yes') => lang('core_yes'),
                    lang('core_no') => lang('core_no')
                ],
                'value' => _choose(@$posts['active'], 'active', '')
            ];
            $data['fields']['variable_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'label' => lang('variable_variable_edit_button')
            ];
            $data['data']['messages'] = [
                'heading' => lang('variable_variable_edit_heading'),
                'prompt' => lang('variable_variable_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to variable listing',
                        'link' => 'variable/list_variables_data'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->variable_model->edit_variable($data['data']['posts']);
                if ($affected) {
                    $success = sprintf(lang('variable_variable_edit_success'), $data['data']['posts']['name'], $data['id']);
                    _redir('success', $success, 'variable/list_variables_data');
                } else {
                    $error = sprintf(lang('variable_variable_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'variable/list_variables_data');
                }
            }
            _render(_cfg('admin_theme'), 'variable/variables/edit_variable', $data);
        } else {
            _redir('error', lang('variable_variable_edit_denied'), 'variable/list_variables_data');
        }
    }

    /**
     * delete_variable
     *
     * Deletes a variable from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_variable($id)
    {
        if (current_user_can()) {

            // Form elements
            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['variable_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('variable_variable_delete_button'),
                'input_class' => 'btn-primary',
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->variable_model->get_variable_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => _cfg('db_prefix') . 'variable',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Name' => 'name',
                'Value' => 'value',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to variable listing',
                        'link' => 'variable/list_variables_data'
                    ]
                ],
                'view' => 'variable/variables/delete_confirm',
                'redirect' => 'variable/list_variables_data',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('variable_variable_delete_heading'),
                'prompt' => lang('variable_variable_delete_prompt'),
                'success' => lang('variable_variable_delete_success'),
                'error' => lang('variable_variable_delete_error'),
                'warning' => lang('core_delete_warn'),
                'return' => lang('variable_variable_delete_return')
            ];
            delete_items($data);
        } else {
            _redir('error', lang('variable_variable_delete_denied'), 'core/no_access');
        }
    }

    /**
     * list_variables
     *
     * Lists all variables
     *
     * @access public
     *
     * @param int $start
     *
     * @return void
     */
    public function list_variables_data($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->variable_model->get_variable_count(false);
            $data['hint'] = [
                'heading' => lang('variable_variable_manage_heading'),
                'message' => lang('variable_variable_manage_hint'),
            ];
            $data['empty'] = [
                'message' => lang('variable_variable_manage_empty'),
                'button' => lang('variable_variable_add_button')
            ];
            $data['tabledata']['page_data'] = $this->variable_model->get_variable_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'variables_list';
            $data['tabledata']['url'] = 'variable/get_variables';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'variable/add_variable',
                    'access' => current_user_can('add'),
                    'title' => lang('variable_variable_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'variable/edit_variable',
                    'access' => current_user_can('edit'),
                    'title' => lang('variable_variable_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'variable/delete_variable',
                    'access' => current_user_can('delete'),
                    'title' => lang('variable_variable_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => '',
                'model' => 'variable_model',
                'function' => 'get_variable_list',
                'parameters' => []
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => '',
                'model' => 'variable_model',
                'function' => 'get_variable_list',
                'parameters' => [
                    'type' => 'table',
                    'template' => 'template_pdf',
                    'title' => lang('variable_variable_system_variables_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'variable/variables/list_variables', $data);
        } else {
            _redir('error', lang('variable_variable_manage_denied'), 'core/no_access');
        }
    }

    /**
     * get_variables
     *
     * Returns variables
     *
     * @access public
     *
     * @return void
     */
    public function get_variables()
    {
        $check = _grid_open();
        $variables = $this->variable_model->get_variable_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->variable_model->get_variable_count(false, $check['search']);
        $final = _grid_close($check, $variables, $count);
        echo $final;
    }
}
