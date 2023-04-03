<?php
/**
 * KyrandiaCMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2021, Impero Consulting (Pty) Ltd., all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 * @version   7.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Cornerstone Library
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

class Cornerstone
{

    // Subclasses
    public $kcmsSession = null;
    public $kcmsSecurity = null;
    public $kcmsGrid = null;
    public $kcmsInput = null;
    public $kcmsOutput = null;
    public $kcmsArray = null;
    public $kcmsString = null;
    public $kcmsDate = null;
    public $kcmsInflection = null;
    public $kcmsBCrypt = null;
    public $kcmsTemplate = null;
    public $kcmsOAuth2 = null;
    public $kcmsDatabase = null;
    public $kcmsCast = null;
    public $kcmsFile = null;
    public $kcmsUtils = null;

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
        $this->CI =& get_instance();

        require_once(APPPATH . 'libraries/Cornerstone/CSSecurity.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSGrid.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSInput.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSOutput.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSUtils.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSArray.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSString.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSDate.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSInflection.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSSession.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSBCrypt.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSTemplate.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSOauth2.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSDatabase.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSCast.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSMath.php');
        require_once(APPPATH . 'libraries/Cornerstone/CSFile.php');

        $this->kSession = new CSSession();
        $this->kSecurity = new CSSecurity();
        $this->kGrid = new CSGrid();
        $this->kInput = new CSInput();
        $this->kOutput = new CSOutput();
        $this->kArray = new CSArray();
        $this->kString = new CSString();
        $this->kDate = new CSDate();
        $this->kInflection = new CSInflection();
        $this->kBCrypt = new CSBCrypt();
        $this->kTemplate = new CSTemplate();
        $this->kOAuth2 = new CSOAuth2();
        $this->kDatabase = new CSDatabase();
        $this->kCast = new CSCast();
        $this->kMath = new CSMath();
        $this->kFile = new CSFile();
        $this->kUtils = new CSUtils();
    }
}
