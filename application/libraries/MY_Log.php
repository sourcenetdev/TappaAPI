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
 * KyrandiaCMS Monolog Integration
 *
 * This is a monolog wrapper for Kyrandia CMS.
 *
 * @package     Impero
 * @subpackage  Hooks
 * @category    Hooks
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

/*
 * CodeIgniter Monolog integration
 *
 * Version 1.1.1
 * (c) Steve Thomas <steve@thomasmultimedia.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Monolog\Logger;
use Monolog\ErrorHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\IntrospectionProcessor;

/**
 * replaces CI's Logger class, use Monolog instead
 *
 * see https://github.com/stevethomas/codeigniter-monolog & https://github.com/Seldaek/monolog
 *
 */
class CI_Log
{

    // CI log levels
    protected $_levels = [
        'OFF' => '0',
        'ERROR' => '1',
        'DEBUG' => '2',
        'INFO' => '3',
        'ALL' => '4'
    ];

    // Config placeholder
    protected $config = [];


    // Prepare logging environment with configuration variables
    public function __construct()
    {

        // Copied functionality from system/core/Common.php, as the whole CI infrastructure is not available yet
        if (!defined('ENVIRONMENT') OR !file_exists($file_path = APPPATH . 'config/' . ENVIRONMENT . '/monolog.php')) {
            $file_path = APPPATH . 'config/monolog.php';
        }

        // Fetch the config file
        if (file_exists($file_path)) {
            require($file_path);
        } else {
            exit('monolog.php config does not exist');
        }

        // Make $config from config/monolog.php accessible to $this->write_log()
        $this->config = $config;
        $this->log = new Logger($this->config['channel']);

        // Detect and register all PHP errors in this log hence forth
        ErrorHandler::register($this->log);
        if ($this->config['introspection_processor']) {

            // Add controller and line number info to each log message
            $this->log->pushProcessor(new IntrospectionProcessor());
        }

        // Decide which handler(s) to use
        foreach ($this->config['handlers'] as $value) {
            switch ($value) {
                case 'file':
                    $handler = new RotatingFileHandler($this->config['file_logfile']);
                    break;
                case 'localdb':
                    $handler = new LocalDBHandler($this->config['file_logfile']);
                    break;
                default:
                    exit('log handler not supported: ' . $this->config['handler']);
            }
            $this->log->pushHandler($handler);
        }
        $this->write_log('DEBUG', 'Monolog replacement logger initialized');
    }


    /**
     * Write to defined logger. Is called from CodeIgniters native log_message()
     *
     * @param string $level
     * @param $msg
     * @return bool
     */
    public function write_log( $level = 'error', $msg)
    {
        $level = strtoupper($level);

        // Verify error level
        if (!isset($this->_levels[$level])) {
            $this->log->addError('unknown error level: ' . $level);
            $level = 'ALL';
        }

        // Filter out anything in $this->config['exclusion_list']
        if (!empty($this->config['exclusion_list'])) {
            foreach ($this->config['exclusion_list'] as $findme) {
                $pos = strpos($msg, $findme);
                if ($pos !== false) {
                    return true;
                }
            }
        }
        if ($this->_levels[$level] <= $this->config['threshold']) {
            switch ($level) {
                case 'ERROR':
                    $this->log->addError($msg);
                    break;
                case 'DEBUG':
                    $this->log->addDebug($msg);
                    break;
                case 'ALL':
                case 'INFO':
                    $this->log->addInfo($msg);
                    break;
            }
        }
        return true;
    }
}
