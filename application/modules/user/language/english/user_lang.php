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
 * KyrandiaCMS User Module
 *
 * Contains the language strings for the User module of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Config
 * @category    Language
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

// User
$lang['user_user_system_users_export'] = 'System users export';
$lang['user_user_successfully_logged_out'] = 'You have been logged out successfully.';
$lang['user_user_add_heading'] = 'Add user';
$lang['user_user_add_prompt'] = 'Please complete all the fields to add a new user.';
$lang['user_user_add_button'] = 'Add user';
$lang['user_user_add_denied'] = 'You do not have permission to add users';
$lang['user_user_add_error'] = 'The user could not be added.';
$lang['user_user_add_warn'] = 'The user could not be added.';
$lang['user_user_add_success'] = 'You have successfully added the user <strong>%1$s</strong> (ID: %2$d) and assigned <strong>%3$d</strong> roles.';
$lang['user_user_field_welcome_mail_label'] = 'Send welcome mail';
$lang['user_user_add_welcome_mail_subject'] = 'Welcome to the %1$s system, %2$s!';
$lang['user_user_add_welcome_mail_status'] = 'Additionally, a welcome email has been sent to the new user at address <strong>%1$s</strong>';
$lang['user_user_add_welcome_mail_error'] = 'Additionally, you have opted to send a welcome mail, but we could not send the message. Please contact your administrator.';
$lang['user_user_add_error'] = 'We could not add the user <strong>%1$s</strong>. If this persists, please contact an administrator.';
$lang['user_user_delete_heading'] = 'Delete user';
$lang['user_user_delete_button'] = 'Delete user';
$lang['user_user_delete_prompt'] = 'Are you sure you want to delete this user?';
$lang['user_user_delete_success'] = 'The user was successfully deleted.';
$lang['user_user_delete_error'] = 'The user could not be deleted.';
$lang['user_user_delete_warn'] = 'The user could not be deleted.';
$lang['user_user_delete_denied'] = 'You do not have permission to delete users';
$lang['user_user_delete_return'] = 'Go back to the users listing.';
$lang['user_user_lock_heading'] = 'Lock user';
$lang['user_user_lock_button'] = 'Lock user';
$lang['user_user_lock_prompt'] = 'Are you sure you want to lock this user?';
$lang['user_user_lock_success'] = 'The user was successfully locked.';
$lang['user_user_lock_error'] = 'The user could not be locked.';
$lang['user_user_lock_denied'] = 'You do not have permission to lock users';
$lang['user_user_lock_return'] = 'Go back to the users listing.';
$lang['user_user_lock_warn'] = 'A locked user will be unable to log in. <strong>Are you sure you want to continue?</strong>';
$lang['user_user_unlock_heading'] = 'Unlock user';
$lang['user_user_unlock_button'] = 'Unlock user';
$lang['user_user_unlock_prompt'] = 'Are you sure you want to unlock this user?';
$lang['user_user_unlock_success'] = 'The user was successfully unlocked.';
$lang['user_user_unlock_error'] = 'The user could not be unlocked.';
$lang['user_user_unlock_warn'] = 'An unlocked user will have their access restored. <strong>Are you sure you want to continue?</strong>';
$lang['user_user_unlock_denied'] = 'You do not have permission to unlock users';
$lang['user_user_unlock_return'] = 'Go back to the users listing.';
$lang['user_user_password_head'] = 'Change password';
$lang['user_user_password_prompt'] = 'Please enter your old and new passwords below.';
$lang['user_user_forgot_head'] = 'Forgot password';
$lang['user_user_forgot_prompt'] = 'Please enter your email address below.';
$lang['user_user_email'] = 'Email';
$lang['user_user_email_hint'] = 'Enter your email address here.';
$lang['user_user_email_placeholder'] = 'Please enter a valid email address.';
$lang['user_user_old_password'] = 'Old password';
$lang['user_user_old_password_hint'] = 'Please enter your current password here.';
$lang['user_user_old_password_placeholder'] = 'Enter your old password here.';
$lang['user_user_new_password_hint'] = 'Please ensure that your password complies to the password rules. [TODO]';
$lang['user_user_new_password_placeholder'] = 'Enter your new password here.';
$lang['user_user_new_password'] = 'New password';
$lang['user_user_new_password_confirm_password_hint'] = 'This password must match your new password.';
$lang['user_user_new_password_confirm_password_placeholder'] = 'Enter your new password here, again.';
$lang['user_user_new_password_confirm_password'] = 'Confirm password';
$lang['user_user_password_may_not_match'] = 'Your new password may not be the same as your old password.';
$lang['user_user_password_must_match'] = 'Your new password and your confirmation password are not the same.';
$lang['user_user_password_changed_successfully'] = 'You have successfully changed your password.';
$lang['user_user_password_error_match'] = 'Your old password does not match your password in the system.';
$lang['user_user_access_restricted'] = 'Access Restricted';
$lang['user_user_access_prompt'] = 'Access to this section of the website is restricted. Please log in below. If you have forgotten your password, or do not have an account, please choose one options below the submit button.';
$lang['user_user_control_panel_head'] = 'Control Panel';
$lang['user_user_entered_invalid_details'] = 'You have entered an invalid username or password.';
$lang['user_user_successfully_logged_in'] = 'You have successfully logged in.';
$lang['user_user_temp_successfully_logged_in'] = 'User has logged in successfully with a temporary password.';
$lang['user_user_admin_override'] = 'User has logged in as an administrator with an administrator override password.';
$lang['user_user_temp_password_expired'] = 'A temporary password was set, but has expired. You can still log in with your old password if you can remember it, otherwise you will have to reset your password again.';
$lang['user_user_access_denied'] = 'Control panel access not permitted. You must be logged in to continue.';
$lang['user_user_access_permitted'] = 'Control panel accessed successfully.';
$lang['user_user_system_users_export'] = 'Users export';
$lang['user_user_manage_heading'] = 'Manage users';
$lang['user_user_manage_hint'] = 'You can manage users here.';
$lang['user_user_manage_denied'] = 'You do not have permission to manage users';
$lang['user_user_edit_heading'] = 'Edit user';
$lang['user_user_edit_prompt'] = 'Please complete all the fields to edit this user.';
$lang['user_user_edit_button'] = 'Save user';
$lang['user_user_edit_denied'] = 'You do not have permission to edit users';
$lang['user_user_edit_error'] = 'The user could not be saved.';
$lang['user_user_edit_warn'] = 'The user could not be saved.';
$lang['user_user_edit_success'] = 'You have successfully saved the user <strong>%1$s</strong> (ID: %2$d) and assigned <strong>%3$d</strong> roles.';
$lang['user_user_system_logs_export'] = 'Session logs export';

// User fields
$lang['user_user_field_password_label'] = 'Password';
$lang['user_user_field_password_hint'] = 'Enter at least 1 character.';
$lang['user_user_field_password_placeholder'] = 'Enter your password here.';
$lang['user_user_field_username_label'] = 'Usermame';
$lang['user_user_field_username_hint'] = 'Enter at least 1 character.';
$lang['user_user_field_username_placeholder'] = 'Enter your username here.';
$lang['user_user_field_email_label'] = 'Email address';
$lang['user_user_field_email_hint'] = 'Enter a valid email address.';
$lang['user_user_field_email_placeholder'] = 'Enter the user\'s email address here.';
$lang['user_user_field_confirm_password_label'] = 'Confirm password';
$lang['user_user_field_confirm_password_hint'] = 'Enter at least 1 character.';
$lang['user_user_field_confirm_password_placeholder'] = 'Confirm the user\'s password here. It must match the password field.';
$lang['user_user_field_active_label'] = 'Active';
$lang['user_user_field_active_hint'] = 'Select whether this user is active or not.';
$lang['user_user_field_active_placeholder'] = 'Click to select';
$lang['user_user_field_locked_label'] = 'Locked';
$lang['user_user_field_locked_hint'] = 'Select whether this user is locked or not.';
$lang['user_user_field_locked_placeholder'] = 'Click to select';
$lang['user_user_field_welcome_mail_label'] = 'Send welcome mail';
$lang['user_user_field_welcome_mail_hint'] = 'Select whether this user will receive a welcome mail or not.';
$lang['user_user_field_welcome_mail_placeholder'] = 'Click to select';
$lang['user_user_field_roles_label'] = 'Roles';
$lang['user_user_field_roles_hint'] = 'Select the roles this user must have.';
$lang['user_user_field_roles_placeholder'] = 'Click to select';
$lang['user_user_register_email_subject'] = 'Complete your registration at %1$s';
$lang['user_user_register_success_inactive'] = 'User registered successfully, account made inactive.';
$lang['user_user_register_success_invite'] = 'You have successfully registered. Please activate your account - see the email that was sent to your email address for further instructions.';
$lang['user_user_register_success_inactive_mail_error'] = 'User registered successfully, account made inactive, but notification could not be sent.';
$lang['user_user_register_success_invite_mail_error'] = 'You have successfully registered, but your welcome email could not be sent. Please ask an administrator to activate your account.';

// Passwords
$lang['user_user_password_changed_prompt'] = 'You have successfully changed your password.';
$lang['user_user_password_changed_head'] = 'Password changed';
$lang['user_user_password_reset_prompt'] = 'You have successfully requested a temporary password. It has been emailed to you.';
$lang['user_user_password_reset_head'] = 'Password reset';
$lang['user_user_password_reset_info'] = 'This new temporary password has been emailed to you and will be valid for %1$d hours. If not used by then, you will have to reset your password again.';
$lang['user_user_password_reset_button'] = 'Log in';
$lang['user_user_password_mail_title'] = 'Your replacement password for %1$s';
$lang['user_user_password_reset_success'] = 'User has successfully reset password';
$lang['user_user_password_reset_user_success'] = 'You have successfully reset your password. Please use your new password the next time you log in.';
$lang['user_user_password_reset_mail_fail'] = 'User has successfully reset password, but notification mail failed.';
$lang['user_user_password_reset_user_mail_fail'] = 'You have successfully reset your password, but we could not email the password to you. Please use your new password the next time you log in.';
$lang['user_user_password_reset_fail'] = 'The password for the user could not be reset. No such email address.';
$lang['user_user_password_reset_user_fail'] = 'We could not find a user with that email address.';
