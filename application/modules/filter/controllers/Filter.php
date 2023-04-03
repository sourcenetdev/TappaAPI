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
 * KyrandiaCMS Filter Module
 *
 * Contains the Filter listing for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh, Haji Maboko
 * @link        https://www.impero.co.za
 * @version     6.0.0
 */
class Filter extends MX_Controller
{
    private $delete_type = 'hard';
    public $page_limit = 25;

    /**
     * function __construct
     *
     * Initializes the module by loading language files, other modules, models, and also checking dependencies.
     *
     * @access public
     * @return void
     */
	function __construct()
	{

	    // Calls the parent's constructor
		parent::__construct();

        // Loads the module's required modules
        _modules_load(['core', 'user', 'syslog', 'metadata']);
        _models_load(['filter/filter_model']);
        _languages_load(['core/core', 'filter/filter']);
        _helpers_load(['core/core', 'filter/filter']);

        // Retrieves this module's settings
		_settings_check('filter');
	}

    /**
     * index
     *
     * TODO: Filters.
     *
     * @access public
     *
     * @return array
     */
    public function index()
    {
    }
}
