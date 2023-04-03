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
 * KyrandiaCMS Block Module
 *
 * This module enables the creation of blocks of content on the site.
 *
 * @package     Impero Consulting
 * @subpackage  Modules
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Block extends MX_Controller
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
        _models_load(['block/block_model']);
        _languages_load(['block/block']);
        _helpers_load(['block/block']);

        // Sets the settings for this module.
        _settings_check('block');
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Block' => [
                'actions' => [
                    $condition . 'list_blocks' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage blocks'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add blocks', 'Manage blocks']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Edit blocks', 'Manage blocks']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete blocks', 'Manage blocks']
                            ]
                        ]
                    ],
                    $condition . 'add_block' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add blocks', 'Manage blocks']
                    ],
                    $condition . 'edit_block' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit blocks', 'Manage blocks']
                    ],
                    $condition . 'get_blocks' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage blocks']
                    ],
                    $condition . 'delete_block' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete blocks', 'Manage blocks']
                    ],
                    $condition . 'export_blocks' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Export blocks', 'Manage blocks']
                    ]
                ]
            ],
        ];
    }

    /**
     * list_blocks
     *
     * Lists all blocks
     *
     * @access public
     *
     * @param int $start
     *
     * @return void
     */
    public function list_blocks($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->block_model->get_block_count(false);
            $data['hint'] = [
                'heading' => lang('block_manage_heading'),
                'message' => lang('block_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('block_manage_empty'),
                'button' => lang('block_add_button')
            ];
            $data['tabledata']['page_data'] = $this->block_model->get_block_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'block_list';
            $data['tabledata']['url'] = 'block/get_blocks';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'block/add_block',
                    'access' => current_user_can('add'),
                    'title' => lang('block_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'block/edit_block',
                    'access' => current_user_can('edit'),
                    'title' => lang('block_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'block/delete_block',
                    'access' => current_user_can('delete'),
                    'title' => lang('block_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'block',
                'model' => 'block_model',
                'function' => 'get_block_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('block_system_blocks_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'block/blocks/list_blocks', $data);
        } else {
            _redir('error', lang('block_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_block
     *
     * Adds a block to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_block()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_block_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['block_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('block_name_label'),
                'hint' => lang('block_name_hint'),
                'placeholder' => lang('block_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['block_title'] = [
                'name' => 'title',
                'id' => 'title',
                'input_class' => 'input-group width-100',
                'label' => lang('block_title_label'),
                'hint' => lang('block_title_hint'),
                'placeholder' => lang('block_title_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['title'], 'title', '')
            ];

            // Nuggets example: 'blocknames' => ['snblock', 'slug', $this->core_model->get_slugs('kcms6_block')]
            $data['fields']['block_body'] = [
                'name' => 'body',
                'id' => 'body',
                'input_class' => 'input-group width-100',
                'label' => lang('block_body_label'),
                'hint' => lang('block_body_hint'),
                'placeholder' => lang('block_body_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'nuggets' => $this->core->set_nuggets([]),
                'value' => _choose(@$data['data']['posts']['body'], 'body', '')
            ];
            $data['fields']['block_view'] = [
                'name' => 'view',
                'id' => 'view',
                'input_class' => 'input-group width-100',
                'label' => lang('block_view_label'),
                'hint' => lang('block_view_hint'),
                'placeholder' => lang('block_view_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['view'], 'view', '')
            ];
            $data['fields']['block_foot'] = [
                'name' => 'foot',
                'id' => 'foot',
                'input_class' => 'input-group width-100',
                'label' => lang('block_foot_label'),
                'hint' => lang('block_foot_hint'),
                'placeholder' => lang('block_view_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['foot'], 'foot', '')
            ];
            $data['fields']['block_author'] = [
                'name' => 'author',
                'id' => 'author',
                'input_class' => 'input-group width-100',
                'label' => lang('block_author_label'),
                'hint' => lang('block_author_hint'),
                'placeholder' => lang('block_author_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['author'], 'author', '')
            ];
            $data['fields']['block_region'] = [
                'name' => 'region',
                'id' => 'region',
                'input_class' => 'input-group width-100',
                'label' => lang('block_region_label'),
                'hint' => lang('block_region_hint'),
                'placeholder' => lang('block_region_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['region'], 'region', '')
            ];
            $data['fields']['block_block_class'] = [
                'name' => 'block_class',
                'id' => 'block_class',
                'input_class' => 'input-group width-100',
                'label' => lang('block_block_class_label'),
                'hint' => lang('block_block_class_hint'),
                'placeholder' => lang('block_block_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['block_class'], 'block_class', '')
            ];
            $data['fields']['block_title_class'] = [
                'name' => 'title_class',
                'id' => 'title_class',
                'input_class' => 'input-group width-100',
                'label' => lang('block_title_class_label'),
                'hint' => lang('block_title_class_hint'),
                'placeholder' => lang('block_title_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['title_class'], 'title_class', '')
            ];
            $data['fields']['block_content_class'] = [
                'name' => 'content_class',
                'id' => 'content_class',
                'input_class' => 'input-group width-100',
                'label' => lang('block_content_class_label'),
                'hint' => lang('block_content_class_hint'),
                'placeholder' => lang('block_content_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['content_class'], 'content_class', '')
            ];
            $data['fields']['block_foot_class'] = [
                'name' => 'foot_class',
                'id' => 'foot_class',
                'input_class' => 'input-group width-100',
                'label' => lang('block_foot_class_label'),
                'hint' => lang('block_foot_class_hint'),
                'placeholder' => lang('block_foot_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['foot_class'], 'foot_class', '')
            ];
            $data['fields']['block_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('block_active_placeholder'),
                'label' => lang('block_active_label'),
                'hint' => lang('block_active_hint'),
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
            $data['fields']['block_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('block_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('block_add_heading'),
                'prompt' => lang('block_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to block listing',
                        'link' => 'block/list_blocks'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->block_model->add_block($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('block_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'block/list_blocks');
                } else {
                    $error = sprintf(lang('block_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'block/list_blocks');
                }
            }
            _render(_cfg('admin_theme'), 'block/blocks/add_block', $data);
        } else {
            _redir('error', lang('block_add_denied'), 'block/list_blocks');
        }
    }

    /**
     * edit_block
     *
     * Modifies a block.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_block($id)
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['item'] = $this->block_model->get_block_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'edit_block_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['block_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('block_name_label'),
                'hint' => lang('block_name_hint'),
                'placeholder' => lang('block_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['block_title'] = [
                'name' => 'title',
                'id' => 'title',
                'input_class' => 'input-group width-100',
                'label' => lang('block_title_label'),
                'hint' => lang('block_title_hint'),
                'placeholder' => lang('block_title_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['title'], 'title', $data['item'][0]['title'])
            ];

            // Nuggets example: 'blocknames' => ['snblock', 'slug', $this->core_model->get_slugs('kcms6_block')]
            $data['fields']['block_body'] = [
                'name' => 'body',
                'id' => 'body',
                'input_class' => 'input-group width-100',
                'label' => lang('block_body_label'),
                'hint' => lang('block_body_hint'),
                'placeholder' => lang('block_body_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'nuggets' => $this->core->set_nuggets([]),
                'value' => _choose(@$data['data']['posts']['body'], 'body', $data['item'][0]['body'])
            ];
            $data['fields']['block_view'] = [
                'name' => 'view',
                'id' => 'view',
                'input_class' => 'input-group width-100',
                'label' => lang('block_view_label'),
                'hint' => lang('block_view_hint'),
                'placeholder' => lang('block_view_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['view'], 'view', $data['item'][0]['view'])
            ];
            $data['fields']['block_foot'] = [
                'name' => 'foot',
                'id' => 'foot',
                'input_class' => 'input-group width-100',
                'label' => lang('block_foot_label'),
                'hint' => lang('block_foot_hint'),
                'placeholder' => lang('block_view_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['foot'], 'foot', $data['item'][0]['foot'])
            ];
            $data['fields']['block_author'] = [
                'name' => 'author',
                'id' => 'author',
                'input_class' => 'input-group width-100',
                'label' => lang('block_author_label'),
                'hint' => lang('block_author_hint'),
                'placeholder' => lang('block_author_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['author'], 'author', $data['item'][0]['author'])
            ];
            $data['fields']['block_region'] = [
                'name' => 'region',
                'id' => 'region',
                'input_class' => 'input-group width-100',
                'label' => lang('block_region_label'),
                'hint' => lang('block_region_hint'),
                'placeholder' => lang('block_region_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['region'], 'region', $data['item'][0]['region'])
            ];
            $data['fields']['block_block_class'] = [
                'name' => 'block_class',
                'id' => 'block_class',
                'input_class' => 'input-group width-100',
                'label' => lang('block_block_class_label'),
                'hint' => lang('block_block_class_hint'),
                'placeholder' => lang('block_block_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['block_class'], 'block_class', $data['item'][0]['block_class'])
            ];
            $data['fields']['block_title_class'] = [
                'name' => 'title_class',
                'id' => 'title_class',
                'input_class' => 'input-group width-100',
                'label' => lang('block_title_class_label'),
                'hint' => lang('block_title_class_hint'),
                'placeholder' => lang('block_title_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['title_class'], 'title_class', $data['item'][0]['title_class'])
            ];
            $data['fields']['block_content_class'] = [
                'name' => 'content_class',
                'id' => 'content_class',
                'input_class' => 'input-group width-100',
                'label' => lang('block_content_class_label'),
                'hint' => lang('block_content_class_hint'),
                'placeholder' => lang('block_content_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['content_class'], 'content_class', $data['item'][0]['content_class'])
            ];
            $data['fields']['block_foot_class'] = [
                'name' => 'foot_class',
                'id' => 'foot_class',
                'input_class' => 'input-group width-100',
                'label' => lang('block_foot_class_label'),
                'hint' => lang('block_foot_class_hint'),
                'placeholder' => lang('block_foot_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['foot_class'], 'foot_class', $data['item'][0]['foot_class'])
            ];
            $data['fields']['block_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('block_active_placeholder'),
                'label' => lang('block_active_label'),
                'hint' => lang('block_active_hint'),
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
            $data['fields']['block_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('block_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('block_edit_heading'),
                'prompt' => lang('block_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to block listing',
                        'link' => 'block/list_blocks'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts']['id'] = $id;
                $affected = $this->block_model->edit_block($data['data']['posts']);
                if (!empty($affected)) {
                    $success = sprintf(lang('block_edit_success'), $data['data']['posts']['name'], $id);
                    _redir('success', $success, 'block/list_blocks');
                } else {
                    $error = sprintf(lang('block_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'block/list_blocks');
                }
            }
            _render(_cfg('admin_theme'), 'block/blocks/edit_block', $data);
        } else {
            _redir('error', lang('block_edit_denied'), 'block/list_blocks');
        }
    }

     /**
     * delete_block
     *
     * Deletes a block from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_block($id)
    {
        if (current_user_can()) {
            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['block_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('block_delete_button'),
                'input_class' => 'btn-primary',
            ];
            $data['id'] = $id;
            $data['item'] = $this->block_model->get_block_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => _cfg('db_prefix') . 'block',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Block' => 'name',
                'Slug' => 'slug',
                'Title' => 'title',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to block listing',
                        'link' => 'block/list_blocks'
                    ]
                ],
                'view' => 'block/blocks/delete_confirm',
                'redirect' => 'block/list_blocks',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('block_delete_heading'),
                'prompt' => lang('block_delete_prompt'),
                'success' => lang('block_delete_success'),
                'error' => lang('block_delete_error'),
                'warning' => lang('block_delete_warn'),
                'return' => lang('block_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('block_delete_denied'), 'block/list_blocks');
        }
    }

    /**
     * function get_blocks
     *
     * Retrieves all blocks for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_blocks()
    {
        $check = _grid_open();
        $blocks = $this->block_model->get_block_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->block_model->get_block_count(false, $check['search']);
        $final = _grid_close($check, $blocks, $count);
        echo $final;
    }
}
