<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Tappa_model
*
* @uses CI_Model
*
* @author Kobus Myburgh <kobus.myburgh@impero.co.za>
*/
class Tappa_model extends CI_Model
{
    private $tables = [
    ];

    public function __construct()
    {
        parent::__construct();
        foreach ($this->tables as $k => $v) {
            $this->tables[$k] = $this->db->dbprefix($this->tables[$k]);
        }
    }

    private function updateWhere($data)
    {
        if (!empty($data) && is_array($data)) {
            foreach ($data as $k => $v) {
                if (!is_array($v)) {
                    $this->db->like($k, $v);
                } else {
                    $this->db->where_in($k, $v);
                }
            }
        }
    }
}
