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
 * KyrandiaCMS Permission module
 *
 * This is the main controller file for KyrandiaCMS's permission module.
 *
 * @package     Impero
 * @subpackage  Modules
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

class Permission extends MX_Controller
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
        _modules_load(['core', 'syslog', 'metadata', 'role', 'user']);
        _models_load(['permission_model']);
        _languages_load(['core/core', 'permission/permission']);

        // Check if module settings and dependencies are correct
        _settings_check('permission');
    }

    public function admin_menu_hook()
    {
        return [
            'text' => 'Permissions',
            'link' => 'permission/list_permissions_data',
            'icon' => 'play-circle',
            'type' => 'relative',
            'target' => 'self',
            'roles' => ['Super Administrator', 'Permissions Manager'],
            'permissions' => ['Manage permissions'],
            'order' => 3,
            'sub_menu_items' => []
        ];
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Permission' => [
                'actions' => [
                    $condition . 'list_permissions_data' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage permissions'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add permissions', 'Manage permissions']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Edit permissions', 'Manage permissions']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete permissions', 'Manage permissions']
                            ]
                        ]
                    ],
                    $condition . 'add_permission' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add permissions', 'Manage permissions']
                    ],
                    $condition . 'edit_permission' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit permissions', 'Manage permissions']
                    ],
                    $condition . 'get_permissions' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage permissions']
                    ],
                    $condition . 'delete_permission' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete permissions', 'Manage permissions']
                    ],
                    $condition . 'export_permissions' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Export permissions', 'Manage permissions']
                    ]
                ]
            ],
        ];
    }

    /**
     * add_permission
     *
     * Adds a permission to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_permission()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_permission_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['permission_permission'] = [
                'name' => 'permission',
                'id' => 'permission',
                'input_class' => 'input-group width-100',
                'label' => lang('permission_permission_permission'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('permission_permission_permission_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['permission'], 'permission', '')
            ];
            $data['fields']['permission_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('permission_permission_active_placeholder'),
                'label' => lang('permission_permission_active_label'),
                'hint' => lang('permission_permission_active_hint'),
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
            $data['fields']['permission_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('permission_permission_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('permission_permission_add_heading'),
                'prompt' => lang('permission_permission_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to permission listing',
                        'link' => 'permission/list_permissions_data'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $perms = explode('|', $data['data']['posts']['permission']);
                foreach ($perms as $k => $v) {
                    if (!empty($v)) {
                        $data['data']['posts']['permission'] = $v;
                        $insert_id = $this->permission_model->add_permission($data['data']['posts']);
                    }
                }
                if (!empty($insert_id)) {
                    $success = sprintf(lang('permission_permission_add_success'), $data['data']['posts']['permission'], $insert_id);
                    _redir('success', $success, 'permission/list_permissions_data');
                } else {
                    $error = sprintf(lang('permission_permission_add_error'), $data['data']['posts']['permission']);
                    _redir('error', $error, 'permission/list_permissions_data');
                }
            }
            _render(_cfg('admin_theme'), 'permission/permissions/add_permission', $data);
        } else {
            _redir('error', lang('permission_permission_add_denied'), 'permission/list_permissions_data');
        }
    }

    /**
     * edit_permission
     *
     * Edits a permission.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_permission($id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] = $posts;
            $data['item'] = $this->permission_model->get_permission_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'add_permission_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['permission_permission'] = [
                'name' => 'permission',
                'id' => 'permission',
                'input_class' => 'input-group width-100',
                'label' => lang('permission_permission_permission'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('permission_permission_permission_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['permission'], 'permission', $data['item'][0]['permission'])
            ];
            $data['fields']['permission_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('permission_permission_active_placeholder'),
                'label' => lang('permission_permission_active_label'),
                'hint' => lang('permission_permission_active_hint'),
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
            $data['fields']['permission_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('permission_permission_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('permission_permission_edit_heading'),
                'prompt' => lang('permission_permission_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to permission listing',
                        'link' => 'permission/list_permissions_data'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->permission_model->edit_permission($data['data']['posts']);
                if ($affected) {
                    $success = sprintf(lang('permission_permission_edit_success'), $data['data']['posts']['permission'], $data['id']);
                    _redir('success', $success, 'permission/list_permissions_data');
                } else {
                    $error = sprintf(lang('permission_permission_edit_error'), $data['data']['posts']['permission']);
                    _redir('error', $error, 'permission/list_permissions_data');
                }
            }
            _render(_cfg('admin_theme'), 'permission/permissions/edit_permission', $data);
        } else {
            _redir('error', lang('permission_permission_edit_denied'), 'permission/list_permissions_data');
        }
    }

    /**
     * delete_permission
     *
     * Deletes a permission from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_permission($id)
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
            $data['fields']['permission_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('permission_permission_delete_button'),
                'input_class' => 'btn-primary',
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->permission_model->get_permission_by_id($id, false);
            $data['delete_info'] = [
                0 => [
                    'table' => _cfg('db_prefix') . 'role_permission',
                    'field' => 'permission_id',
                    'value' => $id,
                ],
                1 => [
                    'table' => _cfg('db_prefix') . 'permission',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Permission' => 'permission',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to permission listing',
                        'link' => 'permission/list_permissions_data'
                    ]
                ],
                'view' => 'permission/permissions/delete_confirm',
                'redirect' => 'permission/list_permissions_data',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('permission_permission_delete_heading'),
                'prompt' => lang('permission_permission_delete_prompt'),
                'success' => lang('permission_permission_delete_success'),
                'error' => lang('permission_permission_delete_error'),
                'warning' => lang('permission_permission_delete_warn'),
                'return' => lang('permission_permission_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('permission_permission_delete_denied'), 'core/no_access');
        }
    }

    /**
     * function list_permissions_data
     *
     * Lists all permissions
     *
     * @access public
     *
     * @return void
     */
    public function list_permissions_data($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->permission_model->get_permission_count(false);
            $data['hint'] = [
                'heading' => lang('permission_permission_manage_heading'),
                'message' => lang('permission_permission_manage_hint'),
            ];
            $data['empty'] = [
                'message' => lang('permission_permission_manage_empty'),
                'button' => lang('permission_permission_add_button')
            ];
            $data['tabledata']['page_data'] = $this->permission_model->get_permission_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'permission_list';
            $data['tabledata']['url'] = 'permission/get_permissions';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'permission/add_permission',
                    'access' => current_user_can('add'),
                    'title' => lang('permission_permission_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'permission/edit_permission',
                    'access' => current_user_can('edit'),
                    'title' => lang('permission_permission_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'permission/delete_permission',
                    'access' => current_user_can('delete'),
                    'title' => lang('permission_permission_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'permission',
                'model' => 'permission_model',
                'function' => 'get_permission_list',
                'parameters' => [
                    'type' => 'table',
                    'template' => 'template_pdf',
                    'title' => lang('permission_permission_system_permissions_export'),
                    'page_title' => lang('permission_permission_system_permissions_export'),
                    'document_title' => lang('permission_permission_system_permissions_export'),
                    'document_author' => 'Impero Consulting',
                    'document_creator' => 'KyrandiaCMS',
                    'document_keywords' => 'kcms,kyrandiacms',
                    'document_subject' => 'permission permissions for KyrandiaCMS configuration'
                ]
            ];
            _render(_cfg('admin_theme'), 'permission/permissions/list_permissions', $data);
        } else {
            _redir('error', lang('permission_permission_manage_denied'), 'core/no_access');
        }
    }

    /**
     * function get_permissions
     *
     * Retrieves all permissions for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_permissions()
    {
        $check = _grid_open();
        $perms = $this->permission_model->get_permission_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->permission_model->get_permission_count(false, $check['search']);
        $final = _grid_close($check, $perms, $count);
        echo $final;
    }
}
