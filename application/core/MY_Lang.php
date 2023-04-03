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
 * This is the MX Lang extension file for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

require APPPATH . "third_party/MX/Lang.php";

class MY_Lang extends MX_Lang
{

    private $languages = array();
    private $special = array('admin');
    private $uri;
    private $default_uri;
    private $lang_code;

    public function __construct()
    {
        parent::__construct();
        global $CFG;
        global $URI;
        global $RTR;
        $this->uri = $URI->uri_string();
        $this->default_uri = $RTR->default_controller;
        $langs = explode('|', config_item('languages_string'));
        if (!empty($langs)) {
            foreach ($langs as $v) {
                $lang = explode(':', $v);
                if (!empty($lang)) {
                    $this->languages[$lang[0]] = $lang[1];
                }
            }
        } else {
            $this->languages['en'] = 'english';
        }
        $uri_segment = $this->get_uri_lang($this->uri);
        $this->lang_code = $uri_segment['lang'];
        $url_ok = false;
        if ((!empty($this->lang_code)) && (array_key_exists($this->lang_code, $this->languages))) {
            $language = $this->languages[$this->lang_code];
            $CFG->set_item('language', $language);
            $url_ok = true;
        }
        if ((!$url_ok) && (!$this->is_special($uri_segment['parts'][0]))) {
            $CFG->set_item('language', $this->languages[$this->default_lang()]);
            $uri = (!empty($this->uri)) ? $this->uri: $this->default_uri;
            $index_url = empty($CFG->config['index_page']) ? '' : $CFG->config['index_page'] . "/";
            $new_url = $CFG->config['base_url'].$index_url.$this->default_lang() . '/' . $uri;
            header("Location: " . $new_url, TRUE, 302);
            exit;
        }
    }

    public function lang()
    {
        global $CFG;
        $language = $CFG->item('language');
        $lang = array_search($language, $this->languages);
        if ($lang) {
            return $lang;
        }
        return NULL;
    }

    public function is_special($lang_code)
    {
        if ((!empty($lang_code)) && (in_array($lang_code, $this->special))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function switch_uri($lang)
    {
        if ((!empty($this->uri)) && (array_key_exists($lang, $this->languages))) {
            if ($uri_segment = $this->get_uri_lang($this->uri)) {
                $uri_segment['parts'][0] = $lang;
                $uri = implode('/', $uri_segment['parts']);
            } else {
                $uri = $lang . '/' . $this->uri;
            }
        }
        return $uri;
    }

    public  function get_uri_lang($uri = '')
    {
        if (!empty($uri)) {
            $uri = ($uri[0] == '/') ? substr($uri, 1) : $uri;
            $uri_expl = explode('/', $uri, 2);
            $uri_segment['lang'] = NULL;
            $uri_segment['parts'] = $uri_expl;
            if (array_key_exists($uri_expl[0], $this->languages)) {
                $uri_segment['lang'] = $uri_expl[0];
            } else {
                $uri_segment['lang'] = $this->default_lang();
            }
        } else {
            $uri_segment['lang'] = $this->default_lang();
        }
        return $uri_segment;
    }

    public function default_lang()
    {
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
        $browser_lang = substr($browser_lang, 0, 2);
        if (empty($browser_lang)) {
            $browser_lang = 'en';
        }
        if (array_key_exists($browser_lang, $this->languages)) {
            return $browser_lang;
        } else {
            reset($this->languages);
            return key($this->languages);
        }
    }

    public function localized($uri)
    {
        if (!empty($uri)) {
            $uri_segment = $this->get_uri_lang($uri);
            if (!$uri_segment['lang']) {
                if ((!$this->is_special($uri_segment['parts'][0])) && (!preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri))) {
                    $uri = $this->lang() . '/' . $uri;
                }
            }
        }
        return $uri;
    }

    public function load($langfile = '', $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '', $load_first_lang = true)
    {
        if ($load_first_lang) {
            reset($this->languages);
            $firstKey = key($this->languages);
            $firstValue = $this->languages[$firstKey];
            if ($this->lang_code != $firstKey) {
                $addedLang = parent::load($langfile, $firstValue, $return, $add_suffix, $alt_path);
                if ($addedLang) {
                    if ($add_suffix) {
                        $langfileToRemove = str_replace('.php', '', $langfile);
                        $langfileToRemove = str_replace('_lang.', '', $langfileToRemove) . '_lang';
                        $langfileToRemove .= '.php';
                    }
                    $this->is_loaded = array_diff($this->is_loaded, array($langfileToRemove));
                }
            }
        }
        return parent::load($langfile, $idiom, $return, $add_suffix, $alt_path);
    }

    public function languify_uri() {
        $lang = $this->get_uri_lang(uri_string());
        if (empty($lang)) {
            $lang['lang'] = '';
        } else {
            $lang['lang'] .= '/';
        }
        return $lang;
    }

}
