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
 * Contains the module features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Module extends MX_Controller
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
        _modules_load(['syslog', 'metadata', 'variable', 'core']);
        _models_load(['module/module_model']);
        _languages_load(['module/module']);
        _helpers_load(['module/module']);

        // Sets the settings for this module.
        _settings_check('module');

        // Delete type
        if (empty($this->delete_type)) {
            $this->delete_type = $this->get_variable('delete_type');
            if (empty($this->delete_type)) {
                $this->delete_type = 'soft';
            }
        }
    }

    public function admin_menu_hook()
    {
        return [
            'text' => 'Modules',
            'link' => 'module/list_modules_data',
            'icon' => 'view-module',
            'type' => 'relative',
            'target' => 'self',
            'roles' => ['Super Administrator', 'Modules Manager'],
            'permissions' => ['Manage modules'],
            'order' => 4,
            'sub_menu_items' => []
        ];
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Module' => [
                'actions' => [
                    $condition . 'list_modules_data' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage modules'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add modules', 'Manage modules']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Edit modules', 'Manage modules']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete modules', 'Manage modules']
                            ]
                        ]
                    ],
                    $condition . 'add_module' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add modules', 'Manage modules']
                    ],
                    $condition . 'edit_module' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit modules', 'Manage modules']
                    ],
                    $condition . 'get_modules' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage modules'],
                    ],
                    $condition . 'delete_module' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete modules', 'Manage modules']
                    ],
                    $condition . 'disable_module' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Disable modules', 'Manage modules']
                    ],
                    $condition . 'enable_module' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Enable modules', 'Manage modules']
                    ]
                ]
            ],
        ];
    }

    /**
     * list_modules_data
     *
     * Lists all modules
     *
     * @access public
     *
     * @param int $start
     *
     * @return void
     */
    public function list_modules_data($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->module_model->get_modules_count(false);
            $data['hint'] = [
                'heading' => lang('module_module_manage_heading'),
                'message' => lang('module_module_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('module_module_manage_empty'),
                'button' => lang('module_module_add_button')
            ];
            $data['tabledata']['page_data'] = $this->module_model->get_module_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'modules_list';
            $data['tabledata']['url'] = 'module/get_modules';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'module/add_module',
                    'access' => current_user_can('add'),
                    'title' => lang('module_module_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'module/edit_module',
                    'access' => current_user_can('edit'),
                    'title' => lang('module_module_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'module/delete_module',
                    'access' => current_user_can('delete'),
                    'title' => lang('module_module_delete_button'),
                    'condition_and' => [
                        'required' => [
                            'column' => 'required',
                            'operator' => '===',
                            'value' => 'No'
                        ]
                    ],
                    'disabled_icon' => 'close-circle mdc-text-grey-300',
                    'disabled_title' => 'This module cannot be disabled as it is a required module.',
                    'show_disabled' => 'No'
                ],
                'disable' => [
                    'icon' => 'close-circle mdc-text-purple',
                    'link' => 'module/disable_module',
                    'access' => current_user_can(NULL, __CLASS__, 'disable_module'),
                    'title' => 'Disable this module',
                    'condition_and' => [
                        'disabled' => [
                            'column' => 'disabled',
                            'operator' => '===',
                            'value' => 'No'
                        ],
                        'required' => [
                            'column' => 'required',
                            'operator' => '===',
                            'value' => 'No'
                        ]
                    ],
                    'disabled_icon' => 'close-circle mdc-text-grey-300',
                    'disabled_title' => 'This module cannot be disabled as it is a required module.',
                    'show_disabled' => 'No'
                ],
                'enable' => [
                    'icon' => 'check-circle mdc-text-purple',
                    'link' => 'module/enable_module',
                    'access' => current_user_can(NULL, __CLASS__, 'enable_module'),
                    'title' => 'Enable this module',
                    'condition_and' => [
                        'disabled' => [
                            'column' => 'disabled',
                            'operator' => '===',
                            'value' => 'Yes'
                        ]
                    ],
                    'disabled_icon' => 'check-circle mdc-text-grey-300',
                    'disabled_title' => 'This module cannot be enabled.',
                    'show_disabled' => 'No'
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'module',
                'model' => 'module_model',
                'function' => 'get_module_list',
                'parameters' => [
                    'type' => 'table',
                    'orientation' => 'landscape',
                    'title' => lang('module_module_system_modules_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'module/modules/list_modules', $data);
        } else {
            _redir('error', lang('module_module_manage_denied'), 'core/no_access');
        }
    }

    /**
     * function get_modules
     *
     * Retrieves all modules for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_modules()
    {
        $check = _grid_open();
        $modules = $this->module_model->get_module_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->module_model->get_modules_count(false, $check['search']);
        $final = _grid_close($check, $modules, $count);
        echo $final;
    }

    /**
     * add_module
     *
     * Adds a module to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_module()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_module_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['module_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('core_name'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('module_module_field_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['module_description'] = [
                'id' => 'description',
                'name' => 'description',
                'placeholder' => lang('module_module_field_description_placeholder'),
                'input_class' => 'input-group-wide width-100',
                'label' => lang('core_description'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['description'], 'description', '')
            ];
            $data['fields']['module_version'] = [
                'id' => 'version',
                'name' => 'version',
                'placeholder' => lang('module_module_field_version_placeholder'),
                'input_class' => 'input-group-wide width-100',
                'label' => lang('core_version'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['version'], 'version', '')
            ];
            $data['fields']['module_author'] = [
                'id' => 'author',
                'name' => 'author',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('module_module_field_author_label'),
                'hint' => lang('module_module_field_author_hint'),
                'placeholder' => lang('module_module_field_author_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['author'], 'author', '')
            ];
            $data['fields']['module_author_site'] = [
                'id' => 'author_site',
                'name' => 'author_site',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('module_module_field_author_site_label'),
                'hint' => lang('module_module_field_author_site_hint'),
                'placeholder' => lang('module_module_field_author_site_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['author_site'], 'author_site', '')
            ];
            $data['fields']['module_author_contact'] = [
                'id' => 'author_contact',
                'name' => 'author_contact',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('module_module_field_author_contact_label'),
                'hint' => lang('module_module_field_author_contact_hint'),
                'placeholder' => lang('module_module_field_author_contact_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['author_contact'], 'author_contact', '')
            ];
            $cat_id = $this->metadata_model->get_metadata_category_by_name('Modules')[0]['id'];
            $categories = $this->metadata_model->get_all_metadata_items($cat_id, true);
            $category_map = $this->core->map_fields($categories, ['id', 'name']);
            $data['fields']['module_category'] = [
                'id' => 'category_id',
                'name' => 'category_id',
                'placeholder' => lang('module_module_field_category_placeholder'),
                'label' => lang('module_module_field_category_label'),
                'hint' => lang('module_module_field_category_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => $category_map,
                'value' => _choose(@$data['data']['posts']['category_id'], 'category_id', '')
            ];
            $status_id = $this->metadata_model->get_metadata_category_by_name('Module Statuses')[0]['id'];
            $statuses = $this->metadata_model->get_all_metadata_items($status_id, true);
            $status_map = $this->core->map_fields($statuses, ['name', 'name']);
            $data['fields']['module_status'] = [
                'id' => 'status',
                'name' => 'status',
                'placeholder' => lang('module_module_field_status_placeholder'),
                'label' => lang('module_module_field_status_label'),
                'hint' => lang('module_module_field_status_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => $status_map,
                'value' => _choose(@$data['data']['posts']['status'], 'status', '')
            ];
            $data['fields']['module_required'] = [
                'id' => 'required',
                'name' => 'required',
                'placeholder' => lang('module_module_field_required_placeholder'),
                'label' => lang('module_module_field_required_label'),
                'hint' => lang('module_module_field_required_hint'),
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
                'value' => _choose(@$data['data']['posts']['required'], 'required', '')
            ];
            $data['fields']['module_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('module_module_field_active_placeholder'),
                'label' => lang('module_module_field_active_label'),
                'hint' => lang('module_module_field_active_hint'),
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
            $data['fields']['module_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('module_module_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('module_module_add_heading'),
                'prompt' => lang('comodulere_module_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to module listing',
                        'link' => 'module/list_modules_data'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->module_model->add_module($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('module_module_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'module/list_modules_data');
                } else {
                    $error = sprintf(lang('module_module_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'module/list_modules_data');
                }
            }
            _render(_cfg('admin_theme'), 'module/modules/add_module', $data);
        } else {
            _redir('error', lang('module_module_add_denied'), 'module/list_modules_data');
        }
    }

    /**
     * edit_module
     *
     * Edits a module in the database.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_module($id)
    {
        if (current_user_can()) {
            $data['id'] = $id;
            $data['data']['posts'] = _post();
            $data['item'] = $this->module_model->get_module_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'edit_module_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['module_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('core_name'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('module_module_field_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['module_description'] = [
                'id' => 'description',
                'name' => 'description',
                'placeholder' => lang('module_module_field_description_placeholder'),
                'input_class' => 'input-group-wide width-100',
                'label' => lang('core_description'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['description'], 'description', $data['item'][0]['description'])
            ];
            $data['fields']['module_version'] = [
                'id' => 'version',
                'name' => 'version',
                'placeholder' => lang('module_module_field_version_placeholder'),
                'input_class' => 'input-group-wide width-100',
                'label' => lang('core_version'),
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['version'], 'version', $data['item'][0]['version'])
            ];
            $data['fields']['module_author'] = [
                'id' => 'author',
                'name' => 'author',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('module_module_field_author_label'),
                'hint' => lang('module_module_field_author_hint'),
                'placeholder' => lang('module_module_field_author_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['author'], 'author', $data['item'][0]['author'])
            ];
            $data['fields']['module_author_site'] = [
                'id' => 'author_site',
                'name' => 'author_site',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('module_module_field_author_site_label'),
                'hint' => lang('module_module_field_author_site_hint'),
                'placeholder' => lang('module_module_field_author_site_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['author_site'], 'author_site', $data['item'][0]['author_site'])
            ];
            $data['fields']['module_author_contact'] = [
                'id' => 'author_contact',
                'name' => 'author_contact',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('module_module_field_author_contact_label'),
                'hint' => lang('module_module_field_author_contact_hint'),
                'placeholder' => lang('module_module_field_author_contact_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['author_contact'], 'author_contact', $data['item'][0]['author_contact'])
            ];
            $cat_id = $this->metadata_model->get_metadata_category_by_name('Modules')[0]['id'];
            $categories = $this->metadata_model->get_all_metadata_items($cat_id, true);
            $category_map = $this->core->map_fields($categories, ['id', 'name']);
            $data['fields']['module_category'] = [
                'id' => 'category_id',
                'name' => 'category_id',
                'placeholder' => lang('module_module_field_category_placeholder'),
                'label' => lang('module_module_field_category_label'),
                'hint' => lang('module_module_field_category_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => $category_map,
                'value' => _choose(@$data['data']['posts']['category_id'], 'category_id', $data['item'][0]['category_id'])
            ];
            $status_id = $this->metadata_model->get_metadata_category_by_name('Module Statuses')[0]['id'];
            $statuses = $this->metadata_model->get_all_metadata_items($status_id, true);
            $status_map = $this->core->map_fields($statuses, ['name', 'name']);
            $data['fields']['module_status'] = [
                'id' => 'status',
                'name' => 'status',
                'placeholder' => lang('module_module_field_status_placeholder'),
                'label' => lang('module_module_field_status_label'),
                'hint' => lang('module_module_field_status_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => $status_map,
                'value' => _choose(@$data['data']['posts']['status'], 'status', $data['item'][0]['status'])
            ];
            $data['fields']['module_required'] = [
                'id' => 'required',
                'name' => 'required',
                'placeholder' => lang('module_module_field_required_placeholder'),
                'label' => lang('module_module_field_required_label'),
                'hint' => lang('module_module_field_required_hint'),
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
                'value' => _choose(@$data['data']['posts']['required'], 'required', $data['item'][0]['required'])
            ];
            $data['fields']['module_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('module_module_field_active_placeholder'),
                'label' => lang('module_module_field_active_label'),
                'hint' => lang('module_module_field_active_hint'),
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
            $data['fields']['module_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('module_module_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('module_module_add_heading'),
                'prompt' => lang('module_module_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to module listing',
                        'link' => 'module/list_modules_data'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->module_model->edit_module($data['data']['posts']);
                if (!empty($affected)) {
                    $success = sprintf(lang('module_module_edit_success'), $data['data']['posts']['name'], $affected);
                    _redir('success', $success, 'module/list_modules_data');
                } else {
                    $error = sprintf(lang('module_module_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'module/list_modules_data');
                }
            }
            _render(_cfg('admin_theme'), 'module/modules/add_module', $data);
        } else {
            _redir('error', lang('module_module_add_denied'), 'module/list_modules_data');
        }
    }

    /**
     * delete_module
     *
     * Deletes a module from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_module($id)
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
            $data['fields']['module_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('module_module_delete_button'),
                'input_class' => 'btn-primary',
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->module_model->get_module_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => _cfg('db_prefix') . 'module',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Module' => 'name',
                'Active' => 'active'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to module listing',
                        'link' => 'module/list_modules_data'
                    ]
                ],
                'view' => 'module/modules/delete_confirm',
                'redirect' => 'module/list_modules_data',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('module_module_delete_heading'),
                'prompt' => lang('module_module_delete_prompt'),
                'success' => lang('module_module_delete_success'),
                'error' => lang('module_module_delete_error'),
                'warning' => lang('core_delete_warn'),
                'return' => lang('module_module_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('module_module_delete_denied'), 'core/no_access');
        }
    }

    /**
     * disable_module
     *
     * Disables a module.
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function disable_module($id)
    {
        if (current_user_can()) {

            // Form elements
            $data['fields']['form_open'] = [
                'id' => 'disable_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['disabled_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('module_module_disable_button'),
                'input_class' => 'btn-primary'
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->module_model->get_module_by_id($id);
            $data['prompt_fields'] = [
                'Name' => 'name',
                'Description' => 'description',
                'Author' => 'author',
                'Version' => 'version',
                'Active' => 'active',
                'Modified date' => 'moddate'
            ];
            $data['field_info'] = [
                'id_field' => 'id',
                'id_value' => $id,
                'items' => [
                    0 => [
                        'table' => _cfg('db_prefix') . 'module',
                        'field' => 'disabled',
                        'value' => 'Yes'
                    ],
                    1 => [
                        'table' => _cfg('db_prefix') . 'module',
                        'field' => 'active',
                        'value' => 'No'
                    ]
                ]
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to module listing',
                        'link' => 'module/list_modules_data'
                    ]
                ],
                'redirect' => 'module/list_modules_data',
                'view' => 'module/modules/disable_confirm'
            ];
            $data['messages'] = [
                'heading' => lang('module_module_disable_heading'),
                'prompt' => lang('module_module_disable_prompt'),
                'success' => lang('module_module_disable_success'),
                'error' => lang('module_module_disable_error'),
                'warning' => lang('module_module_disable_warn'),
                'return' => lang('module_module_disable_return')
            ];
            $data['is_confirmed'] = _post('is_confirmed');
            _update_db_field($data);
        } else {
            _redir('error', lang('module_module_disable_denied'), 'core/no_access');
        }
    }

    /**
     * enable_module
     *
     * Enables a module.
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function enable_module($id)
    {
        if (current_user_can()) {

            // Form elements
            $data['fields']['form_open'] = [
                'id' => 'enable_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['enabled_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('module_module_enable_button'),
                'input_class' => 'btn-primary'
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->module_model->get_module_by_id($id);
            $data['prompt_fields'] = [
                'Name' => 'name',
                'Description' => 'description',
                'Author' => 'author',
                'Version' => 'version',
                'Active' => 'active',
                'Modified date' => 'moddate'
            ];
            $data['field_info'] = [
                'id_field' => 'id',
                'id_value' => $id,
                'items' => [
                    0 => [
                        'table' => _cfg('db_prefix') . 'module',
                        'field' => 'disabled',
                        'value' => 'No'
                    ],
                    1 => [
                        'table' => _cfg('db_prefix') . 'module',
                        'field' => 'active',
                        'value' => 'Yes'
                    ]
                ]
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to module listing',
                        'link' => 'module/list_modules_data'
                    ]
                ],
                'redirect' => 'module/list_modules_data',
                'view' => 'module/modules/enable_confirm'
            ];
            $data['messages'] = [
                'heading' => lang('module_module_enable_heading'),
                'prompt' => lang('module_module_enable_prompt'),
                'success' => lang('module_module_enable_success'),
                'error' => lang('module_module_enable_error'),
                'warning' => lang('module_module_enable_warn'),
                'return' => lang('module_module_enable_return')
            ];
            $data['is_confirmed'] = _post('is_confirmed');
            _update_db_field($data);
        } else {
            _redir('error', lang('module_module_enable_denied'), 'core/no_access');
        }
    }
}
