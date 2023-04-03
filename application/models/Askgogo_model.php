<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Askgogo_model
*
* @uses CI_Model
*
* @author Kobus Myburgh <kobus.myburgh@impero.co.za>
*/
class Askgogo_model extends CI_Model
{
    private $tables = [
        'gogo_symptom' => 'kcms_askgogo_symptom',
        'gogo_contra' => 'kcms_askgogo_contra',
        'gogo_ranking' => 'kcms_askgogo_ranking',
        'gogo_formulation' => 'kcms_askgogo_formulation',
        'gogo_otc' => 'kcms_askgogo_otc'
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

    public function getSymptomCount($data)
    {
        $return = [];
        if (!empty($data) && is_array($data)) {
            $this->updateWhere($data);
            $return = $this->db->get($this->tables['gogo_symptom'])->num_rows();
        }

        return $return;
    }

    public function getSymptom($data, $start = 0, $end = null)
    {
        $return = [];
        if (!empty($data) && is_array($data)) {
            $this->updateWhere($data);
            $this->db->limit($end, $start);
            $return = $this->db->get($this->tables['gogo_symptom'])->result_array();
        }

        return $return;
    }

    public function getOTCCount($data)
    {
        $return = [];
        if (!empty($data) && is_array($data)) {
            $this->updateWhere($data);
            $return = $this->db->get($this->tables['gogo_otc'])->num_rows();
        }

        return $return;
    }

    public function getOTC($data, $start = 0, $end = null)
    {
        $return = [];
        if (!empty($data) && is_array($data)) {
            $this->updateWhere($data);
            $this->db->limit($end, $start);
            $return = $this->db->get($this->tables['gogo_otc'])->result_array();
        }

        return $return;
    }

    public function getFormulationCount($data)
    {
        $return = [];
        if (!empty($data) && is_array($data)) {
            $this->updateWhere($data);
            $return = $this->db->get($this->tables['gogo_formulation'])->num_rows();
        }

        return $return;
    }

    public function getFormulation($data, $start = 0, $end = null)
    {
        $return = [];
        if (!empty($data) && is_array($data)) {
            $this->updateWhere($data);
            $this->db->limit($end, $start);
            $return = $this->db->get($this->tables['gogo_formulation'])->result_array();
        }

        return $return;
    }

    public function getRankingCount($data)
    {
        $return = [];
        if (!empty($data) && is_array($data)) {
            $this->updateWhere($data);
            $return = $this->db->get($this->tables['gogo_ranking'])->num_rows();
        }

        return $return;
    }

    public function getRanking($data, $start = 0, $end = null)
    {
        $return = [];
        if (!empty($data) && is_array($data)) {
            $this->updateWhere($data);
            $this->db->limit($end, $start);
            $return = $this->db->get($this->tables['gogo_ranking'])->result_array();
        }

        return $return;
    }

    public function getContraCount($data)
    {
        $return = [];
        if (!empty($data) && is_array($data)) {
            $this->updateWhere($data);
            $return = $this->db->get($this->tables['gogo_contra'])->num_rows();
        }

        return $return;
    }

    public function getContra($data, $start = 0, $end = null)
    {
        $return = [];
        if (!empty($data) && is_array($data)) {
            $this->updateWhere($data);
            $this->db->limit($end, $start);
            $return = $this->db->get($this->tables['gogo_contra'])->result_array();
        }

        return $return;
    }
}
