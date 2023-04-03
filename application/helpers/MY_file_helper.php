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
 * KyrandiaCMS File Helper
 *
 * Contains a list of file functions used in the system.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

/**
 * Function chop_extension()
 *
 * Removes the extention from a file name.
 *
 * @access public
 *
 * @param string $filename
 *
 * @return string The filename without the extension.
 */
if (!function_exists('chop_extension')) {
    function chop_extension($filename): string
    {
        $basename = basename($filename);
        return strpos($basename, '.') === false ? $filename : substr($filename, 0, - strlen($basename) + strlen(explode('.', $basename)[0]));
    }
}
