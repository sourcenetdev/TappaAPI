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
 * KyrandiaCMS Info Block Component
 *
 * Allows the generation of info blocks on the site.
 *
 * @package     Impero
 * @subpackage  Libraries
 * @category    Widgets
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Info_block extends Widget
{

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

        // Loads this library's resources
        _models_load(['widget/info_block_model']);
        _languages_load(['widget/info_block']);
        _helpers_load(['widget/info_block']);
    }

    /**
     * list_info_blocks
     *
     * Lists all info blocks
     *
     * @access public
     *
     * @param int $start
     *
     * @link https://imperoconsulting.atlassian.net/wiki/spaces/IC/pages/1102446626/Bootstrap+Helper Function reference for bootstrap helper functions
     *
     * @return void
     */
    public function list_info_blocks($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->info_block_model->get_info_block_count(false);
            $data['hint'] = [
                'heading' => lang('info_block_manage_heading'),
                'message' => lang('info_block_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('info_block_manage_empty'),
                'button' => lang('info_block_add_button')
            ];
            $data['tabledata']['page_data'] = $this->info_block_model->get_info_block_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'info_block_list';
            $data['tabledata']['url'] = 'widget/load_widget/info_block/get_info_blocks';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'widget/load_widget/info_block/add_info_block',
                    'access' => current_user_can('add'),
                    'title' => lang('info_block_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'widget/load_widget/info_block/edit_info_block',
                    'access' => current_user_can('edit'),
                    'title' => lang('info_block_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'widget/load_widget/info_block/delete_info_block',
                    'access' => current_user_can('delete'),
                    'title' => lang('info_block_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'info_block',
                'model' => 'widget/info_block_model',
                'function' => 'get_info_block_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('info_block_system_info_blocks_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'info_blocks/list_info_blocks', $data);
        } else {
            _redir('error', lang('info_block_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_info_block
     *
     * Adds an info block to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_info_block()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_info_block_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['info_block_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('info_block_name_label'),
                'hint' => lang('info_block_name_hint'),
                'placeholder' => lang('info_block_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['info_block_description'] = [
                'id' => 'description',
                'name' => 'description',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_description_label'),
                'hint' => lang('info_block_description_hint'),
                'placeholder' => lang('info_block_description_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['description'], 'description', '')
            ];
            $data['fields']['info_block_info_group'] = [
                'id' => 'info_group',
                'name' => 'info_group',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_info_group_label'),
                'hint' => lang('info_block_info_group_hint'),
                'placeholder' => lang('info_block_info_group_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['info_group'], 'info_group', '')
            ];
            $data['fields']['info_block_image_path'] = [
                'id' => 'image_path',
                'name' => 'image_path',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_image_path_label'),
                'hint' => lang('info_block_image_path_hint'),
                'placeholder' => lang('info_block_image_path_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['image_path'], 'image_path', '')
            ];
            $data['fields']['info_block_image_file'] = [
                'id' => 'image_file',
                'name' => 'image_file',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_image_file_label'),
                'hint' => lang('info_block_image_file_hint'),
                'placeholder' => lang('info_block_image_file_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['image_file'], 'image_file', '')
            ];
            $data['fields']['info_block_body_text'] = [
                'id' => 'body_text',
                'name' => 'body_text',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_body_text_label'),
                'hint' => lang('info_block_body_text_hint'),
                'placeholder' => lang('info_block_body_text_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['body_text'], 'body_text', '')
            ];
            $data['fields']['info_block_image_text'] = [
                'id' => 'image_text',
                'name' => 'image_text',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_image_text_label'),
                'hint' => lang('info_block_image_text_hint'),
                'placeholder' => lang('info_block_image_text_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['image_text'], 'image_text', '')
            ];
            $data['fields']['info_block_image_heading'] = [
                'id' => 'image_heading',
                'name' => 'image_heading',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_image_heading_label'),
                'hint' => lang('info_block_image_heading_hint'),
                'placeholder' => lang('info_block_image_heading_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['image_heading'], 'image_heading', '')
            ];
            $data['fields']['info_block_button_class'] = [
                'id' => 'button_class',
                'name' => 'button_class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_button_class_label'),
                'hint' => lang('info_block_button_class_hint'),
                'placeholder' => lang('info_block_button_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['button_class'], 'button_class', '')
            ];
            $data['fields']['info_block_button_text'] = [
                'id' => 'button_text',
                'name' => 'button_text',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_button_text_label'),
                'hint' => lang('info_block_button_text_hint'),
                'placeholder' => lang('info_block_button_text_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['button_text'], 'button_text', '')
            ];
            $data['fields']['info_block_section_id'] = [
                'id' => 'section_id',
                'name' => 'section_id',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_section_id_label'),
                'hint' => lang('info_block_section_id_hint'),
                'placeholder' => lang('info_block_section_id_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['section_id'], 'section_id', '')
            ];
            $data['fields']['info_block_section_class'] = [
                'id' => 'section_class',
                'name' => 'section_class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_section_class_label'),
                'hint' => lang('info_block_section_class_hint'),
                'placeholder' => lang('info_block_section_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['section_class'], 'section_class', '')
            ];
            $data['fields']['info_block_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('info_block_active_placeholder'),
                'label' => lang('info_block_active_label'),
                'hint' => lang('info_block_active_hint'),
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
            $data['fields']['info_block_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('info_block_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('info_block_add_heading'),
                'prompt' => lang('info_block_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to info block listing',
                        'link' => 'widget/load_widget/info_block/list_info_blocks'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->info_block_model->add_info_block($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('info_block_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'widget/load_widget/info_block/list_info_blocks');
                } else {
                    $error = sprintf(lang('info_block_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/info_block/list_info_blocks');
                }
            }
            _render(_cfg('admin_theme'), 'info_blocks/add_info_block', $data);
        } else {
            _redir('error', lang('info_block_add_denied'), 'widget/load_widget/info_block/list_info_blocks');
        }
    }

    /**
     * edit_info_block
     *
     * Edits an info block.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_info_block($id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] = $posts;
            $data['item'] = $this->info_block_model->get_info_block_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'add_info_block_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['info_block_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('info_block_name_label'),
                'hint' => lang('info_block_name_hint'),
                'placeholder' => lang('info_block_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['info_block_info_group'] = [
                'id' => 'info_group',
                'name' => 'info_group',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_info_group_label'),
                'hint' => lang('info_block_info_group_hint'),
                'placeholder' => lang('info_block_info_group_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['info_group'], 'info_group', $data['item'][0]['info_group'])
            ];
            $data['fields']['info_block_description'] = [
                'id' => 'description',
                'name' => 'description',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_description_label'),
                'hint' => lang('info_block_description_hint'),
                'placeholder' => lang('info_block_description_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['description'], 'description', $data['item'][0]['description'])
            ];
            $data['fields']['info_block_image_path'] = [
                'id' => 'image_path',
                'name' => 'image_path',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_image_path_label'),
                'hint' => lang('info_block_image_path_hint'),
                'placeholder' => lang('info_block_image_path_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['image_path'], 'image_path', $data['item'][0]['image_path'])
            ];
            $data['fields']['info_block_image_file'] = [
                'id' => 'image_file',
                'name' => 'image_file',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_image_file_label'),
                'hint' => lang('info_block_image_file_hint'),
                'placeholder' => lang('info_block_image_file_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['image_file'], 'image_file', $data['item'][0]['image_file'])
            ];
            $data['fields']['info_block_body_text'] = [
                'id' => 'body_text',
                'name' => 'body_text',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_body_text_label'),
                'hint' => lang('info_block_body_text_hint'),
                'placeholder' => lang('info_block_body_text_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['body_text'], 'body_text', $data['item'][0]['body_text'])
            ];
            $data['fields']['info_block_image_text'] = [
                'id' => 'image_text',
                'name' => 'image_text',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_image_text_label'),
                'hint' => lang('info_block_image_text_hint'),
                'placeholder' => lang('info_block_image_text_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['image_text'], 'image_text', $data['item'][0]['image_text'])
            ];
            $data['fields']['info_block_image_heading'] = [
                'id' => 'image_heading',
                'name' => 'image_heading',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_image_heading_label'),
                'hint' => lang('info_block_image_heading_hint'),
                'placeholder' => lang('info_block_image_heading_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['image_heading'], 'image_heading', $data['item'][0]['image_heading'])
            ];
            $data['fields']['info_block_button_class'] = [
                'id' => 'button_class',
                'name' => 'button_class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_button_class_label'),
                'hint' => lang('info_block_button_class_hint'),
                'placeholder' => lang('info_block_button_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['button_class'], 'button_class', $data['item'][0]['button_class'])
            ];
            $data['fields']['info_block_button_text'] = [
                'id' => 'button_text',
                'name' => 'button_text',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_button_text_label'),
                'hint' => lang('info_block_button_text_hint'),
                'placeholder' => lang('info_block_button_text_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['button_text'], 'button_text', $data['item'][0]['button_text'])
            ];
            $data['fields']['info_block_section_id'] = [
                'id' => 'section_id',
                'name' => 'section_id',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_section_id_label'),
                'hint' => lang('info_block_section_id_hint'),
                'placeholder' => lang('info_block_section_id_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['section_id'], 'section_id', $data['item'][0]['section_id'])
            ];
            $data['fields']['info_block_section_class'] = [
                'id' => 'section_class',
                'name' => 'section_class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('info_block_section_class_label'),
                'hint' => lang('info_block_section_class_hint'),
                'placeholder' => lang('info_block_section_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['section_class'], 'section_class', $data['item'][0]['section_class'])
            ];
            $data['fields']['info_block_active'] = [
                'id' => 'active',
                'name' => 'active',
                'label' => lang('info_block_active_label'),
                'hint' => lang('info_block_active_hint'),
                'placeholder' => lang('info_block_active_placeholder'),
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
                ]
            ];
            $data['fields']['info_block_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'label' => lang('info_block_edit_button')
            ];
            $data['data']['messages'] = [
                'heading' => lang('info_block_edit_heading'),
                'prompt' => lang('info_block_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to info block listing',
                        'link' => 'widget/load_widget/info_block/list_info_blocks'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->info_block_model->edit_info_block($data['data']['posts']);
                if ($affected) {
                    $success = sprintf(lang('info_block_edit_success'), $data['data']['posts']['name'], $data['id']);
                    _redir('success', $success, 'widget/load_widget/info_block/list_info_blocks');
                } else {
                    $error = sprintf(lang('info_block_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/info_block/list_info_blocks');
                }
            }
            _render(_cfg('admin_theme'), 'info_blocks/edit_info_block', $data);
        } else {
            _redir('error', lang('info_block_edit_denied'), 'widget/load_widget/info_block/list_info_blocks');
        }
    }

    /**
     * delete_info_block
     *
     * Deletes a info_block.
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_info_block($id)
    {
        if (current_user_can()) {
            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['info_block_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('info_block_delete_button'),
                'input_class' => 'btn-primary',
            ];
            $data['id'] = $id;
            $data['item'] = $this->info_block_model->get_info_block_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => 'kcms6_info_block',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Name' => 'name',
                'Description' => 'description',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to info block listing',
                        'link' => 'widget/load_widget/info_block/list_info_blocks'
                    ]
                ],
                'view' => 'info_blocks/delete_confirm',
                'redirect' => 'widget/load_widget/info_block/list_info_blocks',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('info_block_delete_heading'),
                'prompt' => lang('info_block_delete_prompt'),
                'success' => lang('info_block_delete_success'),
                'error' => lang('info_block_delete_error'),
                'warning' => lang('info_block_delete_warn'),
                'return' => lang('info_block_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('info_block_delete_denied'), 'core/no_access');
        }
    }

    /**
     * function get_info_block
     *
     * Retrieves all info blocks for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_info_blocks()
    {
        $check = _grid_open();
        $info_blocks = $this->info_block_model->get_info_block_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->info_block_model->get_info_block_count(false, $check['search']);
        $final = _grid_close($check, $info_blocks, $count);
        echo $final;
    }

}
