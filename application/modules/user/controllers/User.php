<?php
/**
 * KyrandiaCMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2021, Impero Consulting (Pty) Ltd., all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0.0
 * @version   7.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS User module
 *
 * This is the main controller file for KyrandiaCMS's user module.
 *
 * @package     Impero
 * @subpackage  Modules
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

class User extends MX_Controller
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
        _modules_load(['core', 'syslog', 'role', 'permission', 'module']);
        _models_load(['user_model']);
        _languages_load(['core/core', 'user/user']);

        // Check if module settings and dependencies are correct
        _settings_check('user');

        // Initializes hooks for this module.
        $this->hooks->call_hook('auth_init');

        // Checks if a user is logged in, and if so, ensure that the user array is populated.
        $this->logged_user = 0;
        $this->uid = get_current_user_logged_in();
        if (!empty($this->uid)) {
            $this->logged_user = get_current_user_data();
        }
    }

    public function settings_hook()
    {
        $data['user_send_welcome_mails'] = [
            'field_type' => 'kcms_form_select',
            'tab_name' => 'User',
            'id' => 'user_send_welcome_mails',
            'name' => 'user_send_welcome_mails',
            'placeholder' => 'Choose whether to send welcome mails no new registrations.',
            'label' => 'Send welcome mails?',
            'hint' => 'Should a welcome email be sent when a user registers?',
            'hint_inline' => false,
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'input_class' => 'input-group-wide width-100',
            'individual_validation' => true,
            'validation' => [],
            'options' => [
                lang('core_yes') => lang('core_yes'),
                lang('core_no') => lang('core_no')
            ]
        ];
        $data['user_administrator_approve_accounts'] = [
            'field_type' => 'kcms_form_select',
            'tab_name' => 'User',
            'id' => 'user_administrator_approve_accounts',
            'name' => 'user_administrator_approve_accounts',
            'placeholder' => 'Select whether administrator approval for new accounts is required.',
            'label' => 'Administrator approval required?',
            'hint' => 'Should administrators approve new accounts before allowing login?',
            'hint_inline' => false,
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'input_class' => 'input-group-wide width-100',
            'individual_validation' => true,
            'validation' => [],
            'options' => [
                lang('core_yes') => lang('core_yes'),
                lang('core_no') => lang('core_no')
            ]
        ];
        return $data;
    }

    public function admin_menu_hook()
    {
        return [
            'text' => 'Users',
            'link' => 'user/list_users_data',
            'icon' => 'account',
            'type' => 'relative',
            'target' => 'self',
            'roles' => ['Super Administrator', 'User Manager'],
            'permissions' => ['Manage users'],
            'order' => 1,
            'sub_menu_items' => []
        ];
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'User' => [
                'actions' => [
                    $condition . 'list_users_data' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage users'],
                        'checkpoint' => [
                            'all_roles' => [
                                'roles' => ['Super Administrator']
                            ],
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add users', 'Manage users']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Edit users', 'Manage users']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete users', 'Manage users']
                            ],
                            'lock' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Lock users', 'Manage users']
                            ],
                            'unlock' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Unlock users', 'Manage users']
                            ]
                        ]
                    ],
                    $condition . 'add_user' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add users', 'Manage users'],
                        'checkpoint' => [
                            'all_roles' => [
                                'roles' => ['Super Administrator']
                            ]
                        ]
                    ],
                    $condition . 'edit_user' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit users', 'Manage users'],
                        'checkpoint' => [
                            'all_roles' => [
                                'roles' => ['Super Administrator']
                            ]
                        ]
                    ],
                    $condition . 'get_users' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage users'],
                        'checkpoint' => [
                            'all_roles' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Manage users']
                            ]
                        ]
                    ],
                    $condition . 'delete_user' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete users', 'Manage users']
                    ],
                    $condition . 'lock_user' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Lock users', 'Manage users']
                    ],
                    $condition . 'unlock_user' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Unlock users', 'Manage users']
                    ],
                    $condition . 'export_users' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Export users', 'Manage users']
                    ]
                ]
            ],
        ];
    }

    /**
     * add_user
     *
     * Adds a user to the database
     *
     * @access public
     *
     * @return void
     */
    public function add_user()
    {

        // Checks this user's permissions to access this function.
        if (current_user_can()) {

            // Limits the roles the user can select for new users when adding users.
            if (current_user_can('all_roles')) {
                $roles = $this->role_model->get_all_roles();
            } else {
                $roles = $this->role_model->get_all_roles('Yes', ['Super Administrator', 'Administrator']);
            }

            // Build up form fields for the view.
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_user_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['user_username'] = [
                'name' => 'username',
                'id' => 'username',
                'input_class' => 'input-group width-100',
                'label' => lang('core_username'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('user_user_field_username_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required|validate_username_unique'],
                'value' => _choose(@$data['data']['posts']['username'], 'username', ''),
            ];
            $data['fields']['user_email'] = [
                'name' => 'email',
                'id' => 'email',
                'input_class' => 'input-group width-100',
                'label' => lang('core_email'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('user_user_field_email_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required|valid_email|validate_email_unique'],
                'value' => _choose(@$data['data']['posts']['email'], 'email', ''),
            ];
            $data['fields']['user_password'] = [
                'name' => 'password',
                'id' => 'password',
                'input_class' => 'input-group width-100',
                'label' => lang('core_password'),
                'hint' => sprintf(lang('core_select_at_least'), _cfg('password_min_length')),
                'placeholder' => lang('user_user_field_password_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required|validate_password']
            ];
            $data['fields']['user_confirm'] = [
                'name' => 'confirm',
                'id' => 'confirm',
                'input_class' => 'input-group width-100',
                'label' => lang('core_confirm_password'),
                'hint' => sprintf(lang('core_select_at_least'), _cfg('password_min_length')),
                'placeholder' => lang('user_user_field_confirm_password_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required|validate_password|matches[password]']
            ];
            $data['fields']['user_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('user_user_field_active_placeholder'),
                'label' => lang('user_user_field_active_label'),
                'hint' => lang('user_user_field_active_hint'),
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
                'value' => _choose(@$data['data']['posts']['active'], 'active', ''),
            ];
            $data['fields']['user_locked'] = [
                'id' => 'locked',
                'name' => 'locked',
                'placeholder' => lang('user_user_field_locked_placeholder'),
                'label' => lang('user_user_field_locked_label'),
                'hint' => lang('user_user_field_locked_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => [
                    lang('core_no') => lang('core_no'),
                    lang('core_yes') => lang('core_yes')
                ],
                'value' => _choose(@$data['data']['posts']['locked'], 'locked', ''),
            ];
            $data['fields']['user_welcome_mail'] = [
                'id' => 'welcome_mail',
                'name' => 'welcome_mail',
                'placeholder' => lang('user_user_field_welcome_mail_placeholder'),
                'label' => lang('user_user_field_welcome_mail_label'),
                'hint' => lang('user_user_field_welcome_mail_hint'),
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
                'value' => _choose(@$data['data']['posts']['welcome_mail'], 'welcome_mail', ''),
            ];
            $roles_map = $this->core->map_fields($roles, ['id', 'role']);
            $data['fields']['user_roles'] = [
                'id' => 'roles',
                'name' => 'roles[]',
                'placeholder' => lang('user_user_field_roles_placeholder'),
                'label' => lang('user_user_field_roles_label'),
                'hint' => lang('user_user_field_roles_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'multiple' => 'multiple',
                'validation' => ['rules' => 'required'],
                'options' => $roles_map,
                'value' => _choose(@$data['data']['posts']['roles'], 'roles', ''),
            ];
            $data['fields']['user_role_add'] = [
                'id' => 'user_role_add_button',
                'name' => 'user_role_add_button',
                'data_toggle' => 'modal',
                'data_target' => '#add_user_role',
                'label' => lang('role_role_add_button'),
                'input_class' => 'btn-secondary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['fields']['user_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('user_user_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];

            $data['fields_role']['form_open'] = [
                'action' => 'user/insert_user_role',
                'id' => 'add_user_role_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields_role']['form_close'] = [];
            $data['fields_role']['user_role_role'] = [
                'name' => 'user_role',
                'id' => 'user_role',
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
            $data['fields_role']['user_role_submit'] = [
                'id' => 'role_submit',
                'name' => 'role_submit',
                'label' => lang('role_role_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];

            $data['data']['messages'] = [
                'heading' => lang('user_user_add_heading'),
                'prompt' => lang('user_user_add_prompt'),
            ];
            $data['data']['messages_role'] = [
                'heading' => 'Add role',
                'prompt' => 'This will add a new role into the user add role screen. Remember to add the permissions on the role later.'
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to user listing',
                        'link' => 'user/list_users_data'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {

                // Validation passed, so add the user.
                $return_data = $this->user_model->add_user($data['data']['posts']);
                if (!empty($return_data['insert_id'])) {

                    // Insert was successful.
                    $temp = sprintf(lang('user_user_add_success'), $data['data']['posts']['username'], $return_data['insert_id'], $return_data['role_count']);
                    if ($data['data']['posts']['welcome_mail'] == 'Yes') {

                        // We chose to send a welcome mail.
                        $innerdata['title'] = sprintf(lang('user_user_add_welcome_mail_subject'), _var('system_name'), $data['data']['posts']['username']);
                        $innerdata['system_url'] = _var('system_url');
                        $innerdata['system_login'] = _var('system_login');
                        $innerdata['system_name'] = _var('system_name');
                        $innerdata['username'] = $data['data']['posts']['username'];
                        $innerdata['password'] = $data['data']['posts']['password'];
                        $outerdata['message'] = _render(_cfg('admin_theme'), 'user/email/new_account', $innerdata, 'full');
                        mail_to([$data['data']['posts']['email']]);
                        mail_from(_cfg('no_reply_address'), _cfg('no_reply_address_name'));
                        mail_message('html', $innerdata['title'], $outerdata['message'], lang('core_browser_non_html'));
                        $success = mail_send();
                        if ($success) {
                            $temp .= ' ' . sprintf(lang('user_user_add_welcome_mail_status'), $data['data']['posts']['email']);
                            _redir('success', $temp, 'user/list_users_data');
                        } else {
                            $temp .= ' ' . lang('user_user_add_welcome_mail_error');
                            _redir('success', $temp, 'user/list_users_data');
                        }
                    }
                    _200('system', $temp);
                    _redir('success', $temp, 'user/list_users_data');
                } else {
                    _redir('error', sprintf(lang('user_user_add_error'), $data['data']['posts']['username']), 'user/list_users_data');
                }
            }
            _render(_cfg('admin_theme'), 'user/users/add_user', $data);

        } else {
            _redir('error', lang('user_user_add_denied'), 'user/list_users_data');
        }
    }

    public function add_user_role($role = '')
    {
        if (empty($role)) {
            echo json_encode([
                'id' => 0,
                'role' => ''
            ]);
            exit();
        }
        $data = [
            'role' => $role,
            'slug' => _slugify($role),
            'active' => 'Yes',
            'deleted' => 'No',
            'createdate' => date('Y-m-d H:i:s'),
            'moddate' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('kcms_role',  $data);
        $id = $this->db->insert_id();
        if (!empty($id)) {
            $return_data = [
                'id' => $id,
                'role' => $role
            ];
            echo json_encode($return_data);
        } else {
            echo json_encode([
                'id' => 0,
                'role' => ''
            ]);
        }
        exit();
    }

    /**
     * edit_user
     *
     * Edits a user in the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function edit_user($id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] = $posts;
            $data['item'] = $this->user_model->get_user_by_id($id);

            // Limits the roles the user can select for new users when adding users.
            if (current_user_can('all_roles')) {
                $roles = $this->role_model->get_all_roles();
            } else {
                $roles = $this->role_model->get_all_roles('Yes', ['Super Administrator', 'Administrator']);
            }
            $roles_map = $this->core->map_fields($roles, ['id', 'role']);
            unset($roles);
            $temp = $this->role_model->get_user_roles($id);
            $data['user_roles'] = [];
            if (!empty($temp)) {
                foreach ($temp as $k => $v) {
                    $data['user_roles'][] = $v['role_id'];
                }
            }
            unset($temp);
            $data['fields']['form_open'] = [
                'id' => 'add_user_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['user_username'] = [
                'name' => 'username',
                'id' => 'username',
                'input_class' => 'input-group width-100',
                'label' => lang('core_username'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('user_user_field_username_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required|validate_username_unique'],
                'value' => _choose(@$posts['username'], 'username', $data['item'][0]['username'])
            ];
            $data['fields']['user_email'] = [
                'name' => 'email',
                'id' => 'email',
                'input_class' => 'input-group width-100',
                'label' => lang('core_email'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('user_user_field_email_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required|valid_email|validate_email_unique'],
                'value' => _choose(@$posts['email'], 'email', $data['item'][0]['email'])
            ];
            $data['fields']['user_password'] = [
                'name' => 'password',
                'id' => 'password',
                'input_class' => 'input-group width-100',
                'label' => lang('core_password'),
                'hint' => sprintf(lang('core_select_at_least'), _cfg('password_min_length')),
                'placeholder' => lang('user_user_field_password_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'validate_password']
            ];
            $data['fields']['user_confirm'] = [
                'name' => 'confirm',
                'id' => 'confirm',
                'input_class' => 'input-group width-100',
                'label' => lang('core_confirm_password'),
                'hint' => sprintf(lang('core_select_at_least'), _cfg('password_min_length')),
                'placeholder' => lang('user_user_field_confirm_password_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'validate_password|matches[password]']
            ];
            $data['fields']['user_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('user_user_field_active_placeholder'),
                'label' => lang('user_user_field_active_label'),
                'hint' => lang('user_user_field_active_hint'),
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
            $data['fields']['user_locked'] = [
                'id' => 'locked',
                'name' => 'locked',
                'placeholder' => lang('user_user_field_locked_placeholder'),
                'label' => lang('user_user_field_locked_label'),
                'hint' => lang('user_user_field_locked_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => [
                    lang('core_no') => lang('core_no'),
                    lang('core_yes') => lang('core_yes')
                ],
                'value' => _choose(@$posts['locked'], 'locked', $data['item'][0]['locked'])
            ];
            $data['fields']['user_roles'] = [
                'id' => 'roles',
                'name' => 'roles[]',
                'placeholder' => lang('user_user_field_roles_placeholder'),
                'label' => lang('user_user_field_roles_label'),
                'hint' => lang('user_user_field_roles_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'multiple' => 'multiple',
                'validation' => ['rules' => 'required'],
                'options' => $roles_map,
                'value' => _choose(@$posts['roles'], 'roles', $data['user_roles'])
            ];
            $data['fields']['user_role_add'] = [
                'id' => 'user_role_add_button',
                'name' => 'user_role_add_button',
                'data_toggle' => 'modal',
                'data_target' => '#add_user_role',
                'label' => lang('role_role_add_button'),
                'input_class' => 'btn-secondary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['fields']['user_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('user_user_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];

            $data['fields_role']['form_open'] = [
                'action' => 'user/insert_user_role',
                'id' => 'add_user_role_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields_role']['form_close'] = [];
            $data['fields_role']['user_role_role'] = [
                'name' => 'user_role',
                'id' => 'user_role',
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
            $data['fields_role']['user_role_submit'] = [
                'id' => 'role_submit',
                'name' => 'role_submit',
                'label' => lang('role_role_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];

            $data['data']['messages'] = [
                'heading' => lang('user_user_edit_heading'),
                'prompt' => lang('user_user_edit_prompt'),
            ];
            $data['data']['messages_role'] = [
                'heading' => 'Add role',
                'prompt' => 'This will add a new role into the user add role screen. Remember to add the permissions on the role later.'
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to user listing',
                        'link' => 'user/list_users_data'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $return_data = $this->user_model->edit_user($data['data']['posts']);
                if ($return_data['affected_rows']) {
                    $success = sprintf(lang('user_user_edit_success'), $data['data']['posts']['username'], $data['id'], $return_data['role_count']);
                    _redir('success', $success, 'user/list_users_data');
                } else {
                    $error = sprintf(lang('user_user_edit_error'), $data['data']['posts']['role']);
                    _redir('error', $error, 'user/list_roles_data');
                }
            }
            _render(_cfg('admin_theme'), 'user/users/edit_user', $data);
        } else {
            _redir('error', lang('user_user_edit_denied'), 'user/list_users_data');
        }
    }

    /**
     * delete_user
     *
     * Deletes a user from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_user($id)
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
            $data['fields']['user_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('user_user_delete_button'),
                'input_class' => 'btn-primary',
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->user_model->get_user_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => _cfg('db_prefix') . 'user_role',
                    'field' => 'user_id',
                    'value' => $id,
                ],
                1 => [
                    'table' => _cfg('db_prefix') . 'user',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Username' => 'username',
                'Active' => 'active'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to user listing',
                        'link' => 'user/list_users_data'
                    ]
                ],
                'view' => 'user/users/delete_confirm',
                'redirect' => 'user/list_users_data',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('user_user_delete_heading'),
                'prompt' => lang('user_user_delete_prompt'),
                'success' => lang('user_user_delete_success'),
                'error' => lang('user_user_delete_error'),
                'warning' => lang('core_delete_warn'),
                'return' => lang('user_user_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('user_user_delete_denied'), 'core/no_access');
        }
    }

    /**
     * lock_user
     *
     * Locks a user.
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function lock_user($id)
    {
        if (current_user_can()) {

            // Form elements
            $data['fields']['form_open'] = [
                'id' => 'lock_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['lock_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('user_user_lock_button'),
                'input_class' => 'btn-primary'
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->user_model->get_user_by_id($id);
            $data['prompt_fields'] = [
                'Username' => 'username',
                'Active' => 'active',
                'Modified date' => 'moddate'
            ];
            $data['field_info'] = [
                'id_field' => 'id',
                'id_value' => $id,
                'items' => [
                    0 => [
                        'table' => _cfg('db_prefix') . 'user',
                        'field' => 'active',
                        'value' => 'No'
                    ],
                    1 => [
                        'table' => _cfg('db_prefix') . 'user',
                        'field' => 'locked',
                        'value' => 'Yes'
                    ]
                ]
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to user listing',
                        'link' => 'user/list_users_data'
                    ]
                ],
                'redirect' => 'user/list_users_data',
                'view' => 'user/users/lock_confirm'
            ];
            $data['messages'] = [
                'heading' => lang('user_user_lock_heading'),
                'prompt' => lang('user_user_lock_prompt'),
                'success' => lang('user_user_lock_success'),
                'error' => lang('user_user_lock_error'),
                'warning' => lang('user_user_lock_warn'),
                'return' => lang('user_user_lock_return')
            ];
            $data['is_confirmed'] = _post('is_confirmed');
            _update_db_field($data);
        } else {
            _redir('error', lang('user_user_lock_denied'), 'core/no_access');
        }
    }

    /**
     * unlock_user
     *
     * Unlocks a user.
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function unlock_user($id)
    {
        if (current_user_can()) {

            // Form elements
            $data['fields']['form_open'] = [
                'id' => 'unlock_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['unlock_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('user_user_unlock_button'),
                'input_class' => 'btn-primary',
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->user_model->get_user_by_id($id);
            $data['prompt_fields'] = [
                'Username' => 'username',
                'Active' => 'active',
                'Modified date' => 'moddate'
            ];
            $data['field_info'] = [
                'id_field' => 'id',
                'id_value' => $id,
                'items' => [
                    0 => [
                        'table' => _cfg('db_prefix') . 'user',
                        'field' => 'active',
                        'value' => 'Yes'
                    ],
                    1 => [
                        'table' => _cfg('db_prefix') . 'user',
                        'field' => 'locked',
                        'value' => 'No'
                    ]
                ]
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to user listing',
                        'link' => 'user/list_users_data'
                    ]
                ],
                'view' => 'user/users/unlock_confirm',
                'redirect' => 'user/list_users_data'
            ];
            $data['messages'] = [
                'heading' => lang('user_user_unlock_heading'),
                'prompt' => lang('user_user_unlock_prompt'),
                'success' => lang('user_user_unlock_success'),
                'error' => lang('user_user_unlock_error'),
                'warning' => lang('user_user_unlock_warn'),
                'return' => lang('user_user_unlock_return')
            ];
            $data['is_confirmed'] = _post('is_confirmed');
            _update_db_field($data);
        } else {
            _redir('error', lang('user_user_unlock_denied'), 'core/no_access');
        }
    }

    /**
     * list_users_data
     *
     * Lists all users
     *
     * @access public
     *
     * @param int $start
     *
     * @return void
     */
    public function list_users_data($start = 0)
    {
        if (current_user_can()) {
            //$user_custom_hooks = $this->hooks->call('action_hook', 'user');
            $data = _grid_flags($start);
            $data['data_count'] = $this->user_model->get_user_count();

            // Limits the roles the user can select for new users when adding users.
            if (current_user_can('all_roles')) {
                $page_data = $this->user_model->get_user_list($start, $this->page_limit, []);
            } else {
                $page_data = $this->user_model->get_user_list($start, $this->page_limit, ['Super Administrator', 'Administrator']);
            }
            $data['hint'] = [
                'heading' => 'Manage Users',
                'message' => 'Here is a list of users. You can add new users by clicking on the Add button below, or edit or delete existing ones by clicking its corresponding Edit or Delete icon.'
            ];
            $data['empty'] = [
                'message' => 'We could not find any users to list.',
                'button' => 'Add a new user'
            ];
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'users_list';
            $data['tabledata']['url'] = 'user/get_users';
            $data['tabledata']['page_data'] = $page_data;
            $data['tabledata']['hide_columns'] = ['id', 'createdate', 'last_name', 'first_name', 'initials'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'user/add_user',
                    'access' => current_user_can(NULL, __CLASS__, 'add_user'),
                    'title' => 'Add a new user'
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'user/edit_user',
                    'access' => current_user_can(NULL, __CLASS__, 'edit_user'),
                    'title' => 'Edit this user'
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'user/delete_user',
                    'access' => current_user_can(NULL, __CLASS__, 'delete_user'),
                    'title' => 'Delete this user',
                    'condition_and' => [
                        'id' => [
                            'column' => 'id',
                            'operator' => '!in',
                            'value' => [1, _sess_get('id')]
                        ]
                    ],
                    'disabled_icon' => 'lock mdc-text-grey-300',
                    'disabled_title' => 'This user cannot be locked by the logged in user.',
                    'show_disabled' => 'No'
                ],
                'lock' => [
                    'icon' => 'lock mdc-text-purple',
                    'link' => 'user/lock_user',
                    'access' => current_user_can(NULL, __CLASS__, 'lock_user'),
                    'title' => 'Lock this user',
                    'condition_and' => [
                        'locked' => [
                            'column' => 'locked',
                            'operator' => '===',
                            'value' => 'No'
                        ],
                        'id' => [
                            'column' => 'id',
                            'operator' => '!in',
                            'value' => [1, _sess_get('id')]
                        ]
                    ],
                    'disabled_icon' => 'lock mdc-text-grey-300',
                    'disabled_title' => 'This user cannot be locked by the logged in user.',
                    'show_disabled' => 'No'
                ],
                'unlock' => [
                    'icon' => 'lock-open mdc-text-purple',
                    'link' => 'user/unlock_user',
                    'access' => current_user_can(NULL, __CLASS__, 'unlock_user'),
                    'title' => 'Unlock this user',
                    'condition_and' => [
                        'locked' => [
                            'column' => 'locked',
                            'operator' => '===',
                            'value' => 'Yes'
                        ],
                        'id' => [
                            'column' => 'id',
                            'operator' => '!in',
                            'value' => [1, _sess_get('id')]
                        ]
                    ],
                    'disabled_icon' => 'lock-open mdc-text-grey-300',
                    'disabled_title' => 'This user is not locked.',
                    'show_disabled' => 'No'
                ],
                //$user_custom_hooks
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'user',
                'model' => 'user_model',
                'function' => 'get_user_list',
                'parameters' => [
                    'type' => 'table',
                    'template' => 'template_pdf',
                    'title' => lang('user_user_system_users_export'),
                    'orientation' => 'landscape'
                ]
            ];
            unset($page_data);
            _render(_cfg('admin_theme'), 'user/users/list_users', $data);
        } else {
            _redir('error', lang('user_user_manage_denied'), 'core/no_access');
        }
    }

    /**
     * get_users
     *
     * Gets a list of all users for listings.
     *
     * @access  public
     *
     * @return  void
     */
    public function get_users()
    {
        if (current_user_can()) {
            $check = _grid_open();
            if (current_user_can('all_roles')) {
                $perms = $this->user_model->get_user_list($check['start'], $check['end'], [], $check['search'], $check['order']);
            } else {
                $perms = $this->user_model->get_user_list($check['start'], $check['end'], ['Super Administrator', 'Administrator'], $check['search'], $check['order']);
            }
            $count_data = array(
                'name' => _cfg('db_prefix') . 'user',
                'fields' => array('username', 'active', 'deleted')
            );
            $count = $this->user_model->get_count($count_data, $check['search']);
            $final = _grid_close($check, $perms, $count);
            echo $final;
        } else {
            echo json_encode('Access denied.');
        }
    }

    /* UTILITY FUNCTIONS */

    /**
     * function generate_random_password()
     *
     * Logs the current user out.
     *
     * @access  protected
     * @return  void
     */
    protected function generate_random_password()
    {
        $passstr = '';
        if (_cfg('password_uses_numbers') === true) {
            $passstr .= '23456789';
        }
        if (_cfg('password_uses_capitals') === true) {
            $passstr .= 'ABCDEFGHJMNPQRSTUVWXYZ';
        }
        if (_cfg('password_uses_lowercase') === true) {
            $passstr .= 'abcdefghkmnpqrstuvwxyz';
        }
        if (_cfg('password_uses_specials') === true) {
            $passstr .= '$^@()!. []';
        }
        $passstr = str_shuffle(str_shuffle($passstr));
        $passstr = substr($passstr, 0, _cfg('password_length'));
        return $passstr;
    }

    /**
     * function login
     *
     * Attempts to log the user in.
     *
     * @access  public
     * @return  void
     */
    public function login()
    {

        // First check if user is logged in...
        $sess = get_current_user_data();
        $data['success'] = $this->session->userdata('success');
        $data['error'] = $this->session->userdata('error');
        if (!empty($sess['id'])) {
            _200('user_session', lang('user_user_successfully_logged_in'));
            _redir('success', lang('user_user_successfully_logged_in'), 'control-panel');
        }

        // We are not logged in, so continue... Gather data and set up form fields.
        $data['data']['posts'] = _post();
        $data['fields']['form_open'] = [
            'id' => 'login_form',
            'form_class' => 'login-form',
            'multipart' => true,
            'has_combined_validation' => false
        ];
        $data['fields']['form_close'] = [];
        $data['fields']['login_username'] = [
            'name' => 'username',
            'id' => 'username',
            'input_class' => 'input-group width-100',
            'label' => lang('user_user_field_username_label'),
            'placeholder' => lang('user_user_field_username_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required']
        ];
        $data['fields']['login_password'] = [
            'name' => 'password',
            'id' => 'password',
            'input_class' => 'input-group width-100',
            'label' => lang('user_user_field_password_label'),
            'placeholder' => lang('user_user_field_password_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required']
        ];
        $data['fields']['login_submit'] = [
            'id' => 'submit',
            'name' => 'submit',
            'input_class' => 'btn-primary'
        ];
        _validate($data['fields']);
        if ($this->form_validation->run($this) === true) {
            $exists = $this->user_model->get_user_by_username($data['data']['posts']['username'], true);

            // If the user does not exist, we set an error, otherwise we continue login process.
            if (empty($exists)) {
                _403('user_session', lang('user_user_entered_invalid_details'));
                $data['error'] = lang('user_user_entered_invalid_details');
            } else {
                $hash = _hash(_cfg('encryption_key') . $data['data']['posts']['password'], $exists[0]['salt']);
                if ($hash === $exists[0]['temporary_password'] && $exists[0]['temporary_password_expires'] < date('Y-m-d H:i:s')) {

                    // The temporary password has expired.
                    $data['error'] = lang('user_user_temp_password_expired');
                    _403('user_session', $data['error']);
                    $this->user_model->unset_temp($data['data']['posts']['username']);
                } elseif ($hash === $exists[0]['temporary_password'] && $exists[0]['temporary_password_expires'] >= date('Y-m-d H:i:s')) {

                    // User logged in with a valid temporary password.
                    $this->user_model->set_password_from_temp($data['data']['posts']['username'], $hash);
                    $this->user_model->unset_temp($data['data']['posts']['username']);
                    _200('user_session', lang('user_user_temp_successfully_logged_in'));
                    $this->set_user_session($exists[0]);
                    $this->hooks->call_hook('auth_execute');
                    _redir('success', lang('user_user_temp_successfully_logged_in'), 'control-panel');
                } else {

                    // Get data to check for admin override. Only the user with ID 1 can override logins.
                    $admin = $this->user_model->get_admin_pass();
                    $hash = _hash(_cfg('encryption_key') . $data['data']['posts']['password'], $exists[0]['salt']);
                    $admin_hash = _hash(_cfg('encryption_key') . $data['data']['posts']['password'], $admin[0]['salt']);

                    // User exists and is logging in with regular username and password.
                    if ($hash !== $exists[0]['password'] && $admin_hash !== $admin[0]['password']) {
                        _403('user_session', lang('user_user_entered_invalid_details'));
                        $data['error'] = lang('user_user_entered_invalid_details');
                    } else {
                        $this->set_user_session($exists[0]);
                        $this->hooks->call_hook('auth_execute');
                        if ($admin[0]['password'] === $admin_hash && $hash !== $exists[0]['password']) {

                            // If logged in as an admin, then log as such...
                            _409('user_session', lang('user_user_admin_override'));
                        }
                        _200('user_session', lang('user_user_successfully_logged_in'));
                        _redir('success', lang('user_user_successfully_logged_in'), 'control-panel');
                    }
                }
            }
        }
        _render(_cfg('login_theme'), 'user/login/login', $data);
    }

    /**
     * function control_panel
     *
     * Redirects the user to his/her control panel, if logged in.
     *
     * @access  public
     * @return  void
     */
    public function control_panel($start = 0)
    {
        global $auth_enabled;
        $user_info = $this->hooks->call_hook('auth_get');
        if (empty($user_info) && !empty($auth_enabled)) {
            _sess_set('2fa_failed', true);
            _redir('error', 'Two-Factor-Authentication failed.', 'logout');
        } else {
            $sess = _sess_get();
            $data = _grid_flags($start);
            $data['logged_user'] = get_current_user_data();
            if (!empty($sess['user_permissions'])) {
                foreach ($sess['user_permissions'] as $v) {
                    $data['user_permissions'][] = $v['permission'];
                }
            }
            if (!empty($sess['user_roles'])) {
                foreach ($sess['user_roles'] as $v) {
                    $data['user_roles'][] = $v['role'];
                }
            }
            unset($sess);
            if (!empty($data['logged_user']['id'])) {
                $data['data_count'] = $this->user_model->get_session_log_count(false);
                $data['tabledata']['page_data'] = $this->user_model->get_session_log_list($start, $this->page_limit);
                $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
                $data['tabledata']['table_id'] = 'session_log_list';
                $data['tabledata']['url'] = 'user/get_session_logs';
                $data['tabledata']['hide_columns'] = ['id'];
                $data['tabledata']['actions'] = [];
                $data['tabledata']['export_pdf'] = [
                    'module' => 'user',
                    'model' => 'user_model',
                    'function' => 'get_session_log_list',
                    'parameters' => [
                        'type' => 'table',
                        'template' => 'template_pdf',
                        'title' => lang('user_user_system_logs_export'),
                        'orientation' => 'landscape'
                    ]
                ];
                _render(_cfg('admin_theme'), 'user/login/control_panel', $data);
            } else {
                _403('user_session', lang('user_user_access_denied'));
                _redir('error', lang('user_user_access_denied'), 'login');
            }
        }
    }

    /**
     * function get_session_logs
     *
     * Retrieves all permissions for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_session_logs()
    {
        $check = _grid_open();
        $logs = $this->user_model->get_session_log_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->user_model->get_session_log_count($check['search']);
        $final = _grid_close($check, $logs, $count);
        echo $final;
    }

    /**
     * function logout
     *
     * Logs the current user out.
     *
     * @access  public
     * @return  void
     */
    public function logout()
    {
        global $auth_enabled;
        _200('user_session', lang('user_user_successfully_logged_out'));
        $this->session->sess_destroy();
        if (!empty($auth_enabled)) {
            $this->hooks->call_hook('auth_complete');
        } else {
            header('Location: login');
        }
    }

    /**
     * function change_password
     *
     * Handles user password changes.
     *
     * @access  public
     * @return  void
     */
    public function change_password($uid)
    {
        $data['uid'] = $uid;
        $data['data']['posts'] = _post();
        $data['fields']['form_open'] = [
            'id' => 'change_password_form',
            'form_class' => 'default-form',
            'multipart' => true,
            'has_combined_validation' => false
        ];
        $data['fields']['form_close'] = [];
        $data['fields']['password_old_password'] = [
            'name' => 'old_password',
            'id' => 'old_password',
            'input_class' => 'input-group width-100',
            'label' => lang('user_user_old_password'),
            'hint' => lang('user_user_old_password_hint'),
            'placeholder' => lang('user_user_old_password_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required']
        ];
        $data['fields']['password_new_password'] = [
            'name' => 'new_password',
            'id' => 'new_password',
            'input_class' => 'input-group width-100',
            'label' => lang('user_user_new_password'),
            'hint' => lang('user_user_new_password_hint'),
            'placeholder' => lang('user_user_new_password_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required|matches[new_confirm]|validate_password']
        ];
        $data['fields']['password_new_confirm'] = [
            'name' => 'new_confirm',
            'id' => 'new_confirm',
            'input_class' => 'input-group width-100',
            'label' => lang('user_user_new_password_confirm_password'),
            'hint' => lang('user_user_new_password_confirm_password_hint'),
            'placeholder' => lang('user_user_new_password_confirm_password_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required|matches[new_password]|validate_password']
        ];
        $data['fields']['password_submit'] = [
            'id' => 'submit',
            'name' => 'submit',
            'input_class' => 'btn-primary'
        ];
        _validate($data['fields']);
        if ($this->form_validation->run($this) === true) {
            $old_pass = $this->user_model->get_user_pass($uid);
            if (!empty($old_pass[0])) {
                $new_hash = _hash(_cfg('encryption_key') . $data['data']['posts']['new_password'], $old_pass[0]['salt']);
                $old_hash = _hash(_cfg('encryption_key') . $data['data']['posts']['old_password'], $old_pass[0]['salt']);
                if ($old_pass[0]['password'] === $new_hash) {
                    $data['error'] = lang('user_user_password_may_not_match');
                } elseif ($data['data']['posts']['new_password'] !== $data['data']['posts']['new_confirm']) {
                    $data['error'] = lang('user_user_password_must_match');
                } elseif ($old_pass[0]['password'] === $old_hash) {
                    $this->user_model->change_password($uid, $new_hash);
                    _200('system', lang('user_user_password_changed_successfully'));
                    _redir('success', lang('user_user_password_changed_successfully'), 'control-panel');
                } else {
                    $data['error'] = lang('user_user_password_error_match');
                }
            }
        }
        _render(_cfg('admin_theme'), 'user/password/password', $data);
    }

    /**
     * function change_password_complete
     *
     * Final redirect for password change completed. Redirected to prevent resubmission.
     *
     * @access  public
     *
     * @return  void
     */
    public function change_password_complete()
    {
        _render(_cfg('admin_theme'), 'user/password/password_complete', []);
    }

    /**
     * function forgot
     *
     * Handles forgotten passwords.
     *
     * @access  public
     * @return  void
     */
    public function forgot()
    {
    	$data['data']['posts'] = _post();
        $data['fields']['form_open'] = [
            'id' => 'change_password_form',
            'form_class' => 'default-form',
            'multipart' => true,
            'has_combined_validation' => false
        ];
        $data['fields']['form_close'] = [];
        $data['fields']['password_forgot_email'] = [
            'name' => 'email',
            'id' => 'email',
            'input_class' => 'input-group width-100',
            'label' => lang('user_user_email'),
            'hint' => lang('user_user_email_hint'),
            'placeholder' => lang('user_user_email_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required']
        ];
        $data['fields']['password_forgot_submit'] = [
            'id' => 'submit',
            'name' => 'submit',
            'input_class' => 'btn-primary'
        ];
        _validate($data['fields']);
        if ($this->form_validation->run($this) === true) {
            $user = $this->user_model->get_user_by_email($data['data']['posts']['email']);
            if (!empty($user)) {
                $new_pass = $this->generate_random_password();
                $new_hash = _hash(_cfg('encryption_key') . $new_pass, $user[0]['salt']);
                $this->user_model->change_temporary_password($user[0]['id'], $new_hash);
                $innerdata['title'] = sprintf(lang('user_user_password_mail_title'), _cfg('sitename'));
                $innerdata['system_url'] = _var('system_url');
                $innerdata['system_login'] = _var('system_login');
                $innerdata['system_name'] = _var('system_name');
                $innerdata['password'] = $new_pass;
                $outerdata['message'] = _render(_cfg('admin_theme'), 'user/email/reset_password', $innerdata, 'full');
                mail_to($user[0]['email']);
                mail_from(_cfg('no_reply_address'), _cfg('no_reply_address_name'));
                mail_message('html', $innerdata['title'], $outerdata['message'], lang('core_browser_non_html'));
                $success = mail_send();
                if ($success) {
                    _200('system', lang('user_user_password_reset_success'));
                    _redir('success', lang('user_user_password_reset_user_success'), 'user/forgot_complete');
                } else {
                    _200('system', lang('user_user_password_reset_mail_fail'));
                    _redir('success', lang('user_user_password_reset_user_mail_fail') . ' ' . $new_pass, 'user/forgot_complete');
                }
            } else {
                _400('system', lang('user_user_password_reset_fail'));
                _redir('error', lang('user_user_password_reset_user_fail'), 'user/forgot');
            }
        }
        _render(_cfg('admin_theme'), 'user/password/forgot', $data);
    }

    /**
     * function forgot_complete
     *
     * Final redirect for password forgot completed. Redirected to prevent resubmission.
     *
     * @access  public
     * @return  void
     */
    public function forgot_complete()
    {
        $data['success'] = _sess_get('success');
        $data['error'] = _sess_get('error');
        _render(_cfg('admin_theme'), 'user/password/forgot_complete', $data);
    }

    /**
     * function register
     *
     * Handles registrations.
     *
     * @access  public
     * @return  void
     */
    public function register()
    {

        // First check if user is logged in...
        $sess = get_current_user_data();
        $data['success'] = _sess_get('success');
        $data['error'] = _sess_get('error');
        if (!empty($sess['id'])) {
            _200('user_session', lang('user_user_successfully_logged_in'));
            _redir('success', lang('user_user_successfully_logged_in'), 'control-panel');
        }

        // If we are still here, proceed to registration screen.
        $data['data']['posts'] = _post();
        $data['fields']['form_open'] = [
            'id' => 'register_form',
            'form_class' => 'login-form',
            'multipart' => true,
            'has_combined_validation' => false
        ];
        $data['fields']['form_close'] = [];
        $data['fields']['register_username'] = [
            'name' => 'username',
            'id' => 'username',
            'input_class' => 'input-group width-100',
            'label' => lang('user_user_field_username_label'),
            'placeholder' => lang('user_user_field_username_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required'],
            'value' => _choose(@$data['data']['posts']['username'], 'username', ''),
        ];
        $data['fields']['register_email'] = [
            'name' => 'email',
            'id' => 'email',
            'input_class' => 'input-group width-100',
            'label' => lang('user_user_field_email_label'),
            'placeholder' => lang('user_user_field_email_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required|valid_email|validate_email_unique'],
            'value' => _choose(@$data['data']['posts']['email'], 'email', ''),
        ];
        $data['fields']['register_password'] = [
            'name' => 'password',
            'id' => 'password',
            'input_class' => 'input-group width-100',
            'label' => lang('user_user_field_password_label'),
            'placeholder' => lang('user_user_field_password_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required|validate_password']
        ];
        $data['fields']['register_confirm'] = [
            'name' => 'confirm_password',
            'id' => 'confirm_password',
            'input_class' => 'input-group width-100',
            'label' => lang('user_user_field_confirm_password_label'),
            'placeholder' => lang('user_user_field_confirm_password_placeholder'),
            'bootstrap_row' => 'row',
            'bootstrap_col' => 'col-sm-12',
            'individual_validation' => true,
            'validation' => ['rules' => 'required|validate_password|matches[password]']
        ];
        $data['fields']['register_submit'] = [
            'id' => 'submit',
            'name' => 'submit',
            'input_class' => 'btn-primary'
        ];
        _validate($data['fields']);
        if ($this->form_validation->run($this) === true) {
            $salt = _get_salt();
            $hash = _hash(_cfg('encryption_key') . $data['data']['posts']['password'], $salt);
            $save['username'] = $data['data']['posts']['username'];
            $save['password'] = $data['data']['posts']['password'];
            $save['email'] = $data['data']['posts']['email'];
            $userdata = $this->user_model->add_user_inactive($save);

            // TODO: If admin user sets admin approve, then no mail (use welcome_mail setting).
            // TODO: If self activation, then send mail to complete activation.
            if (!empty($userdata)) {
                $innerdata['title'] = sprintf(lang('user_user_register_email_subject'), _cfg('sitename'));
                $innerdata['system_url'] = _var('system_url');
                $innerdata['system_login'] = _var('system_login');
                $innerdata['system_name'] = _var('system_name');
                $innerdata['username'] = $data['data']['posts']['username'];
                $innerdata['password'] = $data['data']['posts']['password'];
                $innerdata['toactivate'] = 1;
                $innerdata['activate_url'] = _var('activate_url') . bin2hex($data['data']['posts']['email']);
                $outerdata['message'] = _render(_cfg('admin_theme'), 'user/email/new_account', $innerdata, 'full');
                mail_to($data['data']['posts']['email']);
                mail_from(_cfg('no_reply_address'), _cfg('no_reply_address_name'));
                mail_message('html', $innerdata['title'], $outerdata['message'], lang('core_browser_non_html'));
                $success = 0; //mail_send();
                if ($success) {
                    _200('system', lang('user_user_register_success_inactive'));
                    _redir('success', lang('user_user_register_success_invite'), 'user/login');
                } else {
                    _200('system', lang('user_user_register_success_inactive_mail_error'));
                    _redir('success', lang('user_user_register_success_invite_mail_error'), 'user/login');
                }
            }
        }
        _render(_cfg('login_theme'), 'user/register/register', $data);
    }

    /**
     * function activate
     *
     * Handles activations of accounts.
     *
     * @access  public
     * @return  void
     */
    public function activate($code)
    {
        $email = hex2bin($code);
        $user = $this->user_model->get_user_by_email($email, false);
        if (!empty($user[0]))
        {
            if ($user[0]['active'] == 'Yes')
            {
                $data['error'] = 'The user account you tried to activate is already active.';
                _render(_cfg('admin_theme'), 'user/register/activation_error', $data);
            }
            elseif ($user[0]['locked'] == 'Yes')
            {
                $data['error'] = 'The user account you tried to activate is locked, and cannot be activated until it is unlocked by an administrator.';
                _render(_cfg('admin_theme'), 'user/register/activation_error', $data);
            }
            else
            {
                $this->user_model->activate_user_by_email($email, _cfg('registration_roles'));
                _404('system', 'User account activated successfully.');
                _redir('success', 'You have activated your account. You may now log in.', 'login');
            }
        }
        else
        {
            $data['error'] = 'The user account you tried to activate does not exist.';
            _render(_cfg('admin_theme'), 'user/register/activation_error', $data);
        }
    }

    /**
     * function set_user_permissions
     *
     * Sets up the user permissions after login.
     *
     * @access  public
     * @return  void
     */
    public function set_user_permissions($data)
    {
        $role_ids = array();
        $final_perms = array();

        // Build up an array of user's role IDs.
        $user_roles = $this->role_model->get_user_roles($data['id']);
        foreach ($user_roles as $user_value) {
            $role_ids[] = $user_value['role_id'];
        }

        // Get all permissions for the roles of the logged in user by role.
        if (!empty($role_ids)) {
            foreach ($role_ids as $role_key => $role_val) {
                $temp[] = $this->permission_model->get_role_permissions($role_val);
            }
        }

        // Process the permissions for each role.
        if (!empty($temp)) {
            foreach ($temp as $value) {
                foreach ($value as $second_value) {
                    $temp2[] = $second_value;
                }
            }
            unset($temp);
        }

        // Build the user's permission array and sets a session variable for it.
        if (!empty($temp2)) {
            foreach ($temp2 as $key => $value) {
                $final_perms[$value['id']] = $value;
            }
            unset($temp2);
        }
        if (!empty($final_perms)) {
            _sess_set('user_permissions', $final_perms);
        }
    }

    /**
     * function set_user_roles
     *
     * Sets up the user roles after login.
     *
     * @access  public
     * @return  void
     */
    public function set_user_roles($data)
    {
        $role_ids = array();
        $final_roles = array();

        // Build up an array of user's role IDs.
        $roles = $this->role_model->get_all_roles();
        $user_roles = $this->role_model->get_user_roles($data['id']);
        foreach ($user_roles as $user_value) {
            if ($user_value['active'] == 'Yes') {
                $role_ids[] = $user_value['role_id'];
            }
        }

        // Check whether user has access to each role.
        foreach ($roles as $role_value) {
            if (in_array($role_value['id'], $role_ids)) {
                $final_roles[$role_value['id']] = $role_value;
            }
        }

        // Set the user's roles as determined above in a session variable.
        if (!empty($final_roles)) {
            _sess_set('user_roles', $final_roles);
        }
    }

    /**
     * function set_user_session
     *
     * Sets up the user session data after login.
     *
     * @access  public
     *
     * @param array $creds
     *
     * @return  void
     */
    public function set_user_session($creds = [])
    {

        // Set the default data for the session.
        $data = array(
            'user_id' => $creds['id'],
            'username' => $creds['username'],
            'previous_login_date' => $creds['last_login_date'],
            'previous_ip' => $creds['ip_address'],
            'login_date' => date('Y-m-d H:i:s'),
            'ip_address' => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
        );

        // Sets the basic session variables.
        _sess_set('id', $data['user_id']);
        _sess_set('username', $data['username']);
        _sess_set('current_ip', $data['ip_address']);
        _sess_set('current_login_date', $data['login_date']);
        _sess_set('previous_login_date', $data['previous_login_date']);
        _sess_set('previous_ip', $data['previous_ip']);

        // Sets the user's roles and permissions
        $this->set_user_roles($creds);
        $this->set_user_permissions($creds);
        $this->user_model->update_user_latest_session($data);
        _200('system', 'User ' . $creds['username'] . ' logged in successfully; session data set.');

        // If the user has some previous failed login attempts, reset to 0.
        $this->user_model->reset_attempts($data);
        _200('system', 'User login attempts reset.');

        // If the user logged in with a temporary password, update the user's password to this temporary password.
        if (!empty($creds['temporary_password']))
        {
            $this->user_model->update_user_password_from_temporary_password($creds);
            $this->user_model->unset_temporary_password($data['user_id']);
            _200('system', 'User password updated from temporary password; tempoary password reset.');
        }
    }

    /**
     * function is_logged_in
     *
     * Returns whether the user is logged in.
     *
     * @access  public
     *
     * @return  void
     */
    public function is_logged_in()
    {
        return !empty(_sess_get('id'));
    }

    /**
     * function is_admin
     *
     * Returns whether the user is a super administrator.
     *
     * @access  public
     *
     * @return  void
     */
    public function is_admin()
    {
        return (!empty(_sess_get('id')) && in_array('Super Administrator', _sess_get('user_roles')));
    }

    /**
     * function has_role
     *
     * Returns whether the user has a specific role.
     *
     * @access  public
     *
     * @param string $role
     *
     * @return  void
     */
    public function has_role($role)
    {
        return (!empty(_sess_get('id')) && in_array($role, _sess_get('user_roles')));
    }
}
