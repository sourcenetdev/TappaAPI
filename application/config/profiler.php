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
 * This is the profiler config file for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Configs
 * @category    Configs
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

/*
| -------------------------------------------------------------------------
| Profiler Sections
| -------------------------------------------------------------------------
| This file lets you determine whether or not various sections of Profiler
| data are displayed when the Profiler is enabled.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/profiling.html
|
*/

$config['global_profiling'] = false;
$config['query_toggle_count'] = 20;

$config['benchamrks'] = true || $config['global_profiling'];
$config['config'] = true || $config['global_profiling'];
$config['controller_info'] = true || $config['global_profiling'];
$config['get'] = true || $config['global_profiling'];
$config['http_headers'] = true || $config['global_profiling'];
$config['memory_usage'] = true || $config['global_profiling'];
$config['post'] = true || $config['global_profiling'];
$config['queries'] = true || $config['global_profiling'];
$config['session_data'] = true || $config['global_profiling'];
$config['uri_string'] = true || $config['global_profiling'];
