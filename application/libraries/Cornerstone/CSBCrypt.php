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
 * KyrandiaCMS Cornerstone Library - BCrypt Functions
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

class CSBCrypt
{
    private $rounds;
    private $randomState;

    /**
     * function __construct()
     *
     * Initializes the library
     *
     * @access public
     *
     * @param int $rounds
     *
     * @return void
     */
	public function __construct($rounds = 8)
	{
        if (CRYPT_BLOWFISH != 1) {
            throw new Exception("bcrypt not supported in this installation. See http://php.net/crypt");
        }
        $this->rounds = $rounds;
	}

    /**
     * Function hash()
     *
     * Hashes a string
     *
     * @access public
     *
     * @param string $input
     * @param string $salt;
     *
     * @return string
     */
    public function hash($input, $salt = '')
    {
        if ($salt == '') {
            $hash = crypt($input, $this->getSalt());
        } else {
            $hash = crypt($input, $salt);
        }
        if(strlen($hash) > 13) {
            return $hash;
        }
        return false;
    }

    /**
     * Function verify()
     *
     * Verify a hashed string
     *
     * @access public
     *
     * @param string $input
     * @param string $existingHash;
     *
     * @return bool
     */
    public function verify($input, $existingHash)
    {
        $hash = crypt($input, $existingHash);
        return $hash === $existingHash;
    }

    /**
     * Function returnSalt()
     *
     * Returns the generated salt
     *
     * @access public
     *
     * @return string
     */
    public function returnSalt()
    {
        return $this->getSalt();
    }

    /**
     * Function getSalt()
     *
     * Hashes a string
     *
     * @access public
     *
     * @return string
     */
    private function getSalt()
    {
        $salt = sprintf('$2a$%02d$', $this->rounds);
        $bytes = $this->getRandomBytes(16);
        $salt .= $this->encodeBytes($bytes);
        return $salt;
    }

    /**
     * Function getRandomBytes()
     *
     * Returns a number of random bytes
     *
     * @access public
     *
     * @param int $count
     *
     * @return string
     */
    private function getRandomBytes($count)
    {
        $bytes = '';
        if (function_exists('openssl_random_pseudo_bytes') && (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')) {
            $bytes = openssl_random_pseudo_bytes($count);
        }
        if ($bytes === '' && is_readable('/dev/urandom') && ($hRand = @fopen('/dev/urandom', 'rb')) !== FALSE) {
            $bytes = fread($hRand, $count);
            fclose($hRand);
        }
        if (strlen($bytes) < $count) {
            $bytes = '';
            if ($this->randomState === null) {
                $this->randomState = microtime();
                if(function_exists('getmypid'))
                {
                    $this->randomState .= getmypid();
                }
            }
            for($i = 0; $i < $count; $i += 16) {
                $this->randomState = md5(microtime() . $this->randomState);
                if (PHP_VERSION >= '5')
                {
                    $bytes .= md5($this->randomState, true);
                }
                else
                {
                    $bytes .= pack('H*', md5($this->randomState));
                }
            }
            $bytes = substr($bytes, 0, $count);
        }
        return $bytes;
    }

    /**
     * Function encodeBytes()
     *
     * Encodes the bytes specified in $input.
     *
     * @access public
     *
     * @param string $input
     *
     * @return string
     */
    private function encodeBytes($input)
    {
        $itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $output = '';
        $i = 0;
        do {
            $c1 = ord($input[$i++]);
            $output .= $itoa64[$c1 >> 2];
            $c1 = ($c1 & 0x03) << 4;
            if ($i >= 16) {
                $output .= $itoa64[$c1];
                break;
            }
            $c2 = ord($input[$i++]);
            $c1 |= $c2 >> 4;
            $output .= $itoa64[$c1];
            $c1 = ($c2 & 0x0f) << 2;
            $c2 = ord($input[$i++]);
            $c1 |= $c2 >> 6;
            $output .= $itoa64[$c1];
            $output .= $itoa64[$c2 & 0x3f];
        }
        while (1);
        return $output;
    }
}
