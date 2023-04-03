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
 * KyrandiaCMS Cornerstone Library - File Functions
 *
 * The kernel of KyrandiaCMS.
 *
 * @package     Impero
 * @subpackage  Core
 * @category    Libraries
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

class CSFile
{

    /**
     * function __construct()
     *
     * Initializes the library
     *
     * @access public
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function arrayToCSV($array, $download = "", $compress = false)
    {
        ob_start();
        $n = 0;
        $f = fopen('php://output', 'w');
        foreach ($array as $line) {
            $n++;
            fputcsv($f, $line);
        }
        fclose($f);
        $str = ob_get_contents();
        ob_end_clean();
        if ($download == "") {
            return $str;
        } else {
            if (!$compress) {
                header('Content-Type: application/csv');
                header('Content-Disposition: attachment; filename="' . $download . '.csv' . '"');
                echo $str;
            } else {
                $zip = new ZipArchive;
                $zip->open($download . '.zip', ZipArchive::CREATE|ZipArchive::OVERWRITE);
                $zip->addFromString($download . '.csv', $str);
                $zip->close();
                header('Content-Type: application/zip');
                header('Content-disposition: attachment; filename=' . $download . '.zip');
                header('Content-Length: ' . filesize($download . '.zip'));
                readfile($download . '.zip');
            }
        }
    }

    public function queryToCSV($query, $headers = TRUE, $download = "", $compress = false)
    {
        if (!is_object($query) || !method_exists($query, 'list_fields')) {
            return false;
        }
        $array = [];
        $line = [];
        if ($headers) {
            foreach ($query->list_fields() as $name) {
                $line[] = $name;
            }
            $array[] = $line;
        }
        foreach ($query->result_array() as $row) {
            foreach ($row as $item) {
                $line[] = $item;
            }
            $array[] = $line;
        }
        echo $this->arrayToCSV($array, $download, $compress);
    }
}
