<?php
/**
 * KyrandiaCMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2020, Impero, all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 * @version   7.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Config
 *
 * This is the autoload config file for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Configs
 * @category    Configs
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

$autoload['packages'] = [];
$autoload['libraries'] = ['Cornerstone', 'form_validation', 'encryption', 'session'];
$autoload['drivers'] = [];
$autoload['helper'] = [
    'kcms', 'access', 'system', 'url', 'form', 'language', 'security', 'email',
    'module/module', 'nucleus/nucleus', 'filter/filter', 'user/user'
];
$autoload['config'] = [];
$autoload['language'] = [];
$autoload['model'] = [];
