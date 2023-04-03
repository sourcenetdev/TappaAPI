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
 * KyrandiaCMS Layout Module
 *
 * This module enables the creation of layouts on the site.
 *
 * @package     Impero Consulting
 * @subpackage  Modules
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Layout extends MX_Controller
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
        _models_load(['layout/layout_model']);
        _languages_load(['layout/layout']);
        _helpers_load(['layout/layout']);

        // Sets the settings for this module.
        _settings_check('layout');
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Layout' => [
                'actions' => [
                    $condition . 'list_layouts' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage layouts'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add layouts', 'Manage layouts']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Edit layouts', 'Manage layouts']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete layouts', 'Manage layouts']
                            ]
                        ]
                    ],
                    $condition . 'add_layout' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add layouts', 'Manage layouts']
                    ],
                    $condition . 'edit_layout' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit layouts', 'Manage layouts']
                    ],
                    $condition . 'get_layouts' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage layouts']
                    ],
                    $condition . 'delete_layout' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete layouts', 'Manage layouts']
                    ],
                    $condition . 'export_layouts' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Export layouts', 'Manage layouts']
                    ]
                ]
            ],
        ];
    }

    /**
     * list_layouts
     *
     * Lists all layouts
     *
     * @access public
     *
     * @param int $start
     *
     * @return void
     */
    public function list_layouts($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->layout_model->get_layout_count(false);
            $data['hint'] = [
                'heading' => lang('layout_manage_heading'),
                'message' => lang('layout_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('layout_manage_empty'),
                'button' => lang('layout_add_button')
            ];
            $data['tabledata']['page_data'] = $this->layout_model->get_layout_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'layout_list';
            $data['tabledata']['url'] = 'layout/get_layouts';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'layout/add_layout',
                    'access' => current_user_can('add'),
                    'title' => lang('layout_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'layout/edit_layout',
                    'access' => current_user_can('edit'),
                    'title' => lang('layout_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'layout/delete_layout',
                    'access' => current_user_can('delete'),
                    'title' => lang('layout_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'layout',
                'model' => 'layout_model',
                'function' => 'get_layout_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('layout_system_layouts_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'layout/layouts/list_layouts', $data);
        } else {
            _redir('error', lang('layout_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_layout
     *
     * Adds a layout to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_layout()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_layout_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['layout_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('layout_name_label'),
                'hint' => lang('layout_name_hint'),
                'placeholder' => lang('layout_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['layout_file'] = [
                'name' => 'file',
                'id' => 'file',
                'input_class' => 'input-group width-100',
                'label' => lang('layout_file_label'),
                'hint' => lang('layout_file_hint'),
                'placeholder' => lang('layout_file_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['file'], 'file', '')
            ];
            $data['fields']['layout_areas'] = [
                'name' => 'areas',
                'id' => 'areas',
                'input_class' => 'input-group width-100',
                'label' => lang('layout_areas_label'),
                'hint' => lang('layout_areas_hint'),
                'placeholder' => lang('layout_areas_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['areas'], 'areas', '')
            ];
            $data['fields']['layout_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('layout_active_placeholder'),
                'label' => lang('layout_active_label'),
                'hint' => lang('layout_active_hint'),
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
            $data['fields']['layout_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('layout_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('layout_add_heading'),
                'prompt' => lang('layout_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to layout listing',
                        'link' => 'layout/list_layouts'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->layout_model->add_layout($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('layout_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'layout/list_layouts');
                } else {
                    $error = sprintf(lang('layout_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'layout/list_layouts');
                }
            }
            _render(_cfg('admin_theme'), 'layout/layouts/add_layout', $data);
        } else {
            _redir('error', lang('layout_add_denied'), 'layout/list_layouts');
        }
    }

    /**
     * edit_layout
     *
     * Modifies a layout.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_layout($id)
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['item'] = $this->layout_model->get_layout_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'edit_layout_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['layout_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('layout_name_label'),
                'hint' => lang('layout_name_hint'),
                'placeholder' => lang('layout_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['layout_file'] = [
                'name' => 'file',
                'id' => 'file',
                'input_class' => 'input-group width-100',
                'label' => lang('layout_file_label'),
                'hint' => lang('layout_file_hint'),
                'placeholder' => lang('layout_file_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['file'], 'file', $data['item'][0]['file'])
            ];
            $data['fields']['layout_areas'] = [
                'name' => 'areas',
                'id' => 'areas',
                'input_class' => 'input-group width-100',
                'label' => lang('layout_areas_label'),
                'hint' => lang('layout_areas_hint'),
                'placeholder' => lang('layout_areas_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['areas'], 'areas', $data['item'][0]['areas'])
            ];
            $data['fields']['layout_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('layout_active_placeholder'),
                'label' => lang('layout_active_label'),
                'hint' => lang('layout_active_hint'),
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
            $data['fields']['layout_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('layout_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('layout_edit_heading'),
                'prompt' => lang('layout_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to layout listing',
                        'link' => 'layout/list_layouts'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts']['id'] = $id;
                $affected = $this->layout_model->edit_layout($data['data']['posts']);
                if (!empty($affected)) {
                    $success = sprintf(lang('layout_edit_success'), $data['data']['posts']['name'], $id);
                    _redir('success', $success, 'layout/list_layouts');
                } else {
                    $error = sprintf(lang('layout_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'layout/list_layouts');
                }
            }
            _render(_cfg('admin_theme'), 'layout/layouts/edit_layout', $data);
        } else {
            _redir('error', lang('layout_edit_denied'), 'layout/list_layouts');
        }
    }

     /**
     * delete_layout
     *
     * Deletes a layout from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_layout($id)
    {
        if (current_user_can()) {
            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['layout_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('layout_delete_button'),
                'input_class' => 'btn-primary',
            ];
            $data['id'] = $id;
            $data['item'] = $this->layout_model->get_layout_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => _cfg('db_prefix') . 'layout',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Layout' => 'name',
                'Slug' => 'slug',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to layout listing',
                        'link' => 'layout/list_layouts'
                    ]
                ],
                'view' => 'layout/layouts/delete_confirm',
                'redirect' => 'layout/list_layouts',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('layout_delete_heading'),
                'prompt' => lang('layout_delete_prompt'),
                'success' => lang('layout_delete_success'),
                'error' => lang('layout_delete_error'),
                'warning' => lang('layout_delete_warn'),
                'return' => lang('layout_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('layout_delete_denied'), 'layout/list_layouts');
        }
    }

    /**
     * function get_layouts
     *
     * Retrieves all layouts for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_layouts()
    {
        $check = _grid_open();
        $layouts = $this->layout_model->get_layout_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->layout_model->get_layout_count(false, $check['search']);
        $final = _grid_close($check, $layouts, $count);
        echo $final;
    }
}
