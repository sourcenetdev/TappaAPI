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
 * KyrandiaCMS Page Module
 *
 * This module enables the creation of pages of content on the site.
 *
 * @package     Impero Consulting
 * @subpackage  Modules
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Page extends MX_Controller
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
        _modules_load(['theme', 'layout', 'seo']);
        _models_load(['page/page_model']);
        _languages_load(['page/page']);
        _helpers_load(['page/page']);

        // Sets the settings for this module.
        _settings_check('page');
    }

    public function permissions_hook()
    {
        global $condition;
        return [
            'Page' => [
                'actions' => [
                    $condition . 'list_pages' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage pages'],
                        'checkpoint' => [
                            'add' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add pages', 'Manage pages']
                            ],
                            'edit' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Add pages', 'Manage pages']
                            ],
                            'delete' => [
                                'roles' => ['Super Administrator'],
                                'permissions' => ['Delete pages', 'Manage pages']
                            ]
                        ]
                    ],
                    $condition . 'add_page' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Add pages', 'Manage pages']
                    ],
                    $condition . 'edit_page' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Edit pages', 'Manage pages']
                    ],
                    $condition . 'get_pages' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Manage pages']
                    ],
                    $condition . 'delete_page' => [
                        'roles' => ['Super Administrator'],
                        'permissions' => ['Delete pages', 'Manage pages']
                    ]
                ]
            ],
        ];
    }

    /**
     * list_pages
     *
     * Lists all pages
     *
     * @access public
     *
     * @param int $start
     *
     * @return void
     */
    public function list_pages($start = 0)
    {
        if (current_user_can()) {
            $data = _grid_flags($start);
            $data['data_count'] = $this->page_model->get_page_count(false);
            $data['hint'] = [
                'heading' => lang('page_manage_heading'),
                'message' => lang('page_manage_hint')
            ];
            $data['empty'] = [
                'message' => lang('page_manage_empty'),
                'button' => lang('page_add_button')
            ];
            $data['tabledata']['page_data'] = $this->page_model->get_page_list($start, $this->page_limit);
            $data['tabledata']['page_count'] = $data['data_count'][0]['count'];
            $data['tabledata']['table_id'] = 'page_list';
            $data['tabledata']['url'] = 'page/get_pages';
            $data['tabledata']['hide_columns'] = ['id'];
            $data['tabledata']['actions_position'] = 'left';
            $data['tabledata']['actions'] = [
                'add' => [
                    'icon' => 'plus mdc-text-white',
                    'link' => 'page/add_page',
                    'access' => current_user_can('add'),
                    'title' => lang('page_add_button')
                ],
                'edit' => [
                    'icon' => 'edit mdc-text-orange',
                    'link' => 'page/edit_page',
                    'access' => current_user_can('edit'),
                    'title' => lang('page_edit_button')
                ],
                'delete' => [
                    'icon' => 'delete mdc-text-red',
                    'link' => 'page/delete_page',
                    'access' => current_user_can('delete'),
                    'title' => lang('page_delete_button')
                ]
            ];
            $data['tabledata']['export_pdf'] = [
                'module' => 'page',
                'model' => 'page_model',
                'function' => 'get_page_list',
                'parameters' => [
                    'type' => 'table',
                    'title' => lang('page_system_pages_export')
                ]
            ];
            _render(_cfg('admin_theme'), 'page/pages/list_pages', $data);
        } else {
            _redir('error', lang('page_manage_denied'), 'core/no_access');
        }
    }

    /**
     * add_page
     *
     * Adds a page to the database.
     *
     * @access public
     *
     * @return array
     */
    public function add_page()
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['theme_containers'] = _set_theme_area_editors();
            $data['layout_containers'] = _set_layout_area_editors();
            $data['fields']['form_open'] = [
                'id' => 'add_page_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['page_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('page_name_label'),
                'hint' => lang('page_name_hint'),
                'placeholder' => lang('page_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', '')
            ];
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
            if (!empty($data['theme_containers'])) {
                foreach ($data['theme_containers'] as $k => $v) {
                    $data['theme_areas'][$v['id']] = [
                        'id' => $v['id'],
                        'parent_id' => $v['parent_id'],
                        'name' => $v['name'],
                        'label' => $v['theme'] . ' theme, ' . $v['area'] . ' area',
                        'input_class' => 'theme-container input-group width-100',
                        'bootstrap_row' => 'row',
                        'bootstrap_col' => 'col-sm-12',
                        'individual_validation' => true,
                        'validation' => [],
                        'nuggets' => $this->core->set_nuggets([]),
                        'value' => _choose(@$data['data']['posts'][$v['id']], $v['id'], '')
                    ];
                }
            }
            if (!empty($data['layout_containers'])) {
                foreach ($data['layout_containers'] as $k => $v) {
                    $data['layout_areas'][$v['id']] = [
                        'id' => $v['id'],
                        'parent_id' => $v['parent_id'],
                        'name' => $v['name'],
                        'label' => $v['layout'] . ' layout, ' . $v['area'] . ' area',
                        'input_class' => 'layout-container input-group width-100',
                        'bootstrap_row' => 'row',
                        'bootstrap_col' => 'col-sm-12',
                        'individual_validation' => true,
                        'validation' => [],
                        'nuggets' => $this->core->set_nuggets([]),
                        'value' => _choose(@$data['data']['posts'][$v['id']], $v['id'], '')
                    ];
                }
            }
            $themes_map = _get_themes_mapped(true);
            $data['fields']['page_theme'] = [
                'id' => 'theme_id',
                'name' => 'theme_id',
                'placeholder' => lang('page_theme_placeholder'),
                'label' => lang('page_theme_label'),
                'hint' => lang('page_theme_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => $themes_map,
                'value' => _choose(@$data['data']['posts']['theme_id'], 'theme_id', '')
            ];
            $layouts_map = _get_layouts_mapped(true);
            $data['fields']['page_layout'] = [
                'id' => 'layout_id',
                'name' => 'layout_id',
                'placeholder' => lang('page_layout_placeholder'),
                'label' => lang('page_layout_label'),
                'hint' => lang('page_layout_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => $layouts_map,
                'value' => _choose(@$data['data']['posts']['layout_id'], 'layout_id', '')
            ];
            $data['fields']['page_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('page_active_placeholder'),
                'label' => lang('page_active_label'),
                'hint' => lang('page_active_hint'),
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
            $data['fields']['page_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('page_add_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('page_add_heading'),
                'prompt' => lang('page_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to page listing',
                        'link' => 'page/list_pages'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $p = $data['data']['posts'];
                $insert_id = $this->page_model->add_page($p);
                if (!empty($insert_id)) {

                    // Page meta can only be saved if we have successfully added a page.
                    if (!empty($p['meta']) && !empty($p['meta_value'])) {
                        $this->page_model->delete_page_headtags($insert_id);
                        $this->page_model->add_page_headtags($insert_id, $p['meta'], $p['meta_value']);
                    }
                    foreach ($p as $k => $v) {
                        $splits = explode('_', $k);

                        // Save the content block for the theme sections. This can only be saved if a page was successfully added.
                        if (!empty($splits[0]) && !empty($splits[1]) && !empty($splits[3]) && $splits[0] == 'theme' && $splits[1] == $p['theme_id']) {
                            $this->page_model->add_page_content($insert_id, $splits[0], $splits[1], $splits[3], $p[$k]);
                        }

                        // Save the content block for the layout sections. This can only be saved if a page was successfully added.
                        if (!empty($splits[0]) && !empty($splits[1]) && !empty($splits[3]) && $splits[0] == 'layout' && $splits[1] == $p['layout_id']) {
                            $this->page_model->add_page_content($insert_id, $splits[0], $splits[1], $splits[3], $p[$k]);
                        }
                    }
                    $success = sprintf(lang('page_add_success'), $p['name'], $insert_id);
                    _redir('success', $success, 'page/list_pages');
                } else {
                    $error = sprintf(lang('page_add_error'), $p['name']);
                    _redir('error', $error, 'page/list_pages');
                }
            }
            _render(_cfg('admin_theme'), 'page/pages/add_page', $data);
        } else {
            _redir('error', lang('page_add_denied'), 'page/list_pages');
        }
    }

    /**
     * edit_page
     *
     * Modifies a page.
     *
     * @access public
     *
     * @param int $id
     *
     * @return array
     */
    public function edit_page($id)
    {
        if (current_user_can()) {
            $data['data']['posts'] = _post();
            $data['item'] = $this->page_model->get_page_by_id($id);
            $data['content'] = $this->page_model->get_page_content($id, TRUE);
            $data['headtags'] = $this->page_model->get_page_headtags($id);
            $data['theme_containers'] = _set_theme_area_editors();
            $data['layout_containers'] = _set_layout_area_editors();
            if (!empty($data['headtags'])) {
                foreach ($data['headtags'] as $k => $v) {
                    $data['headtags_list']['meta'][] = $v['headtag_id'];
                    $data['headtags_list']['meta_value'][$v['headtag_id']][$v['attribute_id']] = $v['value'];
                }
            }
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
            $data['fields']['form_open'] = [
                'id' => 'edit_page_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['page_name'] = [
                'name' => 'name',
                'id' => 'name',
                'input_class' => 'input-group width-100',
                'label' => lang('page_name_label'),
                'hint' => lang('page_name_hint'),
                'placeholder' => lang('page_name_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'value' => _choose(@$data['data']['posts']['name'], 'name', $data['item'][0]['name'])
            ];
            if (!empty($data['theme_containers'])) {
                foreach ($data['theme_containers'] as $k => $v) {
                    $data['theme_areas'][$v['id']] = [
                        'id' => $v['id'],
                        'parent_id' => $v['parent_id'],
                        'name' => $v['name'],
                        'label' => $v['theme'] . ' theme, ' . $v['area'] . ' area',
                        'input_class' => 'theme-container input-group width-100',
                        'bootstrap_row' => 'row',
                        'bootstrap_col' => 'col-sm-12',
                        'individual_validation' => true,
                        'validation' => [],
                        'nuggets' => $this->core->set_nuggets([]),
                        'value' => _choose(@$data['data']['posts'][$v['id']], $v['id'], @$data['content'][$v['id']]['section_content'])
                    ];
                }
            }
            if (!empty($data['layout_containers'])) {
                foreach ($data['layout_containers'] as $k => $v) {
                    $data['layout_areas'][$v['id']] = [
                        'id' => $v['id'],
                        'parent_id' => $v['parent_id'],
                        'name' => $v['name'],
                        'label' => $v['layout'] . ' layout, ' . $v['area'] . ' area',
                        'input_class' => 'layout-container input-group width-100',
                        'bootstrap_row' => 'row',
                        'bootstrap_col' => 'col-sm-12',
                        'individual_validation' => true,
                        'validation' => [],
                        'nuggets' => $this->core->set_nuggets([]),
                        'value' => _choose(@$data['data']['posts'][$v['id']], $v['id'], @$data['content'][$v['id']]['section_content'])
                    ];
                }
            }
            $themes_map = _get_themes_mapped(true);
            $data['fields']['page_theme'] = [
                'id' => 'theme_id',
                'name' => 'theme_id',
                'placeholder' => lang('page_theme_placeholder'),
                'label' => lang('page_theme_label'),
                'hint' => lang('page_theme_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => $themes_map,
                'value' => _choose(@$data['data']['posts']['theme_id'], 'theme_id', $data['item'][0]['theme_id'])
            ];
            $layouts_map = _get_layouts_mapped(true);
            $data['fields']['page_layout'] = [
                'id' => 'layout_id',
                'name' => 'layout_id',
                'placeholder' => lang('page_layout_placeholder'),
                'label' => lang('page_layout_label'),
                'hint' => lang('page_layout_hint'),
                'hint_inline' => false,
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'input_class' => 'input-group-wide width-100',
                'individual_validation' => true,
                'validation' => ['rules' => 'required'],
                'options' => $layouts_map,
                'value' => _choose(@$data['data']['posts']['layout_id'], 'layout_id', $data['item'][0]['layout_id'])
            ];
            $data['fields']['page_active'] = [
                'id' => 'active',
                'name' => 'active',
                'placeholder' => lang('page_active_placeholder'),
                'label' => lang('page_active_label'),
                'hint' => lang('page_active_hint'),
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
            $data['fields']['page_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('page_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('page_edit_heading'),
                'prompt' => lang('page_edit_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to page listing',
                        'link' => 'page/list_pages'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $p = $data['data']['posts'];
                $p['id'] = $id;
                $affected = $this->page_model->edit_page($p);

                // Save the page's metadata. This happens whether or not the page itself has changed.
                if (!empty($p['meta']) && !empty($p['meta_value'])) {
                    $this->page_model->delete_page_headtags($id);
                    $this->page_model->add_page_headtags($id, $p['meta'], $p['meta_value']);
                }

                // Content changes gets saved whether or not the page settings changed.
                $this->page_model->delete_page_content($id);
                foreach ($p as $k => $v) {
                    $splits = explode('_', $k);

                    // Save the content block for the theme sections.
                    if (!empty($splits[0]) && !empty($splits[1]) && !empty($splits[3]) && $splits[0] == 'theme' && $splits[1] == $p['theme_id']) {
                        $affected1 = $this->page_model->add_page_content($id, $splits[0], $splits[1], $splits[3], $p[$k]);
                    }

                    // Save the content block for the layout sections.
                    if (!empty($splits[0]) && !empty($splits[1]) && !empty($splits[3]) && $splits[0] == 'layout' && $splits[1] == $p['layout_id']) {
                        $affected2 = $this->page_model->add_page_content($id, $splits[0], $splits[1], $splits[3], $p[$k]);
                    }
                }
                if (!empty($affected) || !empty($affected1) || !empty($affected2)) {
                    $success = sprintf(lang('page_edit_success'), $p['name'], $id);
                    _redir('success', $success, 'page/list_pages');
                } else {
                    $error = sprintf(lang('page_edit_error'), $p['name']);
                    _redir('error', $error, 'page/list_pages');
                }
            }
            _render(_cfg('admin_theme'), 'page/pages/edit_page', $data);
        } else {
            _redir('error', lang('page_edit_denied'), 'page/list_pages');
        }
    }

     /**
     * delete_page
     *
     * Deletes a page from the database
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function delete_page($id)
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
                'label' => lang('page_delete_button'),
                'input_class' => 'btn-primary',
            ];
            $data['id'] = $id;
            $data['item'] = $this->page_model->get_page_by_id($id);
            $data['delete_info'] = [
                0 => [
                    'table' => _cfg('db_prefix') . 'page',
                    'field' => 'id',
                    'value' => $id,
                ],
                1 => [
                    'table' => _cfg('db_prefix') . 'page_meta',
                    'field' => 'page_id',
                    'value' => $id,
                ],
                2 => [
                    'table' => _cfg('db_prefix') . 'page_content',
                    'field' => 'page_id',
                    'value' => $id,
                ]
            ];
            $data['prompt_fields'] = [
                'Page' => 'name',
                'Slug' => 'slug',
                'Active' => 'active',
                'Deleted' => 'deleted',
                'Modified' => 'moddate'
            ];
            $data['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to page listing',
                        'link' => 'page/list_pages'
                    ]
                ],
                'view' => 'page/pages/delete_confirm',
                'redirect' => 'page/list_pages',
                'delete_type' => $this->delete_type
            ];
            $data['messages'] = [
                'heading' => lang('page_delete_heading'),
                'prompt' => lang('page_delete_prompt'),
                'success' => lang('page_delete_success'),
                'error' => lang('page_delete_error'),
                'warning' => lang('page_delete_warn'),
                'return' => lang('page_delete_return')
            ];
            _delete($data);
        } else {
            _redir('error', lang('page_delete_denied'), 'page/list_pages');
        }
    }

    /**
     * function get_pages
     *
     * Retrieves all pages for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function get_pages()
    {
        $check = _grid_open();
        $pages = $this->page_model->get_page_list($check['start'], $check['end'], $check['search'], $check['order']);
        $count = $this->page_model->get_page_count(false, $check['search']);
        $final = _grid_close($check, $pages, $count);
        echo $final;
    }

    /**
     * function ajax_get_page_meta
     *
     * Retrieves all pages for use in ajax listings
     *
     * @access public
     *
     * @return void
     */
    public function ajax_get_page_meta()
    {
        $return = '';
        $posts = _post();
        $headtags_map = _get_headtags_mapped(false);
        if (!empty($posts['meta'])) {
            $posts['meta'] = array_unique($posts['meta']);
            foreach ($posts['meta'] as $k => $v) {
                $opts = '';
                if (!empty($headtags_map)) {
                    $sel = '';
                    foreach ($headtags_map as $kk => $vv) {
                        $sel = '';
                        if ($kk == $v) {
                            $sel = ' selected=\"selected\"';
                        }
                        $opts .= '<option' . $sel . ' value=\"' . $kk. '\">' . $vv . '</option>';
                    }
                }
                $return .= $this->build_meta_element_group($opts, $posts);
            }
        } else {
            $opts = '';
            if (!empty($headtags_map)) {
                foreach ($headtags_map as $k => $v) {
                    $opts .= '<option value=\"' . $k. '\">' . $v . '</option>';
                }
            }
            $return = $this->build_meta_element_group($opts, $posts);
        }
        echo json_encode($return);
    }

    public function ajax_get_page_headtag_attributes($headtag_id)
    {
        $attributes = _get_headtag_attributes($headtag_id);
        $posts = _post();
        if (!empty($attributes)) {
            $final = '<div class="row">';
            foreach ($attributes as $k => $v) {
                $final .= '
                    <div class="col-sm-4">
                        <input placeholder="' . $v['name'] . '" value="' . (!empty($posts['meta_value'][$v['headtag_id']][$v['attribute_id']]) ? $posts['meta_value'][$v['headtag_id']][$v['attribute_id']] : '') . '" name="meta_value[' . $v['headtag_id'] . '][' . $v['attribute_id'] . ']" class="input-group-wide width-100" style="height: 48px !important;" type="text" id="meta_value_"' . $posts['id_holder'] . '">
                    </div>
                ';
            }
            $final .= '</div>';
            echo $final;
        }
    }

    /**
     * function build_meta_element_group
     *
     * Builds the dropdown and text field combination to add a page headtag meta group.
     *
     * @access private
     *
     * @param string $opts
     *
     * @return string
     */
    private function build_meta_element_group($opts, $data)
    {
        $temp = uniqid();
        $posts = $data;
        $posts['id_holder'] = $temp;
        $return = "
            <div>
                <br>
                <div class=\"row\">
                    <div class=\"col-sm-3\">
                        <select name=\"meta[]\" class=\"meta_select input-group-wide width-100\" id=\"meta_" . $temp . "\">
                            <option value=\"0\">Please select...</option>
                            " . str_replace('\"', '', $opts) . "
                        </select>
                    </div>
                    <div class=\"col-sm-1 text-left\"><a id=\"meta-group-del-" . $temp . "\" href=\"#\"><i style=\"padding-top: 12px;\" class=\"zmdi zmdi-hc-2x mdc-text-red zmdi-minus-circle\"></i></a></div>
                    <div class=\"col-sm-8\" id=\"meta-key-box-" . $temp . "\" style=\"display: block;\"></div>
                </div>
                <script type=\"text/javascript\">
                    $(function() {
                        $(\"#meta-group-del-" . $temp . "\").on(\"click\", function(e) {
                            $(this).parent().parent().parent().html(\"\");
                        });
                        $(\"#meta_" .  $temp . "\").select2({
                            allowClear: true,
                            placeholder: \"Select an option\",
                            allowClear: true,
                            containerCssClass: \"input-group-wide width-100\",
                        }).on(\"change\", function(e){
                            var tag_id = $(this).val();
                            var base_url2 = \"" . base_url() . "page/ajax_get_page_headtag_attributes/\";
                            if (tag_id != 0 && typeof(tag_id) != \"undefined\") {
                                $.ajax(base_url2 + \"/\" + tag_id, {
                                    type: \"POST\",
                                    data: " . json_encode($posts) . ",
                                    success: function(response3) {
                                        if (response3) {
                                            $(\"#meta-key-box-" . $temp . "\").html(response3);
                                            $(\"#meta-key-box-" . $temp . "\").show();
                                        }
                                    }
                                });
                            }
                        });
                        var tag_id = $(\"#meta_" .  $temp . "\").val();
                        var base_url2 = \"" . base_url() . "page/ajax_get_page_headtag_attributes\";
                        if (tag_id != 0 && typeof(tag_id) != \"undefined\") {
                            $.ajax(base_url2 + \"/\" + tag_id, {
                                type: \"POST\",
                                data: " . json_encode($posts) . ",
                                success: function(response3) {
                                    if (response3) {
                                        $(\"#meta-key-box-" . $temp . "\").html(response3);
                                        $(\"#meta-key-box-" . $temp . "\").show();
                                    }
                                }
                            });
                        }
                    });
                </script>
                <div class=\"row\">
                    <div class=\"col-sm-12\">&nbsp;</div>
                </div>
            </div>
        ";
        return $return;
    }
}
