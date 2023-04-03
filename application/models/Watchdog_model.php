<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * M_watchdog
 *
 * @author Kobus Myburgh
 */

class Watchdog_model extends CI_Model
{
    private $table_names = [
        'watchdog' => 'watchdog_log'
    ];

    /**
     * __construct
     *
     * Initializes the class.
     *
     * @access public
     *
     * @return array
     */
    public function __construct()
    {
        parent::__construct();
        foreach($this->table_names as $key => $value) {
            $this->table_names[$key] = $this->db->dbprefix($value);
        }
    }

    /**
     * getWatchdogData
     *
     * Retrieves data built up into the Watchdog Data array - ready for writing to the DB. Some modification is needed to this function
     * and related functions to store student type and other data as well, as joining tables on the log entries is not always making sense.
     *
     * @access public
     *
     * @param array $args
     * @param bool $parentsOnly
     * @param int $start
     * @param mixed $limit
     * @param string $order_by
     * @param string $order_dir
     *
     * @return array
     */
    public function getWatchdogData($args = [], $parentsOnly = true, $start = 0, $limit = null, $order_by = 'date', $order_dir = 'desc')
    {
        $log_db = $this->load->database('log', true);
        foreach ($args as $field => $value) {
            if (strpos($field, 'NOT IN')) {
                $where_part = is_array($value) ? '_not_in' : '';
                $log_db->{'where' . $where_part}(trim(str_replace('NOT IN', '', $field)), $value);
            } else {
                $where_part = is_array($value) ? '_in' : '';
                $log_db->{'where' . $where_part}($field, $value);
            }
        }
        if (!empty($parentsOnly)) {
            $log_db->where('w.parent_id IS NULL', null, false);
        }
        if (!empty($start)) {
            $log_db->limit($limit, $start);
        }
        if (!empty($order_by)) {
            $log_db->order_by($order_by, $order_dir);
        }
        $log_db->select('
            w.id, w.user_id, w.reference_id, w.watchdog_id, w.title, w.date, w.action_user_id,
            w.reference_type, w.file, w.class, w.line, w.function, w.args, w.data
        ');
        $data = $log_db->get($this->table_names['watchdog'] . ' w')->result_array();

        return $data;
    }

    /**
     * getWatchdogDataTotal
     *
     * Retrieves the count of data built up into the Watchdog Data array - ready for writing to the DB. Some modification is needed to this
     * function and related functions to store student type and other data as well, as joining tables on the log entries is not always making sense.
     *
     * @access public
     *
     * @param array $args
     * @param bool $parentsOnly
     *
     * @return int
     */
    public function getWatchdogDataTotal($args = [], $parentsOnly = true)
    {
        $log_db = $this->load->database('log', true);
        foreach ($args as $field => $value) {
            if (strpos($field, 'NOT IN')) {
                $where_part = is_array($value) ? '_not_in' : '';
                $log_db->{'where' . $where_part}(trim(str_replace('NOT IN', '', $field)), $value);
            } else {
                $where_part = is_array($value) ? '_in' : '';
                $log_db->{'where' . $where_part}($field, $value);
            }
        }
        if (!empty($parentsOnly)) {
            $log_db->where('parent_id IS NULL', null, false);
        }
        $log_db->select('COUNT(*) AS `total`');
        $data = $log_db->get($this->table_names['watchdog'] . ' w')->row_array()['total'];

        return $data;
    }

    /**
     * getWatchdogDetailData
     *
     * Retrieves data built up into the Watchdog Data Details array - ready for writing to the DB. Some modification is needed to this function
     * and related functions to store student type and other data as well, as joining tables on the log entries is not always making sense.
     *
     * @access public
     *
     * @param array $args
     * @param int $start
     * @param mixed $limit
     * @param string $order_by
     * @param string $order_dir
     *
     * @return array
     */
    public function getWatchdogDetailData($args = [], $options = [], $start = 0, $limit = null, $order_by = 'date', $order_dir = 'desc')
    {
        if (is_array($options) && !empty($options)) {
            $log_db = $this->load->database('log', true);
            $this->datatable->setLogDBSearchParameters($log_db, $options);
            foreach ($args as $field => $value) {
                if (strpos($field, 'NOT IN')) {
                    $where_part = is_array($value) ? '_not_in' : '';
                    $log_db->{'where' . $where_part}(trim(str_replace('NOT IN', '', $field)), $value);
                } else {
                    $where_part = is_array($value) ? '_in' : '';
                    $log_db->{'where' . $where_part}($field, $value);
                }
            }
            $log_db->limit($limit, $start);
            if (!empty($order_by)) {
                $log_db->order_by($order_by, $order_dir);
            }
            $log_db->select('
                w.id, w.user_id, w.reference_id, w.watchdog_id, w.title, w.date, w.file, w.data,
                w.reference_type, w.class, w.line, w.function, w.args, w.backtrace_data, w.diff_data,
                w.data, w.cookie_data, w.session_data, w.post_data, w.parent_id, w.get_data, w.action_user_id
            ');
            $data = $log_db->get($this->table_names['watchdog'] . ' w')->result_array();

            return $data;
        }

        return [];
    }

    /**
     * getWatchdogDetailDataTotal
     *
     * Retrieves the total of detail data built up into the Watchdog Data array - ready for writing to the DB. Some modification is needed to this
     * function and related functions to store student type and other data as well, as joining tables on the log entries is not always making sense.
     *
     * @access public
     *
     * @param int $parent_id
     * @param int $start
     * @param int $limit
     *
     * @return array
     */
    public function getWatchdogDetailDataTotal($parent_id, $start = 0, $limit = null)
    {
        $log_db = $this->load->database('log', true);
        $log_db->where('parent_id', $parent_id);
        $log_db->select('COUNT(*) AS `total`');
        $log_db->limit($limit, $start);
        $data = $log_db->get($this->table_names['watchdog'])->row_array()['total'];

        return $data;
    }
}
