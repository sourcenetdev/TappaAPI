<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* MaxAPI_v2_model
*
* @uses CI_Model
*
* @author Kobus Myburgh <kobus.myburgh@impero.co.za>
*/
class MaxAPI_v2_model extends CI_Model
{
    private $prefix;
    private $tables;
    private $item_table_map;
    protected $date_format =  'Y-m-d H:i:s';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('maxapi');
        $this->settings = $this->session->userdata('maxapi_settings');
        $this->prefix = 'maxapi_';
        $this->tables = [
            'currency' => 'maxapi_currency',
            'country' => 'maxapi_country',
            'fast_product' => 'maxapi_fast_product',
            'fast_addon' => 'maxapi_fast_addon',
            'fast_category' => 'maxapi_fast_category',
            'fast_client' => 'maxapi_fast_client',
            'fast_combo' => 'maxapi_fast_combo',
            'fast_customize' => 'maxapi_fast_customize',
            'fast_extra' => 'maxapi_fast_extra',
            'fast_extra_category' => 'maxapi_fast_extra_category',
            'fast_merchant' => 'maxapi_fast_merchant',
            'fast_order' => 'maxapi_fast_order',
            'fast_order_line' => 'maxapi_fast_order_line',
            'fast_store' => 'maxapi_fast_store'
        ];
        $this->item_table_map = [
            'fast_product' => [
                'table' => $this->tables['fast_product'],
                'id_field' => 'fast_product_id',
                'short_display_field' => 'fast_product_id|fast_category_id|fast_merchant_id|fast_store_id|name|description|dimensions|size|price|code'
            ],
            'fast_addon' => [
                'table' => $this->tables['fast_addon'],
                'id_field' => 'fast_addon_id',
                'short_display_field' => 'fast_addon_id|fast_category_id|fast_merchant_id|fast_store_id|name|description|price|code'
            ],
            'fast_category' => [
                'table' => $this->tables['fast_category'],
                'id_field' => 'fast_category_id',
                'short_display_field' => 'fast_category_id|fast_merchant_id|fast_store_id|name|description'
            ],
            'fast_client' => [
                'table' => $this->tables['fast_client'],
                'id_field' => 'fast_client_id',
                'short_display_field' => 'fast_client_id|fast_merchant_id|fast_store_id|name|phone|email'
            ],
            'fast_combo' => [
                'table' => $this->tables['fast_combo'],
                'id_field' => 'fast_combo_id',
                'short_display_field' => 'fast_combo_id|fast_product_id|fast_merchant_id|fast_store_id|name|price|code'
            ],
            'fast_customize' => [
                'table' => $this->tables['fast_customize'],
                'id_field' => 'fast_customize_id',
                'short_display_field' => 'fast_customize_id|fast_order_id|fast_product_id|fast_merchant_id|fast_store_id|price|code|description'
            ],
            'fast_extra' => [
                'table' => $this->tables['fast_extra'],
                'id_field' => 'fast_extra_id',
                'short_display_field' => 'fast_extra_id|fast_extra_category_id|fast_merchant_id|fast_store_id|name|dimensions|price'
            ],
            'fast_extra_category' => [
                'table' => $this->tables['fast_extra_category'],
                'id_field' => 'fast_extra_category_id',
                'short_display_field' => 'fast_extra_category_id|fast_merchant_id|fast_store_id|name|description'
            ],
            'fast_merchant' => [
                'table' => $this->tables['fast_merchant'],
                'id_field' => 'fast_merchant_id',
                'short_display_field' => 'fast_merchant_id|name|code|phone|email|contact'
            ],
            'fast_order' => [
                'table' => $this->tables['fast_order'],
                'id_field' => 'fast_order_id',
                'short_display_field' => 'fast_order_id|fast_client_id|fast_merchant_id|fast_store_id|special_instructions'
            ],
            'fast_order_line' => [
                'table' => $this->tables['fast_order_line'],
                'id_field' => 'fast_order_line_id',
                'short_display_field' => 'fast_order_line_id|fast_order_id|fast_product_id|fast_customize_id|fast_merchant_id|fast_store_id|special_instructions'
            ],
            'fast_store' => [
                'table' => $this->tables['fast_store'],
                'id_field' => 'fast_store_id',
                'short_display_field' => 'fast_merchant_id|fast_store_id|name|phone|email|contact'
            ],
            'currency' => [
                'table' => $this->tables['currency'],
                'id_field' => 'currency_id',
                'short_display_field' => 'currency_id|currency_name|currency_symbol'
            ],
            'country' => [
                'table' => $this->tables['country'],
                'id_field' => 'country_id',
                'short_display_field' => 'country_id|country_name'
            ]
        ];
    }

    // This search could be more optimal. Perhaps an index of sorts...
    public function searchGet($get_data, $return_compat = 'array')
    {
        $this->settings = $this->session->userdata('maxapi_settings');

        // Validate.
        if (empty($get_data['search'])) {
            $err = [
                'status' => -1,
                'error' => lang('maxapi_v2_model_provide_search')
            ];
            return $err;
        }
        if (isset($this->settings['minimum_search_characters']) && ($this->settings['minimum_search_characters'] > strlen($get_data['search']))) {
            $err = [
                'status' => -2,
                'error' => sprintf(lang('maxapi_v2_model_min_search_characters'), $this->settings['minimum_search_characters'])
            ];
            return $err;
        }
        if (empty($get_data['source'])) {
            $err = [
                'status' => -3,
                'error' => lang('maxapi_v2_model_provide_search_type')
            ];
            return $err;
        }
        $get_data['source'] = trim($get_data['source']);
        if (!isset($this->item_table_map[$get_data['source']])) {
            $err = [
                'status' => -4,
                'error' => lang('maxapi_v2_model_provide_unknown_search_type')
            ];
            return $err;
        }
        if (empty($get_data['match'])) {
            $get_data['match'] = 'both';
        }
        if (empty($get_data['matchtype'])) {
            $get_data['matchtype'] = 'OR';
        }
        if (empty($this->settings['maximum_search_results'])) {
            $limit = 4;
        } else {
            $limit = $this->settings['maximum_search_results'];
        }

        // Get the column names from the table being searched for.
        $columns = $this->db->query('SHOW COLUMNS FROM `' . $this->item_table_map[$get_data['source']]['table'] . '`')->result_array();
        if (!empty($columns)) {

            // We start the search, as we had no errors up to now.
            $this->db->select($this->item_table_map[$get_data['source']]['table'] . '.*');
            $this->db->from($this->item_table_map[$get_data['source']]['table']);
            $extra_cols = [];
            foreach ($columns as $k => $v) {
                if ($get_data['matchtype'] == 'AND') {
                    $this->db->like($this->item_table_map[$get_data['source']]['table'] . '.' . $v['Field'], $get_data['search'], $get_data['match']);
                } elseif ($get_data['matchtype'] == 'OR') {
                    $this->db->or_like($this->item_table_map[$get_data['source']]['table'] . '.' . $v['Field'], $get_data['search'], $get_data['match']);
                }
                if (strpos($v['Field'], '_id') !== false) {
                    $table_name = explode('_id', $v['Field']);
                    $table_exists = $this->db->query('SHOW TABLES LIKE "' . $this->prefix . $table_name[0] . '"')->result_array();
                    if (!empty($table_exists)) {
                        $columns_exist = $this->db->query('SHOW COLUMNS FROM `' . $this->prefix . $table_name[0] .  '`')->result_array();
                        //preint($columns_exist, true);
                        if (!empty($columns_exist)) {
                            foreach ($columns_exist as $kk => $vv) {
                                if ($vv['Field'] == 'name') {
                                    $extra_cols[$this->item_table_map[$get_data['source']]['table']] =
                                        $this->prefix . $table_name[0] . '|' .
                                        $v['Field'] . '|' .
                                        $vv['Field'];
                                }
                            }
                        }
                    }
                }
            }

            if (!empty($extra_cols)) {
                foreach ($extra_cols as $k => $v) {
                    $params = explode('|', $v);
                    $this->db->join($params[0], $params[0] . '.' . $params[1] . ' = ' . $this->item_table_map[$get_data['source']]['table'] . '.' . $params[1], 'left');
                    $this->db->select($params[0] . '.' . $params[2] . ' AS '  . $params[0] . '_' . $params[2]);
                }
            }
            $this->db->limit($limit);
            $results = $this->db->get()->result_array();

            // Default behaviour is returning the result as an array, but for our Landbot interpretation, we do something different.
            // This is to cater for clumsy or non-existing native functionality in Landbot to do array or complex structure processing.
            if (!empty($results)) {
                if (strtolower($return_compat) == 'array') {
                    $data['search_results'] = $results;
                    return $data;
                } elseif (strtolower($return_compat) == 'landbot') {

                    // Now that the search results are in, and we did not return raw in array format, we need to build up the long display string.
                    $final = [];
                    $final['search_full']['short_display_field'] = '';
                    $final['search_full']['long_display_field'] =  '';
                    foreach ($results as $k => $v) {
                        $final['search_results'][$k]['short_display_field'] = '';
                        $final['search_results'][$k]['long_display_field'] =  '';
                        $final['search_results'][$k]['id_field'] = $this->item_table_map[$get_data['source']]['id_field'];
                        $short_fields = explode('|', $this->item_table_map[$get_data['source']]['short_display_field']);
                        $long_fields = array_keys($results[$k]);

                        // This is to make the keys and values the same of the array generated above. Neat trick.
                        $short_fields = array_combine($short_fields, $short_fields);

                        // Build up short and long fields for results.
                        if (!empty($short_fields)) {
                            foreach ($short_fields as $kk => $vv) {
                                if (isset($results[$k][$kk])) {
                                    $final['search_results'][$k]['short_display_field'] .= $results[$k][$kk] . '|';
                                }
                            }
                            $final['search_full']['short_display_field'] .= $final['search_results'][$k]['short_display_field'] . '|';
                        }
                        if (!empty($long_fields)) {
                            foreach ($long_fields as $kk => $vv) {
                                if (isset($results[$k][$vv])) {
                                    $final['search_results'][$k]['long_display_field'] .= $results[$k][$vv] . '|';
                                }
                            }
                            $final['search_full']['long_display_field'] .= $final['search_results'][$k]['long_display_field'] . '|';
                        }
                        $final['search_results'][$k]['short_display_field'] = rtrim($final['search_results'][$k]['short_display_field'], '|');
                        $final['search_results'][$k]['long_display_field'] = rtrim($final['search_results'][$k]['long_display_field'], '|');

                    }
                    $final['search_full']['short_display_field'] = rtrim($final['search_full']['short_display_field'], '||');
                    $final['search_full']['long_display_field'] = rtrim($final['search_full']['long_display_field'], '||');
                    return $final;
                }
            } else {
                $err = [
                    'status' => -5,
                    'error' => lang('maxapi_v2_model_no_search_result')
                ];
                return $err;
            }
        }
    }

}
