<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Currency_v2_model
*
* @uses CI_Model
*
* @author Kobus Myburgh <kobus.myburgh@impero.co.za>
*/
class Currency_v2_model extends CI_Model
{
    private $tables;

    public function __construct()
    {
        parent::__construct();
        $this->tables = [
            'currency' => 'maxapi_currency'
        ];
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
            $this->db->insert($this->tables['currency'], $insert_data);
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
        $err = [
            'status' => -1,
            'error' => lang('currency_v2_model_no_currency_found_symbol_by_id')
        ];
        return $err;
    }

    public function getCurrencySymbolByName($currency_name)
    {
        $by = ['currency_name' => $currency_name];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_symbol'];
        }
        $err = [
            'status' => -2,
            'error' => lang('currency_v2_model_no_currency_found_symbol_by_id')
        ];
        return $err;
    }

    public function getCurrencyNameById($currency_id)
    {
        $by = ['currency_id' => $currency_id];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_name'];
        }
        $err = [
            'status' => -3,
            'error' => lang('currency_v2_model_no_currency_found_name_by_id')
        ];
        return $err;
    }

    public function getCurrencyNameBySymbol($currency_symbol)
    {
        $by = ['currency_symbol' => $currency_symbol];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_symbol'];
        }
        $err = [
            'status' => -4,
            'error' => lang('currency_v2_model_no_currency_found_name_by_symbol')
        ];
        return $err;
    }

    public function getCurrencyIdBySymbol($currency_symbol)
    {
        $by = ['currency_symbol' => $currency_symbol];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_id'];
        }
        $err = [
            'status' => -5,
            'error' => lang('currency_v2_model_no_currency_found_id_by_symbol')
        ];
        return $err;
    }

    public function getCurrencyIdByName($currency_name)
    {
        $by = ['currency_name' => $currency_name];
        $currency = $this->currencyGet($by);
        if (!empty($currency['currency'])) {
            return $currency['currency']['currency_id'];
        }
        $err = [
            'status' => -6,
            'error' => lang('currency_v2_model_no_currency_found_id_by_name')
        ];
        return $err;
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
            $data['currency'] = $this->db->get($this->tables['currency'])->row_array();
            return $data;
        }
        $err = [
            'status' => -7,
            'error' => lang('currency_v2_model_no_currency_found_by_args')
        ];
        return $err;
    }

}
