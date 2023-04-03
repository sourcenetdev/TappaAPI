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
 * KyrandiaCMS Parallax Div Component
 *
 * Allows the generation of parallax divs on the site.
 *
 * @package     Impero
 * @subpackage  Libraries
 * @category    Widgets
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Parallax_div extends Widget
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
        _models_load(['widget/parallax_div_model']);
        _languages_load(['widget/parallax_div']);
        _helpers_load(['widget/parallax_div']);
    }

    /**
     * list_parallax_divs
     *
     * Lists all parallax divs
     *
     * @access public
     *
     * @param int $start
     *
     * @link https://imperoconsulting.atlassian.net/wiki/spaces/IC/pages/1102446626/Bootstrap+Helper Function reference for bootstrap helper functions
     *
     * @return void
     */
    public function list_parallax_divs($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->parallax_div_model->get_parallax_div_count(false);
            $data['hint'] = [
                'heading' => lang('parallax_div_manage_heading'),
                'message' => lang('parallax_div_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('parallax_div_manage_empty'),
                'button' => lang('parallax_div_add_button')
            ];
            $data['tabledata']['page_data'] = $this->parallax_div_model->get_parallax_div_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'parallax_div_list';
            $data['tabledata']['url'] = 'widget/load_widget/parallax_div/get_parallax_divs';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'widget/load_widget/parallax_div/add_parallax_div',
                    'access' => current_user_can('add'),
                    'title' => lang('parallax_div_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'widget/load_widget/parallax_div/edit_parallax_div',
                    'access' => current_user_can('edit'),
                    'title' => lang('parallax_div_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'widget/load_widget/parallax_div/delete_parallax_div',
                    'access' => current_user_can('delete'),
                    'title' => lang('parallax_div_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'parallax_div',
                'model' => 'widget/parallax_div_model',
                'function' => 'get_parallax_div_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('parallax_div_system_parallax_divs_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'parallax_divs/list_parallax_divs', $data);
        } else {
            _redir('error', lang('parallax_div_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_parallax_div
     *
     * Adds an parallax div to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_parallax_div()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_parallax_div_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['parallax_div_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('parallax_div_name_label'),
                'hint' => lang('parallax_div_name_hint'),
                'placeholder' => lang('parallax_div_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['parallax_div_description'] = [
                'id' => 'description',
                'name' => 'description',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_description_label'),
                'hint' => lang('parallax_div_description_hint'),
                'placeholder' => lang('parallax_div_description_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['description'], 'description', '')
            ];
            $data['fields']['parallax_div_image_path'] = [
                'id' => 'image_path',
                'name' => 'image_path',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_image_path_label'),
                'hint' => lang('parallax_div_image_path_hint'),
                'placeholder' => lang('parallax_div_image_path_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['image_path'], 'image_path', '')
            ];
            $data['fields']['parallax_div_image_file'] = [
                'id' => 'image_file',
                'name' => 'image_file',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_image_file_label'),
                'hint' => lang('parallax_div_image_file_hint'),
                'placeholder' => lang('parallax_div_image_file_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['image_file'], 'image_file', '')
            ];
            $data['fields']['parallax_div_image_text'] = [
                'id' => 'image_text',
                'name' => 'image_text',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_image_text_label'),
                'hint' => lang('parallax_div_image_text_hint'),
                'placeholder' => lang('parallax_div_image_text_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['image_text'], 'image_text', '')
            ];
            $data['fields']['parallax_div_image_heading'] = [
                'id' => 'image_heading',
                'name' => 'image_heading',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_image_heading_label'),
                'hint' => lang('parallax_div_image_heading_hint'),
                'placeholder' => lang('parallax_div_image_heading_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['image_heading'], 'image_heading', '')
            ];
            $data['fields']['parallax_div_section_id'] = [
                'id' => 'section_id',
                'name' => 'section_id',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_section_id_label'),
                'hint' => lang('parallax_div_section_id_hint'),
                'placeholder' => lang('parallax_div_section_id_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['section_id'], 'section_id', '')
            ];
            $data['fields']['parallax_div_section_class'] = [
                'id' => 'section_class',
                'name' => 'section_class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_section_class_label'),
                'hint' => lang('parallax_div_section_class_hint'),
                'placeholder' => lang('parallax_div_section_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['section_class'], 'section_class', '')
            ];
            $data['fields']['parallax_div_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('parallax_div_active_placeholder'),
                'label' => lang('parallax_div_active_label'),
                'hint' => lang('parallax_div_active_hint'),
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
            $data['fields']['parallax_div_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('parallax_div_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('parallax_div_add_heading'),
                'prompt' => lang('parallax_div_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to parallax div listing',
                        'link' => 'widget/load_widget/parallax_div/list_parallax_divs'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->parallax_div_model->add_parallax_div($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('parallax_div_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'widget/load_widget/parallax_div/list_parallax_divs');
                } else {
                    $error = sprintf(lang('parallax_div_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/parallax_div/list_parallax_divs');
                }
            }
            _render(_cfg('admin_theme'), 'parallax_divs/add_parallax_div', $data);
        } else {
            _redir('error', lang('parallax_div_add_denied'), 'widget/load_widget/parallax_div/list_parallax_divs');
        }
    }

    /**
     * edit_parallax_div
     *
     * Edits an parallax div.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_parallax_div($id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] = $posts;
            $data['item'] = $this->parallax_div_model->get_parallax_div_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'add_parallax_div_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['parallax_div_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('parallax_div_name_label'),
                'hint' => lang('parallax_div_name_hint'),
                'placeholder' => lang('parallax_div_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['parallax_div_description'] = [
                'id' => 'description',
                'name' => 'description',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_description_label'),
                'hint' => lang('parallax_div_description_hint'),
                'placeholder' => lang('parallax_div_description_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['description'], 'description', $data['item'][0]['description'])
            ];
            $data['fields']['parallax_div_image_path'] = [
                'id' => 'image_path',
                'name' => 'image_path',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_image_path_label'),
                'hint' => lang('parallax_div_image_path_hint'),
                'placeholder' => lang('parallax_div_image_path_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['image_path'], 'image_path', $data['item'][0]['image_path'])
            ];
            $data['fields']['parallax_div_image_file'] = [
                'id' => 'image_file',
                'name' => 'image_file',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_image_file_label'),
                'hint' => lang('parallax_div_image_file_hint'),
                'placeholder' => lang('parallax_div_image_file_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['image_file'], 'image_file', $data['item'][0]['image_file'])
            ];
            $data['fields']['parallax_div_image_text'] = [
                'id' => 'image_text',
                'name' => 'image_text',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_image_text_label'),
                'hint' => lang('parallax_div_image_text_hint'),
                'placeholder' => lang('parallax_div_image_text_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['image_text'], 'image_text', $data['item'][0]['image_text'])
            ];
            $data['fields']['parallax_div_image_heading'] = [
                'id' => 'image_heading',
                'name' => 'image_heading',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_image_heading_label'),
                'hint' => lang('parallax_div_image_heading_hint'),
                'placeholder' => lang('parallax_div_image_heading_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['image_heading'], 'image_heading', $data['item'][0]['image_heading'])
            ];
            $data['fields']['parallax_div_section_id'] = [
                'id' => 'section_id',
                'name' => 'section_id',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_section_id_label'),
                'hint' => lang('parallax_div_section_id_hint'),
                'placeholder' => lang('parallax_div_section_id_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['section_id'], 'section_id', $data['item'][0]['section_id'])
            ];
            $data['fields']['parallax_div_section_class'] = [
                'id' => 'section_class',
                'name' => 'section_class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('parallax_div_section_class_label'),
                'hint' => lang('parallax_div_section_class_hint'),
                'placeholder' => lang('parallax_div_section_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['section_class'], 'section_class', $data['item'][0]['section_class'])
            ];
            $data['fields']['parallax_div_active'] = [
                'id' => 'active',
                'name' => 'active',
                'label' => lang('parallax_div_active_label'),
                'hint' => lang('parallax_div_active_hint'),
                'placeholder' => lang('parallax_div_active_placeholder'),
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
            $data['fields']['parallax_div_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'label' => lang('parallax_div_edit_button')
            ];
            $data['data']['messages'] = [
                'heading' => lang('parallax_div_edit_heading'),
                'prompt' => lang('parallax_div_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to parallax div listing',
                        'link' => 'widget/load_widget/parallax_div/list_parallax_divs'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->parallax_div_model->edit_parallax_div($data['data']['posts']);
                if ($affected) {
                    $success = sprintf(lang('parallax_div_edit_success'), $data['data']['posts']['name'], $data['id']);
                    _redir('success', $success, 'widget/load_widget/parallax_div/list_parallax_divs');
                } else {
                    $error = sprintf(lang('parallax_div_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/parallax_div/list_parallax_divs');
                }
            }
            _render(_cfg('admin_theme'), 'parallax_divs/edit_parallax_div', $data);
        } else {
            _redir('error', lang('parallax_div_edit_denied'), 'widget/load_widget/parallax_div/list_parallax_divs');
        }
    }

    /**
     * delete_parallax_div
     *
     * Deletes a parallax_div.
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_parallax_div($id)
    {
        if (current_user_can()) {
            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['parallax_div_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('parallax_div_delete_button'),
                'input_class' => 'btn-primary',
            ];
            $data['id'] = $id;
            $data['item'] = $this->parallax_div_model->get_parallax_div_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => 'kcms6_parallax_div',
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
                        'label' => 'Return to parallax div listing',
                        'link' => 'widget/load_widget/parallax_div/list_parallax_divs'
                    ]
                ],
                'view' => 'parallax_divs/delete_confirm',
                'redirect' => 'widget/load_widget/parallax_div/list_parallax_divs',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('parallax_div_delete_heading'),
                'prompt' => lang('parallax_div_delete_prompt'),
                'success' => lang('parallax_div_delete_success'),
                'error' => lang('parallax_div_delete_error'),
                'warning' => lang('parallax_div_delete_warn'),
                'return' => lang('parallax_div_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('parallax_div_delete_denied'), 'core/no_access');
        }
    }

    /**
     * function get_parallax_div
     *
     * Retrieves all parallax divs for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_parallax_divs()
    {
        $check = _grid_open();
        $parallax_divs = $this->parallax_div_model->get_parallax_div_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->parallax_div_model->get_parallax_div_count(false, $check['search']);
        $final = _grid_close($check, $parallax_divs, $count);
        echo $final;
    }

}
