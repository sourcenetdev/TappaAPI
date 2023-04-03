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
 * KyrandiaCMS Slider Component
 *
 * Allows the generation of sliders on the site.
 *
 * @package     Impero
 * @subpackage  Libraries
 * @category    Widgets
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Slider extends Widget
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
        _models_load(['widget/slider_model']);
        _languages_load(['widget/slider']);
        _helpers_load(['widget/slider']);
    }

    /**
     * list_sliders
     *
     * Lists all sliders
     *
     * @access public
     *
     * @param int $start
     *
     * @link https://imperoconsulting.atlassian.net/wiki/spaces/IC/pages/1102446626/Bootstrap+Helper Function reference for bootstrap helper functions
     *
     * @return void
     */
    public function list_sliders($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->slider_model->get_slider_count(false);
            $data['hint'] = [
                'heading' => lang('slider_manage_heading'),
                'message' => lang('slider_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('slider_manage_empty'),
                'button' => lang('slider_add_button')
            ];
            $data['tabledata']['page_data'] = $this->slider_model->get_slider_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'slider_list';
            $data['tabledata']['url'] = 'widget/load_widget/slider/get_sliders';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'widget/load_widget/slider/add_slider',
                    'access' => current_user_can('add'),
                    'title' => lang('slider_add_button')
                ],
                'list' => [
                    'icon' => 'collection-text mdc-text-green',
                    'link' => 'widget/load_widget/slider/list_slider_items',
                    'access' => current_user_can('add_items'),
                    'title' => lang('slider_item_list_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'widget/load_widget/slider/edit_slider',
                    'access' => current_user_can('edit'),
                    'title' => lang('slider_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'widget/load_widget/slider/delete_slider',
                    'access' => current_user_can('delete'),
                    'title' => lang('slider_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'slider',
                'model' => 'widget/slider_model',
                'function' => 'get_slider_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('slider_system_menus_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'sliders/list_sliders', $data);
        } else {
            _redir('error', lang('slider_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_slider
     *
     * Adds an slider to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_slider()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_slider_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['slider_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('slider_name_label'),
                'hint' => lang('slider_name_hint'),
                'placeholder' => lang('slider_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['slider_description'] = [
                'id' => 'description',
                'name' => 'description',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_description_label'),
                'hint' => lang('slider_description_hint'),
                'placeholder' => lang('slider_description_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['description'], 'description', '')
            ];
            $data['fields']['slider_image_path'] = [
                'id' => 'image_path',
                'name' => 'image_path',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_image_path_label'),
                'hint' => lang('slider_image_path_hint'),
                'placeholder' => lang('slider_image_path_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['image_path'], 'image_path', '')
            ];
            $data['fields']['slider_section_class'] = [
                'id' => 'section_class',
                'name' => 'section_class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_section_class_label'),
                'hint' => lang('slider_section_class_hint'),
                'placeholder' => lang('slider_section_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['section_class'], 'section_class', '')
            ];
            $data['fields']['slider_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('slider_active_placeholder'),
                'label' => lang('slider_active_label'),
                'hint' => lang('slider_active_hint'),
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
            $data['fields']['slider_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('slider_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('slider_add_heading'),
                'prompt' => lang('slider_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to slider listing',
                        'link' => 'widget/load_widget/slider/list_sliders'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->slider_model->add_slider($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('slider_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'widget/load_widget/slider/list_sliders');
                } else {
                    $error = sprintf(lang('slider_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/slider/list_sliders');
                }
            }
            _render(_cfg('admin_theme'), 'sliders/add_slider', $data);
        } else {
            _redir('error', lang('slider_add_denied'), 'widget/load_widget/slider/list_sliders');
        }
    }

    /**
     * edit_slider
     *
     * Edits a slider.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_slider($id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] = $posts;
            $data['item'] = $this->slider_model->get_slider_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'add_slider_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['slider_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('slider_name_label'),
                'hint' => lang('slider_name_hint'),
                'placeholder' => lang('slider_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['slider_description'] = [
                'id' => 'description',
                'name' => 'description',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_description_label'),
                'hint' => lang('slider_description_hint'),
                'placeholder' => lang('slider_description_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['description'], 'description', $data['item'][0]['description'])
            ];
            $data['fields']['slider_image_path'] = [
                'id' => 'image_path',
                'name' => 'image_path',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_image_path_label'),
                'hint' => lang('slider_image_path_hint'),
                'placeholder' => lang('slider_image_path_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['image_path'], 'image_path', $data['item'][0]['image_path'])
            ];
            $data['fields']['slider_section_class'] = [
                'id' => 'section_class',
                'name' => 'section_class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_section_class_label'),
                'hint' => lang('slider_section_class_hint'),
                'placeholder' => lang('slider_section_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['section_class'], 'section_class', $data['item'][0]['section_class'])
            ];
            $data['fields']['slider_active'] = [
                'id' => 'active',
                'name' => 'active',
                'label' => lang('slider_active_label'),
                'hint' => lang('slider_active_hint'),
                'placeholder' => lang('slider_active_placeholder'),
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
            $data['fields']['slider_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'label' => lang('slider_edit_button')
            ];
            $data['data']['messages'] = [
                'heading' => lang('slider_edit_heading'),
                'prompt' => lang('slider_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to slider listing',
                        'link' => 'widget/load_widget/slider/list_sliders'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->slider_model->edit_slider($data['data']['posts']);
                if ($affected) {
                    $success = sprintf(lang('slider_edit_success'), $data['data']['posts']['name'], $data['id']);
                    _redir('success', $success, 'widget/load_widget/slider/list_sliders');
                } else {
                    $error = sprintf(lang('slider_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/slider/list_sliders');
                }
            }
            _render(_cfg('admin_theme'), 'sliders/edit_slider', $data);
        } else {
            _redir('error', lang('slider_edit_denied'), 'widget/load_widget/slider/list_sliders');
        }
    }

    /**
     * delete_slider
     *
     * Deletes a slider.
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_slider($id)
    {
        if (current_user_can()) {
            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['slider_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('slider_delete_button'),
                'input_class' => 'btn-primary',
            ];
            $data['id'] = $id;
            $data['item'] = $this->slider_model->get_slider_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => 'kcms6_slider_item',
                    'field' => 'slider_id',
                    'value' => $id,
                ],
                1 => [
                    'table' => 'kcms6_slider',
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
                        'label' => 'Return to slider listing',
                        'link' => 'widget/load_widget/slider/list_sliders'
                    ]
                ],
                'view' => 'sliders/delete_confirm',
                'redirect' => 'widget/load_widget/slider/list_sliders',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('slider_delete_heading'),
                'prompt' => lang('slider_delete_prompt'),
                'success' => lang('slider_delete_success'),
                'error' => lang('slider_delete_error'),
                'warning' => lang('slider_delete_warn'),
                'return' => lang('slider_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('slider_delete_denied'), 'core/no_access');
        }
    }

    /**
     * function get_sliders
     *
     * Retrieves all sliders for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_sliders()
    {
        $check = _grid_open();
        $sliders = $this->slider_model->get_slider_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->slider_model->get_slider_count(false, $check['search']);
        $final = _grid_close($check, $sliders, $count);
        echo $final;
    }

    // Slider items

    /**
     * list_slider_items
     *
     * Lists all slider items for a menu
     *
     * @access public
     *
     * @param int $menu_id
     * @param int $start
     *
     * @return void
     */
    public function list_slider_items($slider_id, $start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->slider_model->get_slider_item_count($slider_id, false);
            $data['hint'] = [
                'heading' => lang('slider_item_manage_heading'),
                'message' => lang('slider_item_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('slider_item_manage_empty'),
                'button' => lang('slider_item_add_button')
            ];
            $data['id'] = $slider_id;
            $data['tabledata']['page_data'] = $this->slider_model->get_slider_item_list($slider_id, $start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'slider_items_list';
            $data['tabledata']['url'] = 'widget/load_widget/slider/get_slider_items/'  . $slider_id;
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'widget/load_widget/slider/add_slider_item/' . $slider_id,
                    'access' => current_user_can('add'),
                    'title' => lang('slider_item_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'widget/load_widget/slider/edit_slider_item/' . $slider_id,
                    'access' => current_user_can('edit'),
                    'title' => lang('slider_item_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'widget/load_widget/slider/delete_slider_item/' . $slider_id,
                    'access' => current_user_can('delete'),
                    'title' => lang('slider_item_delete_button')
                ],
                'generic_1' => [
                    'class' => 'btn-secondary',
                    'icon' => 'arrow-left mdc-text-white',
                    'link' => 'widget/load_widget/slider/list_sliders',
                    'access' => current_user_can(NULL, __CLASS__, 'list_sliders'),
                    'title' => lang('slider_return_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'widget',
                'model' => 'slider_model',
                'function' => 'get_slider_item_list',
                'parameters' => [
                    'type' => 'table',
                    'base' => $slider_id,
                    'template' => 'template_pdf',
                    'title' => lang('slider_item_system_menus_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'slider_items/list_slider_items', $data);
        } else {
            _redir('error', lang('slider_items_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_slider_item
     *
     * Adds a slider item to the database.
     *
     * @access public
     *
     * @param int $slider_id
     *
     * @return array
     */
    public function add_slider_item($slider_id)
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_slider_item_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['slider_item_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('slider_item_name_label'),
                'hint' => lang('slider_item_name_hint'),
                'placeholder' => lang('slider_item_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['slider_item_image_div_class'] = [
                'name' => 'image_div_class',
                'id' => 'image_div_class',
                'input_class' => 'input-group width-100',
                'label' => lang('slider_item_image_div_class_label'),
                'hint' => lang('slider_item_image_div_class_hint'),
                'placeholder' => lang('slider_item_image_div_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['image_div_class'], 'image_div_class', '')
            ];
            $data['fields']['slider_item_image'] = [
                'id' => 'image',
                'name' => 'image',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_item_image_label'),
                'hint' => lang('slider_item_image_hint'),
                'placeholder' => lang('slider_item_image_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['image'], 'image', '')
            ];
            $data['fields']['slider_item_title'] = [
                'id' => 'title',
                'name' => 'title',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_item_title_label'),
                'hint' => lang('slider_item_title_hint'),
                'placeholder' => lang('slider_item_title_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['title'], 'title', '')
            ];
            $data['fields']['slider_item_image_text'] = [
                'id' => 'image_text',
                'name' => 'image_text',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_item_image_text_label'),
                'hint' => lang('slider_item_image_text_hint'),
                'placeholder' => lang('slider_item_image_text_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['image_text'], 'image_text', '')
            ];
            $data['fields']['slider_item_image_heading'] = [
                'id' => 'image_heading',
                'name' => 'image_heading',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_item_image_heading_label'),
                'hint' => lang('slider_item_image_heading_hint'),
                'placeholder' => lang('slider_item_image_heading_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['image_heading'], 'image_heading', '')
            ];
            $data['fields']['slider_item_active'] = [
                'id' => 'active',
                'name' => 'active',
                'label' => lang('slider_item_active_label'),
                'hint' => lang('slider_item_active_hint'),
                'placeholder' => lang('slider_item_active_placeholder'),
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
            $data['fields']['slider_item_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('slider_item_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('slider_item_add_heading'),
                'prompt' => lang('slider_item_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to slider item listing',
                        'link' => 'widget/load_widget/slider/list_slider_items/' . $slider_id
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts']['slider_id'] = $slider_id;
                $insert_id = $this->slider_model->add_slider_item($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('slider_item_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'widget/load_widget/slider/list_slider_items/' . $slider_id);
                } else {
                    $error = sprintf(lang('slider_item_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/slider/list_slider_items/' . $slider_id);
                }
            }
            _render(_cfg('admin_theme'), 'slider_items/add_slider_item', $data);
        } else {
            _redir('error', lang('slider_item_add_denied'), 'widget/load_widget/slider/list_slider_items/' . $slider_id);
        }
    }

    /**
     * edit_slider_item
     *
     * Edits a slider item.
     *
     * @access public
     *
     * @param int $slider_id
     * @param int $id
     *
     * @return array
     */
    public function edit_slider_item($slider_id, $id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] = $posts;
            $data['item'] = $this->slider_model->get_slider_item_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'add_slider_item_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['slider_item_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('slider_item_name_label'),
                'hint' => lang('slider_item_name_hint'),
                'placeholder' => lang('slider_item_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['slider_item_image_div_class'] = [
                'name' => 'image_div_class',
                'id' => 'image_div_class',
                'input_class' => 'input-group width-100',
                'label' => lang('slider_item_image_div_class_label'),
                'hint' => lang('slider_item_image_div_class_hint'),
                'placeholder' => lang('slider_item_image_div_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['image_div_class'], 'image_div_class', $data['item'][0]['image_div_class'])
            ];
            $data['fields']['slider_item_image'] = [
                'id' => 'image',
                'name' => 'image',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_item_image_label'),
                'hint' => lang('slider_item_image_hint'),
                'placeholder' => lang('slider_item_image_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['image'], 'image', $data['item'][0]['image'])
            ];
            $data['fields']['slider_item_title'] = [
                'id' => 'title',
                'name' => 'title',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_item_title_label'),
                'hint' => lang('slider_item_title_hint'),
                'placeholder' => lang('slider_item_title_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['title'], 'title', $data['item'][0]['title'])
            ];
            $data['fields']['slider_item_image_text'] = [
                'id' => 'image_text',
                'name' => 'image_text',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_item_image_text_label'),
                'hint' => lang('slider_item_image_text_hint'),
                'placeholder' => lang('slider_item_image_text_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['image_text'], 'image_text', $data['item'][0]['image_text'])
            ];
            $data['fields']['slider_item_image_heading'] = [
                'id' => 'image_heading',
                'name' => 'image_heading',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('slider_item_image_heading_label'),
                'hint' => lang('slider_item_image_heading_hint'),
                'placeholder' => lang('slider_item_image_heading_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['image_heading'], 'image_heading', $data['item'][0]['image_heading'])
            ];
            $data['fields']['slider_item_active'] = [
                'id' => 'active',
                'name' => 'active',
                'label' => lang('slider_item_active_label'),
                'hint' => lang('slider_item_active_hint'),
                'placeholder' => lang('slider_item_active_placeholder'),
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
            $data['fields']['slider_item_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('slider_item_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('slider_item_edit_heading'),
                'prompt' => lang('slider_item_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to slider item listing',
                        'link' => 'widget/load_widget/slider/list_slider_items/' . $slider_id
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->slider_model->edit_slider_item($data['data']['posts']);
                if ($affected) {
                    $success = sprintf(lang('slider_item_edit_success'), $data['data']['posts']['name'], $data['id']);
                    _redir('success', $success, 'widget/load_widget/slider/list_slider_items/' . $slider_id);
                } else {
                    $error = sprintf(lang('slider_item_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/slider/list_slider_items/' . $slider_id);
                }
            }
            _render(_cfg('admin_theme'), 'slider_items/edit_slider_item', $data);
        } else {
            _redir('error', lang('slider_item_edit_denied'), 'widget/load_widget/slider/list_slider_items/' . $slider_id);
        }
    }

    /**
     * delete_slider_item
     *
     * Deletes an slider item.
     *
     * @access public
     *
     * @param int $slider_id
     * @param int $id
     *
     * @return void
     */
    public function delete_slider_item($slider_id, $id)
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
            $data['fields']['slider_item_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('slider_item_delete_button'),
                'input_class' => 'btn-primary',
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->slider_model->get_slider_item_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => 'kcms6_slider_item',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Name' => 'name',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to slider item listing',
                        'link' => 'widget/load_widget/slider/list_slider_items/' . $slider_id
                    ]
                ],
                'view' => 'slider_items/delete_confirm',
                'redirect' => 'widget/load_widget/slider/list_slider_items/' . $slider_id,
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('slider_item_delete_heading'),
                'prompt' => lang('slider_item_delete_prompt'),
                'success' => lang('slider_item_delete_success'),
                'error' => lang('slider_item_delete_error'),
                'warning' => lang('slider_item_delete_warn'),
                'return' => lang('slider_item_delete_return')
            ];
            $data['slider_id'] = $slider_id;
            delete_items($data);
        } else {
            _redir('error', lang('slider_item_delete_denied'), 'core/no_access');
        }
    }

    /**
     * function get_slider_items
     *
     * Retrieves all slider items for use in ajax listings
     *
     * @access public
     *
     * @param int $slider_id
     *
     * @return void
     */
    public function get_slider_items($slider_id)
    {
        $check = _grid_open();
        $items = $this->slider_model->get_slider_item_list($slider_id, $check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->slider_model->get_slider_item_count($slider_id, false, $check['search']);
        $final = _grid_close($check, $items, $count);
        echo $final;
    }
}
