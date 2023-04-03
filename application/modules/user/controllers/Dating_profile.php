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
 * KyrandiaCMS Dating Profile module
 *
 * This is the main controller file for KyrandiaCMS's dating profile module.
 *
 * @package     Impero
 * @subpackage  Modules
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

class Dating_profile extends MX_Controller
{

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
        _modules_load(['core', 'syslog']);
        _models_load(['dating_profile_model']);
        _languages_load(['core/core', 'user/user', 'user/dating_profile']);

        // Check if module settings and dependencies are correct
        _settings_check('dating_profile');
    }

    /**
     * edit_dating_profile
     *
     * Edits the profile
     *
     * @access public
     *
     * @param int $id
     *
     * @return void
     */
    public function edit_dating_profile($id)
    {

        // Checks this user's permissions to access this function.
        $uid = _sess_get('id');
        $posts = $this->input->post();
        if (current_user_can() && ($uid == $id)) {

            // Build up form fields for the view.
            $data['data']['posts'] = _post();
            $data['fields']['form_open'] = [
                'id' => 'add_user_form',
                'form_class' => 'default-form',
                'multipart' => true,
                'has_combined_validation' => false
            ];
            $data['fields']['form_close'] = [];
            $data['fields']['dating_profile_nickname'] = [
                'name' => 'nickname',
                'id' => 'nickname',
                'input_class' => 'input-group width-100',
                'label' => 'Nickname',
                'hint' => sprintf(lang('core_select_at_least'), 1),
                'placeholder' => lang('dating_profile_dating_profile_field_nickname_placeholder'),
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12',
                'individual_validation' => true,
                'validation' => ['rules' => 'required|validate_username_unique'],
                'value' => _choose(@$data['data']['posts']['nickname'], 'nickname', ''),
            ];
            $data['fields']['dating_profile_submit'] = [
                'id' => 'submit',
                'name' => 'submit',
                'label' => lang('dating_profile_dating_profile_edit_button'),
                'input_class' => 'btn-primary',
                'bootstrap_row' => 'row',
                'bootstrap_col' => 'col-sm-12'
            ];
            $data['data']['messages'] = [
                'heading' => lang('dating_profile_dating_profile_add_heading'),
                'prompt' => lang('dating_profile_dating_profile_add_prompt'),
            ];
            $data['data']['process'] = [
                'actions' => [
                    0 => [
                        'label' => 'Return to profile',
                        'link' => 'user/dating_profile/my_profile'
                    ]
                ]
            ];
            _validate($data['fields']);
            if ($this->form_validation->run($this) === true) {
                $data['id'] = $id;
                $data['data']['posts'] = $posts;
                $data['data']['posts']['id'] = $data['id'];
                $return_data = $this->user_model->edit_dating_profile($data['data']['posts']);
                if ($return_data['affected_rows']) {
                    $success = 'Your profile was successfully updated.';
                    _redir('success', $success, 'user/dating_profile/my_profile');
                } else {
                    $error = 'Your profile could not be saved.';
                    _redir('error', $error, 'user/dating_profile/my_profile');
                }
            }
            _render(_cfg('current_theme'), 'user/dating_profile/edit_profile', $data);

        } else {
            _redir('error', 'You do not have permission to edit this profile.', 'user/dating_profile/my_profile');
        }
    }

    /**
     * function my_profile
     *
     * Redirects the user to his/her profile page
     *
     * @access public
     * @return void
     */
    public function my_profile()
    {
        $data['logged_user'] = get_current_user_data();
        if (!empty($data['logged_user']['id'])) {
            _render(_cfg('current_theme'), 'user/dating_profile/my_profile', $data);
        } else {
            _403('user_session', 'You do not have permission to access this profile.');
            _redir('error', 'You do not have permission to access this profile.', 'home');
        }
    }
}
