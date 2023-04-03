<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

defined('VALIDATION_ERROR_EMAIL') OR define('VALIDATION_ERROR_EMAIL', -8);
defined('VALIDATION_ERROR_PHONE') OR define('VALIDATION_ERROR_PHONE', -7);

defined('HTTP_OK') OR define('HTTP_OK', 200);
defined('HTTP_CREATED') OR define('HTTP_CREATED', 201);
defined('HTTP_NOT_MODIFIED') OR define('HTTP_NOT_MODIFIED', 304);
defined('HTTP_BAD_REQUEST') OR define('HTTP_BAD_REQUEST', 400);
defined('HTTP_UNAUTHORIZED') OR define('HTTP_UNAUTHORIZED', 401);
defined('HTTP_FORBIDDEN') OR define('HTTP_FORBIDDEN', 403);
defined('HTTP_NOT_FOUND') OR define('HTTP_NOT_FOUND', 404);
defined('HTTP_METHOD_NOT_ALLOWED') OR define('HTTP_METHOD_NOT_ALLOWED', 405);
defined('HTTP_NOT_ACCEPTABLE') OR define('HTTP_NOT_ACCEPTABLE', 406);
defined('HTTP_INTERNAL_ERROR') OR define('HTTP_INTERNAL_ERROR', 500);

/**
 * MaxAPI web services API
 *
 * @copyright Impero Consulting, 2021
 * @package api.Max
 * @category API
 * @version 1.0
 * @link https://www.impero.co.za
 *
 * @access  public
 */
class MaxAPI extends \chriskacerguis\RestServer\RestController
{
    public $ci;
    public $config;

    protected $perPage = 5;
    protected $maxapi_settings;
    protected $prefix = 'maxapi_';
    protected $documentation_url;
    protected $api_key;
    protected $debug;
    protected $currency;
    protected $currency_id;
    protected $date_format;
    protected $methods = [
        'key_put' => ['level' => 10, 'limit' => 100],
        'key_delete' => ['level' => 10],
        'level_post' => ['level' => 10],
        'suspend_post' => ['level' => 10],
        'regenerate_post' => ['level' => 10]
    ];
    protected $http_status = [
        'OK' => HTTP_OK,
        'CREATED' => HTTP_CREATED,
        'METHOD_NOT_ALLOWED' => HTTP_METHOD_NOT_ALLOWED,
        'NOT_MODIFIED' => HTTP_NOT_MODIFIED,
        'BAD_REQUEST' => HTTP_BAD_REQUEST,
        'UNAUTHORIZED' => HTTP_UNAUTHORIZED,
        'FORBIDDEN' => HTTP_FORBIDDEN,
        'NOT_FOUND' => HTTP_NOT_FOUND,
        'NOT_ACCEPTABLE' => HTTP_NOT_ACCEPTABLE,
        'INTERNAL_ERROR' => HTTP_INTERNAL_ERROR
    ];

    public function __construct($currency = 'ZAR', $debug = false)
    {
        parent::__construct();
        $this->ci =& get_instance();
        $this->ci->load->model('MaxAPI_v3_model');
        $this->ci->load->model('Currency_v3_model');
        $this->ci->load->helper('maxapi');
        $this->maxapi_settings = $this->verifySettings();
        $this->documentation_url = site_url() .  '/documentation/errors';
        $this->debug = $debug;
        $this->currency = $currency;
        $this->currency_id = $this->ci->Currency_v3_model->getCurrencyIdBySymbol($this->currency);
        $this->date_format = 'Y-m-d H:i:s';
    }

    private function _set_api_settings_values($temp)
    {
        $final = [];
        if (!empty($temp)) {
            foreach ($temp as $v) {
                if (ctype_digit($v['setting_value'])) {
                    $final[$v['setting_name']] = (int)$v['setting_value'];
                } elseif (is_float($v['setting_value'])) {
                    $final[$v['setting_name']] = (float)$v['setting_value'];
                } else {
                    $final[$v['setting_name']] = $v['setting_value'];
                }
            }
        }

        return $final;
    }

    protected function verifySettings()
    {
        $final = [];
        $api_key = '';

        // Get global API settings. These take the base settings of the API system, and then overwrites them with user's settings for some items.
        $this->ci->db->where('api_key', 'global');
        $temp = $this->ci->db->get('api_settings')->result_array();
        $final = $this->_set_api_settings_values($temp);

        // Get specific key settings - these overwrite globals on a per key basis, if they exist.
        $headers = getallheaders();
        if (!empty($headers['X-API-KEY'])) {
            $api_key = $headers['X-API-KEY'];
        }
        if (empty($api_key)) {
            $api_key = $this->post('X-API-KEY');
        }
        if (empty($api_key)) {
            $api_key = $this->get('X-API-KEY');
        }
        if (!empty($api_key)) {
            $this->ci->db->where('api_key', $api_key);
            $temp = $this->ci->db->get('api_settings')->result_array();
            $final = $this->_set_api_settings_values($temp);
            $this->maxapi_settings = $final;
            $this->api_key = $api_key;
            $this->ci->session->set_userdata('maxapi_settings', $this->maxapi_settings);
        }

        return $final;
    }

    public function verifySettings_get()
    {
        $start_api = microtime(true);
        if (empty($this->maxapi_settings)) {
            $this->verifySettings();
        }
        if (empty($this->api_key)) {
            $this->buildResponse([
                'data' => ['settings' => []],
                'type' => 'success',
                'message' => 'Invalid API key - no settings retrieval possible.',
                'status_code' => 400,
                'log_timestamp' => $start_api
            ]);
        }
        if (!empty($this->maxapi_settings)) {
            $data['data']['settings'] = $this->maxapi_settings;
            $data['data']['api_key'] = $this->api_key;
            $this->buildResponse([
                'data' => $data['data'],
                'type' => 'success',
                'message' => 'Settings for API Key ' . $this->api_key . ' successfully retrieved.',
                'status_code' => 200,
                'log_timestamp' => $start_api
            ]);
        }
        $this->buildResponse([
            'data' => ['settings' => []],
            'type' => 'success',
            'message' => 'Settings for API Key ' . $this->api_key . ' not retrieved.',
            'status_code' => 400,
            'log_timestamp' => $start_api
        ]);
    }

    public function key_put()
    {
        $key = $this->generateKey();
        $level = $this->put('level') ? $this->put('level') : 1;
        $ignore_limits = $this->put('ignore_limits') ? $this->put('ignore_limits') : 1;
        if ($this->insertKey($key, ['level' => $level, 'ignore_limits' => $ignore_limits])) {
            $res['Status']['Message'] = 'Successfully created the API key.';
            $res['Status']['StatusCode'] = RestController::HTTP_CREATED;
            $res['Data']['Key'] = $key;
            $this->response($res, RestController::HTTP_CREATED);
        }
        $res['Status']['Message'] = 'Could not save the key.';
        $res['Status']['StatusCode'] = RestController::HTTP_INTERNAL_SERVER_ERROR;
        $this->response($res, RestController::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function key_delete()
    {
        $key = $this->delete('key');
        if (!$this->keyExists($key)) {
            $res['Status']['Message'] = 'Invalid API key';
            $res['Status']['StatusCode'] = RestController::HTTP_BAD_REQUEST;
            $this->response($res, RestController::HTTP_BAD_REQUEST);
        }
        if (!$this->deleteKey($key)) {
            $res['Status']['Message'] = 'API key could not be deleted.';
            $res['Status']['StatusCode'] = RestController::HTTP_INTERNAL_SERVER_ERROR;
            $this->response($res, RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
        $res['Status']['Message'] = 'API Key was deleted.';
        $res['Status']['StatusCode'] = RestController::HTTP_OK;
        $this->response($res, RestController::HTTP_OK);
    }

    public function level_put()
    {
        $key = $this->put('key');
        $new_level = $this->put('level');
        if (!$this->keyExists($key)) {
            $res['Status']['Message'] = 'Invalid API key';
            $res['Status']['StatusCode'] = RestController::HTTP_BAD_REQUEST;
            $this->response($res, RestController::HTTP_BAD_REQUEST);
        }
        if ($this->updateKey($key, ['level' => $new_level])) {
            $res['Data']['Level'] = (int)$new_level;
            $res['Status']['Message'] = 'API Key was updated.';
            $res['Status']['StatusCode'] = RestController::HTTP_OK;
            $this->response($res, RestController::HTTP_OK);
        }
        $res['Status']['Message'] = 'Could not update the API key level.';
        $res['Status']['StatusCode'] = RestController::HTTP_INTERNAL_SERVER_ERROR;
        $this->response($res, RestController::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function suspend_post()
    {
        $key = $this->post('key');
        if (!$this->keyExists($key)) {
            $res['Status']['Message'] = 'Invalid API key';
            $res['Status']['StatusCode'] = RestController::HTTP_BAD_REQUEST;
            $this->response($res, RestController::HTTP_BAD_REQUEST);
        }
        if ($this->updateKey($key, ['level' => 0])) {
            $res['Status']['Message'] = 'API Key was suspended.';
            $res['Status']['StatusCode'] = RestController::HTTP_OK;
            $this->response($res, RestController::HTTP_OK);
        }
        $res['Status']['Message'] = 'Could not suspend the API key.';
        $res['Status']['StatusCode'] = RestController::HTTP_INTERNAL_SERVER_ERROR;
        $this->response($res, RestController::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function regenerate_post()
    {
        $old_key = $this->post('key');
        if (!$this->keyExists($old_key)) {
            $res['Status']['Message'] = 'Invalid API key';
            $res['Status']['StatusCode'] = RestController::HTTP_BAD_REQUEST;
            $this->response($res, RestController::HTTP_BAD_REQUEST);
        }
        $key_details = $this->getKey($old_key);
        $new_key = $this->generateKey();
        if ($this->insertKey($new_key, ['level' => $key_details->level, 'ignore_limits' => $key_details->ignore_limits])) {
            $this->updateKey($old_key, ['level' => 0]);
            $res['Data']['key'] = $new_key;
            $res['Status']['Message'] = 'API Key was regenerated.';
            $res['Status']['StatusCode'] = RestController::HTTP_CREATED;
            $this->response($res, RestController::HTTP_CREATED);
        }
        $res['Status']['Message'] = 'Could not save the API key.';
        $res['Status']['StatusCode'] = RestController::HTTP_INTERNAL_SERVER_ERROR;
        $this->response($res, RestController::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function generateKey()
    {
        $this->ci->load->helper('security');
        do {
            $salt = do_hash(time() . mt_rand());
            $new_key = substr($salt, 0, $this->ci->config->item('rest_key_length'));
        }
        while ($this->keyExists($new_key));

        return $new_key;
    }

    private function getKey($key)
    {
        return $this->ci->MaxAPI_v3_model->getKey($key);
    }

    private function keyExists($key)
    {
        return $this->ci->MaxAPI_v3_model->keyExists($key);
    }

    private function insertKey($key, $data)
    {
        $data[$this->ci->config->item('rest_key_column')] = $key;
        $data['date_created'] = time();

        return $this->ci->MaxAPI_v3_model->insertKey($data);
    }

    private function updateKey($key, $data)
    {
        return $this->ci->MaxAPI_v3_model->updateKey($key, $data);
    }

    private function deleteKey($key)
    {
        return $this->ci->MaxAPI_v3_model->deleteKey($key);
    }

    protected function setDataMap($data, $map)
    {
        $return = [];
        if (!empty($data) && !empty($map)) {
            foreach ($map as $v) {
                if (isset($data[$v])) {
                    $return[$v] = $data[$v];
                }
            }
        }

        return $return;
    }

    protected function setQuery($queries, $map = true)
    {
        $data = [];
        if (!empty($queries) && is_array($queries)) {
            foreach ($queries as $key => $query) {

                // We have passed a numeric array to $gets, meaning, we do not have key:value pairs, thus assuming that key will equal the get value
                if (is_numeric($key)) {
                    $key = $query;
                }
                $data['queries'][$key] = $this->query($query);
            }
        }
        if (!empty($map)) {
            $data['maps'] = $this->setDataMap($data['queries'], $queries);
        }

        return $data;
    }

    protected function setOptions($options, $map = true)
    {
        $data = [];
        if (!empty($options) && is_array($options)) {
            foreach ($options as $key => $option) {

                // We have passed a numeric array to $gets, meaning, we do not have key:value pairs, thus assuming that key will equal the get value
                if (is_numeric($key)) {
                    $key = $option;
                }
                $data['options'][$key] = $this->options($option);
            }
        }
        if (!empty($map)) {
            $data['maps'] = $this->setDataMap($data['options'], $options);
        }

        return $data;
    }

    protected function setGet($gets, $map = true)
    {
        $data = [];
        if (!empty($gets) && is_array($gets)) {
            foreach ($gets as $key => $get) {

                // We have passed a numeric array to $gets, meaning, we do not have key:value pairs, thus assuming that key will equal the get value
                if (is_numeric($key)) {
                    $key = $get;
                }
                $data['gets'][$key] = $this->get($get);
            }
        }
        if (!empty($map)) {
            $data['maps'] = $this->setDataMap($data['gets'], $gets);
        }

        return $data;
    }

    protected function setPut($puts, $map = true)
    {
        $data = [];
        if (!empty($puts) && is_array($puts)) {
            foreach ($puts as $key => $put) {

                // We have passed a numeric array to $puts, meaning, we do not have key:value pairs, thus assuming that key will equal the put value
                if (is_numeric($key)) {
                    $key = $put;
                }
                $data['puts'][$key] = $this->put($put);
            }
        }
        if (!empty($map)) {
            $data['maps'] = $this->setDataMap($data['puts'], $puts);
        }

        return $data;
    }

    protected function setPatch($patches, $map = true)
    {
        $data = [];
        if (!empty($patches) && is_array($patches)) {
            foreach ($patches as $key => $patch) {

                // We have passed a numeric array to $patches, meaning, we do not have key:value pairs, thus assuming that key will equal the patch value
                if (is_numeric($key)) {
                    $key = $patch;
                }
                $data['patches'][$key] = $this->patch($patch);
            }
        }
        if (!empty($map)) {
            $data['maps'] = $this->setDataMap($data['patches'], $patches);
        }

        return $data;
    }

    protected function setHead($heads, $map = true)
    {
        $data = [];
        if (!empty($heads) && is_array($heads)) {
            foreach ($heads as $key => $head) {

                // We have passed a numeric array to $heads, meaning, we do not have key:value pairs, thus assuming that key will equal the head value
                if (is_numeric($key)) {
                    $key = $head;
                }
                $data['heads'][$key] = $this->head($head);
            }
        }
        if (!empty($map)) {
            $data['maps'] = $this->setDataMap($data['heads'], $heads);
        }

        return $data;
    }

    protected function setPost($posts, $map = true)
    {
        $data = [];
        if (!empty($posts) && is_array($posts)) {
            foreach ($posts as $key => $post) {

                // We have passed a numeric array to $posts, meaning, we do not have key:value pairs, thus assuming that key will equal the post value
                if (is_numeric($key)) {
                    $key = $post;
                }
                $data['posts'][$key] = $this->post($post);
            }
        }
        if (!empty($map)) {
            $data['maps'] = $this->setDataMap($data['posts'], $posts);
        }

        return $data;
    }

    protected function setDelete($deletes, $map = true)
    {
        $data = [];
        if (!empty($deletes) && is_array($deletes)) {
            foreach ($deletes as $key => $delete) {

                // We have passed a numeric array to $deletes, meaning, we do not have key:value pairs, thus assuming that key will equal the delete value
                if (is_numeric($key)) {
                    $key = $delete;
                }
                $data['deletes'][$key] = $this->query($delete);
            }
        }
        if (!empty($map)) {
            $data['maps'] = $this->setDataMap($data['deletes'], $deletes);
        }

        return $data;
    }

    protected function setDebug($start_api)
    {
        if (!empty($start_api)) {
            $end_api = microtime(true);
            $duration_api = number_format(($end_api - $start_api), 2) . ' sec';
            $return = [
                'requestStart' => $start_api,
                'requestEnd' => $end_api,
                'requestDuration' => $duration_api
            ];

            return $return;
        }
        return false;
    }

    protected function buildResponse($data)
    {

        $response = [];
        if (!empty($data['code'])) {
            $response['status']['code'] = $data['code'];
        } elseif (!empty($data['status_code'])) {
            $response['status']['code'] = $data['status_code'];
        } else {
            $response['status']['code'] = 200;
        }
        if (empty($data['type'])) {
            $response['status']['type'] = 'success';
        } else {
            $response['status']['type'] = $data['type'];
        }
        if (!empty($data['message'])) {
            $response['status']['message'] = $data['message'];
        }
        if (isset($data['data'])) {
            $response['data'] = $data['data'];
        }
        if (isset($data['count'])) {
            $response['status']['count'] = $data['count'];
        }
        if (isset($data['currentPage'])) {
            $response['status']['currentPage'] = $data['currentPage'];
        }
        if (isset($data['totalPages'])) {
            $response['status']['totalPages'] = $data['totalPages'];
        }
        if (!empty($data['logTimestamp'])) {
            $response['debug'] = $this->setDebug($data['logTimestamp']);
        }
        if (!empty($data['perPage'])) {
            $response['debug']['perPage'] = $data['perPage'];
        }

        // Remove debug info if not requested - default is on. A falsy value will unset the debug data.
        if (empty($data['debug'])) {
            unset($response['debug']);
        }

        // Remove status info if not requested - default is on. A falsy value will unset the status data.
        if (empty($data['status'])) {
            unset($response['status']);
        }

        // Set error messages if provided.
        if (!empty($data['errors'])) {
            $response['errors'] = $data['errors'];
        }

        // Send the response if requested, otherwise simply return the response data for further processing.
        // If the parameter is not provided, we will send the response as default behaviour. Any non falsy value will send.
        if (!empty($data['sendResponse'])) {
            $this->response($response, $response['status']['code']);
        }

        return $response;
    }

    protected function successResponse($packetData = [])
    {

        // Set sensible defaults.
        if (!empty($packetData['code'])) {
            $code = $packetData['code'];
        } elseif (!empty($packetData['statusCode'])) {
            $code = $packetData['statusCode'];
        } else {
            $code = 200;
        }
        $data['code'] = !empty($packetData['code']) ? $packetData['code'] : $code;
        $data['message'] = !empty($packetData['message']) ? $packetData['message'] : 'Your action was successful!';
        $data['data'] = !empty($packetData['data']) ? $packetData['data'] : [];
        $data['status'] = !empty($packetData['status']) ? $packetData['status'] : true;
        $data['count'] = !empty($packetData['count']) ? $packetData['count'] : 0;
        $data['perPage'] = !empty($packetData['perPage']) ? $packetData['perPage'] : $this->perPage;

        // For non-errors, debug data must be explicitly specified.
        $data['debug'] = !empty($packetData['debug']) ? $packetData['debug'] : false;

        // Pagination
        $data['currentPage'] = !empty($packetData['currentPage']) ? $packetData['currentPage'] : '<not set>';
        $data['totalPages'] = !empty($packetData['totalPages']) ? $packetData['totalPages'] : '<not set>';

        // Default sending the response; pass false if you'd rather return it.
        $data['sendResponse'] = !empty($packetData['sendResponse']) ? $packetData['sendResponse'] : true;

        // For non-errors, logging must be explicitly specified.
        $data['logTimestamp'] = !empty($packetData['logTimestamp']) ? $packetData['logTimestamp'] : false;

        // Pass the data to the response handler.
        $this->buildResponse($data);
    }

    protected function errorResponse($type = 'server', $packetData = [])
    {

        // Set sensible defaults.
        if ($type == 'server') {
            $code = 500;
            if (!empty($packetData['code'])) {
                $code = $packetData['code'];
            }
        } else {
            $code = 400;
            if (!empty($packetData['code'])) {
                $code = $packetData['code'];
            }
            $type = 'user';
        }
        $data['code'] = !empty($packetData['code']) ? $packetData['code'] : $code;
        $data['message'] = 'A ' . $type . ' error occurred - if more error information is present, it will be shown in the `errors` section.';
        $data['data'] = !empty($packetData['data']) ? $packetData['data'] : [];
        $data['debug'] = !empty($packetData['debug']) ? $packetData['debug'] : true;
        $data['status'] = !empty($packetData['status']) ? $packetData['status'] : true;
        $data['type'] = !empty($packetData['type']) ? $packetData['type'] : 'unknown_' . $type . '_error';

        // Default sending the response; pass false if you'd rather return it.
        $data['sendResponse'] = !empty($packetData['sendResponse']) ? $packetData['sendResponse'] : true;

        // Errors always have timestamps logged. This value may be a little off, as we are generating the start time on the fly if not provided.
        $data['logTimestamp'] = !empty($packetData['logTimestamp']) ? $packetData['logTimestamp'] : microtime(true);

        // Prepare error return data.
        if (!empty($packetData['errors'])) {
            foreach ($packetData['errors'] as $k => $v) {
                $data['errors'][$k] = [
                    'code' => !empty($v['code']) ? $v['code'] : $code,
                    'type' => !empty($v['type']) ? $v['type'] : $type,
                    'message' => (!empty($v['message']) ? $v['message'] : 'An unexpected ' . $type . ' error occurred. No additional detail is available at this time. We have been notified of this problem.'),
                    'developerMessage' => (!empty($v['developerMessage']) ? $v['developerMessage'] : 'An unexpected ' . $type . ' error occurred. No additional detail is available at this time. We have been notified of this problem.'),
                    'moreInfo' => $this->documentation_url . '/' . $type,
                    'instance' => $_SERVER['REQUEST_URI']
                ];
            }
        }

        // Pass the data to the response handler.
        $this->buildResponse($data);
    }

    // HELPERS
    protected function dataRetrievedResponse($qData, $data, $resultSet)
    {
        $count = null;
        $limit = null;
        $totalPages = null;
        $currentPage = null;
        if (!empty($data['limit']) && isset($data['start']) && isset($data['returnCount'])) {
            $limit = $data['limit'];
            $count = $data['returnCount'];
            $totalPages = ceil($data['returnCount'] / $data['limit']);
            $currentPage = $totalPages + 1;
        }
        $this->successResponse([
            'debug' => true,
            'count' => $count,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'perPage' => $limit,
            'data' => [$qData['identifier'] => $resultSet],
            'message' => (!empty($qData['message']) ? $qData['message'] : 'Data retrieved successfully.'),
            'code' => (!empty($qData['code']) ? $qData['code'] : 201),
            'status' => (!empty($qData['status']) ? $qData['status'] : 'success'),
            'logTimestamp' => $qData['time']
        ]);
    }

    protected function missingDataResponse($qData)
    {
        $this->errorResponse('user', [
            'data' => [],
            'logTimestamp' => $qData['time'],
            'errors' => [
                [
                    'call' => $qData['identifier'],
                    'type' => (!empty($qData['error_type']) ? $qData['error_type'] : 'get_data_user_error'),
                    'message' => (!empty($qData['message']) ? $qData['message'] : 'Missing parameters.'),
                    'userMessage' => (!empty($qData['userMessage']) ? $qData['userMessage'] : 'Please ensure you provide all the required parameters for this call.'),
                    'developerMessage' => (!empty($qData['developerMessage']) ? $qData['developerMessage'] : 'PEBKAC!'),
                    'code' => (!empty($qData['code']) ? $qData['code'] : 400),
                    'status' => (!empty($qData['status']) ? $qData['status'] : 'error')
                ]
            ]
        ]);
    }

    protected function serverErrorResponse($qData, $data)
    {
        $this->errorResponse('server', [
            'data' => [$qData['identifier'] => $data],
            'log_timestamp' => $qData['time'],
            'errors' => [
                [
                    'type' => $qData['identifier'] . '_server_error',
                    'message' => (!empty($qData['message']) ? $qData['message'] : 'Query error.'),
                    'userMessage' => (!empty($qData['userMessage']) ? $qData['userMessage'] : 'We could not query the API. Please contact support.'),
                    'developerMessage' => (!empty($qData['developerMessage']) ? $qData['developerMessage'] : 'Some work coming up for you, my developer friend. This problem is on your side. Take a deep breath.'),
                    'code' => (!empty($qData['code']) ? $qData['code'] : 500),
                    'status' => (!empty($qData['status']) ? $qData['status'] : 'error')
                ]
            ]
        ]);
    }

    protected function noDataResponse($qData)
    {
        $this->successResponse([
            'debug' => true,
            'count' => 0,
            'totalPages' => 1,
            'currentPage' => 1,
            'data' => [$qData['identifier'] => []],
            'message' => (!empty($qData['message']) ? $qData['message'] : 'Your query returned no data.'),
            'code' => (!empty($qData['code']) ? (int)$qData['code'] : 200),
            'status' => (!empty($qData['status']) ? $qData['status'] : 'success'),
            'logTimestamp' => $qData['time']
        ]);
    }

    protected function userErrorResponse($qData)
    {
        $this->successResponse([
            'debug' => true,
            'count' => 0,
            'totalPages' => 1,
            'currentPage' => 1,
            'data' => [$qData['identifier'] => []],
            'message' => (!empty($qData['message']) ? $qData['message'] : 'A user error occurred. Please contact support if you are sure that all your input parameters are correct.'),
            'code' => (!empty($qData['code']) ? (int)$qData['code'] : 400),
            'status' => (!empty($qData['status']) ? $qData['status'] : 'error'),
            'logTimestamp' => $qData['time']
        ]);
    }

    protected function userErrorResponseNew($qData, $data)
    {
        $this->errorResponse('user', [
            'data' => [$qData['identifier'] => $data],
            'log_timestamp' => $qData['time'],
            'errors' => [
                [
                    'type' => $qData['identifier'] . '_user_error',
                    'message' => (!empty($qData['message']) ? $qData['message'] : 'User Error'),
                    'userMessage' => (!empty($qData['userMessage']) ? $qData['userMessage'] : 'A user error occurred. Please contact support if you are sure that all your input parameters are correct.'),
                    'developerMessage' => (!empty($qData['developerMessage']) ? $qData['developerMessage'] : 'PEBKAC!'),
                    'code' => (!empty($qData['code']) ? $qData['code'] : 400),
                    'status' => (!empty($qData['status']) ? $qData['status'] : 'error')
                ]
            ]
        ]);
    }

    protected function deniedErrorResponse($qData)
    {
        $this->successResponse([
            'debug' => true,
            'count' => 0,
            'totalPages' => 1,
            'currentPage' => 1,
            'data' => [$qData['identifier'] => []],
            'message' => (!empty($qData['message']) ? $qData['message'] : 'Access was denied from the host API for the request.'),
            'code' => (!empty($qData['code']) ? (int)$qData['code'] : 403),
            'status' => (!empty($qData['status']) ? $qData['status'] : 'error'),
            'logTimestamp' => $qData['time']
        ]);
    }

    protected function deniedErrorResponseNew($qData, $data)
    {
        $this->errorResponse('user', [
            'data' => [$qData['identifier'] => $data],
            'log_timestamp' => $qData['time'],
            'errors' => [
                [
                    'type' => $qData['identifier'] . '_user_error',
                    'message' => (!empty($qData['message']) ? $qData['message'] : 'Access Denied'),
                    'userMessage' => (!empty($qData['userMessage']) ? $qData['userMessage'] : 'Access was denied from the host API for the request. You do not have access to this resource.'),
                    'developerMessage' => (!empty($qData['developerMessage']) ? $qData['developerMessage'] : 'PEBKAC!'),
                    'code' => (!empty($qData['code']) ? $qData['code'] : 403),
                    'status' => (!empty($qData['status']) ? $qData['status'] : 'error')
                ]
            ]
        ]);
    }
}
