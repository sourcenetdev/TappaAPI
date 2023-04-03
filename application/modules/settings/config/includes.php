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
 * KyrandiaCMS Settings Module
 *
 * This is a configuration file for the Settings Module.
 *
 * @package     Impero
 * @subpackage  Modules
 * @category    Configs
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @since       Version 1.0
 * @version     6.0
 */

/**
 * Configuration options:
 *
 * Scripts are ALWAYS loaded in the order they are specified in the array.
 *
 * If an item is not an array, the following is assumed:
 *
 * - The script is placed just above the closing body tag.
 * - The script will be loaded via a link to the script (external source file).
 *
 * If an item is an array, the following settings will be overridden from the defaults:
 *
 * - place: specifies where the script must be injected. Possible values are 'head', 'body'
 * - method: specifies how the script must be injected. Possible values are 'link', 'inline'
 * - 'link' will inject <script src="..."></script> (Note that in HTML5 the "type" attribute is not required.)
 * - 'inline' will execute PHP's file_get_contents() on the file, and insert the result in <script></script> tags. (Note that in HTML5 the "type" attribute is not required.)
 *
 * CSS files will always be added to the head, so you will make use of a normal single dimension array to load all CSS files.
 *
 * You can specify 'inline' in the file's array to specify whether the CSS file should be injected between <style></style> tags.
 */
$scripts = array();
$css = array();

