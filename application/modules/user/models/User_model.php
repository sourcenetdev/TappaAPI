<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Kyrandia CMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2020, Impero Consulting (Pty) Ltd., all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 */

/**
 * Kyrandia CMS User module
 *
 * This file is the main model for the User module.
 *
 * @package     Impero
 * @subpackage  Modules
 * @category    Models
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 */
class User_model extends CI_Model
{
    protected $tables = [];

    // Session logs.
    private $session_log_list_fields = 's.id, s.code, s.createdate AS `date`, s.message AS `activity`, s.type, s.impact, s.username, s.ip_address';
    private $session_log_search_fields = ['s.message', 's.code', 's.type', 's.impact', 's.username', 's.ip_address'];

    // Users.
    private $user_common_fields = 'u.id, u.username, u.email, u.ip_address, u.salt, u.password, u.temporary_password, u.temporary_password_expires, u.attempts, u.locked, u.welcome_mail, u.active, u.deleted, u.createdate, u.moddate, u.last_login_date';
    private $user_list_fields = 'u.id, u.username, u.email, u.ip_address, u.last_login_date, u.attempts, u.locked, u.active, u.deleted, u.createdate AS `date_created`, u.moddate AS `date_modified`';
    private $user_search_fields = ['u.username', 'u.email', 'u.ip_address', 'r.role', 'u.locked', 'u.active', 'u.deleted'];

    public function __construct()
    {
        parent::__construct();

        // Tables used in this module.
        $this->tables = [
            'user' => _cfg('db_prefix') . 'user',
            'user_profile' => _cfg('db_prefix') . 'user_profile',
            'metadata' => _cfg('db_prefix') . 'metadata',
            'user_session_log' => _cfg('db_prefix') . 'user_session_log',
            'user_role' => _cfg('db_prefix') . 'user_role',
            'role' => _cfg('db_prefix') . 'role'
        ];
    }

    /**
     * get_user_count
     *
     * Gets the number of users in the database
     *
     * @access public
     *
     * @param bool $active_only
     * @param string $search
     *
     * @return array
     */
    public function get_user_count($active_only = true, $search = '')
    {
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['user'] . ' u');
        _set_db_where($active_only, ['u.active' => 'Yes', 'u.deleted' => 'No']);
        _set_db_or_like($search, $this->user_search_fields);
        return $this->db->get()->result_array();
    }

    public function get_user_list($start, $end, $excludes = [], $search = '', $order = '')
    {
        $this->db->distinct();
        $this->db->select($this->user_list_fields);
        $this->db->from($this->tables['user'] . ' u');
        $this->db->join($this->tables['user_profile'] . ' up', 'up.user_id =  u.id', 'left');
        if (!empty($excludes)) {
            $this->db->join($this->tables['user_role'] . ' ur', 'ur.user_id = u.id', 'left');
            $this->db->join($this->tables['role'] . ' r', 'r.id = ur.role_id', 'left');
            foreach ($excludes as $v) {
                $this->db->not_like('r.role', $v, 'after');
            }
        }
        _set_db_or_like($search, $this->user_search_fields);
        _set_db_order($order);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * get_user
     *
     * Queries the database for a user, and returns it.
     *
     * @access public
     *
     * @param string $field
     * @param string $value
     * @param bool $active_only
     *
     * @return array
     */
    public function get_user($field, $value, $active_only = false)
    {
        _set_db_where($active_only, ['active' => 'Yes', 'deleted' => 'No']);
        $this->db->select($this->user_common_fields);
        $this->db->where($field, $value);
        $this->db->from($this->tables['user'] . ' u');
        return $this->db->get()->result_array();
    }

    /**
     * get_user_by_id
     *
     * Queries the database for a user, and returns it (by id).
     *
     * @access public
     *
     * @param int $id
     * @param bool $active_only
     *
     * @return array
     */
    public function get_user_by_id($id, $active_only = false)
    {
        return $this->get_user('u.id', $id, $active_only);
    }

    /**
     * get_user_by_email
     *
     * Queries the database for a user, and returns it (by email).
     *
     * @access public
     *
     * @param string $email
     * @param bool $active_only
     *
     * @return array
     */
    public function get_user_by_email($email, $active_only = false)
    {
        return $this->get_user('u.email', $email, $active_only);
    }

    /**
     * get_user_by_username
     *
     * Queries the database for a user, and returns it (by username).
     *
     * @access public
     *
     * @param string $username
     * @param bool $active_only
     *
     * @return array
     */
    public function get_user_by_username($username, $active_only = false)
    {
        return $this->get_user('u.username', $username, $active_only);
    }

    /**
     * add_user_inactive
     *
     * Adds a user, but does not notify or make active.
     *
     * @access public
     *
     * @param array $data
     *
     * @return array
     */
    public function add_user_inactive($data)
    {
        $data['active'] = 'No';
        $data['welcome_mail'] = 'No';
        return $this->add_user($data);
    }

    /**
     * add_user
     *
     * Adds a user.
     *
     * @access public
     *
     * @param array $data
     *
     * @return array
     */
    public function add_user($data)
    {
        $salt = _get_salt();
        $hash = _hash(_cfg('encryption_key') . $data['password'], $salt);
        if (empty($data['welcome_mail'])) {
            $insert['welcome_mail'] = 'No';
        } else {
            $insert['welcome_mail'] = $data['welcome_mail'];
        }
        if (empty($data['locked'])) {
            $insert['locked'] = 'No';
        } else {
            $insert['locked'] = $data['locked'];
        }
        if (empty($data['active'])) {
            $insert['active'] = 'Yes';
        } else {
            $insert['active'] = $data['active'];
        }
        $insert['username'] = $data['username'];
        $insert['email'] = $data['email'];
        $insert['createdate'] = date('Y-m-d H:i:s');
        $insert['moddate'] = date('Y-m-d H:i:s');
        $insert['password'] = $hash;
        $insert['salt'] = $salt;
        $this->db->insert($this->tables['user'], $insert);
        $insert_id = $this->db->insert_id();
        $role_count = 0;
        if (!empty($data['roles'])) {
            foreach ($data['roles'] as $k => $v) {
                $test = $this->role_model->add_user_role($insert_id, $v);
                if (!empty($test)) {
                    $role_count++;
                }
            }
        }
        if (!empty($data['profile'])) {
            $profile_id = $this->add_user_profile($insert_id, $data['profile']);
        }
        $return_data['insert_id'] = $insert_id;
        $return_data['role_count'] = $role_count;
        if (!empty($profile_id)) {
            $return_data['profile_id'] = $profile_id;
        }
        if (_cfg('audit') == 'Yes') {
            $return_data['audit']['user'] = json_encode($insert);
            if (!empty($data['profile'])) {
                $return_data['audit']['profile'] = json_encode($data['profile']);
            }
            if (!empty($data['roles'])) {
                $return_data['audit']['roles'] = json_encode($data['roles']);
            }
            if (!empty($role_count)) {
                $return_data['audit']['role_count'] = $role_count;
            }
        }
        return $return_data;
    }

    /**
     * add_user_profile
     *
     * Adds a user profile.
     *
     * @access public
     *
     * @param int $id
     * @param array $data
     *
     * @return int
     */
    public function add_user_profile($id, $data)
    {
        $insert['createdate'] = date('Y-m-d H:i:s');
        $insert['moddate'] = date('Y-m-d H:i:s');
        $insert['user_id'] = $id;
        $insert['first_name'] = !empty($data['first_name']) ? $data['first_name'] : '';
        $insert['initials'] = !empty($data['initials']) ? $data['initials'] : '';
        $insert['last_name'] = !empty($data['last_name']) ? $data['last_name'] : '';
        $insert['date_of_birth'] = !empty($data['date_of_birth']) ? $data['date_of_birth'] : '';
        $insert['hobbies'] = !empty($data['hobbies']) ? $data['hobbies'] : '';
        $insert['active'] = 'Yes';
        $insert['deleted'] = 'No';
        $this->db->insert($this->tables['user_profile'], $data);
        return $this->db->insert_id();
    }

    /**
     * edit_user
     *
     * Changes a user.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    function edit_user($data)
    {
        $update_data['username'] = $data['username'];
        $update_data['email'] = $data['email'];
        $update_data['locked'] = $data['locked'];
        $update_data['active'] = $data['active'];
        $update_data['moddate'] = date('Y-m-d H:i:s');
        if (!empty(trim($data['password']))) {
            $salt = $this->get_user_salt($data['id']);
            if (!empty($salt['salt'])) {
                $hash = _hash(_cfg('encryption_key') . $data['password'], $salt['salt']);
            }
            $update_data['password'] = $hash;
        }
        $this->db->where('id', $data['id']);
        $this->db->update($this->tables['user'], $update_data);
        $return_data['affected_rows'] = $this->db->affected_rows();
        $role_count = 0;
        if (!empty($data['roles'])) {
            $this->role_model->delete_user_roles($data['id']);
            foreach ($data['roles'] as $k => $v) {
                $test = $this->role_model->add_user_role($data['id'], $v);
                if (!empty($test)) {
                    $role_count++;
                }
            }
        }
        if (!empty($data['profile'])) {
            $return_data['profile_id'] = $data['profile'][0]['profile_id'];
        } else {
            $data['profile'] = [];
        }
        $return_data['role_count'] = $role_count;
        if (_cfg('audit') == 'Yes') {
            $return_data['audit']['user'] = json_encode($update_data);
            $return_data['audit']['profile'] = json_encode($data['profile']);
            $return_data['audit']['roles'] = json_encode($data['roles']);
            $return_data['audit']['role_count'] = $return_data['role_count'];
        }
        return $return_data;
    }

    public function change_temporary_password($uid, $hash)
    {
        $new_time = date("Y-m-d H:i:s", strtotime('+' . _cfg('temp_password_validity') . ' hours'));
        $update_data = [
            'temporary_password' => $hash,
            'temporary_password_expires' => $new_time
        ];
        $this->db->where('id', $uid);
        $this->db->update($this->tables['user'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * edit_user_profile
     *
     * Changes a user's profile.
     *
     * @access public
     *
     * @param int $id
     * @param array $data
     *
     * @return int
     */
    public function edit_user_profile($id, $data)
    {
        $update_data['moddate'] = date('Y-m-d H:i:s');
        $update_data['user_id'] = $id;
        $update_data['first_name'] = !empty($data['first_name']) ? $data['first_name'] : '';
        $update_data['initials'] = !empty($data['initials']) ? $data['initials'] : '';
        $update_data['last_name'] = !empty($data['last_name']) ? $data['last_name'] : '';
        $update_data['date_of_birth'] = !empty($data['date_of_birth']) ? $data['date_of_birth'] : '';
        $update_data['hobbies'] = !empty($data['hobbies']) ? $data['hobbies'] : '';
        $update_data['active'] = 'Yes';
        $update_data['deleted'] = 'No';
        $this->db->where('user_id', $id);
        $this->db->update($this->tables['user_profile'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * get_session_log_list
     *
     * Gets a list of session log items for display in ajax listings.
     *
     * @access public
     *
     * @param int $start
     * @param int $end
     * @param string $search
     * @param string $order
     *
     * @return array
     */
    public function get_session_log_list($start, $end, $search = '', $order = '')
    {
        $this->db->select($this->session_log_list_fields);
        $this->db->from($this->tables['user_session_log'] . ' s');
        $this->db->where('user_id', _sess_get('id'));
        if (empty($order)) {
            $this->db->order_by('createdate', 'desc');
        } else {
            _set_db_order($order);
        }
        _set_db_or_like($search, $this->session_log_search_fields);
        $this->db->limit($end, $start);
        return $this->db->get()->result_array();
    }

    /**
     * get_session_log_count
     *
     * Gets the number of session logs in the database
     *
     * @access public
     *
     * @param bool $active_only
     * @param string $search
     *
     * @return array
     */
    public function get_session_log_count($search = '')
    {
        $sess = $this->session->userdata();
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from($this->tables['user_session_log'] . ' s');
        $this->db->group_start();
        $this->db->or_where('s.user_id', $sess['id']);
        $this->db->or_where('s.username', $sess['username']);
        $this->db->group_end();
        unset($sess);
        _set_db_or_like($search, $this->session_log_search_fields);
        return $this->db->get()->result_array();
    }


    /**
     * set_password_from_temp
     *
     * Updates a user's password from temporary password.
     *
     * @access public
     *
     * @param string $username
     * @param string $password
     *
     * @return int
     */
    public function set_password_from_temp($username, $password)
    {
        $data['password'] = $password;
        $this->db->where('username', $username);
        $this->db->update($this->tables['user'], $data);
        return $this->db->affected_rows();
    }

    /**
     * unset_temp
     *
     * Removes a temporary password from the user table.
     *
     * @access public
     *
     * @param string $username
     *
     * @return int
     */
    public function unset_temp($username)
    {
        $data['temporary_password'] = '';
        $data['temporary_password_expires'] = '0000-00-00 00:00:00';
        $this->db->where('username', $username);
        $this->db->update($this->tables['user'], $data);
        return $this->db->affected_rows();
    }

    /**
     * get_admin_password
     *
     * Retrieves the admin's password.
     *
     * @access public
     *
     * @return array
     */
    public function get_admin_pass()
    {
        $this->db->select('password, salt');
        $this->db->from($this->tables['user']);
        $this->db->where('id', 1);
        return $this->db->get()->result_array();
    }

    /**
     * get_user_pass
     *
     * Retrieves a user's password.
     *
     * @access public
     *
     * @param int $uid
     *
     * @return array
     */
    public function get_user_pass($uid)
    {
        $this->db->select('password, salt');
        $this->db->from($this->tables['user']);
        $this->db->where('id', $uid);
        return $this->db->get()->result_array();
    }

    /**
     * change_password
     *
     * Changes a user's password.
     *
     * @access public
     *
     * @param int $uid
     * @param string $hash
     *
     * @return array
     */
    public function change_password($uid, $hash)
    {
        $update_data = [
            'password' => $hash,
            'attempts' => 0,
            'temporary_password' => '',
            'moddate' => date('Y-m-d H:i:s'),
            'temporary_password_expires' => '0000-00-00 00:00:00',
            'locked' => 'No'
        ];
        $this->db->where('id', $uid);
        $this->db->update($this->tables['user'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * unset_temporary_password
     *
     * Unsets a user's temporary password after logging in.
     *
     * @access public
     *
     * @param int $uid
     *
     * @return int
     */
    public function unset_temporary_password($uid)
    {
        $update_data = [
            'temporary_password_expires' => '0000-00-00 00:00:00',
            'temporary_password' => '',
            'moddate' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', $uid);
        $this->db->update($this->tables['user'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * update_user_password_from_temporary_password
     *
     * Sets the user's new password to the temporary password when logged in as such.
     *
     * @access public
     *
     * @param array $data
     *
     * @return int
     */
    public function update_user_password_from_temporary_password($data)
    {
        $update_data = [
            'password' => $data['temporary_password']
        ];
        $this->db->where('id', $data['id']);
        $this->db->update($this->tables['user'], $update_data);
        return $this->db->affected_rows();
    }

    /**
     * Function get_user_salt
     *
     * Retrieves the user's salt form the database.
     *
     * @access private
     *
     * @param int $id
     *
     * @return string
     */
    private function get_user_salt($id)
    {
        $this->db->select('salt');
        $this->db->from($this->tables['user']);
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }

    // CONTINUE FROM HERE!

    /* FRONT-END MANAGEMENT TOOLS - A LOT OF THIS IS CRAP THAT IS NOT USED ANYMORE */
    public function activate_user_by_email($email, $roles = [])
    {
        $sql = "
            UPDATE " . _cfg('db_prefix') . "user
            SET `active` = 'Yes'
            WHERE `email` = ?
            LIMIT 1
        ";
        $sql_array = array($email);
        $q = $this->db->query($sql, $sql_array);
        $x = $this->db->affected_rows();
        if (!empty($roles) && $x)
        {
            $sql = "
                SELECT `id` FROM " . _cfg('db_prefix') . "user
                WHERE `email` = ?
                LIMIT 1
            ";
            $sql_array = array($email);
            $q = $this->db->query($sql, $sql_array);
            $temp = $q->result_array();
            if (!empty($temp))
            {
                $sql = "
                    DELETE FROM " . _cfg('db_prefix') . "user_role
                    WHERE `user_id` = ?
                    LIMIT 1
                ";
                $sql_array = array($temp[0]['id']);
                $q = $this->db->query($sql, $sql_array);
                foreach ($roles as $role)
                {
                    $sql = "
                        INSERT INTO " . _cfg('db_prefix') . "user_role
                        (`user_id`, `role_id`, `access_date`, `access_given_by`, `access_revoked_by`, `active`, `active_until`, `createdate`, `moddate`)
                        VALUES (?, ?, NOW(), 1, 0, 'Yes', ?, NOW(), NOW())
                    ";
                    $until = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s", time()) . "+ 1 year"));
                    $sql_array = array($temp[0]['id'], $role, $until);
                    $q = $this->db->query($sql, $sql_array);
                }
            }
        }
        return $x;
    }

    public function update_user_latest_session($data)
    {
        $sql = "
            UPDATE `" . _cfg('db_prefix') . "user`
            SET `last_login_date` = ?, `ip_address` = ?
            WHERE `id` = ?
        ";
        $sql_array = array($data['login_date'], $data['ip_address'], $data['user_id']);
        $q = $this->db->query($sql, $sql_array);
        return $this->db->affected_rows();
    }

    public function reset_attempts($data)
    {
        $sql = "
            UPDATE `" . _cfg('db_prefix') . "user`
            SET `attempts` = 0
            WHERE `id` = ?
        ";
        $sql_array = array($data['user_id']);
        $q = $this->db->query($sql, $sql_array);
        return $this->db->affected_rows();
    }

    public function get_user_profiles($id, $type = '', $default = 'Yes')
    {
        $sql = "
            SELECT up.id, p.value AS name, up.default, up.profile_type_id, up.user_id
            FROM `" . _cfg('db_prefix') . "metadata` p
            LEFT JOIN `" . _cfg('db_prefix') . "user_profile_types` up
            ON up.profile_type_id = p.id
            WHERE up.active = 'Yes'
            AND p.active = 'Yes'
            AND up.user_id = ?
            AND p.type = 'usertype'
        ";
        if ($default == 'Yes')
        {
            $sql .= " AND up.default = 'Yes' ";
        }
        $sql_array = array($id);
        if (!empty($type))
        {
            $sql .= "
                AND p.value = ?
            ";
            $sql_array[] = $type;
        }
        $q = $this->db->query($sql, $sql_array);
        return $q->result_array();
    }

    public function get_field_unique($field, $value, $exclude = '', $table = 'user')
    {
        $sql = "
            SELECT `" . $field . "`, `id`
            FROM `" . _cfg('db_prefix') . $table . "`
            WHERE `" . $field . "` = ?
        ";
        $sql_array = array($value);
        if (!empty($exclude))
        {
            $sql .= "AND `id` != ? ";
            $sql_array[] = $exclude;
        }
        $q = $this->db->query($sql, $sql_array);
        return $q->result_array();
    }

    function delete($affected = array(), $type = 'soft')
    {
        if (!empty($affected))
        {
            if ($type == 'soft')
            {
                foreach ($affected as $k => $v)
                {
                    if (!empty($v['field']) && !empty($v['value']))
                    {
                        $sql = "
                            UPDATE `" . $v['table'] . "`
                            SET `active` = 'No', `deleted` = 'Yes'
                            WHERE `" . $v['field'] . "` = ?
                        ";
                        $sql_array = array($v['value']);
                        $q = $this->db->query($sql, $sql_array);
                    }
                }
                return true;
            }
            else
            {
                foreach ($affected as $k => $v)
                {
                    if (!empty($v['field']) && !empty($v['value']))
                    {
                        $sql = "
                            DELETE FROM `" . $v['table'] . "`
                            WHERE `" . $v['field'] . "` = ?
                        ";
                        $sql_array = array($v['value']);
                        $q = $this->db->query($sql, $sql_array);
                    }
                }
                return true;
            }
        }
        return false;
    }

    function get_count($table, $search = '')
    {
        $sql = "
            SELECT COUNT(`id`) AS `count`
            FROM `" . $table['name'] . "`
            WHERE 1 = 1
        ";
        $sql_array = array();
        if ($search != '')
        {
            if (!empty($table['fields']))
            {
                $sql .= ' AND (';
                foreach ($table['fields'] as $k => $v)
                {
                    $sql .= "`" . $v . "` LIKE CONCAT('%', ?, '%') OR ";
                    $sql_array[] = $search;
                }
                $sql = rtrim($sql, 'OR ') . ')';
            }
        }
        if (!empty($table['sid'][0]))
        {
            $sql .= ' AND `' . $table['sid'][0] . '` = ? ';
            $sql_array[] = $table['sid'][1];
        }
        $q = $this->db->query($sql, $sql_array);
        return $q->result_array();
    }

}

// END User_model class

/* End of file user_model.php */
/* Location: ./application/modules/user/models/user_model.php */
