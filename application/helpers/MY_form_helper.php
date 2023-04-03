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
 * @version   7.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Form Helper
 *
 * Contains a list of common form functions used in the system.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

/**
 * Function set_on()
 *
 * Sets a variable based on a particular set of conditions and values passed by parameters.
 *
 * @access public
 *
 * @param string $type
 * @param mixed $var
 * @param mixed $value
 * @param mixed $else
 *
 * @return void
 */
if (!function_exists('set_on')) {
    function set_on(&$var, $type = 'notset', $value = '', $else = ''): void
    {
        if ($value != '') {
            if ($type == 'notset') {

                // Only sets the variable to $value if it is not set already, but if $else is not empty, and $var is set already, set it to $else
                if (!isset($var)) {
                    $var = $value;
                } else {
                    if (!empty($else)) {
                        $var = $else;
                    }
                }
            } elseif ($type == 'isset') {

                // Only sets the variable to $value if it is set already, but if $else is not empty, and $var is not set yet, set it to $else
                if (isset($var)) {
                    $var = $value;
                } else {
                    if (!empty($else)) {
                        $var = $else;
                    }
                }
            } elseif ($type == 'notempty') {

                // Only sets the variable to $value if it does not evaluate to empty, but if $else is not empty, and $var is not empty, set it to $else
                if (!empty($var)) {
                    $var = $value;
                } else {
                    if (!empty($else)) {
                        $var = $else;
                    }
                }
            } elseif ($type == 'isempty') {

                // Only sets the variable to $value if it evaluates to empty, but if $else is not empty, and it is $var empty, set it to $else
                if (empty($var)) {
                    $var = $value;
                }
            } elseif ($type == 'append') {

                // Only sets the variable to $value if it does not evaluate to empty. If $else is filled, append that to the value.
                if (!empty($var)) {
                    $var = $value;
                }
                if (!empty($else)) {
                    $var .= $else;
                }
            }
        }
    }
}

/**
 * Function do_file_upload()
 *
 * Uploads files to the server.
 *
 * TODO: Add database layer.
 * TODO: Fix this crap!
 *
 * @access public
 *
 * @return array
 */
if (!function_exists('do_file_upload')) {
    function do_file_upload($field_name = ''): array
    {
        $ci =& get_instance();
        $data = $ci->input->post();
        $config['upload_path'] = $data['upload_path'];
        $config['allowed_types'] = $data['upload_allowed_types'];
        $config['max_size'] = $data['upload_max_size'];
        $config['max_width'] = $data['upload_max_width'];
        $config['max_height'] = $data['upload_max_height'];
        $result = [];
        $error = [];
        $files = $ci->session->userdata('files_' . $data['upload_name']);
        if (!empty($files) && is_array($files[$data['upload_name']]['name']) && count($files[$data['upload_name']]['name']) > 1) {
            foreach ($files[$data['upload_name']]['name'] as $key => $file) {
                $config['file_name'] = $files[$data['upload_name']]['name'][$key];
                $config['file_ext_tolower'] = true;
                $_FILES[$data['upload_field_name']]['name'] = $files[$data['upload_name']]['name'][$key];
                $_FILES[$data['upload_field_name']]['type'] = $files[$data['upload_name']]['type'][$key];
                $_FILES[$data['upload_field_name']]['tmp_name'] = $files[$data['upload_name']]['tmp_name'][$key];
                $_FILES[$data['upload_field_name']]['error'] = $files[$data['upload_name']]['error'][$key];
                $_FILES[$data['upload_field_name']]['size'] = $files[$data['upload_name']]['size'][$key];
                $ci->load->library('upload', $config);
                $ci->upload->initialize($config);
                if (!$ci->upload->do_upload($data['upload_field_name'])) {
                    $error[] = array('error' => $ci->upload->display_errors($data['upload_delimiter_open'], $data['upload_delimiter_close']));
                } else {
                    $result[] = $ci->upload->data();
                }
            }
        } else {
            $config['file_name'] = $_FILES[$data['upload_field_name']]['name'];
            $config['file_ext_tolower'] = true;
            if (empty($field_name)) {
                $field_name = $data['upload_field_name'];
            }
            if (!empty($field_name)) {
                $ci->load->library('upload', $config);
                $ci->upload->initialize($config);
                if (!$ci->upload->do_upload($field_name)) {
                    $error[] = array('error' => $ci->upload->display_errors($data['upload_delimiter_open'], $data['upload_delimiter_close']));
                    preint($field_name);
                    preint($_FILES);
                    preint($error);
                    die();
                } else {
                    $result[] = $ci->upload->data();
                }
            }
        }
        if (!empty($error)) {
            return ['error' => $error];
        }
        return $result;
    }
}

/**
 * Function general_prompt()
 *
 * Displays a general prompt to request user to confirm an action.
 *
 * @access public
 *
 * @param array $meta
 *
 * @return void
 */
function general_prompt($data, $make_card = true): void
{
    if (!empty($data)) {
        $out = '
            <div class="card-header bgm-dark text-white">
                <h2>' . $data['messages']['heading'] . '
                    <small>' . $data['messages']['prompt'] . '</small>
                </h2>
        ';
        if (!empty($data['process']['actions'])) {
            $out .= '
                <ul class="actions actions-alt">
                    <li class="dropdown">
                        <a href="" data-toggle="dropdown" aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
            ';
            foreach ($data['process']['actions'] as $k => $v) {
                $out .= '
                            <li><a href="' . base_url() . $v['link'] . '">' . $v['label'] .  '</a></li>
                ';
            }
            $out .= '
                        </ul>
                    </li>
                </ul>
            ';
        }
        $out .= '
            </div>
        ';
        if ($make_card) {
            $out .= '
                <div class="card-body card-padding">
            ';
            if (!empty($data['prompt_fields'])) {
                $out .= '
                    <div class="row">
                        <div class="col-sm-12">
                ';
                foreach ($data['prompt_fields'] as $k => $v) {
                    $out .= '<strong>' . $k . ': </strong>' . $data['item'][0][$v] . '<br />';
                }
                $out .= '
                        </div>
                    </div>
                ';
            }
            $out .= '
                </div>
            ';
        }
        echo $out;
    }
}

/**
 * Function add_tag_attribute()
 *
 * Adds an attribute and associated value to a html tag.
 *
 * @access public
 *
 * @param bool $attribute
 * @param string $value
 *
 * @return string
 */
if (!function_exists('add_tag_attribute')) {
    function add_tag_attribute($attribute, $value): string
    {
        if (!empty($value)) {
            return ' ' . $attribute . '="' . $value . '"';
        }
        return '';
    }
}

/**
 * Function exit_if_empty()
 *
 * Exits the routine with an error if some fields are empty
 *
 * @access public
 *
 * @param mixed $fields
 * @param string $message
 *
 * @return string
 */
if (!function_exists('exit_if_empty')) {
    function exit_if_empty(&$data, $indexes, $message = '')
    {
        $elements = '';
        if (empty($message)) {
            $message = 'Some of the required attributes for this form element was not set appropriately, cannot construct form element: ';
        }
        if (!is_array($data)) {
            $data = [$data];
        }
        foreach ($indexes as $v) {
            if (empty($data[$v])) {
                $elements .= $v . ', ';
            }
        }
        $elements = rtrim($elements, ', ');
        if (!empty($elements)) {
            exit($message . $elements);
        }
    }
}

/**
 * function kcms_form_fieldset()
 *
 * Draws an entire form fieldset
 *
 * @access public
 *
 * @param array $data
 *  ['form'] - must we include form open/close tags?
 *  ['accept_charset'] - which character set should the form use?
 *  ['form_class'] - the CSS class that is applied to the form tag.
 *  ['extra'] - additional Code Igniter abilities to add on to the form.
 *  ['action'] - where the form should redirect to.
 *  ['hidden'] - an array of hidden fields you want to add to the form.
 *  ['multipart'] - whether or not file uploads should be supported.
 *  ['has_combined_validation'] - will error messages also be shown at the top of the form?
 *  ['error_delimiters'] - how will form errors be deliminted?
 *  ['error_class'] - the CSS class that is used for individual errors.
 *  ['save_to_db'] - data will be json_encoded, and saved to the database on submit.
 *
 * @return string
 */
if (!function_exists('kcms_form_fieldset')) {
    function kcms_form_fieldset(&$data)
    {

        // Initialize with sensible defaults.
        $ci =& get_instance();
        $out = '';

        if (!empty($data['form_open'])) {
            $out .= kcms_form_open($data);
        }

        // Add each form element
        if (!empty($data['fields'])) {
            foreach ($data['fields'] as $a => $field) {
                if (isset($field['type']) && $field['type'] == 'text') {
                    set_on($field['outer_class'], 'notset', '');
                    set_on($field['type'], 'notset', $field['type'], 'text');
                    set_on($field['label_class'], 'notset', 'control-label');
                    set_on($field['error_class'], 'notset', 'form-narrow-error');
                    set_on($field['input_class'], 'notset', '');
                    set_on($field['input_style'], 'notset', '');
                    set_on($field['individual_validation'], 'notset', true);
                    set_on($field['length'], 'notset', '');
                    set_on($field['label'], 'notset', '');
                    set_on($field['disabled'], 'notset', '');
                    set_on($field['hint'], 'notset', '');
                    set_on($field['readonly'], 'notset', '');
                    set_on($field['placeholder'], 'notset', '');
                    set_on($field['validation'], 'notset', '');
                    set_on($field['validation_indicator'], 'notset', '');
                    set_on($field['name'], 'notset', '');
                    set_on($field['datepicker'], 'notset', false);
                    set_on($field['timepicker'], 'notset', false);
                    set_on($field['datetimepicker'], 'notset', false);
                    set_on($field['datepicker_now'], 'notset', true);
                    set_on($field['value'], 'notset', !empty($ci->input->post($field['name'])) ? $ci->input->post($field['name']) : '');

                    // Never trust user input.
                    $data = _clean_array($field);

                    // Wrap the element.
                    $out .= _append_if(!empty($field['outer_class']), '<div class="' . $field['outer_class'] . '">');

                    // Apply validation related rules markup.
                    if (!empty($field['validation']['rules'])) {
                        $rules = explode('|', $field['validation']['rules']);
                        if (!empty($rules) && in_array('required', $rules)) {
                            $field['validation_indicator'] = '<span class="form-validation-required"> * </span>';
                        }
                    }

                    // See if we must add a picker class.
                    $now = '';
                    if ($field['datepicker_now']) {
                        $now = ' dp-now';
                    }
                    if ($field['datepicker']) {
                        $field['input_class'] .= ' date-picker' . $now;
                    }
                    if ($field['timepicker']) {
                        if (!empty($field['seconds'])) {
                            $field['input_class'] .= ' time-ss-picker' . $now;
                        } else {
                            $field['input_class'] .= ' time-picker' . $now;
                        }
                    }
                    if ($field['datetimepicker']) {
                        if (!empty($field['seconds'])) {
                            $field['input_class'] .= ' date-time-ss-picker' . $now;
                        } else {
                            $field['input_class'] .= ' date-time-picker' . $now;
                        }
                    }

                    // Add the actual element now.
                    $out .= '<div class="row">';
                    $out .= '<div class="col-sm-3">';
                    $out .= '
                        <label class="' . $field['label_class'] . '" for="' . $field['id'] . '">' . $field['label'] . $field['validation_indicator'] . '</label>
                    ';
                    $out .= '</div>';
                    $out .= '<div class="col-sm-9">';

                    $out .= '<input id="' . $field['id'] . '" name="' . $field['name'] . '"';
                    $out .= add_tag_attribute('placeholder', $field['placeholder']);
                    $out .= add_tag_attribute('class', $field['input_class']);
                    $out .= add_tag_attribute('style', $field['input_style']);
                    $out .= add_tag_attribute('type', $field['type']);
                    $out .= add_tag_attribute('value', $field['value']);
                    $out .= add_tag_attribute('length', $field['length']);
                    $out .= add_tag_attribute('readonly', $field['readonly']);
                    $out .= add_tag_attribute('disabled', $field['disabled']);
                    if (!empty($field['validation']['rules'])) {
                        $out .= add_tag_attribute('data-has-validation', true);
                    }
                    $out .= '>';
                    $out .= '</div>';
                    $out .= '</div>';

                    // Do we have an inline hint?
                    if (!empty($field['hint'])) {
                        $out .= '<div class="row">';
                        $out .= '<div class="col-sm-3"></div>';
                        $out .= '<div class="col-sm-9">';
                        $out .= '<span class="hint-text">' . $field['hint'] . '</span>';
                        $out .= '</div>';
                        $out .= '</div>';
                    }
                    //$out .= '</div>';

                    // Close the element wrap.
                    $out .= _append_if(!empty($field['outer_class']), '</div>');

                    // Add validation errors row.
                    if (!empty(form_error($field['name'])) && !empty($field['individual_validation'])) {
                        $out .= '<div class="row">';
                        $out .= '<div class="col-sm-12">';
                        $out .= _append_if(!empty($field['error_class']), '<div class="' . $field['error_class'] . '">');
                        $out .= form_error($field['name']);
                        $out .= _append_if(!empty($field['error_class']), '</div>');
                        $out .= '</div>';
                        $out .= '</div>';
                    }
                }
            }
        }

        // Add the close tag if required by parameters.
        if (!empty($data['form_close'])) {
            $out .= kcms_form_close($data);
        }

        // Return the element.
        unset($form_func);
        unset($data);

        return $out;
    }
}


/**
 * function kcms_form_open()
 *
 * Function to generate the form open tag.
 *
 * @access public
 *
 * @param array $data
 *  ['method'] - should the form be post or get?
 *  ['accept_charset'] - which character set should the form use?
 *  ['form_class'] - the CSS class that is applied to the form tag.
 *  ['extra'] - additional Code Igniter abilities to add on to the form.
 *  ['action'] - where the form should redirect to.
 *  ['hidden'] - an array of hidden fields you want to add to the form.
 *  ['multipart'] - whether or not file uploads should be supported.
 *  ['has_combined_validation'] - will error messages also be shown at the top of the form?
 *  ['error_delimiters'] - how will form errors be deliminted?
 *  ['error_class'] - the CSS class that is used for individual errors.
 *  ['save_to_db'] - data will be json_encoded, and saved to the database on submit.
 *
 * @return string
 */
if (!function_exists('kcms_form_open')) {
    function kcms_form_open(&$data)
    {

        // Initialize with sensible defaults.
        $ci =& get_instance();
        set_on($data['method'], 'notset', 'post');
        set_on($data['accept_charset'], 'notset', 'utf-8');
        set_on($data['form_class'], 'notset', 'default-form');
        set_on($data['extra'], 'notset', '');
        set_on($data['id'], 'notset', '');
        set_on($data['name'], 'notset', $data['id']);
        set_on($data['action'], 'notset', '');
        set_on($data['hidden'], 'notset', []);
        set_on($data['multipart'], 'notset', true);
        set_on($data['has_combined_validation'], 'notset', true);
        set_on($data['error_delimiters'], 'notset', ['<div>', '</div>']);
        set_on($data['error_class'], 'notset', 'form-narrow-error');
        set_on($data['save_to_db'], 'notset', false);
        $form_func = 'form_open';
        if (!empty($data['multipart'])) {
            $form_func = 'form_open_multipart';
        }

        // Never trust user input.
        $data = _clean_array($data);

        // Set up form error delimiters and options.
        if (!empty($data['error_delimiters'])) {
            $ci->form_validation->set_error_delimiters(
                (!empty($data['error_delimiters'][0]) ? $data['error_delimiters'][0] : null),
                (!empty($data['error_delimiters'][1]) ? $data['error_delimiters'][1] : null)
            );
        }

        // Additional CSS class to use in the form.
        if (!empty($data['form_class'])) {
            if (empty($data['extra'])) {
                $data['extra'] = ' class="' . $data['form_class'] . '"';
            } else {
                if (strpos($data['extra'], 'class') === false) {
                    $data['extra'] .= ' class="' . $data['form_class'] . '"';
                }
            }
        }
        $data['extra'] .= ' id="' . $data['id'] . '" name="' . $data['name'] . '"';

        // Construct the form tag.
        if (!empty($data['hidden'])) {
            $out = $form_func($data['action'], $data['extra'], $data['hidden']);
        } else {
            $out = $form_func($data['action'], $data['extra']);
        }

        // Add the div of combined validation errors if needed.
        if (!empty(validation_errors()) && !empty($data['has_combined_validation'])) {
            if (!empty($data['error_class'])) {
                $out .= '
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="' . $data['error_class'] . '">' . validation_errors() . '</div>
                        </div>
                    </div>
                ';
            } else {
                $out .= '
                    <div class="row">
                        <div class="col-sm-12">' . validation_errors() . '</div>
                    </div>
                ';
            }
        }

        // Must the data entered into the form be saved to the database?
        if (!empty($data['save_to_db'])) {
            $out .= form_hidden('save_to_db', true);
        }

        // Return the element.
        unset($form_func);
        unset($data);
        return $out;
    }
}

/**
 * function kcms_form_close()
 *
 * Function to generate the form close tag.
 *
 * @access public
 *
 * @param array $data
 *  ['extra'] - additional Code Igniter abilities to add on after the closing form tag.
 *
 * @return string
 */
if (!function_exists('kcms_form_close')) {
    function kcms_form_close(&$data)
    {

        // Initialize with sensible defaults.
        set_on($data['close_extra'], 'empty', '');

        // Never trust user input.
        $data = _clean_array($data);

        // Return the element.
        $extra = $data['close_extra'];
        unset($data);
        return form_close($extra);
    }
}

/**
 * function kcms_form_button()
 *
 * Function to generate a button
 *
 * @access public
 *
 * @param array $data
 *  ['icon'] - should the button have an icon, and if set, which CSS classes?
 *  ['label'] - what text is displayed on the button?
 *  ['input_class'] - the outer class for the element.
 *  ['id'] - how will the button be uniquely identified?
 *  ['name'] - the name of the button for reading post or get values from it.
 *  ['button_type'] - the type of the button - button or submit.
 *  ['bootstrap_row'] - will the element be wrapped in a bootstrap row?
 *  ['bootstrap_col'] - will the element be wrapped in a bootstrap column?
 *
 * @return string
 */
if (!function_exists('kcms_form_button')) {
    function kcms_form_button(&$data)
    {

        // Initialize with sensible defaults.
        $out = '';
        set_on($data['icon'], 'notset', 'zmdi zmdi-arrow-forward');
        set_on($data['label'], 'notset', 'Submit');
        set_on($data['input_class'], 'notset', 'btn', 'btn ' . $data['input_class']);
        set_on($data['button_type'], 'notset', 'button');
        set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
        set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
        exit_if_empty($data, ['id', 'name']);

        // Never trust user input.
        $data = _clean_array($data);

        // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
        $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
        $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

        // Build up the form element.
        $out .= '<button name="' . $data['name'] . '" id="' . $data['id'] . '"';
        $out .= add_tag_attribute('type', $data['button_type']);
        $out .= add_tag_attribute('class', $data['input_class']);
        if (!empty($data['data_target']) && !empty($data['data_toggle'])) {
            $out .= add_tag_attribute('data-toggle', $data['data_toggle']);
            $out .= add_tag_attribute('data-target', $data['data_target']);
        }
        $out .= '>' . $data['label'];
        $out .= _append_if(!empty($data['icon']), '&nbsp;<i class="' . $data['icon'] . '"></i>');
        $out .= '</button>';

        // Conclusion of the bootstrap wrapping, if enabled.
        $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
        $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

        // Return the element.
        unset($data);
        return $out;
    }
}

/**
 * function kcms_form_submit()
 *
 * Function to generate a submit button
 *
 * @access public
 *
 * @param array $data
 *  ['button_type'] - the type of the button - defaulted to submit, all others inherited from kcms_form_button function.
 *
 * @return string
 */
if (!function_exists('kcms_form_submit')) {
    function kcms_form_submit(&$data) {
        set_on($data['button_type'], 'notset', 'submit');
        $data = _clean_array($data);
        return kcms_form_button($data);
    }
}

/**
 * function kcms_form_hidden()
 *
 * Function to generate a hidden field.
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('kcms_form_hidden')) {
    function kcms_form_hidden(&$data)
    {
        $data = _clean_array($data);
        $element = form_hidden($data['id'], $data['value']);
        unset($data);
        return $element;
    }
}

/**
 * function kcms_form_input()
 *
 * Function to generate an input field.
 *
 * @access public
 *
 * @param array $data
 *  ['outer_class'] - the CSS class to apply on the outer div of the element.
 *  ['type'] - the type of the field - text/password
 *  ['label_class'] - the CSS class to apply to the element label.
 *  ['error_class'] - the CSS class to apply to errors.
 *  ['input_class'] - the CSS class to appply to the input element.
 *  ['value'] - the default value to set for the element.
 *  ['length'] - number of characters allowed in the input.
 *  ['disabled'] - whether the element is disabled or not.
 *  ['hint'] - text that is displayed just below the label to explain the field, if needed.
 *  ['hint_inline'] - The above hint is rather displayed next to the label to save vertical space.
 *  ['readonly'] - whether the element is readonly or not.
 *  ['name'] - the element's name for reading get or post values from.
 *  ['id'] - the unique identifier for the button.
 *  ['placeholder'] - placeholder text to put inside the element, if any.
 *  ['bootstrap_row'] - will the element be wrapped in a bootstrap row?
 *  ['bootstrap_col'] - will the element be wrapped in a bootstrap column?
 *  ['validation'] - should there be validation on the element?
 *
 * @return string
 */
if (!function_exists('kcms_form_input')) {
    function kcms_form_input(&$data, $type = 'text')
    {

        // Initialize with sensible defaults.
        $ci =& get_instance();
        set_on($data['outer_class'], 'notset', '');
        set_on($data['type'], 'notset', $type, 'text');
        set_on($data['label_class'], 'notset', 'control-label');
        set_on($data['error_class'], 'notset', 'form-narrow-error');
        set_on($data['input_class'], 'notset', '');
        set_on($data['input_style'], 'notset', '');
        set_on($data['individual_validation'], 'notset', true);
        set_on($data['length'], 'notset', '');
        set_on($data['disabled'], 'notset', '');
        set_on($data['hint'], 'notset', '');
        set_on($data['hint_inline'], 'notset', '');
        set_on($data['readonly'], 'notset', '');
        set_on($data['placeholder'], 'notset', '');
        set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
        set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
        set_on($data['validation'], 'notset', '');
        set_on($data['validation_indicator'], 'notset', '');
        set_on($data['name'], 'notset', '');
        set_on($data['datepicker'], 'notset', false);
        set_on($data['dateformat'], 'notset', 'YYYY-MM-DD');
        set_on($data['timepicker'], 'notset', false);
        set_on($data['datetimepicker'], 'notset', false);
        set_on($data['datepicker_now'], 'notset', true);
        exit_if_empty($data, ['id', 'name']);
        set_on($data['value'], 'notset', !empty($ci->input->post($data['name'])) ? $ci->input->post($data['name']) : '');
        $out = '';

        // Never trust user input.
        $data = _clean_array($data);

        // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
        $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
        $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

        // Wrap the element.
        $out .= _append_if(!empty($data['outer_class']), '<div class="' . $data['outer_class'] . '">');

        // Apply validation related rules markup.
        if (!empty($data['validation']['rules'])) {
            $rules = explode('|', $data['validation']['rules']);
            if (!empty($rules)) {
                if (in_array('required', $rules)) {
                    $data['validation_indicator'] = '<span class="form-validation-required"> * </span>';
                }
            }
        }

        // Shall we add a label? Note: without it, there will be no validation indicator for required fields.
        if (!empty($data['label'])) {
            $out .= '
                    <label class="' . $data['label_class'] . '" for="' . $data['id'] . '">' . $data['label'] . $data['validation_indicator'] . '</label>
            ';

            // Do we have an inline hint?
            $out .= _append_if(!empty($data['hint']) && !empty($data['hint_inline']), '<span class="hint-text">' . $data['hint'] . '</span>');
        }

        // Do we have a hint that is not inline?
        $out .= _append_if(!empty($data['hint']) && empty($data['hint_inline']), '<div class="hint-text">' . $data['hint'] . '</div>');

        // See if we must add a picker class.
        $now = '';
        if ($data['datepicker_now']) {
            $now = ' dp-now';
        }
        if ($data['datepicker']) {
            $data['input_class'] .= ' date-picker' . $now;
        }
        if ($data['timepicker']) {
            if (!empty($data['seconds'])) {
                $data['input_class'] .= ' time-ss-picker' . $now;
            } else {
                $data['input_class'] .= ' time-picker' . $now;
            }
        }
        if ($data['datetimepicker']) {
            if (!empty($data['seconds'])) {
                $data['input_class'] .= ' date-time-ss-picker' . $now;
            } else {
                $data['input_class'] .= ' date-time-picker' . $now;
            }
        }

        // Build up the form element.
        $out .= '<input id="' . $data['id'] . '" name="' . $data['name'] . '"';
        $out .= add_tag_attribute('placeholder', $data['placeholder']);
        $out .= add_tag_attribute('class', $data['input_class']);
        $out .= add_tag_attribute('style', $data['input_style']);
        $out .= add_tag_attribute('type', $data['type']);
        $out .= add_tag_attribute('value', $data['value']);
        $out .= add_tag_attribute('length', $data['length']);
        $out .= add_tag_attribute('readonly', $data['readonly']);
        $out .= add_tag_attribute('data-date-format', $data['dateformat']);
        $out .= add_tag_attribute('disabled', $data['disabled']);
        if (!empty($data['validation']['rules'])) {
            $out .= add_tag_attribute('data-has-validation', true);
        }
        $out .= '>';

        // Close the element wrap.
        $out .= _append_if(!empty($data['outer_class']), '</div>');

        // Add validation errors row.
        if (!empty(form_error($data['name'])) && !empty($data['individual_validation'])) {
            $out .= '<div class="row">';
            $out .= '<div class="col-sm-12">';
            $out .= _append_if(!empty($data['error_class']), '<div class="' . $data['error_class'] . '">');
            $out .= form_error($data['name']);
            $out .= _append_if(!empty($data['error_class']), '</div>');
            $out .= '</div>';
            $out .= '</div>';
        }

        // Conclusion of the bootstrap wrapping, if enabled.
        $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
        $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

        // Return the element.
        unset($data);
        return $out;
    }
}

/**
 * function kcms_form_password()
 *
 * Function to generate a password field.
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('kcms_form_password')) {
    function kcms_form_password(&$data) {
        return kcms_form_input($data, 'password');
    }
}

/**
 * function kcms_form_textarea()
 *
 * Function to generate a textarea field.
 *
 * @access public
 *
 * @param array $data
 *  ['outer_class'] - the CSS class to apply on the outer div of the element.
 *  ['label_class'] - the CSS class to apply to the element label.
 *  ['error_class'] - the CSS class to apply to errors.
 *  ['input_class'] - the CSS class to appply to the input element.
 *  ['hint'] - text that is displayed just below the label to explain the field, if needed.
 *  ['hint_inline'] - The above hint is rather displayed next to the label to save vertical space.
 *  ['value'] - the default value to set for the element.
 *  ['length'] - number of characters allowed in the input.
 *  ['disabled'] - whether the element is disabled or not.
 *  ['readonly'] - whether the element is readonly or not.
 *  ['name'] - the element's name for reading get or post values from.
 *  ['id'] - the unique identifier for the textarea.
 *  ['placeholder'] - placeholder text to put inside the element, if any.
 *  ['bootstrap_row'] - will the element be wrapped in a bootstrap row?
 *  ['bootstrap_col'] - will the element be wrapped in a bootstrap column?
 *  ['validation'] - should there be validation on the element?
 *  ['rows'] - the number of rows to use for the textarea. Only effective in raw HTML.
 *  ['cols'] - the number of columns to use for the textarea. Only effective in raw HTML.
 *
 * @return string
 */
if (!function_exists('kcms_form_textarea')) {
    function kcms_form_textarea(&$data)
    {

        // Initialize with sensible defaults.
        $ci =& get_instance();
        set_on($data['outer_class'], 'notset', '');
        set_on($data['label_class'], 'notset', 'control-label');
        set_on($data['error_class'], 'notset', 'form-narrow-error');
        set_on($data['individual_validation'], 'notset', true);
        set_on($data['input_class'], 'notset', '');
        set_on($data['hint'], 'notset', '');
        set_on($data['hint_inline'], 'notset', '');
        set_on($data['length'], 'notset', '');
        set_on($data['disabled'], 'notset', '');
        set_on($data['readonly'], 'notset', '');
        set_on($data['rows'], 'notset', 5);
        set_on($data['cols'], 'notset', 80);
        set_on($data['placeholder'], 'notset', '');
        set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
        set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
        set_on($data['validation'], 'notset', '');
        set_on($data['validation_indicator'], 'notset', '');
        exit_if_empty($data, ['id', 'name']);
        set_on($data['value'], 'notset', !empty($ci->input->post($data['name'])) ? $ci->input->post($data['name']) : '');
        $out = '';

        // Never trust user input.
        $data = _clean_array($data);

        // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
        $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
        $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

        // Wrap the element.
        $out .= _append_if(!empty($data['outer_class']), '<div class="' . $data['outer_class'] . '">');

        // Apply validation related rules markup.
        if (!empty($data['validation']['rules'])) {
            $rules = explode('|', $data['validation']['rules']);
            if (!empty($rules)) {
                if (in_array('required', $rules)) {
                    $data['validation_indicator'] = '<span class="form-validation-required"> * </span>';
                }
            }
        }

        // Shall we add a label? Note: without it, there will be no validation indicator for required fields.
        if (!empty($data['label'])) {
            $out .= '
                <div class="' . $data['label_class'] . '">
                    <label for="' . $data['id'] . '">' . $data['label'] . $data['validation_indicator'] . '</label>
            ';

            // Do we have an inline hint?
            $out .= _append_if(!empty($data['hint']) && !empty($data['hint_inline']), '<span class="hint-text">' . $data['hint'] . '</span>');
            $out .= '
                </div>
            ';
        }

        // Do we have a hint that is not inline?
        $out .= _append_if(!empty($data['hint']) && empty($data['hint_inline']), '<div class="hint-text">' . $data['hint'] . '</div>');

        // Add the form element.
        $out .= '<textarea';
        $out .= add_tag_attribute('id', $data['id']);
        $out .= add_tag_attribute('name', $data['name']);
        $out .= add_tag_attribute('placeholder', $data['placeholder']);
        $out .= add_tag_attribute('class', $data['input_class']);
        $out .= add_tag_attribute('readonly', $data['readonly']);
        $out .= add_tag_attribute('disabled', $data['disabled']);
        $out .= add_tag_attribute('rows', $data['rows']);
        $out .= add_tag_attribute('cols', $data['cols']);
        if (!empty($data['validation']['rules'])) {
            $out .= add_tag_attribute('data-has-validation', true);
        }
        $out .= '>';
        $out .= _append_if(!empty($data['value']), $data['value']);
        $out .= '</textarea>';

        // Close the element wrap.
        $out .= _append_if(!empty($data['outer_class']), '</div>');

        // Add validation errors.
        if (!empty(form_error($data['name'])) && !empty($data['individual_validation'])) {
            $out .= '<div class="row">';
            $out .= '<div class="col-sm-12">';
            $out .= _append_if(!empty($data['error_class']), '<div class="' . $data['error_class'] . '">');
            $out .= form_error($data['name']);
            $out .= _append_if(!empty($data['error_class']), '</div>');
            $out .= '</div>';
            $out .= '</div>';
        }

        // Conclusion of the bootstrap wrapping, if enabled.
        $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
        $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

        // Return the element.
        unset($data);
        return $out;
    }
}

/**
 * function kcms_form_summernote()
 *
 * Function to create a summernote edit field from a textarea
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('kcms_form_summernote')) {
    function kcms_form_summernote(&$data)
    {

        // Initialize with sensible data
        $ci =& get_instance();
        set_on($data['outer_class'], 'notset', '');
        set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
        set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
        set_on($data['individual_validation'], 'notset', true);
        set_on($data['placeholder'], 'notset', '');
        set_on($data['validation'], 'notset', '');
        set_on($data['validation_indicator'], 'notset', '');
        set_on($data['hint'], 'notset', '');
        set_on($data['hint_inline'], 'notset', '');
        set_on($data['label_class'], 'notset', 'control-label');
        set_on($data['error_class'], 'notset', 'form-narrow-error');
        set_on($data['nuggets']['heads'], 'notset', '');
        set_on($data['nuggets']['content'], 'notset', '');
        exit_if_empty($data, ['id', 'name']);
        set_on($data['value'], 'notset', !empty($ci->input->post($data['name'])) ? $ci->input->post($data['name']) : '');
        $out = '';

        // Never trust user input.
        $data = _clean_array($data);

        // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
        $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
        $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

        // Wrap the element.
        $out .= _append_if(!empty($data['outer_class']), '<div class="' . $data['outer_class'] . '">');

        // Apply validation related rules markup.
        if (!empty($data['validation']['rules'])) {
            $rules = explode('|', $data['validation']['rules']);
            if (!empty($rules)) {
                if (in_array('required', $rules)) {
                    $data['validation_indicator'] = '<span class="form-validation-required"> * </span>';
                }
            }
        }

        // Shall we add a label? Note: without it, there will be no validation indicator for required fields.
        if (!empty($data['label'])) {
            $out .= '
                <div class="' . $data['label_class'] . '">
                    <label for="' . $data['id'] . '">' . $data['label'] . $data['validation_indicator'] . '</label>
            ';

            // Do we have an inline hint?
            $out .= _append_if(!empty($data['hint']) && !empty($data['hint_inline']), '<span class="hint-text">' . $data['hint'] . '</span>');
            $out .= '
                </div>
            ';
        }

        // Do we have a hint that is not inline?
        $out .= _append_if(!empty($data['hint']) && empty($data['hint_inline']), '<div class="hint-text">' . $data['hint'] . '</div>');

        // Add the form element.
        $out .= '<textarea';
        $out .= add_tag_attribute('id', $data['id']);
        $out .= add_tag_attribute('name', $data['name']);
        $out .= add_tag_attribute('class', 'wysiwyg-editor');
        $out .= add_tag_attribute('placeholder', $data['placeholder']);
        if (!empty($data['validation']['rules'])) {
            $out .= add_tag_attribute('data-has-validation', true);
        }
        $out .= '>';
        $out .= _append_if(!empty($data['value']), $data['value']);
        $out .= '</textarea>';

        // Close the element wrap.
        $out .= _append_if(!empty($data['outer_class']), '</div>');

        // Add validation errors.
        if (!empty(form_error($data['name'])) && !empty($data['individual_validation'])) {
            $out .= '<div class="row">';
            $out .= '<div class="col-sm-12">';
            $out .= _append_if(!empty($data['error_class']), '<div class="' . $data['error_class'] . '">');
            $out .= form_error($data['name']);
            $out .= _append_if(!empty($data['error_class']), '</div>');
            $out .= '</div>';
            $out .= '</div>';
        }

        // Conclusion of the bootstrap wrapping, if enabled.
        $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
        $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

        // Custom JS
        $out .= '
            <script type="text/javascript">
                $(function() {
                    "use strict";
                    $("#' . $data['id'] . '").summernote({
                        height: 350,
                        fontSizes: ["8", "9", "10", "11", "12", "13", "14", "16", "18", "24", "36", "48"],
                        toolbar: [
                            ["style", ["style", "bold", "italic", "underline", "clear"]],
                            ["font", ["strikethrough", "superscript", "subscript"]],
                            ["fontsize", ["fontsize"]],
                            ["fontname", ["fontname"]],
                            ["para", ["ul", "ol", "paragraph"]],
                            ["misc", ["codeview", "undo", "redo"]],
                            ["insert", ["table"' . $data['nuggets']['heads'] . ']],
                        ],
                        ' . $data['nuggets']['content'] . '
                    });
                    $(".note-codable").on("blur", function() {
                        if ($("#' . $data['id'] . '").summernote("codeview.isActivated")) {
                            var content = $(".wysiwyg-editor").summernote("code");
                            content = content.trim();
                            content = content.replace("/></gi", ">\r\n<");
                            $(".note-codable").val(content);
                        }
                    });
                });
            </script>
        ';

        // Cleanup and return the element.
        unset($nuggets);
        unset($data);
        return $out;
    }
}

/**
 * function kcms_form_fieldset_open()
 *
 * Function to open a form fieldset
 *
 * @access public
 *
 * @param array $data
 *  ['id'] - the unique identifier for the fieldset.
 *  ['legend'] - the text to display in the fieldset legend.
 *
 * @return  string
 */
if (!function_exists('kcms_form_fieldset_open')) {
    function kcms_form_fieldset_open(&$data)
    {

        // Initialize with sensible values.
        set_on($data['id'], 'notset', 'fieldset-' . rand(0, 9999));
        set_on($data['legend'], 'notset', '');
        set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
        set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
        $out = '';

        // Never trust user input.
        $data = _clean_array($data);

        // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
        // Please note that if you set it here, you must also set it in the fieldset close.
        $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
        $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

        // Build up the element.
        $out .= '<fieldset';
        $out .= add_tag_attribute('id', $data['id']);
        $out .= '>';
        $out .= '<legend>' . $data['legend'] . '</legend>';

        // Return the element.
        unset($data);
        return $out;
    }
}

/**
 * function kcms_form_fieldset_close()
 *
 * Function to close a previously opened form fieldset
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('kcms_form_fieldset_close')) {
    function kcms_form_fieldset_close(&$data)
    {

        // Initialize with sensible data
        set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
        set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
        $out = '';

        // Build up the element.
        $out .= '</fieldset>';

        // Conclusion of the bootstrap wrapping, if enabled. Please note, this will break your form if the fieldset open is not wrapped.
        $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
        $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

        // Return the element.
        unset($data);
        return $out;
    }
}

function kcms_form_select(&$data)
{

    // Initialize with sensible data
    set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
    set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
    set_on($data['multiple'], 'notset', false);
    set_on($data['disabled'], 'notset', '');
    set_on($data['outer_class'], 'notset', '');
    set_on($data['input_class'], 'notset', '');
    set_on($data['input_style'], 'notset', '');
    set_on($data['readonly'], 'notset', '');
    set_on($data['placeholder'], 'notset', 'Select an option');
    set_on($data['individual_validation'], 'notset', true);
    set_on($data['options'], 'notset', []);
    set_on($data['validation_indicator'], 'notset', '');
    set_on($data['validation'], 'notset', '');
    set_on($data['hint'], 'notset', '');
    set_on($data['hint_inline'], 'notset', '');
    set_on($data['label_class'], 'notset', 'control-label');
    set_on($data['error_class'], 'notset', 'form-narrow-error');
    set_on($data['id'], 'notset', 'select-' . rand(0, 9999));
    set_on($data['name'], 'notset', 'select-' . rand(0, 9999));
    set_on($data['value'], 'notset', '');
    exit_if_empty($data, ['id', 'name']);
    $out = '';

    // Never trust user input.
    $data = _clean_array($data);

    // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
    $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
    $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

    // Wrap the element.
    $out .= _append_if(!empty($data['outer_class']), '<div class="' . $data['outer_class'] . '">');

    // Apply validation related rules markup.
    if (!empty($data['validation']['rules'])) {
        $rules = explode('|', $data['validation']['rules']);
        if (!empty($rules)) {
            if (in_array('required', $rules)) {
                $data['validation_indicator'] = '<span class="form-validation-required"> * </span>';
            }
        }
    }

    // Shall we add a label? Note: without it, there will be no validation indicator for required fields.
    if (!empty($data['label'])) {
        $out .= '
            <div class="' . $data['label_class'] . '">
                <label for="' . $data['id'] . '">' . $data['label'] . $data['validation_indicator'] . '</label>
        ';

        // Do we have an inline hint?
        $out .= _append_if(!empty($data['hint']) && !empty($data['hint_inline']), '<span class="hint-text">' . $data['hint'] . '</span>');
        $out .= '
            </div>
        ';
    }

    // Do we have a hint that is not inline?
    $out .= _append_if(!empty($data['hint']) && empty($data['hint_inline']), '<div class="hint-text">' . $data['hint'] . '</div>');

    // Add the form element.
    $out_attr = add_tag_attribute('multiple', $data['multiple']);
    $out_attr .= add_tag_attribute('class', $data['input_class']);
    $out_attr .= add_tag_attribute('style', $data['input_style']);
    $out_attr .= add_tag_attribute('id', $data['id']);
    if (!empty($data['validation']['rules'])) {
        $out_attr .= add_tag_attribute('data-has-validation', true);
    }
    $out .= form_dropdown($data['name'], $data['options'], $data['value'], $out_attr);

    // Close the element wrap.
    $out .= _append_if(!empty($data['outer_class']), '</div>');

    // Add validation errors.
    if (!empty(form_error($data['name'])) && !empty($data['individual_validation'])) {
        $out .= '<div class="row">';
        $out .= '<div class="col-sm-12">';
        $out .= _append_if(!empty($data['error_class']), '<div class="' . $data['error_class'] . '">');
        $out .= form_error($data['name']);
        $out .= _append_if(!empty($data['error_class']), '</div>');
        $out .= '</div>';
        $out .= '</div>';
    }

    // Conclusion of the bootstrap wrapping, if enabled.
    $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
    $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

    // Initialize the select2 feature.
    $out .= '
        <script type="text/javascript">
            $(function() {
                $("#' . $data['id'] . '").select2({
                    allowClear: true,
    ';
    if (!empty($data['placeholder'])) {
        $out .= '
            placeholder: "' . $data['placeholder'] . '",
            allowClear: true,
        ';
    }
    if (!empty($data['input_class'])) {
        $out .= '
            containerCssClass: "' . $data['input_class'] . '",
        ';
    }
    if (!empty($data['disabled'])) {
        $out .= '
            disabled: "' . $data['disabled'] . '",
        ';
    }
    $out .=  '
                });
            });
        </script>
    ';

    // Return the element.
    unset($data);
    return $out;
}

/**
 * function kcms_form_checkbox()
 *
 * Function to generate a styled checkbox
 *
 * @access public
 *
 * @param array $data
 *  ['label'] - what text is displayed on the button?
 *  ['disabled'] - is it disabled?
 *  ['checked'] - is it checked?
 *  ['color'] - what color is it?
 *  ['value'] - what value is it set to?
 *  ['outer_class'] - the outer class for the element.
 *  ['inner_class'] - the inner class for the element, used for the label.
 *  ['label_class'] - the label class is used for the checkbox tick.
 *  ['id'] - how will the button be uniquely identified?
 *  ['name'] - the name of the button for reading post or get values from it.
 *  ['button_type'] - the type of the button - button or submit.
 *  ['bootstrap_row'] - will the element be wrapped in a bootstrap row?
 *  ['bootstrap_col'] - will the element be wrapped in a bootstrap column?
 *
 * @return  string
 */
if (!function_exists('kcms_form_checkbox')) {
    function kcms_form_checkbox(&$data)
    {

        // Initialize with sensible defaults.
        $out = '';
        set_on($data['label'], 'notset', 'Checkbox');
        set_on($data['size'], 'notset', 'el-radio-md');
        set_on($data['individual_validation'], 'notset', true);
        set_on($data['disabled'], 'notset', false);
        set_on($data['checked'], 'notset', false);
        set_on($data['color'], 'notset', 'blue');
        set_on($data['value'], 'notset', '');
        set_on($data['id'], 'notset', 'checkbox-' . rand(0, 9999));
        set_on($data['name'], 'notset', 'checkbox-' . rand(0, 9999));
        set_on($data['outer_class'], 'notset', 'margin-top-10 el-checkbox el-checkbox-' . $data['color']);
        set_on($data['inner_class'], 'notset', 'margin-r');
        set_on($data['label_class'], 'notset', 'el-checkbox-style');
        set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
        set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
        set_on($data['readonly'], 'notset', false);
        exit_if_empty($data, ['id', 'name']);

        // Never trust user input.
        $data = _clean_array($data);

        // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
        $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
        $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

        // Build up attributes
        $disabled = '';
        $checked = '';
        if ($data['disabled']) {
            $disabled = ' disabled';
        }
        if ($data['checked']) {
            $checked = ' checked';
        }

        // Build up the form element.
        $out .= '<div';
        $out .= add_tag_attribute('class', $data['outer_class'] . ' ' . $data['size']);
        $out .= '>';
        $out .= '<span';
        $out .= add_tag_attribute('class', $data['inner_class']);
        $out .= '>';
        $out .= $data['label'];
        $out .= '</span>';
        $out .= '<input' . $checked . $disabled;
        $out .= add_tag_attribute('type', 'checkbox');
        $out .= add_tag_attribute('name', $data['name']);
        $out .= add_tag_attribute('readonly', $data['readonly']);
        $out .= add_tag_attribute('disabled', $data['disabled']);
        $out .= add_tag_attribute('id', $data['id']);
        $out .= add_tag_attribute('value', $data['value']);
        if (!empty($data['validation']['rules'])) {
            $out .= add_tag_attribute('data-has-validation', true);
        }
        $out .= '>';
        $out .= '<label';
        $out .= add_tag_attribute('class', 'nopad ' . $data['label_class']);
        $out .= add_tag_attribute('for', $data['id']);
        $out .= '>';
        $out .= '</label>';
        $out .= '</div>';

        // Add validation errors.
        if (!empty(form_error($data['name'])) && !empty($data['individual_validation'])) {
            $out .= '<div class="row">';
            $out .= '<div class="col-sm-12">';
            $out .= _append_if(!empty($data['error_class']), '<div class="' . $data['error_class'] . '">');
            $out .= form_error($data['name']);
            $out .= _append_if(!empty($data['error_class']), '</div>');
            $out .= '</div>';
            $out .= '</div>';
        }

        // Conclusion of the bootstrap wrapping, if enabled.
        $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
        $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

        // Return the element.
        unset($data);
        return $out;
    }
}

if (!function_exists('kcms_form_label')) {
    function kcms_form_label(&$data)
    {

        // Initialize with sensible defaults.
        $ci =& get_instance();
        set_on($data['outer_class'], 'notset', '');
        set_on($data['label_class'], 'notset', 'control-label');
        set_on($data['hint'], 'notset', '');
        set_on($data['hint_inline'], 'notset', '');
        set_on($data['readonly'], 'notset', '');
        set_on($data['placeholder'], 'notset', '');
        set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
        set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
        set_on($data['validation'], 'notset', '');
        set_on($data['validation_indicator'], 'notset', '');
        set_on($data['name'], 'notset', '');
        exit_if_empty($data, ['id', 'name']);
        $out = '';

        // Never trust user input.
        $data = _clean_array($data);

        // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
        $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
        $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

        // Wrap the element.
        $out .= _append_if(!empty($data['outer_class']), '<div class="' . $data['outer_class'] . '">');

        // Apply validation related rules markup.
        if (!empty($data['validation']['rules'])) {
            $rules = explode('|', $data['validation']['rules']);
            if (!empty($rules)) {
                if (in_array('required', $rules)) {
                    $data['validation_indicator'] = '<span class="form-validation-required"> * </span>';
                }
            }
        }

        // Shall we add a label? Note: without it, there will be no validation indicator for required fields.
        if (!empty($data['label'])) {
            $out .= '
                    <label class="' . $data['label_class'] . '" for="' . $data['id'] . '">' . $data['label'] . $data['validation_indicator'] . '</label>
            ';

            // Do we have an inline hint?
            $out .= _append_if(!empty($data['hint']) && !empty($data['hint_inline']), '<span class="hint-text">' . $data['hint'] . '</span>');
        }

        // Do we have a hint that is not inline?
        $out .= _append_if(!empty($data['hint']) && empty($data['hint_inline']), '<div class="hint-text">' . $data['hint'] . '</div>');

        // Close the element wrap.
        $out .= _append_if(!empty($data['outer_class']), '</div>');

        // Conclusion of the bootstrap wrapping, if enabled.
        $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
        $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

        // Return the element.
        unset($data);
        return $out;
    }
}

/**
 * function kcms_form_radio()
 *
 * Function to generate a styled radio button
 *
 * @access public
 *
 * @param array $data
 *  ['label'] - what text is displayed on the button?
 *  ['disabled'] - is it disabled?
 *  ['checked'] - is it checked?
 *  ['color'] - what color is it?
 *  ['value'] - what value is it set to?
 *  ['outer_class'] - the outer class for the element.
 *  ['inner_class'] - the inner class for the element, used for the label.
 *  ['label_class'] - the label class is used for the checkbox tick.
 *  ['id'] - how will the button be uniquely identified?
 *  ['name'] - the name of the button for reading post or get values from it.
 *  ['button_type'] - the type of the button - button or submit.
 *  ['bootstrap_row'] - will the element be wrapped in a bootstrap row?
 *  ['bootstrap_col'] - will the element be wrapped in a bootstrap column?
 *
 * @return  string
 */
if (!function_exists('kcms_form_radio')) {
    function kcms_form_radio(&$data)
    {

        // Initialize with sensible defaults.
        $out = '';
        set_on($data['label'], 'notset', 'Radio');
        set_on($data['size'], 'notset', 'el-radio-md');
        set_on($data['disabled'], 'notset', false);
        set_on($data['checked'], 'notset', false);
        set_on($data['color'], 'notset', 'yellow');
        set_on($data['individual_validation'], 'notset', true);
        set_on($data['value'], 'notset', '');
        set_on($data['id'], 'notset', 'radio-' . rand(0, 9999));
        set_on($data['name'], 'notset', 'radio-' . rand(0, 9999));
        set_on($data['outer_class'], 'notset', 'margin-right-20 line-height-1-6 margin-top-10 el-radio el-radio-' . $data['color']);
        set_on($data['inner_class'], 'notset', 'margin-r');
        set_on($data['label_class'], 'notset', 'el-radio-style');
        set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
        set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
        set_on($data['readonly'], 'notset', false);
        exit_if_empty($data, ['id', 'name']);

        // Never trust user input.
        $data = _clean_array($data);

        //return form_radio(['name' => $data['name']], $data['value'], $data['checked']);

        // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
        $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
        $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

        // Build up attributes
        $disabled = '';
        $checked = '';
        if ($data['disabled']) {
            $disabled = ' disabled';
        }
        if ($data['checked']) {
            $checked = ' checked';
        }

        // Build up the form element.
        $out .= '<span';
        $out .= add_tag_attribute('class', $data['outer_class'] . ' ' . $data['size']);
        $out .= '>';
        $out .= '<span';
        $out .= add_tag_attribute('class', $data['inner_class']);
        $out .= '>';
        $out .= $data['label'];
        $out .= '</span>';
        $out .= '<input' . $checked . $disabled;
        $out .= add_tag_attribute('type', 'radio');
        $out .= add_tag_attribute('name', $data['name']);
        $out .= add_tag_attribute('readonly', $data['readonly']);
        $out .= add_tag_attribute('disabled', $data['disabled']);
        $out .= add_tag_attribute('id', $data['id']);
        $out .= add_tag_attribute('value', $data['value']);
        if (!empty($data['validation']['rules'])) {
            $out .= add_tag_attribute('data-has-validation', true);
        }
        $out .= '>';
        $out .= '<label';
        $out .= add_tag_attribute('class', 'nopad ' . $data['label_class']);
        $out .= add_tag_attribute('for', $data['id']);
        $out .= '>';
        $out .= '</label>';
        $out .= '</span>';

        // Add validation errors.
        if (!empty(form_error($data['name'])) && !empty($data['individual_validation'])) {
            $out .= '<div class="row">';
            $out .= '<div class="col-sm-12">';
            $out .= _append_if(!empty($data['error_class']), '<div class="' . $data['error_class'] . '">');
            $out .= form_error($data['name']);
            $out .= _append_if(!empty($data['error_class']), '</div>');
            $out .= '</div>';
            $out .= '</div>';
        }

        // Conclusion of the bootstrap wrapping, if enabled.
        $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
        $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

        // Return the element.
        unset($data);
        return $out;
    }
}

/**
 * function kcms_form_switch()
 *
 * Function to generate a styled switch
 * Required: id, name
 *
 * @access public
 *
 * @param array $data
 *  ['label'] - what text is displayed on the button?
 *  ['disabled'] - is it disabled?
 *  ['checked'] - is it checked?
 *  ['color'] - what color is it?
 *  ['value'] - what value is it set to?
 *  ['outer_class'] - the outer class for the element.
 *  ['inner_class'] - the inner class for the element, used for the label.
 *  ['hint'] - additional hint text to be displayed, if specified.
 *  ['label_class'] - the label class is used for the checkbox tick.
 *  ['id'] - how will the button be uniquely identified?
 *  ['name'] - the name of the button for reading post or get values from it.
 *  ['button_type'] - the type of the button - button or submit.
 *  ['bootstrap_row'] - will the element be wrapped in a bootstrap row?
 *  ['bootstrap_col'] - will the element be wrapped in a bootstrap column?
 *  ['error_class'] - the CSS class that is used for individual errors.
 *
 * @return  string
 */
if (!function_exists('kcms_form_switch')) {
    function kcms_form_switch(&$data)
    {

        // Initialize with sensible defaults.
        $out = '';
        set_on($data['label'], 'notset', 'Switch');
        set_on($data['size'], 'notset', 'el-switch-md');
        set_on($data['disabled'], 'notset', false);
        set_on($data['checked'], 'notset', false);
        set_on($data['color'], 'notset', 'green');
        set_on($data['individual_validation'], 'notset', true);
        set_on($data['value'], 'notset', '');
        set_on($data['hint'], 'notset', '');
        set_on($data['id'], 'notset', 'switch-' . rand(0, 9999));
        set_on($data['name'], 'notset', 'switch-' . rand(0, 9999));
        set_on($data['outer_class'], 'notset', 'el-switch el-switch-' . $data['color']);
        set_on($data['inner_class'], 'notset', 'margin-r');
        set_on($data['div_class'], 'notset', 'margin-top-10');
        set_on($data['label_class'], 'notset', 'el-switch-style');
        set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
        set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
        set_on($data['error_class'], 'notset', 'form-narrow-error');
        set_on($data['readonly'], 'notset', false);
        exit_if_empty($data, ['id', 'name']);

        // Never trust user input.
        $data = _clean_array($data);

        // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
        $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
        $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

        // Build up attributes
        $disabled = '';
        $checked = '';
        if ($data['disabled']) {
            $disabled = ' disabled';
        }
        if ($data['checked']) {
            $checked = ' checked';
        }

        // Build up the form element.
        $out .= '<div';
        $out .= add_tag_attribute('class', $data['div_class']);
        $out .= '>';
        $out .= '<span';
        $out .= add_tag_attribute('class', $data['inner_class']);
        $out .= '>';
        $out .= $data['label'];
        $out .= '</span>';
        $out .= '<label';
        $out .= add_tag_attribute('class', 'nopad ' . $data['outer_class'] . ' ' . $data['size']);
        $out .= '>';
        $out .= '<input' . $checked . $disabled;
        $out .= add_tag_attribute('type', 'checkbox');
        $out .= add_tag_attribute('name', $data['name']);
        $out .= add_tag_attribute('id', $data['id']);
        $out .= add_tag_attribute('readonly', $data['readonly']);
        $out .= add_tag_attribute('disabled', $data['disabled']);
        $out .= add_tag_attribute('value', $data['value']);
        if (!empty($data['validation']['rules'])) {
            $out .= add_tag_attribute('data-has-validation', true);
        }
        $out .= '>';
        $out .= '<span';
        $out .= add_tag_attribute('class', $data['label_class']);
        $out .= '>';
        $out .= '</span>';
        $out .= '</label>';
        $out .= _append_if(!empty($data['hint']) && empty($data['hint_inline']), '<div class="hint-text">' . $data['hint'] . '</div>');
        $out .= '</div>';

        // Add validation errors.
        if (!empty(form_error($data['name'])) && !empty($data['individual_validation'])) {
            $out .= '<div class="row">';
            $out .= '<div class="col-sm-12">';
            $out .= _append_if(!empty($data['error_class']), '<div class="' . $data['error_class'] . '">');
            $out .= form_error($data['name']);
            $out .= _append_if(!empty($data['error_class']), '</div>');
            $out .= '</div>';
            $out .= '</div>';
        }

        // Conclusion of the bootstrap wrapping, if enabled.
        $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
        $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

        // Return the element.
        unset($data);
        return $out;
    }
}

/**
 * kcms_form_datatable
 *
 * Generates a datatable form
 * Required: NONE  -- EB: TODO??
 *
 * @param array $data
 *  ['hint']
 *  ['hint_inline']
 *  ['bootstrap_row']
 *  ['bootstrap_col']
 *  ['table_class']
 *  ['footer_class']
 *  ['head_cell_class']
 *  ['content_cell_class']
 *  ['table_footer']
 *  ['selection']
 *  ['actions_position']
 *  ['multiselect']
 *  ['rowselect']
 *  ['keepselection']
 *  ['searchdelay']
 *  ['searchchars']
 *  ['sorting']
 *  ['outer_class']
 *  ['method']
 *  ['cache']
 *  ['casesensitive']
 *  ['columnselection']
 *  ['id']
 *  ['table_id']
 *  ['name']
 *  ['export_pdf'] - Enable the export button on the table
 *          ['model'] - model name that can fetch the data for the pdf
 *          ['function'] - function in model to fetch the data
 *          ['parameters'] - any variables to be passed to the model function
 *
 * @access public
 *
 * @return string
 */
function kcms_form_datatable(&$data)
{
    $ci =& get_instance();

    // Initialize with sensible data
    $out = '';
    $btns = '';
    if (empty($data['rowcount'])) {
        $temp = array(5 => 5, 10 => 10, 25 => 25, 50 => 50, 100 => 100, 250 => 250);
        unset($temp[$data['page_limit']]);
        $data['rowcount'] = '[' . $data['page_limit'] . ', ';
        foreach ($temp as $v) {
            $data['rowcount'] .= $v . ', ';
        }
        $data['rowcount'] = rtrim($data['rowcount'], ', ') . ']';
        unset($temp);
    }
    set_on($data['hint'], 'notset', '');
    set_on($data['hint_inline'], 'notset', '');
    set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
    set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
    set_on($data['table_class'], 'notset', 'table table-striped bootgrid-table');
    set_on($data['footer_class'], 'notset', '');
    set_on($data['head_cell_class'], 'notset', '');
    set_on($data['content_cell_class'], 'notset', '');
    set_on($data['table_footer'], 'notset', '');
    set_on($data['selection'], 'notset', 'true');
    set_on($data['actions_position'], 'notset', 'right');
    set_on($data['multiselect'], 'notset', 'true');
    set_on($data['rowselect'], 'notset', 'true');
    set_on($data['keepselection'], 'notset', 'true');
    set_on($data['searchdelay'], 'notset', 100);
    set_on($data['searchchars'], 'notset', 2);
    set_on($data['sorting'], 'notset', 'true');
    set_on($data['outer_class'], 'notset', '');
    set_on($data['method'], 'notset', 'POST');
    set_on($data['cache'], 'notset', 'false');
    set_on($data['casesensitive'], 'notset', 'false');
    set_on($data['columnselection'], 'notset', 'true');
    set_on($data['id'], 'notset', 'bootgrid-' . rand(0, 9999));
    set_on($data['table_id'], 'notset', 'bootgrid-table-' . rand(0, 9999));
    set_on($data['name'], 'notset', 'bootgrid-' . rand(0, 9999));
    set_on($data['export_pdf'], 'notset', false);

    $out = '';

    // Never trust user input.
    $data = _clean_array($data);

    // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
    $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
    $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

    // Wrap the element.
    $out .= _append_if(!empty($data['outer_class']), '<div class="' . $data['outer_class'] . '">');

    // Do we have hints?
    $out .= _append_if(!empty($data['hint']) && !empty($data['hint_inline']), '<span class="hint-text">' . $data['hint'] . '</span>');
    $out .= _append_if(!empty($data['hint']) && empty($data['hint_inline']), '<div class="hint-text">' . $data['hint'] . '</div>');

    // Build up the table.
    if (!empty($data['page_data'])) {
        $out .= '<div class="table-responsive">';
        $has_generic_buttons = false;

        // We have up to 5 generic action buttons. It might be overkill, but possible.
        for ($ii = 1; $ii <= 5; $ii++) {
            if (!empty($data['actions']['generic_' . $ii]['link'])) {
                $has_generic_buttons = true;
            }
        }

        // Process generic action links, if any.
        if (!empty($data['actions']['add']['link']) || $has_generic_buttons) {
            $btns .= '<div id="add-' . $data['table_id'] . '" style="float: right">';

            // Generic buttons
            for ($ii = 1; $ii <= 5; $ii++) {
                if (
                    !empty($data['actions']['generic_' . $ii]['link']) &&
                    !empty($data['actions']['generic_' . $ii]) &&
                    (
                        (isset($data['actions']['generic_' . $ii]['access']) && $data['actions']['generic_' . $ii]['access']) ||
                        (isset($data['actions']['generic_' . $ii]['perm']) && $data['actions']['generic_' . $ii]['perm']) ||
                        (isset($data['actions']['generic_' . $ii]['role']) && $data['actions']['generic_' . $ii]['role'])
                    )
                ) {
                    if (empty($data['actions']['generic_' . $ii]['class'])) {
                        $data['actions']['generic_' . $ii]['class'] = 'info';
                    }
                    $btns .= '<a style="margin-left: 10px" id="generic-' . $ii . '-' . $data['table_id'] . '" class="btn ' . $data['actions']['generic_' . $ii]['class'] . '" href="' . base_url() . $data['actions']['generic_' . $ii]['link'] . '">';
                    if (!empty($data['actions']['generic_' . $ii]['icon'])) {
                        $btns .= '<i style="margin-right: 8px;" title=\"' . $data['actions']['generic_' . $ii]['title'] . '\" class=\"zmdi zmdi-hc-lg zmdi-' . $data['actions']['generic_' . $ii]['icon'] . '\"><\/i>';
                    }
                    $btns .= str_replace('%20', ' ', $data['actions']['generic_' . $ii]['title']);
                    $btns .= '<\/a>';
                }
            }

            // Add button
            if (
                !empty($data['actions']['add']['link']) &&
                !empty($data['actions']['add']) &&
                (
                    (isset($data['actions']['add']['access']) && $data['actions']['add']['access']) ||
                    (isset($data['actions']['add']['perm']) && $data['actions']['add']['perm']) ||
                    (isset($data['actions']['add']['role']) && $data['actions']['add']['role'])
                )
            ) {
                $btns .= '<a style="margin-left: 10px" id="add-' . $data['table_id'] . '" class="btn waves-effect btn-primary" href="' . base_url() . $data['actions']['add']['link'] . '">';
                if (!empty($data['actions']['add']['icon'])) {
                    $btns .= '<i style="margin-right: 8px;" title=\"' . $data['actions']['add']['title'] . '\" class=\"zmdi zmdi-hc-lg zmdi-' . $data['actions']['add']['icon'] . '\"><\/i>';
                }
                $btns .= str_replace('%20', ' ', $data['actions']['add']['title']);
                $btns .= '<\/a>';
            }
            $btns .= '<\/div>';
        }

        // PDF export functionality
        if (!empty($data['export_pdf']) && module_active('pdf')) {
            if (!function_exists('pdf_export_table_button')) {
                $ci->load->helper('pdf/pdf');
            }
            $btns .= '<div id="export-pdf-' . $data['table_id'] . '" style="float: right">';
            $btns .= pdf_export_table_button($data['export_pdf']['module'], $data['export_pdf']['model'], $data['export_pdf']['function'], $data['export_pdf']['parameters']);
            $btns .= '<\/div>';
        }

        // Initialize the table.
        $out .= '
            <table id="' . $data['table_id'] . '" class="' . $data['table_class'] . '">
                <thead>
                    <tr>
        ';

        // Set table header for actions column
        if ($data['actions_position'] == 'left' || $data['actions_position'] == 'both') {
            $headtext = '
                <th class="' . $data['head_cell_class'] . '" data-sortable="false" data-formatter="' . strtolower(lang($data['actions_label'])) . '" data-column-id="' . strtolower(lang($data['actions_label'])) . '">
                    ' . strtoupper(lang($data['actions_label'])) . '
                </th>
            ';
        } else {
            $headtext = '';
        }

        // Set the rest of the table column headers.
        $test = reset($data['page_data']);
        if (!empty($test)) {
            foreach ($test as $key => $val) {
                $sortable = '';
                if (!empty($data['not_sortable']) && in_array($key, $data['not_sortable'])) {
                    $sortable = ' data-sortable="false"';
                }
                if (empty($data['index_key'])) {
                    $data['index_key'] = 'id';
                }
                if ($key == $data['index_key']) {
                    if (!empty($data['hide_columns'])) {
                        if (!in_array($key, $data['hide_columns'])) {
                            $headtext .= '
                                <th data-identifier="true"' . $sortable . ' data-column-id="' . $key . '" class="' . $data['head_cell_class'] . '">
                                    <a class="column-header-anchor sortable" href="javascript:void(0);"><span class="text">' . strtoupper(str_replace('_', ' ', $key)) . '</span><span class="zmdi icon"></span></a>
                                </th>
                            ';
                        }
                    } else {
                        $headtext .= '
                            <th data-identifier="true"' . $sortable . ' data-column-id="' . $key . '" class="' . $data['head_cell_class'] . '">
                                <a class="column-header-anchor sortable" href="javascript:void(0);"><span class="text">' . strtoupper(str_replace('_', ' ', $key)) . '</span><span class="zmdi icon"></span></a>
                            </th>
                        ';
                    }
                } else {
                    if (!empty($data['hide_columns'])) {
                        if (!in_array($key, $data['hide_columns'])) {
                            $headtext .= '
                                <th class="' . $data['head_cell_class'] . '"' . $sortable . ' data-column-id="' . $key . '">
                                    <a class="column-header-anchor sortable" href="javascript:void(0);"><span class="text">' . strtoupper(str_replace('_', ' ', $key)) . '</span><span class="zmdi icon"></span></a>
                                </th>
                            ';
                        }
                    } else {
                        $headtext .= '
                            <th class="' . $data['head_cell_class'] . '"' . $sortable . ' data-column-id="' . $key . '">
                                <a class="column-header-anchor sortable" href="javascript:void(0);"><span class="text">' . strtoupper(str_replace('_', ' ', $key)) . '</span><span class="zmdi icon"></span></a>
                            </th>
                        ';
                    }
                }
            }
        }

        // Set the action column data for when the actions are on the right of a listing.
        if ($data['actions_position'] == 'right' || $data['actions_position'] == 'both') {
            $out =
                $out .
                $headtext . '
                        <th class="' . $data['head_cell_class'] . '" data-sortable="false" data-formatter="' . strtolower(lang($data['actions_label'])) . '" data-column-id="' . strtolower(lang($data['actions_label'])) . '">
                            ' . strtoupper(lang($data['actions_label'])) . '
                        </th>
                    </tr>
                </thead>
                <tbody>
            ';
        } else {
            $out =
                $out .
                $headtext . '
                    </tr>
                </thead>
                <tbody>
            ';
        }

        // Build up the rows of data.
        foreach ($data['page_data'] as $key => $val) {
            $out .= '<tr>';
            if (is_array($val)) {
                foreach ($val as $k => $v) {
                    if (!empty($data['hide_columns'])) {
                        if (!in_array($k, $data['hide_columns'])) {
                            $out .= '<td>' . $v . '</td>';
                        }
                    } else {
                        $out .= '<td>' . $v . '</td>';
                    }
                }
            } else {
                $out .= '<td colspan="' . (count($val) + 1) . '">No data...</td>';
            }
            $out .= '</tr>';
        }

        // Close off the table.
        $out .= '
                    </tbody>
                </table>
            </div>
        ';
    }

    // Close the element wrap.
    $out .= _append_if(!empty($data['outer_class']), '</div>');

    // Conclusion of the bootstrap wrapping, if enabled.
    $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
    $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

    // Initialize the bootgrid feature.
    $out .= '
        <script type="text/javascript">
            $(document).ready(function(){
                var grid = $("#' . $data['table_id'] . '").bootgrid({
                    css: {
                        icon: "zmdi icon",
                        iconColumns: "zmdi-view-module",
                        iconDown: "zmdi-sort-amount-desc",
                        iconRefresh: "zmdi-refresh",
                        iconUp: "zmdi-sort-amount-asc"
                    },
                    ajaxSettings: {
                        method: "' . $data['method'] . '",
                        cache: ' . $data['cache'] . '
                    },
                    searchSettings: {
                        delay: ' . $data['searchdelay'] . ',
                        characters: ' . $data['searchchars'] . '
                    },
                    post: function () {
                        return {
                            id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                        };
                    },
                    search: true,
                    ajax: true,
                    columnSelection: ' . $data['columnselection'] . ',
                    url: "' . base_url() . $data['url'] . '",
                    caseSensitive: ' . $data['casesensitive'] . ',
                    rowCount: ' . $data['rowcount'] . ',
                    selection: ' . $data['selection'] . ',
                    multiSelect: ' . $data['multiselect'] . ',
                    rowSelect: ' . $data['rowselect'] . ',
                    sorting: ' . $data['sorting'] . ',
                    keepSelection: ' . $data['keepselection'] . ',
    ';
    if (!empty($data['actions'])) {
        $out .= '
                    formatters: {
                        "' . strtolower(lang($data['actions_label'])) . '": function(column, row) {
                            return ("" +
                            ';
        foreach ($data['actions'] as $kk => $vv) {
            if ($kk !== 'add' && $kk !== 'generic_1' && $kk !== 'generic_2' && $kk !== 'generic_3' && $kk !== 'generic_4' && $kk !== 'generic_5') {
                if (!empty($vv['perm']) || !empty($vv['role']) || !empty($vv['access'])) {
                    $link = base_url() . $vv['link'];
                    $modal_toggle = '';
                    $modal_class = '';
                    $modal_target = '';
                    $sep = '/';
                    if (strpos($vv['link'], '#') == 0 && !empty($vv['is_dialog'])) {
                        $link = $vv['link'];
                        $sep = '';
                        $modal_toggle = ' data-toggle=\"modal\" ';
                        $modal_class = ' class=\"pop-modal\" ';
                        $modal_target = ' data-target=\"' . $link . ' + row.id + "\" ';
                    }
                    if (!empty($vv['condition_or'])) {
                        $check_cond = '
                        (';
                        foreach ($vv['condition_or'] as $conv) {
                            if ($conv['operator'] != 'contains' && $conv['operator'] != '!contains' && $conv['operator'] != 'in' && $conv['operator'] != '!in') {
                                $check_cond .= '(row.' . $conv['column'] . ' ' . $conv['operator'] . ' "' . $conv['value'] . '") || ';
                            } elseif ($conv['operator'] == 'contains') {
                                $check_cond .= '(row.' . $conv['column'] . '.search("^' . $conv['value'] . '$") !== -1) || ';
                            } elseif ($conv['operator'] == '!contains') {
                                $check_cond .= '(row.' . $conv['column'] . '.search("^' . $conv['value'] . '$") == -1) || ';
                            } elseif ($conv['operator'] == 'in') {
                                $check_cond .= '(';
                                if (is_array($conv['value']) && !empty($conv['value'])) {
                                    foreach ($conv['value'] as $vxx) {
                                        $check_cond .= '(row.' . $conv['column'] . '.search("^' . $vxx . '$") !== -1) || ';
                                    }
                                }
                                $check_cond = rtrim($check_cond, ' || ') . ')';
                            } elseif ($conv['operator'] == '!in') {
                                $check_cond .= '(';
                                if (is_array($conv['value']) && !empty($conv['value'])) {
                                    foreach ($conv['value'] as $vxx) {
                                        $check_cond .= '(row.' . $conv['column'] . '.search("^' . $vxx . '$") == -1) || ';
                                    }
                                }
                                $check_cond = rtrim($check_cond, ' || ') . ')';
                            }
                        }
                        $check_cond = rtrim($check_cond, ' || ');
                        if (!empty($vv['show_disabled'] && $vv['show_disabled'] == 'Yes')) {
                            $out .=
                                $check_cond . ' ?
                                "<a ' . $modal_class . ' data-target=\"' . $link . '" + row.id + "\" style=\"margin-right: 8px\" ' . $modal_toggle . ' href=\"' . $link . $sep . '" + row.id + "\"><i title=\"' . $vv['title'] . '\" class=\"zmdi zmdi-hc-lg zmdi-' . $vv['icon'] . '\"><\/i><\/a>" :
                                "<i style=\"margin-right: 8px;\" title=\"' . $vv['disabled_title'] . '\" class=\"zmdi zmdi-hc-lg zmdi-' . $vv['disabled_icon'] . '\"><\/i>"
                            ) + ';
                        } else {
                            $out .=
                                $check_cond . ' ?
                                "<a ' . $modal_class . ' data-target=\"' . $link . '" + row.id + "\" style=\"margin-right: 8px\" ' . $modal_toggle . ' href=\"' . $link . $sep . '" + row.id + "\"><i title=\"' . $vv['title'] . '\" class=\"zmdi zmdi-hc-lg zmdi-' . $vv['icon'] . '\"><\/i><\/a>" :
                                ""
                            ) + ';
                        }
                    } elseif (!empty($vv['condition_and'])) {
                        $check_cond = '
                        (';
                        foreach ($vv['condition_and'] as $conv) {
                            if ($conv['operator'] != 'contains' && $conv['operator'] != '!contains' && $conv['operator'] != 'in' && $conv['operator'] != '!in') {
                                $check_cond .= '(row.' . $conv['column'] . ' ' . $conv['operator'] . ' "' . $conv['value'] . '") && ';
                            } elseif ($conv['operator'] == 'contains') {
                                $check_cond .= '(row.' . $conv['column'] . '.search("^' . $conv['value'] . '$") !== -1) && ';
                            } elseif ($conv['operator'] == '!contains') {
                                $check_cond .= '(row.' . $conv['column'] . '.search("^' . $conv['value'] . '$") == -1) && ';
                            } elseif ($conv['operator'] == 'in') {
                                $check_cond .= '(';
                                if (is_array($conv['value']) && !empty($conv['value'])) {
                                    foreach ($conv['value'] as $vxx) {
                                        $check_cond .= '(row.' . $conv['column'] . '.search("^' . $vxx . '$") !== -1) && ';
                                    }
                                }
                                $check_cond = rtrim($check_cond, ' && ') . ')';
                            } elseif ($conv['operator'] == '!in') {
                                $check_cond .= '(';
                                if (is_array($conv['value']) && !empty($conv['value'])) {
                                    foreach ($conv['value'] as $vxx) {
                                        $check_cond .= '(row.' . $conv['column'] . '.search("^' . $vxx . '$") == -1) && ';
                                    }
                                }
                                $check_cond = rtrim($check_cond, ' && ') . ')';
                            }
                        }
                        $check_cond = rtrim($check_cond, ' && ');
                        if (!empty($vv['show_disabled'] && $vv['show_disabled'] == 'Yes')) {
                            $out .=
                                $check_cond . ' ?
                                "<a ' . $modal_class . ' data-target=\"' . $link . '" + row.id + "\" style=\"margin-right: 8px\" ' . $modal_toggle . ' href=\"' . $link . $sep . '" + row.id + "\"><i title=\"' . $vv['title'] . '\" class=\"zmdi zmdi-hc-lg zmdi-' . $vv['icon'] . '\"><\/i><\/a>" :
                                "<i style=\"margin-right: 8px;\" title=\"' . $vv['disabled_title'] . '\" class=\"zmdi zmdi-hc-lg zmdi-' . $vv['disabled_icon'] . '\"><\/i>"
                            ) + ';
                        } else {
                            $out .=
                                $check_cond . ' ?
                                "<a ' . $modal_class . ' data-target=\"' . $link . '" + row.id + "\" style=\"margin-right: 8px\" ' . $modal_toggle . ' href=\"' . $link . $sep . '" + row.id + "\"><i title=\"' . $vv['title'] . '\" class=\"zmdi zmdi-hc-lg zmdi-' . $vv['icon'] . '\"><\/i><\/a>" :
                                ""
                            ) + ';
                        }
                    } else {
                        $out .= '"<a ' . $modal_class . ' style=\"margin-right: 8px\" href=\"' . $link . '/" + row.id + "\"><i title=\"' . $vv['title'] . '\" class=\"zmdi zmdi-hc-lg zmdi-' . $vv['icon'] . '\"><\/i><\/a>" + ';
                    }
                }
            }
        }
        $out = rtrim($out, ' + ') . '
            );
        ';
        $out .= '
                        }
                    }
        ';
    }
    $out .= '
                }).on("selected.rs.jquery.bootgrid", function(e, rows){
                    var ids = $("#selected_grid_items").val();
                    var ids = ids.split(",");
                    for (var i = 0; i < rows.length; i++) {
                        ids.push(rows[i].id);
                    }
                    $("#selected_grid_items").val(ids.join(","));
                    return rowIds;
                }).on("deselected.rs.jquery.bootgrid", function(e, rows){
                    var ids = $("#selected_grid_items").val();
                    var ids = ids.split(",");
                    for (var i = 0; i < rows.length; i++) {
                        ids.pop(rows[i].id);
                    }
                    $("#selected_grid_items").val(ids.join(","));
                });
                $(\'' . $btns . '\').insertAfter(".actionBar .actions");
            })
        </script>
        <input type="hidden" id="selected_grid_items" name="selected_grid_items">
    ';

    // Return the element.
    unset($data);
    return $out;
}

/**
 * kcms_form_datetime_picker
 *
 * Generates a date-time picker.
 *
 * @param array $data (see kcms_form_input for defaults)
 *  ['seconds']
 *  ['datetimepicker']
 *
 * @access public
 *
 * @return string
 */
function kcms_form_date_time_picker($data)
{
    set_on($data['seconds'], 'isempty', '', '-ss');
    set_on($data['datetimepicker'], 'notset', true);
    return kcms_form_input($data);
}

/**
 * kcms_form_date_picker
 *
 * Generates a date picker.
 *
 * @param array $data (see kcms_form_input for defaults)
 *  ['seconds']
 *  ['datetimepicker']
 *
 * @access public
 *
 * @return string
 */
function kcms_form_date_picker($data)
{
    set_on($data['datepicker'], 'notset', true);
    return kcms_form_input($data);
}

/**
 * kcms_form_time_picker
 *
 * Generates a time picker.
 *
 * @param array $data (see kcms_form_input for defaults)
 *  ['seconds']
 *  ['datetimepicker']
 *
 * @access public
 *
 * @return string
 */
function kcms_form_time_picker($data)
{
    set_on($data['seconds'], 'isempty', '', '-ss');
    set_on($data['timepicker'], 'notset', true);
    return kcms_form_input($data);
}

/**
 * kcms_form_file
 *
 * Generates a file upload widget
 *
 * @param array $data
 *  ['prompt']
 *  ['button']
 *  ['button_new']
 *  ['button_exists']
 *  ['name']
 *  ['id']
 *  ['upload_path']
 *  ['multiple']
 *  ['allowed_types']
 *  ['max_size']
 *  ['max_width']
 *  ['max_height']
 *  ['bootstrap_row']
 *  ['bootstrap_col']
 *  ['validation']
 *  ['validation_indicator']
 *  ['readonly']
 *  ['hint']
 *  ['hint_inline']
 *
 * @access public
 *
 * @return string
 */
function kcms_form_file($data)
{
    $ci =& get_instance();
    $out = '';
    set_on($data['label'], 'notset', 'Select file');
    set_on($data['button'], 'notset', 'Browse...');
    set_on($data['button_new'], 'notset', $data['button']);
    set_on($data['button_exists'], 'notset', $data['button']);
    set_on($data['name'], 'notset', 'upload-' . rand(0, 9999));
    set_on($data['id'], 'notset', 'upload-' . rand(0, 9999));
    set_on($data['upload_path'], 'notset', 'uploads/');
    set_on($data['multiple'], 'notset', false);
    set_on($data['max_size'], 'notset', 5120);
    set_on($data['max_width'], 'notset', 1920);
    set_on($data['max_height'], 'notset', 1080);
    set_on($data['bootstrap_row'], 'notset', '', $data['bootstrap_row']);
    set_on($data['bootstrap_col'], 'notset', '', $data['bootstrap_col']);
    set_on($data['validation'], 'notset', '');
    set_on($data['validation_indicator'], 'notset', '');
    set_on($data['label_class'], 'notset', 'control-label');
    set_on($data['error_class'], 'notset', 'form-narrow-error');
    set_on($data['input_class'], 'notset', '');
    set_on($data['individual_validation'], 'notset', true);
    set_on($data['outer_class'], 'notset', '');
    set_on($data['hint'], 'notset', 'Select some files to upload.');
    set_on($data['hint_inline'], 'notset', false);
    set_on($data['readonly'], 'notset', false);
    set_on($data['file_types'], 'notset', 'general');
    set_on($data['delimiter_open'], 'notset', '');
    set_on($data['delimiter_close'], 'notset', '');

    // Set some sensible default file types.
    if ($data['file_types'] == 'general') {
        set_on($data['allowed_types'], 'notset', 'jpg|gif|png|bmp|svg|jpeg|pdf|csv|txt|doc|docx|odt|ott|oth|odm|xlsx|xls|csv|ods|ots');
    } elseif ($data['file_types'] == 'images') {
        set_on($data['allowed_types'], 'notset', 'jpg|gif|png|bmp|svg|jpeg');
    } elseif ($data['file_types'] == 'documents') {
        set_on($data['allowed_types'], 'notset', 'pdf|csv|txt|doc|docx|odt|ott|oth|odm');
    } elseif ($data['file_types'] == 'sheets') {
        set_on($data['allowed_types'], 'notset', 'xlsx|xls|csv|ods|ots');
    } elseif ($data['file_types'] == 'contracts') {
        set_on($data['allowed_types'], 'notset', 'xlsx|xls|doc|docx|pdf');
    } else {
        set_on($data['allowed_types'], 'notset', $data['file_types']);
    }
    set_on($data['allowed_types'], 'notset', 'jpg|gif|png|bmp|svg|jpeg|pdf|csv|txt|doc|docx|odt|ott|oth|odm|xlsx|xls|csv|ods|ots');
    $split = explode('|', $data['allowed_types']);
    $data['accept'] = '';
    foreach($split as $vv) {
        $data['accept'] .= '.' . $vv . ',';
    }
    $data['accept'] = rtrim($data['accept'], ',');

    // Never trust user input.
    $data = _clean_array($data);

    // Check if multiple files were configured.
    $add_multiple = '';
    $data['real_name'] = $data['name'];
    if (!empty($data['multiple'])) {
        $data['name'] .= '[]';
        $add_multiple = ' multiple';
    }

    // Defaults to wrapping in a row. This makes for vertical forms. If set to false, you can do inline forms with some CSS.
    $out .= _append_if(!empty($data['bootstrap_row']), '<div class="' . $data['bootstrap_row'] . '">');
    $out .= _append_if(!empty($data['bootstrap_col']), '<div class="' . $data['bootstrap_col'] . '">');

    // Wrap the element.
    $out .= _append_if(!empty($data['outer_class']), '<div class="' . $data['outer_class'] . '">');

    // Apply validation related rules markup.
    if (!empty($data['validation']['rules'])) {
        $rules = explode('|', $data['validation']['rules']);
        if (!empty($rules)) {
            if (in_array('required', $rules)) {
                $data['validation_indicator'] = '<span class="form-validation-required"> * </span>';
            }
        }
    }

    // Shall we add a label? Note: without it, there will be no validation indicator for required fields.
    if (!empty($data['label'])) {
        $out .= '
            <div class="' . $data['label_class'] . '">
                <label for="' . $data['id'] . '">' . $data['label'] . $data['validation_indicator'] . '</label>
        ';

        // Do we have an inline hint?
        $out .= _append_if(!empty($data['hint']) && !empty($data['hint_inline']), '<span class="hint-text">' . $data['hint'] . '</span>');
        $out .= '
            </div>
        ';
    }

    // Do we have a hint that is not inline?
    $out .= _append_if(!empty($data['hint']) && empty($data['hint_inline']), '<div class="hint-text">' . $data['hint'] . '</div>');

    // Make the form element. I am not sure if specifying the parameters as hidden fields is a security risk. To be confirmed.
    if ($data['file_types'] != 'images') {
        $out .= '
            <div id="wrapper-' . $data['id'] . '" class="fileinput fileinput-new" data-provides="fileinput">
                <span class="btn btn-primary btn-file m-r-10">
                    <span class="fileinput-new">' . $data['button_new'] . '</span>
                    <span class="fileinput-exists">' . $data['button_exists'] . '</span>
                    <input accept="' . $data['accept'] . '" type="file" id="' . $data['id'] . '" ' . $add_multiple . ' name="' . $data['name'] . '">
                </span>
                <span id="filetag-' . $data['id'] . '" class="fileinput-filename"></span>
                <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
            </div>
        ';
    } else {
        $out .= '
            <div id="wrapper-' . $data['id'] . '" class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                <div>
                    <span class="btn btn-info btn-file">
                        <span class="fileinput-new">' . $data['button_new'] . '</span>
                        <span class="fileinput-exists">' . $data['button_exists'] . '</span>
                        <input accept="' . $data['accept'] . '" type="file" id="' . $data['id'] . '" name="' . $data['name'] . '">
                    </span>
                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
        ';
    }
    $out .= '
        <input type="hidden" name="upload_path" id="upload_path" value="' . $data['upload_path'] . '">
        <input type="hidden" name="upload_max_width" value="' . $data['max_width'] . '">
        <input type="hidden" name="upload_max_height" value="' . $data['max_height'] . '">
        <input type="hidden" name="upload_max_size" value="' . $data['max_size'] . '">
        <input type="hidden" name="upload_allowed_types" value="' . $data['allowed_types'] . '">
        <input type="hidden" name="upload_name" value="' . $data['real_name'] . '">
        <input type="hidden" name="upload_field_name" value="' . $data['name'] . '">
        <input type="hidden" name="upload_delimiter_open" value="' . $data['delimiter_open'] . '">
        <input type="hidden" name="upload_delimiter_close" value="' . $data['delimiter_close'] . '">
    ';

    // Close the element wrap.
    $out .= _append_if(!empty($data['outer_class']), '</div>');

    // Add validation errors row.
    if (!empty(form_error($data['name'])) && !empty($data['individual_validation'])) {
        $out .= '<div class="row">';
        $out .= '<div class="col-sm-12">';
        $out .= _append_if(!empty($data['error_class']), '<div class="' . $data['error_class'] . '">');
        $out .= form_error($data['name']);
        $out .= _append_if(!empty($data['error_class']), '</div>');
        $out .= '</div>';
        $out .= '</div>';
    }
    $files = _sess_get('files_' . $data['id']);
    if (!empty($files) || !empty($data['uploaded_file'])) {
        if (empty($files)) {
            $files[$data['real_name']]['name'] = $data['uploaded_file'];
        }
        if (is_array($files[$data['real_name']]['name']) && !empty($files[$data['real_name']]['name'][0])) {
            $file_name = '';
            foreach ($files[$data['real_name']]['name'] as $v) {
                $file_name .= $v . ', ';
            }
            $file_name = '(' . count($files[$data['real_name']]['name']) . ') ' . rtrim($file_name, ', ');
            $temp_end = '';
            if (strlen($file_name) > 60) {
                $temp_end = substr($file_name, -6, 6);
                $file_name = shorten($file_name, 54) . $temp_end;
            }
        } else {
            $file_name = $files[$data['real_name']]['name'];
        }
        $out .= '
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#wrapper-' . $data['id'] . '").addClass("fileinput-exists").removeClass("fileinput-new");
                    $("#filetag-' . $data['id'] . '").text("' . $file_name  . '");
                });
            </script>
        ';
    }

    // Conclusion of the bootstrap wrapping, if enabled.
    $out .= _append_if(!empty($data['bootstrap_col']), '</div>');
    $out .= _append_if(!empty($data['bootstrap_row']), '</div>');

    // Return the element.
    unset($data);
    return $out;
}

/**
 * kcms_files_to_session
 *
 * Stores the uploaded file(s) to a session, in case form validation fails otherwise.
 *
 * @param array $files
 * @param string $handle
 * @param bool $unset
 *
 * @access public
 *
 * @return string
 */
function kcms_files_to_session($files, $handle, $unset = false)
{
    $ci =& get_instance();
    if ($unset === true) {
        $ci->session->unset_userdata('files_' . $handle);
    } else {
        if (!empty($files[$handle]['name'])) {
            $ci->session->set_userdata('files_' . $handle, $files);
        } else {
            $return = $ci->session->userdata('files_' . $handle);
            return $return;
        }
    }
    return $files;
}

?>
