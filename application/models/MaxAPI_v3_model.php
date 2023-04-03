<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* MaxAPI_v3_model
*
* @uses CI_Model
*
* @author Kobus Myburgh <kobus.myburgh@impero.co.za>
*/
class MaxAPI_v3_model extends CI_Model
{
    protected $prefix;
    protected $tables;
    protected $date_format =  'Y-m-d H:i:s';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('maxapi');
        $this->settings = $this->session->userdata('maxapi_settings');
        $this->prefix = 'maxapi_';
        $this->tables = [
            'currency' => 'maxapi_currency',
            'country' => 'maxapi_country'
        ];
    }

    public function deleteKey($key)
    {
        $this->db->where($this->config->item('rest_key_column'), $key);
        $this->db->delete($this->config->item('rest_keys_table'));

        return $this->db->affected_rows();
    }

    public function updateKey($key, $data)
    {
        $this->db->where($this->ci->config->item('rest_key_column'), $key);
        $this->db->update($this->ci->config->item('rest_keys_table'), $data);

        return $this->db->affected_rows();
    }

    public function insertKey($data)
    {
        $this->db->insert($this->ci->config->item('rest_keys_table'), $data);

        return $this->db->insert_id();
    }

    public function keyExists($key)
    {
        $this->db->where($this->ci->config->item('rest_key_column'), $key);

        return $this->db->count_all_results($this->ci->config->item('rest_keys_table')) > 0;
    }

    public function getKey($key)
    {
        $this->db->where($this->ci->config->item('rest_key_column'), $key);
        return $this->db->get($this->ci->config->item('rest_keys_table'))->row();
    }
}
