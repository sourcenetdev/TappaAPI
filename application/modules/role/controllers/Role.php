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
 * KyrandiaCMS Role module
 *
 * This is the main controller file for KyrandiaCMS's role module.
 *
 * @package     Impero
 * @subpackage  Modules
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

class Role extends MX_Controller
{
    private $page_limit = 10;
    private $delete_type = 'hard';

    /**
     * function __construct
     *
     * Initializes the module by loading language files, other modules, models, and also checking dependencies.
     *
     * @access public
     *
     * @return void
     */
    public function __construct()
    {

        // Load parent's constructor.
        parent::__construct();

        // Load this module's resources.
        _modules_load(['core', 'syslog', 'metadata', 'permission', 'user']);
        _models_load(['role_model']);
        _languages_load(['core/core', 'role/role']);

        // Check if module settings and dependencies are correct
        _settings_check('role');
    }

    public function admin_menu_hook()
    {
        return [
            'text' => 'Roles',
            'link' => 'role/list_roles_data',
            'icon' => 'group-work',
            'type' => 'relative',
            'target' => 'self',
            'roles' => ['Super Administrator', 'Roles Manager'],
            'permissions' => ['Manage roles'],
            'order' => 2,
            'sub_menu_items' => []
        ];
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Role' => [
                'actions' => [
                    $condition . 'list_roles_data' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage roles'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add roles', 'Manage roles']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Edit roles', 'Manage roles']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete roles', 'Manage roles']
                            ]
                        ]
                    ],
                    $condition . 'add_role' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add roles', 'Manage roles']
                    ],
                    $condition . 'edit_role' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit roles', 'Manage roles']
                    ],
                    $condition . 'get_roles' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage roles']
                    ],
                    $condition . 'delete_role' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete roles', 'Manage roles']
                    ],
                    $condition . 'export_roles' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Export roles', 'Manage roles']
                    ]
                ]
            ],
        ];
    }

    /**
     * function list_roles_data
     *
     * Lists all roles
     *
     * @access public
     *
     * @return void
     */
    public function list_roles_data($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->role_model->get_role_count(false);
            $data['hint'] = [
                'heading' => lang('role_role_manage_heading'),
                'message' => lang('role_role_manage_hint'),
            ];
            $data['empty'] = [
                'message' => lang('role_role_manage_empty'),
                'button' => lang('role_role_add_button')
            ];
            $data['tabledata']['page_data'] = $this->role_model->get_role_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'role_list';
            $data['tabledata']['url'] = 'role/get_roles';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'role/add_role',
                    'access' => current_user_can('add'),
                    'title' => lang('role_role_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'role/edit_role',
                    'access' => current_user_can('edit'),
                    'title' => lang('role_role_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'role/delete_role',
                    'access' => current_user_can('delete'),
                    'title' => lang('role_role_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'role',
                'model' => 'role_model',
                'function' => 'get_role_list',
                'parameters' => [
                    'type' => 'table',
                    'template' => 'template_pdf',
                    'title' => lang('role_role_system_roles_export'),
                    'type' => 'table',
                    'template' => 'template_pdf',
                    'document_author' => 'Impero Consulting',
                    'document_creator' => 'KyrandiaCMS',
                    'document_keywords' => 'kcms,kyrandiacms',
                    'document_subject' => 'User roles for KyrandiaCMS configuration',
                ]
            ];
            _render(_cfg('admin_theme'), 'role/roles/list_roles', $data);
        } else {
            _redir('error', lang('role_role_manage_denied'), 'core/no_access');
        }
    }

    /**
     * function get_roles
     *
     * Retrieves all roles for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_roles()
    {
        $check = _grid_open();
        $roles = $this->role_model->get_role_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->role_model->get_role_count(false, $check['search']);
        $final = _grid_close($check, $roles, $count);
        echo $final;
    }

    /**
     * add_role
     *
     * Adds a role to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_role()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_role_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['role_role'] = [
                'name' => 'role',
                'id' => 'role',
                'input_class' => 'input-group width-100',
                'label' => lang('role_role_role'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('role_role_role_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['role'], 'role', '')
            ];
            $permissions = $this->permission_model->get_all_permissions();
            $permissions_map = $this->core->map_fields($permissions, ['id', 'permission']);
            unset($permissions);
            $data['fields']['role_permissions'] = [
                'id' => 'permissions',
                'name' => 'permissions[]',
                'placeholder' => lang('role_role_permissions_placeholder'),
                'label' => lang('role_role_permissions_label'),
                'hint' => lang('role_role_permissions_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'multiple' => true,
                'validation' => ['rules' => 'required'],
                'options' => $permissions_map,
                'value' => _choose(@$data['data']['posts']['permissions'], 'permissions', '')
            ];
            $data['fields']['role_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('role_role_active_placeholder'),
                'label' => lang('role_role_active_label'),
                'hint' => lang('role_role_active_hint'),
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
            $data['fields']['role_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('role_role_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('role_role_add_heading'),
                'prompt' => lang('role_role_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to role listing',
                        'link' => 'role/list_roles_data'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->role_model->add_role($data['data']['posts']);
                if (!empty($insert_id)) {
                    $permcount = 0;
                    if (!empty($data['data']['posts']['permissions'])) {
                        foreach ($data['data']['posts']['permissions'] as $key => $value) {
                            $ins = $this->role_model->add_role_permission($insert_id, $value);
                            $permcount++;
                        }
                    }
                    $success = sprintf(lang('role_role_add_success'), $data['data']['posts']['role'], $insert_id, $permcount);
                    _redir('success', $success, 'role/list_roles_data');
                } else {
                    $error = sprintf(lang('role_role_add_error'), $data['data']['posts']['role']);
                    _redir('error', $error, 'role/list_roles_data');
                }
            }
            _render(_cfg('admin_theme'), 'role/roles/add_role', $data);
        } else {
            _redir('error', lang('role_role_add_denied'), 'role/list_roles_data');
        }
    }

    /**
     * edit_role
     *
     * Edits a role.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_role($id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] = $posts;
            $data['item'] = $this->role_model->get_role_by_id($id);
            $permissions = $this->permission_model->get_all_permissions();
            $permissions_map = $this->core->map_fields($permissions, ['id', 'permission']);
            unset($permissions);
            $temp = $this->permission_model->get_role_permissions($id);
            if (!empty($temp)) {
                foreach ($temp as $k => $v) {
                    $data['role_permissions'][] = $v['permission_id'];
                }
            }
            unset($temp);
            $data['fields']['form_open'] = [
                'id' => 'add_role_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['role_role'] = [
                'name' => 'role',
                'id' => 'role',
                'input_class' => 'input-group width-100',
                'label' => lang('role_role_role'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('role_role_role_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['role'], 'role', $data['item'][0]['role'])
            ];
            $data['fields']['role_permissions'] = [
                'id' => 'permissions',
                'name' => 'permissions[]',
                'placeholder' => lang('role_role_permissions_placeholder'),
                'label' => lang('role_role_permissions_label'),
                'hint' => lang('role_role_permissions_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'multiple' => true,
                'validation' => ['rules' => 'required'],
                'options' => $permissions_map,
                'value' => _choose(@$posts['permissions'], 'permissions', $data['role_permissions'])
            ];
            $data['fields']['role_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('role_role_active_placeholder'),
                'label' => lang('role_role_active_label'),
                'hint' => lang('role_role_active_hint'),
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
                'value' => _choose(@$posts['active'], 'active', $data['item'][0]['active'])
            ];
            $data['fields']['role_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('role_role_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('role_role_edit_heading'),
                'prompt' => lang('role_role_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to role listing',
                        'link' => 'role/list_roles_data'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->role_model->edit_role($data['data']['posts']);
                if ($affected) {
                    $permcount = 0;
                    if (!empty($data['data']['posts']['permissions'])) {
                        $this->role_model->delete_role_permissions($id);
                        foreach ($data['data']['posts']['permissions'] as $key => $value) {
                            $ins = $this->role_model->add_role_permission($id, $value);
                            $permcount++;
                        }
                    }
                    $success = sprintf(lang('role_role_edit_success'), $data['data']['posts']['role'], $data['id'], $permcount);
                    _redir('success', $success, 'role/list_roles_data');
                } else {
                    $error = sprintf(lang('role_role_edit_error'), $data['data']['posts']['role']);
                    _redir('error', $error, 'role/list_roles_data');
                }
            }
            _render(_cfg('admin_theme'), 'role/roles/edit_role', $data);
        } else {
            _redir('error', lang('role_role_edit_denied'), 'role/list_roles_data');
        }
    }

    /**
     * delete_role
     *
     * Deletes a role from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_role($id)
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
            $data['fields']['role_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('role_role_delete_button'),
                'input_class' => 'btn-primary',
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->role_model->get_role_by_id($id, false);
            $data['delete_info'] = [
                0 => [
                    'table' => _cfg('db_prefix') . 'role_permission',
                    'field' => 'role_id',
                    'value' => $id,
                ],
                1 => [
                    'table' => _cfg('db_prefix') . 'user_role',
                    'field' => 'role_id',
                    'value' => $id,
                ],
                2 => [
                    'table' => _cfg('db_prefix') . 'role',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Role' => 'role',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to role listing',
                        'link' => 'role/list_roles_data'
                    ]
                ],
                'view' => 'role/roles/delete_confirm',
                'redirect' => 'role/list_roles_data',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('role_role_delete_heading'),
                'prompt' => lang('role_role_delete_prompt'),
                'success' => lang('role_role_delete_success'),
                'error' => lang('role_role_delete_error'),
                'warning' => lang('role_role_delete_warn'),
                'return' => lang('role_role_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('role_role_delete_denied'), 'core/no_access');
        }
    }
}
