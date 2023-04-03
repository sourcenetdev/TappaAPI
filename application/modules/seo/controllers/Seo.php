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
 * KyrandiaCMS SEO Module
 *
 * Contains the SEO features for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh, Haji Maboko
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Seo extends MX_Controller
{
    private $delete_type = 'hard';
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

        // Loads the module's required modules
        _modules_load(['core', 'user', 'syslog', 'metadata']);
        _models_load(['seo/seo_model']);
        _helpers_load(['seo/seo']);
        _languages_load(['core/core', 'seo/seo']);

        // Retrieves this module's settings
		_settings_check('seo');
	}

    /**
     * index
     *
     * Default controller loads the countries.
     *
     * @access public
     *
     * @return array
     */
    public function index()
    {
        $this->list_headtags();
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Seo' => [
                'actions' => [
                    $condition . 'list_global_headtags' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage global headtags'],
                        'checkpoint' => [
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
                        ]
                    ],
                    $condition . 'to_do' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage users'],
                        'checkpoint' => [
                            'all_roles' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Manage users']
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    /**
     * add_headtag
     *
     * Adds a headtag to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_headtag()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['attributes'] = _get_attributes_mapped(true);
            $data['fields']['form_open'] = [
                'id' => 'add_headtag_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['headtag_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('headtag_name_label'),
                'hint' => lang('headtag_name_hint'),
                'placeholder' => lang('headtag_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['headtag_type'] = [
                'id' => 'type',
                'name' => 'type',
                'placeholder' => lang('headtag_type_placeholder'),
                'label' => lang('headtag_type_label'),
                'hint' => lang('headtag_type_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => [
                    'meta' => 'meta',
                    'link' => 'link',
                    'title' => 'title',
                    'style' => 'style',
                    'script' => 'script',
                    'noscript' => 'noscript',
                    'base' => 'base'
                ],
                'value' => _choose(@$data['data']['posts']['type'], 'type', '')
            ];
            $data['fields']['headtag_attributes'] = [
                'id' => 'attributes',
                'name' => 'attributes[]',
                'placeholder' => lang('headtag_attributes_placeholder'),
                'label' => lang('headtag_attributes_label'),
                'hint' => lang('headtag_attributes_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'multiple' => true,
                'validation' => ['rules' => 'required'],
                'options' => $data['attributes'],
                'value' => _choose(@$data['data']['posts']['attributes'], 'attributes', ''),
            ];
            $data['fields']['headtag_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('headtag_active_placeholder'),
                'label' => lang('headtag_active_label'),
                'hint' => lang('headtag_active_hint'),
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
            $data['fields']['headtag_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('headtag_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('headtag_add_heading'),
                'prompt' => lang('headtag_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to headtag listing',
                        'link' => 'seo/list_headtags'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $p = $data['data']['posts'];
                $insert_id = $this->seo_model->add_headtag($data['data']['posts']);
                if (!empty($insert_id)) {
                    if (!empty($p['attributes'])) {
                        $this->seo_model->add_headtag_attributes($insert_id, $p['attributes']);
                    }
                    $success = sprintf(lang('headtag_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'seo/list_headtags');
                } else {
                    $error = sprintf(lang('headtag_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'seo/list_headtags');
                }
            }
            _render('theme_admin', 'seo/headtags/add_headtag', $data);
        } else {
            _redir('error', lang('headtag_add_denied'), 'seo/list_headtags');
        }
    }

    /**
     * edit_headtag
     *
     * Edits a headtag.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_headtag($id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] =$posts;
            $data['item'] = $this->seo_model->get_headtag_by_id($id);
            $data['attributes'] = _get_attributes_mapped();
            $data['headtag_attributes'] = _get_headtag_attribute_ids($id);
            $data['fields']['form_open'] = [
                'id' => 'add_headtag_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['headtag_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('headtag_name_label'),
                'hint' => lang('headtag_name_hint'),
                'placeholder' => lang('headtag_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['headtag_type'] = [
                'id' => 'type',
                'name' => 'type',
                'placeholder' => lang('headtag_type_placeholder'),
                'label' => lang('headtag_type_label'),
                'hint' => lang('headtag_type_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => [
                    'meta' => 'meta',
                    'link' => 'link',
                    'title' => 'title',
                    'style' => 'style',
                    'script' => 'script',
                    'noscript' => 'noscript',
                    'base' => 'base'
                ],
                'value' => _choose(@$data['data']['posts']['type'], 'type', $data['item'][0]['type'])
            ];
            $data['fields']['headtag_attributes'] = [
                'id' => 'attributes',
                'name' => 'attributes[]',
                'placeholder' => lang('headtag_attributes_placeholder'),
                'label' => lang('headtag_attributes_label'),
                'hint' => lang('headtag_attributes_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => $data['attributes'],
                'multiple' => true,
                'value' => _choose(@$posts['attributes'], 'attributes', $data['headtag_attributes']),
            ];
            $data['fields']['headtag_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('headtag_active_placeholder'),
                'label' => lang('headtag_active_label'),
                'hint' => lang('headtag_active_hint'),
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
            ];
            $data['fields']['headtag_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'label' => lang('headtag_edit_button')
            ];
            $data['data']['messages'] = [
                'heading' => lang('headtag_edit_heading'),
                'prompt' => lang('headtag_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to headtag listing',
                        'link' => 'seo/list_headtags'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->seo_model->edit_headtag($data['data']['posts']);
                if (!empty($posts['attributes'])) {
                    $this->seo_model->delete_headtag_attributes($id);
                    $this->seo_model->add_headtag_attributes($id, $posts['attributes']);
                }
                if ($affected) {
                    $success = sprintf(lang('headtag_edit_success'), $data['data']['posts']['name'], $data['id']);
                    _redir('success', $success, 'seo/list_headtags');
                } else {
                    $error = sprintf(lang('headtag_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'seo/list_headtags');
                }
            }
            _render('theme_admin', 'seo/headtags/edit_headtag', $data);
        } else {
            _redir('error', lang('headtag_edit_denied'), 'core/no_access');
        }
    }

     /**
     * delete_headtag
     *
     * Deletes a headtag from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_headtag($id)
    {
        if (current_user_can()) {

            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['headtag_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('headtag_delete_button'),
                'input_class' => 'btn-primary',
            ];

            $data['id'] = $id;
            $data['item'] = $this->seo_model->get_headtag_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => 'kcms6_headtag_attribute',
                    'field' => 'headtag_id',
                    'value' => $id,
                ],
                1 => [
                    'table' => 'kcms6_headtag',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Headtag' => 'name',
                'Type' => 'type',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to headtag listing',
                        'link' => 'seo/list_headtags'
                    ]
                ],
                'view' => 'seo/headtags/delete_confirm',
                'redirect' => 'seo/list_headtags',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('headtag_delete_heading'),
                'prompt' => lang('headtag_delete_prompt'),
                'success' => lang('headtag_delete_success'),
                'error' => lang('headtag_delete_error'),
                'warning' => lang('headtag_delete_warn'),
                'return' => lang('headtag_delete_return')
            ];
            delete_items($data);
        } else {
            _redir('error', lang('headtag_delete_denied'), 'core/no_access');
        }
    }

     /**
     * list_headtags
     *
     * Lists all headtags
     *
     * @access public
     *
     * @param int $start
     *
     * @return void
     */
    public function list_headtags($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->seo_model->get_headtag_count(false);
            $data['hint'] = [
                'heading' => lang('headtag_manage_heading'),
                'message' => lang('headtag_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('headtag_manage_empty'),
                'button' => lang('headtag_add_button')
            ];
            $data['tabledata']['page_data'] = $this->seo_model->get_headtag_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'headtag_list';
            $data['tabledata']['url'] = 'seo/get_headtags';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'seo/add_headtag',
                    'access' => current_user_can('add'),
                    'title' => lang('headtag_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'seo/edit_headtag',
                    'access' => current_user_can('edit'),
                    'title' => lang('headtag_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'seo/delete_headtag',
                    'access' => current_user_can('delete'),
                    'title' => lang('headtag_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'seo',
                'model' => 'seo_model',
                'function' => 'get_headtag_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('headtag_system_headtags_export')
                ]
            ];
            _render('theme_admin', 'seo/headtags/list_headtags', $data);
        } else {
            _redir('error', lang('headtag_manage_denied'), 'core/no_access');
        }
    }

    /**
     * function get_headtags
     *
     * Retrieves all headtags for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_headtags()
    {
        $check = _grid_open();
        $headtags = $this->seo_model->get_headtag_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->seo_model->get_headtag_count(false, $check['search']);
        $final = _grid_close($check, $headtags, $count);
        echo $final;
    }

    /**
     * add_attribute
     *
     * Adds a attribute to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_attribute()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_attribute_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['attribute_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('attribute_name_label'),
                'hint' => lang('attribute_name_hint'),
                'placeholder' => lang('attribute_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['attribute_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('attribute_active_placeholder'),
                'label' => lang('attribute_active_label'),
                'hint' => lang('attribute_active_hint'),
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
            $data['fields']['attribute_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('attribute_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('attribute_add_heading'),
                'prompt' => lang('attribute_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to attribute listing',
                        'link' => 'seo/list_attributes'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->seo_model->add_attribute($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('attribute_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'seo/list_attributes');
                } else {
                    $error = sprintf(lang('attribute_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'seo/list_attributes');
                }
            }
            _render('theme_admin', 'seo/attributes/add_attribute', $data);
        } else {
            _redir('error', lang('attribute_add_denied'), 'seo/list_attributes');
        }
    }

    /**
     * edit_attribute
     *
     * Edits a attribute.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_attribute($id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] =$posts;
            $data['item'] = $this->seo_model->get_attribute_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'add_attribute_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['attribute_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('attribute_name_label'),
                'hint' => lang('attribute_name_hint'),
                'placeholder' => lang('attribute_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['attribute_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('attribute_active_placeholder'),
                'label' => lang('attribute_active_label'),
                'hint' => lang('attribute_active_hint'),
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
            ];
            $data['fields']['attribute_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'label' => lang('attribute_edit_button')
            ];
            $data['data']['messages'] = [
                'heading' => lang('attribute_edit_heading'),
                'prompt' => lang('attribute_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to attribute listing',
                        'link' => 'seo/list_attributes'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->seo_model->edit_attribute($data['data']['posts']);
                if ($affected) {
                    $success = sprintf(lang('attribute_edit_success'), $data['data']['posts']['name'], $data['id']);
                    _redir('success', $success, 'seo/list_attributes');
                } else {
                    $error = sprintf(lang('attribute_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'seo/list_attributes');
                }
            }
            _render('theme_admin', 'seo/attributes/edit_attribute', $data);
        } else {
            _redir('error', lang('attribute_edit_denied'), 'core/no_access');
        }
    }

     /**
     * delete_attribute
     *
     * Deletes a attribute from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_attribute($id)
    {
        if (current_user_can()) {

            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['attribute_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('attribute_delete_button'),
                'input_class' => 'btn-primary',
            ];

            $data['id'] = $id;
            $data['item'] = $this->seo_model->get_attribute_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => 'kcms6_attribute',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Attribute' => 'name',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to attribute listing',
                        'link' => 'seo/list_attributes'
                    ]
                ],
                'view' => 'seo/attributes/delete_confirm',
                'redirect' => 'seo/list_attributes',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('attribute_delete_heading'),
                'prompt' => lang('attribute_delete_prompt'),
                'success' => lang('attribute_delete_success'),
                'error' => lang('attribute_delete_error'),
                'warning' => lang('attribute_delete_warn'),
                'return' => lang('attribute_delete_return')
            ];
            delete_items($data);
        } else {
            _redir('error', lang('attribute_delete_denied'), 'core/no_access');
        }
    }

     /**
     * list_attributes
     *
     * Lists all attributes
     *
     * @access public
     *
     * @param int $start
     *
     * @return void
     */
    public function list_attributes($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->seo_model->get_attribute_count(false);
            $data['hint'] = [
                'heading' => lang('attribute_manage_heading'),
                'message' => lang('attribute_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('attribute_manage_empty'),
                'button' => lang('attribute_add_button')
            ];
            $data['tabledata']['page_data'] = $this->seo_model->get_attribute_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'attribute_list';
            $data['tabledata']['url'] = 'seo/get_attributes';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'seo/add_attribute',
                    'access' => current_user_can('add'),
                    'title' => lang('attribute_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'seo/edit_attribute',
                    'access' => current_user_can('edit'),
                    'title' => lang('attribute_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'seo/delete_attribute',
                    'access' => current_user_can('delete'),
                    'title' => lang('attribute_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'seo',
                'model' => 'seo_model',
                'function' => 'get_attribute_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('attribute_system_attributes_export')
                ]
            ];
            _render('theme_admin', 'seo/attributes/list_attributes', $data);
        } else {
            _redir('error', lang('attribute_manage_denied'), 'core/no_access');
        }
    }

    /**
     * function get_attributes
     *
     * Retrieves all attributes for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_attributes()
    {
        $check = _grid_open();
        $attributes = $this->seo_model->get_attribute_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->seo_model->get_attribute_count(false, $check['search']);
        $final = _grid_close($check, $attributes, $count);
        echo $final;
    }

    /**
     * list_global_headtags
     *
     * Lists all global_headtags
     *
     * @access public
     *
     * @param int $start
     *
     * @return void
     */
    public function list_global_headtags($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->seo_model->get_global_headtag_count(false);
            $data['hint'] = [
                'heading' => lang('global_headtag_manage_heading'),
                'message' => lang('global_headtag_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('global_headtag_manage_empty'),
                'button' => lang('global_headtag_add_button')
            ];
            $data['tabledata']['page_data'] = $this->seo_model->get_global_headtag_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'global_headtag_list';
            $data['tabledata']['url'] = 'seo/get_global_headtags';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'seo/add_global_headtag',
                    'access' => current_user_can('add'),
                    'title' => lang('global_headtag_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'seo/edit_global_headtag',
                    'access' => current_user_can('edit'),
                    'title' => lang('global_headtag_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'seo/delete_global_headtag',
                    'access' => current_user_can('delete'),
                    'title' => lang('global_headtag_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'seo',
                'model' => 'seo_model',
                'function' => 'get_global_headtag_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('global_headtag_system_global_headtags_export')
                ]
            ];
            _render('theme_admin', 'seo/global_headtags/list_global_headtags', $data);
        } else {
            _redir('error', lang('global_headtag_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_global_headtag
     *
     * Adds a global headtag to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_global_headtag()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_globaltag_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            if (!empty($data['data']['posts']['meta'])) {
                foreach ($data['data']['posts']['meta'] as $k => $v) {
                    $data['headtags_list']['meta'][$v] = $v;
                    if (!empty($data['data']['posts']['meta_value'])) {
                        foreach ($data['data']['posts']['meta_value'] as $kk => $vv) {
                            $data['headtags_list']['meta_value'][$kk] = $vv;
                        }
                    }
                }
            }
            $headtags_map = _get_headtags_mapped(true);
            $data['fields']['global_headtag_headtag_id'] = [
                'id' => 'headtag_id',
                'name' => 'headtag_id',
                'placeholder' => lang('global_headtag_headtag_id_placeholder'),
                'label' => lang('global_headtag_headtag_id_label'),
                'hint' => lang('global_headtag_headtag_id_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => $headtags_map,
                'value' => _choose(@$data['data']['posts']['headtag_id'], 'headtag_id', '')
            ];
            $data['fields']['global_headtag_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('global_headtag_active_placeholder'),
                'label' => lang('global_headtag_active_label'),
                'hint' => lang('global_headtag_active_hint'),
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
            $data['fields']['global_headtag_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('global_headtag_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('global_headtag_add_heading'),
                'prompt' => lang('global_headtag_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to global headtag listing',
                        'link' => 'seo/list_global_headtags'
                    ]
                ]
            ];
            $p = $data['data']['posts'];
            if (!empty($p['meta_value'])) {
                foreach ($p['meta_value'] as $k => $v) {
                    $data['fields']['meta_value[' . $k . ']'] = [
                        'name' => 'meta_value[' . $k . ']',
                        'id' => 'meta_value[' . $k . ']',
                        'label' => 'value of the headtag',
                        'validation' => [
                            'rules' => 'required'
                        ],
                        'value' => $p['meta_value'][$k]
                    ];
                }
            }
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->seo_model->add_global_headtag($p);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('global_headtag_add_success'), $p['headtag_id']);
                    _redir('success', $success, 'seo/list_global_headtags');
                } else {
                    $error = sprintf(lang('global_headtag_add_error'), $p['name']);
                    _redir('error', $error, 'seo/list_global_headtag');
                }
            }
            _render('theme_admin', 'seo/global_headtags/add_global_headtag', $data);
        } else {
            _redir('error', lang('global_headtag_add_denied'), 'seo/list_global_headtag');
        }
    }

    /**
     * edit_global_headtag
     *
     * Modifies a global headtag.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_global_headtag($id)
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['item'] = $this->seo_model->get_global_headtag_by_id($id);
            $data['headtag_id'] = $data['item']['headtag_id'];
            $data['fields']['form_open'] = [
                'id' => 'edit_page_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['global_headtag_headtag'] = [
                'type' => 'text',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'id' => 'headtag',
                'name' => 'headtag',
                'readonly' => 'readonly',
                'label' => 'Headtag',
                'input_class' => 'input-group-wide width-100',
                'hint' => 'This is the head tag you are editing (cannot be changed).',
                'validation' => ['rules' => 'required'],
                'value' => $data['item']['value']
            ];
            $data['fields']['global_headtag_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('global_headtag_active_placeholder'),
                'label' => lang('global_headtag_active_label'),
                'hint' => lang('global_headtag_active_hint'),
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
                'value' => _choose(@$data['data']['posts']['active'], 'active', $data['item']['active'])
            ];
            if (!empty($data['item'])) {
                foreach ($data['item']['attributes'] as $k => $v) {
                    $val = explode('--', $v);
                    $data['fields']['global_headtag_fields'][$k] = [
                        'type' => 'text',
                        'name' => 'attributes[' . $val[0] . ']',
                        'id' => 'gha_' . $k,
                        'input_class' => 'input-group-wide width-100',
                        'label' => ucfirst($k),
                        'hint' => 'Enter the value of attribute ' . ucfirst($k),
                        'placeholder' => 'Enter the value of attribute ' . ucfirst($k),
                        'value' => $val[1],
                        'validation' => ['rules' => 'required']
                    ];
                }
            }
            $data['fields']['global_headtag_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('global_headtag_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('global_headtag_edit_heading'),
                'prompt' => lang('global_headtag_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to global headtag listing',
                        'link' => 'seo/list_global_headtags'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $p = $data['data']['posts'];
                $p['id'] = $id;
                $affected = $this->seo_model->edit_global_headtag($p);
                if (!empty($affected)) {
                    $success = sprintf(lang('page_edit_success'), $id);
                    _redir('success', $success, 'seo/list_global_headtags');
                } else {
                    $error = lang('page_edit_error');
                    _redir('error', $error, 'seo/list_global_headtags');
                }
            }
            _render('theme_admin', 'seo/global_headtags/edit_global_headtag', $data);
        } else {
            _redir('error', lang('global_headtag_edit_denied'), 'seo/list_global_headtags');
        }
    }

     /**
     * delete_global_headtag
     *
     * Deletes a global_headtag from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_global_headtag($id)
    {
        if (current_user_can()) {
            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['page_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('global_headtag_delete_button'),
                'input_class' => 'btn-primary',
            ];
            $data['id'] = $id;
            $data['item'] = $this->seo_model->get_global_headtag_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => 'kcms6_global_meta',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Value' => 'value',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to global headtag listing',
                        'link' => 'seo/list_global_headtags'
                    ]
                ],
                'view' => 'seo/global_headtags/delete_confirm',
                'redirect' => 'seo/list_global_headtags',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('global_headtag_delete_heading'),
                'prompt' => lang('global_headtag_delete_prompt'),
                'success' => lang('global_headtag_delete_success'),
                'error' => lang('paglobal_headtagge_delete_error'),
                'warning' => lang('global_headtag_delete_warn'),
                'return' => lang('global_headtag_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('global_headtag_delete_denied'), 'seo/list_global_headtags');
        }
    }

    /**
     * function get_global_headtags
     *
     * Retrieves all global headtags for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_global_headtags()
    {
        $check = _grid_open();
        $tags = $this->seo_model->get_global_headtag_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->seo_model->get_global_headtag_count(false, $check['search']);
        $final = _grid_close($check, $tags, $count);
        echo $final;
    }

    /**
     * function `_element_group
     *
     * Builds the dropdown and text field combination to add a page headtag meta group.
     *
     * @access public
     *
     * @param string $opts
     *
     * @return string
     */
    public function build_meta_element_group($data = null)
    {
        $posts = $data;
        $return = '
            <div>
                <div class="row">
                    <div class="col-sm-12" id="meta-key-box" style="display: block;"></div>
                </div>
                <script type="text/javascript">
                    $(function() {
                        var tag_id = $("#headtag_id").val();
                        var base_url2 = "' . base_url() . 'seo/ajax_get_global_headtag_attributes";
                        if (tag_id != 0 && typeof(tag_id) != "undefined") {
                            $.ajax(base_url2 + "/" + tag_id, {
                                type: "POST",
                                data: ' . json_encode($posts) . ',
                                success: function(response3) {
                                    if (response3) {
                                        $("#meta-key-box").html(response3);
                                        $("#meta-key-box").show();
                                    }
                                }
                            });
                        }
                    });
                </script>
            </div>
        ';
        echo json_encode($return);
    }

    public function ajax_get_global_headtag_attributes($headtag_id)
    {
        $attributes = _get_headtag_attributes($headtag_id);
        $posts = _post();
        if (!empty($attributes)) {
            $final = '<div class="row">';
            foreach ($attributes as $v) {
                $final .= '
                    <div class="col-sm-6 col-md-4">
                        <label>' . ucfirst($v['name']) . '</label>
                        <div class="hint-text">' . lang('global_headtag_seo_prefix') . ' "' . ucfirst($v['name']) . '"</div>
                        <input value="' . (!empty($posts['meta_value'][$v['headtag_id']][$v['attribute_id']]) ? $posts['meta_value'][$v['headtag_id']][$v['attribute_id']] : '') . '" name="meta_value[' . $v['attribute_id'] . ']" class="input-group-wide width-100" style="height: 48px !important;" type="text" id="meta_value_' . $v['attribute_id'] . '">
                    </div>
                ';
                $this->form_validation->set_rules('meta_value[' . $v['attribute_id'] . ']', 'meta_value[' . $v['attribute_id'] . ']', 'required');
            }
            $final .= '</div>';
            echo $final;
        }
    }
}
