<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Currency_model
*
* @uses CI_Model
*
* @author Kobus Myburgh <kobus.myburgh@impero.co.za>
*/
class Currency_model extends CI_Model
{
    private $tables = [
        'maxapi_currency' => 'maxapi_currency'
    ];

    private $date_format =  'Y-m-d H:i:s';

    public function __construct()
    {
        parent::__construct();
        foreach ($this->tables as $k => $v) {
            $this->tables[$k] = $this->db->dbprefix($this->tables[$k]);
        }
    }

    public function currencyAdd($add_data)
    {
        if (empty($add_data['currency_name']) || empty($add_data['currency_symbol']) || empty($add_data['country_id'])) {
            return false;
        }
        if (empty($add_data['currency_active'])) {
            $add_data['currency_active'] = 'No';
        }
        if (!empty($add_data['currency_id'])) {
            $exists_data['currency_id'] = $add_data['currency_id'];
        }
        $exists_data['currency_name'] = $add_data['currency_name'];
        $exists_data['currency_symbol'] = $add_data['currency_symbol'];
        $exists = $this->currencyGet($exists_data);
        if (empty($exists['currency']['currency_id'])) {
            $insert_data = [
                'currency_name' => $add_data['currency_name'],
                'currency_symbol' => $add_data['currency_symbol'],
                'currency_active' => $add_data['currency_active'],
                'country_id' => $add_data['country_id'],
                'create_date' => date($this->date_format),
                'modify_date' => date($this->date_format)
            ];
            $this->db->insert($this->tables['maxapi_currency'], $insert_data);
            $insert_data['currency_id'] = $this->db->insert_id();
            return $insert_data;
        }

        return false;
    }

    public function getCurrencySymbolById($currency_id)
    {
        $by = ['currency_id' => $currency_id];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_symbol'];
        }
        return '';
    }

    public function getCurrencySymbolByName($currency_name)
    {
        $by = ['currency_name' => $currency_name];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_symbol'];
        }
        return '';
    }

    public function getCurrencyNameById($currency_id)
    {
        $by = ['currency_id' => $currency_id];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_name'];
        }
        return '';
    }

    public function getCurrencyNameBySymbol($currency_symbol)
    {
        $by = ['currency_symbol' => $currency_symbol];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_symbol'];
        }
        return '';
    }

    public function getCurrencyIdBySymbol($currency_symbol)
    {
        $by = ['currency_symbol' => $currency_symbol];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_id'];
        }
        return 0;
    }

    public function getCurrencyIdByName($currency_name)
    {
        $by = ['currency_name' => $currency_name];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_id'];
        }
        return 0;
    }

    public function currencyGet($args)
    {
        if (!empty($args) && is_array($args)) {
            foreach ($args as $k => $v) {
                if (!is_array($v)) {
                    if (!empty($v)) {
                        $this->db->where($k, $v);
                    }
                } else {
                    if (!empty($v)) {
                        $this->db->where_in($k, $v);
                    }
                }
            }
            $data['currency'] = $this->db->get($this->tables['maxapi_currency'])->row_array();
            return $data;
        }
        return [];
    }

}
