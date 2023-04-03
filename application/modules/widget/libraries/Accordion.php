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
 * KyrandiaCMS Accordion Component
 *
 * Allows the generation of accordions on the site.
 *
 * @package     Impero
 * @subpackage  Libraries
 * @category    Widgets
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Accordion extends Widget
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
        _models_load(['widget/accordion_model']);
        _languages_load(['widget/accordion']);
        _helpers_load(['widget/accordion']);
    }

    /**
     * list_accordions
     *
     * Lists all accordions
     *
     * @access public
     *
     * @param int $start
     *
     * @link https://imperoconsulting.atlassian.net/wiki/spaces/IC/pages/1102446626/Bootstrap+Helper Function reference for bootstrap helper functions
     *
     * @return void
     */
    public function list_accordions($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->accordion_model->get_accordion_count(false);
            $data['hint'] = [
                'heading' => lang('accordion_manage_heading'),
                'message' => lang('accordion_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('accordion_manage_empty'),
                'button' => lang('accordion_add_button')
            ];
            $data['tabledata']['page_data'] = $this->accordion_model->get_accordion_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'accordion_list';
            $data['tabledata']['url'] = 'widget/load_widget/accordion/get_accordions';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'widget/load_widget/accordion/add_accordion',
                    'access' => current_user_can('add'),
                    'title' => lang('accordion_add_button')
                ],
                'list' => [
                    'icon' => 'collection-text mdc-text-green',
                    'link' => 'widget/load_widget/accordion/list_accordion_items',
                    'access' => current_user_can('add_items'),
                    'title' => lang('accordion_item_list_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'widget/load_widget/accordion/edit_accordion',
                    'access' => current_user_can('edit'),
                    'title' => lang('accordion_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'widget/load_widget/accordion/delete_accordion',
                    'access' => current_user_can('delete'),
                    'title' => lang('accordion_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'widget',
                'model' => 'accordion_model',
                'function' => 'get_accordion_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('accordion_system_menus_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'accordions/list_accordions', $data);
        } else {
            _redir('error', lang('accordion_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_accordion
     *
     * Adds an accordion to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_accordion()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_accordion_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['accordion_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('accordion_name_label'),
                'hint' => lang('accordion_name_hint'),
                'placeholder' => lang('accordion_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['accordion_region'] = [
                'name' => 'region',
                'id' => 'region',
                'input_class' => 'input-group width-100',
                'label' => lang('accordion_region_label'),
                'hint' => lang('accordion_region_hint'),
                'placeholder' => lang('accordion_region_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['region'], 'region', '')
            ];
            $data['fields']['accordion_description'] = [
                'id' => 'description',
                'name' => 'description',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('accordion_description_label'),
                'hint' => lang('accordion_description_hint'),
                'placeholder' => lang('accordion_description_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['description'], 'description', '')
            ];
            $data['fields']['accordion_outer_class'] = [
                'id' => 'outer_class',
                'name' => 'outer_class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('accordion_outer_class_label'),
                'hint' => lang('accordion_outer_class_hint'),
                'placeholder' => lang('accordion_outer_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['outer_class'], 'outer_class', '')
            ];
            $data['fields']['accordion_first_open'] = [
                'id' => 'first_open',
                'name' => 'first_open',
                'placeholder' => lang('accordion_first_open_placeholder'),
                'label' => lang('accordion_first_open_label'),
                'hint' => lang('accordion_first_open_hint'),
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
                'value' => _choose(@$data['data']['posts']['first_open'], 'first_open', '')
            ];
            $data['fields']['accordion_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('accordion_active_placeholder'),
                'label' => lang('accordion_active_label'),
                'hint' => lang('accordion_active_hint'),
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
            $data['fields']['accordion_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('accordion_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('accordion_add_heading'),
                'prompt' => lang('accordion_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to accordion listing',
                        'link' => 'widget/load_widget/accordion/list_accordions'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $insert_id = $this->accordion_model->add_accordion($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('accordion_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'widget/load_widget/accordion/list_accordions');
                } else {
                    $error = sprintf(lang('accordion_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/accordion/list_accordions');
                }
            }
            _render(_cfg('admin_theme'), 'accordions/add_accordion', $data);
        } else {
            _redir('error', lang('accordion_add_denied'), 'widget/load_widget/accordion/list_accordions');
        }
    }

    /**
     * edit_accordion
     *
     * Edits a accordion.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_accordion($id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] = $posts;
            $data['item'] = $this->accordion_model->get_accordion_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'add_accordion_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['accordion_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('accordion_name_label'),
                'hint' => lang('accordion_name_hint'),
                'placeholder' => lang('accordion_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['accordion_region'] = [
                'name' => 'region',
                'id' => 'region',
                'input_class' => 'input-group width-100',
                'label' => lang('accordion_region_label'),
                'hint' => lang('accordion_region_hint'),
                'placeholder' => lang('accordion_region_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$data['data']['posts']['region'], 'region', $data['item'][0]['region'])
            ];
            $data['fields']['accordion_description'] = [
                'id' => 'description',
                'name' => 'description',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('accordion_description_label'),
                'hint' => lang('accordion_description_hint'),
                'placeholder' => lang('accordion_description_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$posts['description'], 'description', $data['item'][0]['description'])
            ];
            $data['fields']['accordion_outer_class'] = [
                'id' => 'outer_class',
                'name' => 'outer_class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('accordion_outer_class_label'),
                'hint' => lang('accordion_outer_class_hint'),
                'placeholder' => lang('accordion_outer_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => [],
                'value' => _choose(@$posts['outer_class'], 'outer_class', $data['item'][0]['outer_class'])
            ];
            $data['fields']['accordion_first_open'] = [
                'id' => 'first_open',
                'name' => 'first_open',
                'placeholder' => lang('accordion_first_open_placeholder'),
                'label' => lang('accordion_first_open_label'),
                'hint' => lang('accordion_first_open_hint'),
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
                'value' => _choose(@$data['data']['posts']['first_open'], 'first_open', $data['item'][0]['first_open'])
            ];
            $data['fields']['accordion_active'] = [
                'id' => 'active',
                'name' => 'active',
                'label' => lang('accordion_active_label'),
                'hint' => lang('accordion_active_hint'),
                'placeholder' => lang('accordion_active_placeholder'),
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
            $data['fields']['accordion_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'label' => lang('accordion_edit_button')
            ];
            $data['data']['messages'] = [
                'heading' => lang('accordion_edit_heading'),
                'prompt' => lang('accordion_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to accordion listing',
                        'link' => 'accordion/list_accordions'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->accordion_model->edit_accordion($data['data']['posts']);
                if ($affected) {
                    $success = sprintf(lang('accordion_edit_success'), $data['data']['posts']['name'], $data['id']);
                    _redir('success', $success, 'widget/load_widget/accordion/list_accordions');
                } else {
                    $error = sprintf(lang('accordion_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/accordion/list_accordions');
                }
            }
            _render(_cfg('admin_theme'), 'accordions/edit_accordion', $data);
        } else {
            _redir('error', lang('accordion_edit_denied'), 'widget/load_widget/accordion/list_accordions');
        }
    }

    /**
     * delete_accordion
     *
     * Deletes a accordion.
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_accordion($id)
    {
        if (current_user_can()) {
            $data['fields']['form_open'] = [
                'id' => 'delete_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['accordion_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('accordion_delete_button'),
                'input_class' => 'btn-primary',
            ];
            $data['id'] = $id;
            $data['item'] = $this->accordion_model->get_accordion_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => 'kcms6_accordion_item',
                    'field' => 'accordion_id',
                    'value' => $id,
                ],
                1 => [
                    'table' => 'kcms6_accordion',
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
                        'label' => 'Return to accordion listing',
                        'link' => 'widget/load_widget/accordion/list_accordions'
                    ]
                ],
                'view' => 'accordions/delete_confirm',
                'redirect' => 'widget/load_widget/accordion/list_accordions',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('accordion_delete_heading'),
                'prompt' => lang('accordion_delete_prompt'),
                'success' => lang('accordion_delete_success'),
                'error' => lang('accordion_delete_error'),
                'warning' => lang('accordion_delete_warn'),
                'return' => lang('accordion_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('accordion_delete_denied'), 'core/no_access');
        }
    }

    /**
     * function get_accordions
     *
     * Retrieves all accordions for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_accordions()
    {
        $check = _grid_open();
        $accordions = $this->accordion_model->get_accordion_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->accordion_model->get_accordion_count(false, $check['search']);
        $final = _grid_close($check, $accordions, $count);
        echo $final;
    }

    // Accordion items

    /**
     * list_accordion_items
     *
     * Lists all accordion items for a menu
     *
     * @access public
     *
     * @param int $menu_id
     * @param int $start
     *
     * @return void
     */
    public function list_accordion_items($accordion_id, $start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->accordion_model->get_accordion_item_count($accordion_id, false);
            $data['hint'] = [
                'heading' => lang('accordion_item_manage_heading'),
                'message' => lang('accordion_item_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('accordion_item_manage_empty'),
                'button' => lang('accordion_item_add_button')
            ];
            $data['id'] = $accordion_id;
            $data['tabledata']['page_data'] = $this->accordion_model->get_accordion_item_list($accordion_id, $start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'accordion_items_list';
            $data['tabledata']['url'] = 'widget/load_widget/accordion/get_accordion_items/'  . $accordion_id;
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'widget/load_widget/accordion/add_accordion_item/' . $accordion_id,
                    'access' => current_user_can('add'),
                    'title' => lang('accordion_item_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'widget/load_widget/accordion/edit_accordion_item/' . $accordion_id,
                    'access' => current_user_can('edit'),
                    'title' => lang('accordion_item_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'widget/load_widget/accordion/delete_accordion_item/' . $accordion_id,
                    'access' => current_user_can('delete'),
                    'title' => lang('accordion_item_delete_button')
                ],
                'generic_1' => [
                    'class' => 'btn-secondary',
                    'icon' => 'arrow-left mdc-text-white',
                    'link' => 'widget/load_widget/accordion/list_accordions',
                    'access' => current_user_can(NULL, __CLASS__, 'list_accordions'),
                    'title' => lang('accordion_return_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'accordion',
                'model' => 'widget/accordion_model',
                'function' => 'get_accordion_item_list',
                'parameters' => [
                    'type' => 'table',
                    'base' => $accordion_id,
                    'template' => 'template_pdf',
                    'title' => lang('accordion_item_system_menus_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'accordion_items/list_accordion_items', $data);
        } else {
            _redir('error', lang('accordion_items_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_accordion_item
     *
     * Adds a accordion item to the database.
     *
     * @access public
     *
     * @param int $accordion_id
     *
     * @return array
     */
    public function add_accordion_item($accordion_id)
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_accordion_item_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['accordion_item_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('accordion_item_name_label'),
                'hint' => lang('accordion_item_name_hint'),
                'placeholder' => lang('accordion_item_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
            $data['fields']['accordion_item_body'] = [
                'name' => 'body',
                'id' => 'body',
                'input_class' => 'input-group width-100',
                'label' => lang('accordion_item_body_label'),
                'hint' => lang('accordion_item_body_hint'),
                'placeholder' => lang('accordion_item_body_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['body'], 'body', '')
            ];
            $data['fields']['accordion_item_class'] = [
                'id' => 'class',
                'name' => 'class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('accordion_item_class_label'),
                'hint' => lang('accordion_item_class_hint'),
                'placeholder' => lang('accordion_item_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['class'], 'class', '')
            ];
            $data['fields']['accordion_item_icon'] = [
                'id' => 'icon',
                'name' => 'icon',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('accordion_item_icon_label'),
                'hint' => lang('accordion_item_icon_hint'),
                'placeholder' => lang('accordion_item_icon_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['icon'], 'icon', '')
            ];
            $data['fields']['accordion_item_active'] = [
                'id' => 'active',
                'name' => 'active',
                'label' => lang('accordion_item_active_label'),
                'hint' => lang('accordion_item_active_hint'),
                'placeholder' => lang('accordion_item_active_placeholder'),
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
            $data['fields']['accordion_item_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('accordion_item_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('accordion_item_add_heading'),
                'prompt' => lang('accordion_item_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to accordion item listing',
                        'link' => 'widget/load_widget/accordion/list_accordion_items/' . $accordion_id
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts']['accordion_id'] = $accordion_id;
                $insert_id = $this->accordion_model->add_accordion_item($data['data']['posts']);
                if (!empty($insert_id)) {
                    $success = sprintf(lang('accordion_item_add_success'), $data['data']['posts']['name'], $insert_id);
                    _redir('success', $success, 'widget/load_widget/accordion/list_accordion_items/' . $accordion_id);
                } else {
                    $error = sprintf(lang('accordion_item_add_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/accordion/list_accordion_items/' . $accordion_id);
                }
            }
            _render(_cfg('admin_theme'), 'accordion_items/add_accordion_item', $data);
        } else {
            _redir('error', lang('accordion_item_add_denied'), 'widget/load_widget/accordion/list_accordion_items/' . $accordion_id);
        }
    }

    /**
     * edit_accordion_item
     *
     * Edits a accordion item.
     *
     * @access public
     *
     * @param int $accordion_id
     * @param int $id
     *
     * @return array
     */
    public function edit_accordion_item($accordion_id, $id)
    {
        if (current_user_can()) {
            $posts = _post();
            $data['id'] = $id;
            $data['posts'] = $posts;
            $data['item'] = $this->accordion_model->get_accordion_item_by_id($id);
            $data['fields']['form_open'] = [
                'id' => 'add_accordion_item_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['accordion_item_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('accordion_item_name_label'),
                'hint' => lang('accordion_item_name_hint'),
                'placeholder' => lang('accordion_item_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', $data['item'][0]['name'])
            ];
            $data['fields']['accordion_item_body'] = [
                'name' => 'body',
                'id' => 'body',
                'input_class' => 'input-group width-100',
                'label' => lang('accordion_item_body_label'),
                'hint' => lang('accordion_item_body_hint'),
                'placeholder' => lang('accordion_item_body_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['body'], 'body', $data['item'][0]['body'])
            ];
            $data['fields']['accordion_item_class'] = [
                'id' => 'class',
                'name' => 'class',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('accordion_item_class_label'),
                'hint' => lang('accordion_item_class_hint'),
                'placeholder' => lang('accordion_item_class_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['class'], 'class', $data['item'][0]['class'])
            ];
            $data['fields']['accordion_item_icon'] = [
                'id' => 'icon',
                'name' => 'icon',
                'input_class' => 'input-group-wide width-100',
                'label' => lang('accordion_item_icon_label'),
                'hint' => lang('accordion_item_icon_hint'),
                'placeholder' => lang('accordion_item_icon_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'value' => _choose(@$data['data']['posts']['icon'], 'icon', $data['item'][0]['icon'])
            ];
            $data['fields']['accordion_item_active'] = [
                'id' => 'active',
                'name' => 'active',
                'label' => lang('accordion_item_active_label'),
                'hint' => lang('accordion_item_active_hint'),
                'placeholder' => lang('accordion_item_active_placeholder'),
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
            $data['fields']['accordion_item_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('accordion_item_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('accordion_item_edit_heading'),
                'prompt' => lang('accordion_item_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to accordion item listing',
                        'link' => 'accordion/list_accordion_items/' . $accordion_id
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $affected = $this->accordion_model->edit_accordion_item($data['data']['posts']);
                if ($affected) {
                    $success = sprintf(lang('accordion_item_edit_success'), $data['data']['posts']['name'], $data['id']);
                    _redir('success', $success, 'widget/load_widget/accordion/list_accordion_items/' . $accordion_id);
                } else {
                    $error = sprintf(lang('accordion_item_edit_error'), $data['data']['posts']['name']);
                    _redir('error', $error, 'widget/load_widget/accordion/list_accordion_items/' . $accordion_id);
                }
            }
            _render(_cfg('admin_theme'), 'accordion_items/edit_accordion_item', $data);
        } else {
            _redir('error', lang('accordion_item_edit_denied'), 'widget/load_widget/accordion/list_accordion_items/' . $accordion_id);
        }
    }

    /**
     * delete_accordion_item
     *
     * Deletes an accordion item.
     *
     * @access public
     *
     * @param int $accordion_id
     * @param int $id
     *
     * @return void
     */
    public function delete_accordion_item($accordion_id, $id)
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
            $data['fields']['accordion_item_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('accordion_item_delete_button'),
                'input_class' => 'btn-primary',
            ];

            // Form processing data
            $data['id'] = $id;
            $data['item'] = $this->accordion_model->get_accordion_item_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => 'kcms6_accordion_item',
                    'field' => 'id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Name' => 'name',
                'Active' => 'active',
                'Icon' => 'icon',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to accordion item listing',
                        'link' => 'widget/load_widget/accordion/list_accordion_items/' . $accordion_id
                    ]
                ],
                'view' => 'accordion_items/delete_confirm',
                'redirect' => 'widget/load_widget/accordion/list_accordion_items/' . $accordion_id,
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('accordion_item_delete_heading'),
                'prompt' => lang('accordion_item_delete_prompt'),
                'success' => lang('accordion_item_delete_success'),
                'error' => lang('accordion_item_delete_error'),
                'warning' => lang('accordion_item_delete_warn'),
                'return' => lang('accordion_item_delete_return')
            ];
            $data['accordion_id'] = $accordion_id;
            delete_items($data);
        } else {
            _redir('error', lang('accordion_item_delete_denied'), 'core/no_access');
        }
    }

    /**
     * function get_accordion_items
     *
     * Retrieves all accordion items for use in ajax listings
     *
     * @access public
     *
     * @param int $accordion_id
     *
     * @return void
     */
    public function get_accordion_items($accordion_id)
    {
        $check = _grid_open();
        $items = $this->accordion_model->get_accordion_item_list($accordion_id, $check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->accordion_model->get_accordion_item_count($accordion_id, false, $check['search']);
        $final = _grid_close($check, $items, $count);
        echo $final;
    }
}
