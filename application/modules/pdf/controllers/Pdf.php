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
 * KyrandiaCMS Core Module
 *
 * Contains the core features of KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Pdf extends MX_Controller
{
    public $settings = [];
    protected $page_limit = 10;

    /**
     * __construct
     *
     * Initializes the module by loading language files, other modules, models, and also checking dependencies.
     *
     * @access  public
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();

        // Load modules that this module depend upon.
        $this->load->module('core');
        $this->load->module('syslog');

        // Load this module's main model.
        $this->load->model('pdf_model');

        // Load this module's main helper.
        $this->load->helper('pdf');
    }

    /**
     * generate
     *
     * Generates the PDF document.
     *
     * @access  public
     *
     * @return  void
     */
    public function generate($data = [], $output = 'I', $file = 'generated-pdf', $path = 'uploads/')
    {
        $params = set_value('param');
        if (empty($params['type'])) {
            $params['type'] = 'table';
        }
        if (empty($params['orientation'])) {
            $params['orientation'] = 'portrait';
        }
        if ($params['orientation'] == 'portrait' || $params['orientation'] == 'P') {
            $params['per_page'] = (isset($params['per_page']) ? $params['per_page'] : 500);
        } else {
            $params['per_page'] = (isset($params['per_page']) ? $params['per_page'] : 500);
        }
        if ($params['type'] == 'table') {
            $this->form_validation->set_rules('model', 'Model', 'required');
            $this->form_validation->set_rules('function', 'Function', 'required');
            if ($this->form_validation->run($this) === true) {

                // Get the datatable data we need to write to the PDF
                $data['data'] = $this->pdf_model->get_table_data(
                    set_value('module'),
                    set_value('model'),
                    set_value('function'),
                    set_value('param')
                );
                $data['orientation'] = $params['orientation'];
                $data['per_page'] = $params['per_page'];
                if (isset($params['base'])) {
                    $data['base'] = $params['base'];
                }
                $content['contents']['body'] = pdf_generate_table_html($data);
            } else {
                $content['contents']['body'] = '';
            }
        } elseif ($params['type'] == 'page') {
            if (!empty($data)) {
                if (is_array($data)) {
                    if (!empty($data['view'])) {
                        $content['contents']['body'] = $this->load->view($data['view'], $data['variables'], true);
                    } else {
                        $content['contents']['body'] = '';
                    }
                } else {
                    $content['contents']['body'] = $data;
                }
            }
        }
        if (!empty($content['contents'])) {
            $content['contents']['page_title'] = (isset($params['page_title']) ? $params['page_title'] : (isset($params['title']) ? $params['title'] : ''));
            $content['contents']['document_title'] = (isset($params['document_title']) ? $params['document_title'] : (isset($params['title']) ? $params['title'] : ''));
            $content['contents']['document_subject'] = (isset($params['document_subject']) ? $params['document_subject'] : '');
            $content['contents']['document_keywords'] = (isset($params['document_keywords']) ? $params['document_keywords'] : '');
            $content['contents']['document_author'] = (isset($params['document_author']) ? $params['document_author'] : '');
            $content['contents']['document_creator'] = (isset($params['document_creator']) ? $params['document_creator'] : '');
            $content['contents']['orientation'] = (isset($params['orientation']) ? $params['orientation'] : 'portrait');
            $content['contents']['per_page'] = $params['per_page'];
            $filename = $path . $file;
            $counter = 1;
            while (file_exists($filename . '.pdf')) {

                // Check for duplicate filenames and add a counter if found.
                $filename = $filename . '_' . $counter;
                $counter++;
            }
            $filename .= '.pdf';

            // Create the PDF document
            $filename = pdf_generate_document($filename, $content, $output, $params['orientation']);
            echo $filename;
        } else {
            return '';
        }
    }
}
