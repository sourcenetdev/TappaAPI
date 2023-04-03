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
 * KyrandiaCMS PDF Helper
 *
 * Use this file to define all functions used specifically by the PDF module or modules using its features.
 *
 * @package     Impero
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Kobus Myburgh and Elsabe Bester
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */

/**
 * pdf_export_table_button
 *
 * Generates html for a button that will export a data table to a pdf.
 *
 * @param string $module
 * @param string $model
 * @param string $function
 * @param array $params
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('pdf_export_table_button')) {
    function pdf_export_table_button($module, $model, $function, $params)
    {
        if (!is_array($params)) {
            $params = [$params];
        }
        $html = sprintf('<form method="POST" target="_blank" action="%s" class="export_pdf_table_button">', site_url() . 'pdf/generate');
        $html .= sprintf('<input type="hidden" name="module" value="%s"><input type="hidden" name="model" value="%s"><input type="hidden" name="function" value="%s">',
            $module, $model, $function
        );
        foreach ($params as $key => $value) {
            $html .= sprintf('<input type="hidden" name="param[%s]" value="%s">', $key, $value);
        }
        $html .= '<button name="export_pdf" id="submit" type="submit" class="btn btn-secondary waves-effect"><i class="zmdi zmdi-download"><\/i>&nbsp;&nbsp;Export PDF</button>';
        $html .= '</form>';
        return $html;
    }
}

/**
 * render_pdf_export_table_button
 *
 * Uses pdf_export_table_button to generate html for an export button.
 * Prints out the result.
 *
 * @param string $module
 * @param string $model
 * @param string $function
 * @param array $params
 *
 * @access public
 *
 * @return void
 */
if (!function_exists('render_pdf_export_table_button')) {
    function render_pdf_export_table_button($module, $model, $function, $params)
    {
        echo pdf_export_table_button($module, $model, $function, $params);
    }
}

/**
 * pdf_generate_table_html
 *
 * @param array $data
 *
 * @access public
 *
 * @return string
 */
if (!function_exists('pdf_generate_table_html')) {
    function pdf_generate_table_html($data)
    {
        $page_length = $data['per_page'];
        $pages = ceil(count($data['data']) / $page_length);
        $keys = array_keys($data['data'][0]);
        $html = [];
        $counter = 0;
        $page = 0;
        for ($i = 1; $i <= $pages; $i++) {
            $html[$page] = '<table style="font-family: arial; font-size: 12px; width: 100%; border: 1px solid #dddddd;">' . "\r\n";
            $html[$page] .= '    <thead>' . "\r\n";
            $html[$page] .= '        <tr>' . "\r\n";
            foreach($keys as $key) {
                $html[$page] .= '            <th class="content" style="padding: 8px; background-color: #333333; color: #ffffff;">' . $key . '</th>' . "\r\n";
            }
            $html[$page] .= '        </tr>' . "\r\n";
            $html[$page] .= '    </thead>' . "\r\n";
            $html[$page] .= '    <tbody>' . "\r\n";
            $slice = array_slice($data['data'], $counter, $page_length, true);
            foreach($slice as $key => $entry) {
                $html[$page] .= '        <tr>' . "\r\n";
                foreach($entry as $value) {
                    $html[$page] .= '            <td class="content" style="padding: 8px;">' . $value . '</td>' . "\r\n";
                }
                $html[$page] .= '        </tr>' . "\r\n";
            }
            $html[$page] .= '    </tbody>' . "\r\n";
            $html[$page] .= '</table>' . "\r\n";
            $counter += $page_length;
            $page++;
        }
        return $html;
    }
}

/**
 * pdf_generate_document
 *
 * @param string $filename
 * @param array $data
 * @param string $output
 *
 * @access public
 *
 * @return mixed Value.
 */
if (!function_exists('pdf_generate_document')) {
    function pdf_generate_document($filename, $data, $output = 'I')
    {
        $ci =& get_instance();
        $document_title['title'] = '';

        // Initialize the PDF.
        $mpdf = new \Mpdf\Mpdf(['orientation' => $data['contents']['orientation']]);
        $mpdf->SetDisplayMode('fullpage');
        if (!empty($data['contents']['document_author'])) {
            $mpdf->setAuthor($data['contents']['document_author']);
        }
        if (!empty($data['contents']['document_keywords'])) {
            $mpdf->setKeywords($data['contents']['document_keywords']);
        }
        if (!empty($data['contents']['document_subject'])) {
            $mpdf->setSubject($data['contents']['document_subject']);
        }
        if (!empty($data['contents']['document_creator'])) {
            $mpdf->setCreator($data['contents']['document_creator']);
        }
        if (!empty($data['contents']['document_title'])) {
            $mpdf->setTitle($data['contents']['document_title']);
            $document_title['title'] = $data['contents']['document_title'];
        }
        if (!empty($data['contents']['document_footer'])) {
            $document_footer['content'] = $data['contents']['document_footer'] . ' - ' . $filename;
        } else {
            $document_footer['content'] = $filename;
            $document_footer['copyright'] = '&copy; Copyright ' . date('Y') . ', <strong>Impero Consulting</strong>, all rights reserved';
        }

        // Set the document header and footer.
        if (!empty($data['contents']['page_title'])) {
            $header['title'] = $data['contents']['page_title'];
        } else {
            if (!empty($data['contents']['title'])) {
                $header['title'] = $data['contents']['title'];
            } else {
                $header['title'] = 'Untitled document';
            }
        }
        $document_header = $ci->load->view('pdf/pdf_document_header', $document_title, true);
        $document_footer = $ci->load->view('pdf/pdf_document_footer', $document_footer, true);
        try {
            $css = '';
            if (file_exists(APPPATH . 'modules/pdf/assets/css/pdf_styles.css')) {
                $css = file_get_contents(APPPATH . 'modules/pdf/assets/css/pdf_styles.css');
            }
            $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
            exit();
        }

        // Generate the PDF body
        if (isset($data['contents']['body']) && is_array($data['contents']['body'])) {
            $counter = 1;
            $footer['total'] = count($data['contents']['body']);
            foreach ($data['contents']['body'] as $section) {
                $footer['page'] = $counter;
                $page['section'] = $section;
                $page_header = $ci->load->view('pdf/pdf_page_header', $header, true);
                $page_footer = $ci->load->view('pdf/pdf_page_footer', $footer, true);
                $body = $ci->load->view('pdf/pdf_section', $page, true);
                try {
                    $mpdf->setHeader($document_header);
                    $mpdf->setFooter($document_footer);
                    $mpdf->WriteHTML($page_header, \Mpdf\HTMLParserMode::HTML_BODY, true, false);
                    $mpdf->WriteHTML($body, \Mpdf\HTMLParserMode::HTML_BODY, false, false);
                    $mpdf->WriteHTML($page_footer, \Mpdf\HTMLParserMode::HTML_BODY, false, true);
                    if ($counter != count($data['contents']['body'])) {
                        $mpdf->addPage();
                    }
                } catch (\Mpdf\MpdfException $e) {
                    echo $e->getMessage();
                    exit();
                }
                $counter++;
            }
        } else {
            $page['section'] = $data['contents']['body'];
            $page_header = $ci->load->view('pdf/pdf_page_header', $header, true);
            $page_footer = $ci->load->view('pdf/pdf_page_footer', [], true);
            $body = $this->load->view('pdf/pdf_section', $page, true);
            try {
                $mpdf->setHeader($document_header);
                $mpdf->setFooter($document_footer);
                $mpdf->WriteHTML($page_header, \Mpdf\HTMLParserMode::HTML_BODY, true, false);
                $mpdf->WriteHTML($body, \Mpdf\HTMLParserMode::HTML_BODY, false, false);
                $mpdf->WriteHTML($page_footer, \Mpdf\HTMLParserMode::HTML_BODY, false, true);
                $mpdf->addPage();
            } catch (\Mpdf\MpdfException $e) {
                echo $e->getMessage();
                exit();
            }
        }

        // Output the PDF
        if (!$output || !in_array($output, array('I', 'F')))  {
            $output = 'F';
        }
        $mpdf->Output($filename, strtoupper($output));
        return $filename;
    }
}
