<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* PayFast_v1_model
*
* @uses CI_Model
*
* @author Kobus Myburgh <kobus.myburgh@impero.co.za>
*/
class PayFast_v1_model extends CI_Model
{
    protected $tables;

    public function __construct()
    {
        parent::__construct();
        $this->date_format = 'Y-m-d H:i:s';
        $this->tables = [
            'payfast' => 'maxapi_payfast'
        ];
    }
}
