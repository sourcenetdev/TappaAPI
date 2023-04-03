<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * onEmptySet
 *
 * Sets a variable to a value if the variable is empty, and the value not.
 *
 * @param string $variable
 * @param mixed $value
 *
 * @return mixed
 */
if (!function_exists('onEmptySet')) {
    function onEmptySet($variable, $value)
    {
        if (empty($variable) && !empty($value)) {
            $variable = $value;
        }
        return $variable;
    }
}

/**
 * padAmountDecimals
 *
 * Adds decimals to the decimal part of a number when dealing with currency.
 *
 * @param string $variable
 * @param mixed $value
 *
 * @return mixed
 */
if (!function_exists('padAmountDecimals')) {
    function padAmountDecimals($value)
    {
        if (!is_numeric($value)) {
            return false;
        }
        return number_format((float)$value, 2, '.', '');
    }
}

/**
 * processPhoneNumber
 *
 * Transforms a phone number to be in the correct format for using in the API.
 *
 * @param string $number
 * @param string $country_code
 *
 * @return string
 */
if (!function_exists('processPhoneNumber')) {
    function processPhoneNumber($number, $country_code = '27')
    {
        $number = str_replace(['(', ')', '-', ' ', '+', '.', ','], '', $number);
        if (substr($number, 0, strlen($country_code)) != $country_code && strlen($number) == 10) {
            $number = $country_code . substr($number, 1);
        }
        return $number;
    }
}

/**
 * validatePhoneNumber
 *
 * Validates whether aphone number conforms to required format for using in the API - country specific rules may apply.
 *
 * @param string $number
 * @param string $country_code
 * @param int $number_length
 *
 * @TODO: Determine if all countries have the same rule - test for different country codes.
 *
 * @return string
 */
if (!function_exists('validatePhoneNumber')) {
    function validatePhoneNumber($number, $country_code = '27', $number_length = 11)
    {
        $number = processPhoneNumber(trim($number));
        if (!is_numeric($number) || substr($number, 0, 2) != $country_code || strlen($number) != $number_length) {
            return false;
        }
        return true;
    }
}

/**
 * validateEmail
 *
 * Validates an email address for validity.
 *
 * @param string $number
 * @param string $country_code
 *
 * @return string
 */
if (!function_exists('validateEmail')) {
    function validateEmail($email)
    {
        if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            return '';
        }
        return trim($email);
    }
}

/**
 * validationErrorResponse
 *
 * Sends an email validation error response.
 *
 * @param string $data_type
 *
 * @return string
 */
if (!function_exists('validationErrorResponse')) {
    function validationErrorResponse($data_type, $validation_type, $error_code = VALIDATION_ERROR_EMAIL, $start_api = null)
    {
        $ci =& get_instance();
        $ci->errorResponse('user', [
            'data' => [$data_type => []],
            'type' => $data_type . '_input_data_user_error',
            'message' => sprintf(lang('maxapi_helper_validation_failed_error'), $data_type, $validation_type),
            'code' => 400,
            'log_timestamp' => $start_api,
            'error_code' => $error_code
        ]);
    }
}
