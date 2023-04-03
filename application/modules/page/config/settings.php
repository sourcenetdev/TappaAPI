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
 * KyrandiaCMS Page Module
 *
 * Contains the page features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

/**
 * BASIC USAGE INSTRUCTIONS
 *
 * Required:
 *
 * - Specifies if this module is required by the system - in other words, it cannot be disabled via the back-end.
 *
 * Name:
 *
 * - This is the unique identifier for the module. This MUST BE unique on a per-module basis.
 *
 * Active:
 *
 * - If set to anything but 'Yes', this module can not be used. It will fail the dependencies test.
 *
 * Dependencies: Utilizes a format similar to npmjs's approach. Possible values are:
 *
 * - = version:    Matches version exactly
 * - > version:    Matches greater than version
 * - >= version:   Matches greater or equal than version
 * - < version:    Matches less than version
 * - <= version:   Matches less than or equal to version
 */
$settings['page'] = array(
    'version' => '6.0',
    'active' => 'Yes',
    'name' => 'pavge',
    'description' => 'KyrandiaCMS Page Module',
    'date' => '2020-01-01',
    'required' => 'Yes',
    'author' => array(
        'name' => 'Kobus Myburgh',
        'email' => 'kobus.myburgh@impero.co.za',
        'website' => 'https://www.impero.co.za'
    )
);
