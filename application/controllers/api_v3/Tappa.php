<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/controllers/api_v3/MaxAPI.php');

/**
 * MaxAPI web services API
 *
 * @copyright Impero Consulting, 2021
 * @package api.Max
 * @category API
 * @version 2.0
 * @link https://www.impero.co.za
 *
 * @access  public
 */
class Tappa extends MaxAPI
{
    public $ci;
    protected $debug = false;
    // private $TAUserName = 'TSO_TappaMarket_UAT_User';
    // private $TASolutionSetName = 'TSO_TappaMarketplace_AGSS';
    // private $TASolutionSetVersion = '8';
    // private $TAPassWord = 'Ta#^hgvM)p01G';
    // private $TABaseUrl = 'https://deservices-UAT.transunion.co.za/DE/TU.DE.Pont';

    private $TAUserName = 'TSO_TappaMarket_Prod_User';
    private $TASolutionSetName = 'TSO_TappaMarketplace_AGSS';
    private $TASolutionSetVersion = '8';
    private $TAPassWord = 'Ta7o@AcyXtppa0';
    private $TABaseUrl = 'https://deservices.transunion.co.za/DE/TU.DE.Pont';

    public function __construct()
    {
        parent::__construct();

        $lang = $this->get('language');
        if (empty($lang)) {
            $lang = $this->post('language');
        }
        $this->lang->load('maxapi', 'english');
        if (!empty($lang)) {
            $this->lang->load('maxapi', $lang);
        }

        $this->load->model('Tappa_model');

        $this->perPage = 10;
    }

    private function getRemoteFile($url)
    {
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt($curl,  CURLOPT_RETURNTRANSFER, TRUE);
        $contents = curl_exec ($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode != 404) {
            curl_close ($curl);

            return $contents;
        }

        return false;
    }

    private function externalFileExists($location, $return_content_type = false)
    {
        ob_start();
        $curl = curl_init($location);
        curl_setopt($curl, CURLOPT_URL, $location);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_exec($curl);
        $info = curl_getinfo($curl);
        ob_clean();
        ob_end_clean();
        if ((int)$info['http_code'] >= 200 && (int)$info['http_code'] <= 206) {
            if ($return_content_type !== false) {
                return $info;
            }

            return true;
        }

        return false;
    }

    private function _makeCall($data, $isInit = null, $tokenCheck = null, $returnHeader = false)
    {
        if (
            (!empty($tokenCheck) && empty($isInit)) ||
            (!empty($isInit) && empty($tokenCheck))
        ) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $data['url'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $data['method'],
                CURLOPT_HTTPHEADER => $data['header']
            ]);
            if (!empty($data['postFields'])) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data['postFields']);
            }
            $headers = [];
            if (!empty($returnHeader)) {
                curl_setopt($curl, CURLOPT_HEADERFUNCTION,
                    function ($c, $header) use (&$headers) {
                        $len = strlen($header);
                        $header = explode(':', $header, 2);
                        if (count($header) < 2) {
                            return $len;
                        }
                        $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                        return $len;
                    }
                );
            }
            $response = curl_exec($curl);
            if ($response === false) {
                $return = [
                    'status' => 'error',
                    'code' => 500,
                    'data' => curl_error($curl)
                ];
                if (!empty($headers)) {
                    $return['headers'] = $headers;
                }
            } else {
                $msg = json_decode($response);
                if (!empty($msg->Message) && substr($msg->Message, 0, 29) === 'Authorization has been denied') {
                    $return = [
                        'status' => 'error',
                        'code' => 403,
                        'data' => $response
                    ];
                } else {
                    $return = [
                        'status' => 'success',
                        'code' => 200,
                        'data' => $response
                    ];
                }
                if (!empty($headers)) {
                    $return['headers'] = $headers;
                }
            }
            curl_close($curl);

            return $return;
        } else {
            $return = [
                'status' => 'error',
                'code' => 500,
                'data' => 'If the method is not an initiation, you must specify the AccessToken to this call.'
            ];

            return $return;
        }
    }

    /**
     * ANY request you wish to make needs to have an authentication token. You get this by first running the
     * getAccessToken_get endpoint. The output of that call, you need to store on your side, and inject it into
     * the headers of every future request.
     *
     * When you call an endpoint in THIS API, you do NOT append _get or _post to it. The API itself determines
     * that from the HTTP verb used, for example, if you are running the getAccessToken endpoint, you call
     * getAccessToken() and NOT getAccessToken_get()
     *
     * Some endpoints may require more than one field to be passed through, therefore ensure that you look at
     * the original Postman collection sent by TransUnion to see what they are, and replace them accordingly in
     * your calls.In Postman, they are denoted as follows: {{variableName}} in orange, which indicate things that
     * Postman automatically replaces in most cases, but you would need to replace yourself in the calls by
     * specifying valid data for them.
     */

    // Retry Queue
    private function _setReviewData($qData)
    {
        $uData = [];
        if (!empty($qData['data'])) {
            $uData = json_decode($qData['data']);
        }

        return $uData;
    }

    public function reviewQueue_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Reviewaction',
            'Reviewcomments'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Applicationid']) ||
            empty($head['heads']['Reviewaction']) ||
            empty($head['heads']['Reviewcomments']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'reviewQueue', 'time' => $start_api]);
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/queues/TSO_Review',
            'postFields' => '{
                "Fields": {
                    "ApplicationData_IO": {
                        "ReviewAction": "' . $head['heads']['Reviewaction'] . '",
                        "Attributes": {
                            "DecisionComments": "' . $head['heads']['Reviewcomments'] . '"
                        }
                    }
                }
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['reviewQueue'] = $this->_setReviewData($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'reviewQueue', 'time' => $start_api], $head['heads'], $data['data']['reviewQueue']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'reviewQueue', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'reviewQueue', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'reviewQueue', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'reviewQueue', 'time' => $start_api], []);
        }
    }

    // Retry Queue
    private function _setDARetryData($qData)
    {
        $uData = [];
        if (!empty($qData['data'])) {
            $uData = json_decode($qData['data']);
        }

        return $uData;
    }

    public function daRetryQueue_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Applicationid']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'daRetryQueue', 'time' => $start_api]);
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/queues/TSO_DARetry',
            'postFields' => '{
                "Fields": {
                    "Applicants_IO": {
                    }
                }
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['daRetryQueue'] = $this->_setDARetryData($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'daRetryQueue', 'time' => $start_api], $head['heads'], $data['data']['daRetryQueue']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'daRetryQueue', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'daRetryQueue', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'daRetryQueue', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'daRetryQueue', 'time' => $start_api], []);
        }
    }

    // Optional Queue
    private function _setOptionalQueueData($qData)
    {
        $uData = [];
        if (!empty($qData['data'])) {
            $uData = json_decode($qData['data']);
        }

        return $uData;
    }

    public function optionalQueue_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Blackbox',
            'Accountcode',
            'Statedip',
            'Email',
            'Telephonetype',
            'Telephonecountrycode',
            'Telephoneareacode',
            'Telephonenumber'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Applicationid']) ||
            empty($head['heads']['Accesstoken'])

            // To add more of these error checking
            // empty($head['heads']['Blackbox'])  ||
            // empty($head['heads']['Statedip'])  ||
            // empty($head['heads']['Email'])  ||
            // empty($head['heads']['Telephonetype']) ||
            // empty($head['heads']['Telephonecountrycode']) ||
            // empty($head['heads']['Telephoneareacode']) ||
            // empty($head['heads']['Telephonenumber']) ||
        ) {
            $this->missingDataResponse(['identifier' => 'optionalQueue', 'time' => $start_api]);
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/queues/TSO_QDE2',
            'postFields' => '{
                "Fields": {
                    "Applicants_IO": {
                        "Applicant": {
                            "DeviceRequest": {
                                "blackboxes": {
                                    "blackbox": {
                                        "value": "' . $head['heads']['Blackbox'] . '"
                                    }
                                },
                                "AccountCode": "' . $head['heads']['Accountcode'] . '",
                                "StatedIp": "' . $head['heads']['Statedip'] . '"
                            },
                            "EmailAddress": "' . $head['heads']['Email'] . '",
                            "Telephones": {
                                "Telephone": [{
                                        "TelephoneType": "' . $head['heads']['Telephonetype'] . '",
                                        "TelephoneCountryCode": "' . $head['heads']['Telephonecountrycode'] . '",
                                        "TelephoneAreaCode": "' . $head['heads']['Telephoneareacode'] . '",
                                        "TelephoneNumber": "' . $head['heads']['Telephonenumber'] . '"
                                    }

                                ]
                            }
                        }
                    }
                }
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['optionalQueue'] = $this->_setOptionalQueueData($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'optionalQueue', 'time' => $start_api], $head['heads'], $data['data']['optionalQueue']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'optionalQueue', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'optionalQueue', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'optionalQueue', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'optionalQueue', 'time' => $start_api], []);
        }
    }

    // Complete ID Document Back
    private function _setCompleteIdDocumentBack($idData)
    {
        $uData = [];
        if (!empty($idData['data'])) {
            $uData = json_decode($idData['data']);
        }

        return $uData;
    }

    public function completeIdDocumentBack_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Documentidfront',
            'Documentidback',
            'Description'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Documentidfront']) ||
            empty($head['heads']['Documentidback']) ||
            empty($head['heads']['Applicationid']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'completeIdDocumentBack', 'time' => $start_api]);
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/queues/TSO_DocAuth',
            'postFields' => '{
                "Fields": {
                    "IdentityVerification": {
                        "Front": {
                            "Id": "' . $head['heads']['Documentidfront'] . '",
                            "Error": ""
                        },
                        "Back": {
                            "Id": "' . $head['heads']['Documentidback'] . '",
                            "Error": ""
                        },
                        "Type": "' . $head['heads']['Description'] . '",
                        "Step": "back",
                        "CurrentStep": "continue"
                    }
                }
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['completeIdDocumentBack'] = $this->_setCompleteIdDocumentBack($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'completeIdDocumentBack', 'time' => $start_api], $head['heads'], $data['data']['completeIdDocumentBack']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'completeIdDocumentBack', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'completeIdDocumentBack', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'completeIdDocumentBack', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'completeIdDocumentBack', 'time' => $start_api], []);
        }
    }

    // Process ID Document Back
    private function _setProcessIdDocumentBack($idData)
    {
        $uData = [];
        if (!empty($idData['data'])) {
            $uData = json_decode($idData['data']);
        }

        return $uData;
    }

    public function processIdDocumentBack_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Documentidfront',
            'Documentidback',
            'Description'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Documentidfront']) ||
            empty($head['heads']['Documentidback']) ||
            empty($head['heads']['Applicationid']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'processIdDocumentBack', 'time' => $start_api]);
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/queues/TSO_DocAuth',
            'postFields' => '        {
                "Fields": {
                    "IdentityVerification": {
                        "Front": {
                            "Id": "' . $head['heads']['Documentidfront'] . '",
                            "Error": ""
                        },
                        "Back": {
                            "Id": "' . $head['heads']['Documentidback'] . '",
                            "Error": ""
                        },
                        "Type": "' . $head['heads']['Description'] . '",
                        "Step": "back",
                        "CurrentStep": "back"
                    }
                }
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];
        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['processIdDocumentBack'] = $this->_setProcessIdDocumentBack($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'processIdDocumentBack', 'time' => $start_api], $head['heads'], $data['data']['processIdDocumentBack']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'processIdDocumentBack', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'processIdDocumentBack', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'processIdDocumentBack', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'processIdDocumentBack', 'time' => $start_api], []);
        }
    }

    // Set Upload ID document
    private function _setUploadIdDocumentBack($idData)
    {
        $uData = [];
        if (!empty($idData['data'])) {
            $uData = json_decode($idData['data']);
        }

        return $uData;
    }

    public function uploadIdDocumentBack_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Documentid',
            'File'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Documentid']) ||
            empty($head['heads']['File']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'uploadIdDocumentBack', 'time' => $start_api]);
        }

        // Make the call.
        $body = '';
        $content_type = '';
        $fn = $head['heads']['File'];
        $exists = $this->externalFileExists($fn, true);
        if (!empty($exists)) {
            $body = $this->getRemoteFile($fn);
            $content_type = (!empty($exists['content_type']) ? $exists['content_type'] : '');
        }
        if (empty($content_type)) {
            $this->userErrorResponseNew([
                'identifier' => 'uploadIdDocumentBack',
                'message' => 'Unable to determine the file mime type.',
                'code' => 400,
                'time' => $start_api
            ], []);
        }
        $callData = [
            'url' => $this->TABaseUrl . '/documents/' . $head['heads']['Documentid'],
            'postFields' => $body,
            'method' => 'POST',
            'header' => [
                'Content-Type: ' . $content_type,
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['uploadIdDocumentBack'] = $this->_setUploadIdDocumentBack($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'uploadIdDocumentBack', 'time' => $start_api], $head['heads'], $data['data']['uploadIdDocumentBack']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'uploadIdDocumentBack', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'uploadIdDocumentBack', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'uploadIdDocumentBack', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'uploadIdDocumentBack', 'time' => $start_api], []);
        }
    }

    // Create Document Back
    private function _setCreateDocumentBack($newDocumentData, $heads = null)
    {
        $nd = [];
        if (!empty($newDocumentData['data'])) {
            $nd = json_decode($newDocumentData['data']);
        }
        if (!empty($heads)) {
            if (!empty($heads['headers'])) {
                if (!empty($heads['headers']['location'][0])) {
                    $nd->DocumentId = explode('/', $heads['headers']['location'][0])[2];
                } else {
                    $nd->DocumentId = null;
                }
                $nd->FileName = $heads['Filename'];
                $nd->Note = $heads['Note'];
                $nd->Description = $heads['Description'];
            } else {
                $nd['Headers'] = null;
                $nd['FileName'] = $heads['Filename'];
                $nd['Note'] = $heads['Note'];
                $nd['Description'] = $heads['Description'];
            }
        }

        return $nd;
    }

    public function createDocumentBack_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Filename',
            'Description',
            'Note'
        ]);

        // Checks required parameters.
        if (empty($head['heads']['Filename']) || empty($head['heads']['Accesstoken']) || empty($head['heads']['Applicationid'])) {
            $this->missingDataResponse(['identifier' => 'documentBack', 'time' => $start_api]);
        }
        if (empty($head['heads']['Note'])) {
            $head['heads']['Note'] = 'File uploaded via Tappa API for application ID ' . $head['heads']['Applicationid'];
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/documents',
            'postFields' => '{
                "Description": "' . $head['heads']['Description'] . '",
                "FileName": "' . $head['heads']['Filename'] . '",
                "Note": "' . $head['heads']['Note'] . '"
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken'], true);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['documentBack'] = $this->_setCreateDocumentBack($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'documentBack', 'time' => $start_api], $head['heads'], $data['data']['documentBack']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'documentBack', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'documentBack', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'documentBack', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'documentBack', 'time' => $start_api], []);
        }
    }

    // Complete ID Document Front
    private function _setCompleteIdDocumentFront($idData)
    {
        $uData = [];
        if (!empty($idData['data'])) {
            $uData = json_decode($idData['data']);
        }

        return $uData;
    }

    public function completeIdDocumentFront_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Documentid',
            'Description'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Documentid']) ||
            empty($head['heads']['Applicationid']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'completeIdDocument', 'time' => $start_api]);
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/queues/TSO_DocAuth',
            'postFields' => '{
                "Fields": {
                    "IdentityVerification": {
                        "Front": {
                            "Id": "' . $head['heads']['Documentid'] . '",
                            "Error": ""
                        },
                        "Type": "' . $head['heads']['Description'] . '",
                        "Step": "continue"
                    }
                }
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['completeIdDocument'] = $this->_setCompleteIdDocumentFront($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'completeIdDocument', 'time' => $start_api], $head['heads'], $data['data']['completeIdDocument']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'completeIdDocument', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'completeIdDocument', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'completeIdDocument', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'completeIdDocument', 'time' => $start_api], []);
        }
    }

    // Process ID Document Front
    private function _setProcessIdDocumentFront($idData)
    {
        $uData = [];
        if (!empty($idData['data'])) {
            $uData = json_decode($idData['data']);
        }

        return $uData;
    }

    public function processIdDocumentFront_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Documentid',
            'Description'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Documentid']) ||
            empty($head['heads']['Applicationid']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'processIdDocument', 'time' => $start_api]);
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/queues/TSO_DocAuth',
            'postFields' => '{
                "Fields": {
                    "IdentityVerification": {
                        "Front": {
                            "Id": "' . $head['heads']['Documentid'] . '",
                            "Error": ""
                        },
                        "Type": "' . $head['heads']['Description'] . '",
                        "Step": "front"
                    }
                }
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['processIdDocument'] = $this->_setProcessIdDocumentFront($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'processIdDocument', 'time' => $start_api], $head['heads'], $data['data']['processIdDocument']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'processIdDocument', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'processIdDocument', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'processIdDocument', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'processIdDocument', 'time' => $start_api], []);
        }
    }

    // Set Upload ID document
    private function _setUploadIdDocument($idData)
    {
        $uData = [];
        if (!empty($idData['data'])) {
            $uData = json_decode($idData['data']);
        }

        return $uData;
    }

    public function uploadIdDocument_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Documentid',
            'File'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Documentid']) ||
            empty($head['heads']['File']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'uploadIdDocument', 'time' => $start_api]);
        }

        // Make the call.
        $body = '';
        $content_type = '';
        $fn = $head['heads']['File'];
        $exists = $this->externalFileExists($fn, true);
        if (!empty($head['heads']['File']) && $exists) {
            $body = $this->getRemoteFile($fn);
            $content_type = (!empty($exists['content_type']) ? $exists['content_type'] : '');
        }
        if (empty($content_type)) {
            $this->userErrorResponseNew([
                'identifier' => 'uploadIdDocument',
                'message' => 'Unable to determine the File mime type.',
                'code' => 400,
                'time' => $start_api
            ], []);
        }
        $callData = [
            'url' => $this->TABaseUrl . '/documents/' . $head['heads']['Documentid'],
            'postFields' => $body,
            'method' => 'POST',
            'header' => [
                'Content-Type: ' . $content_type,
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['uploadIdDocument'] = $this->_setUploadIdDocument($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'uploadIdDocument', 'time' => $start_api], $head['heads'], $data['data']['uploadIdDocument']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'uploadIdDocument', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'uploadIdDocument', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'uploadIdDocument', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'uploadIdDocument', 'time' => $start_api], []);
        }
    }

    // Create Document Front
    private function _setCreateDocumentFront($newDocumentData, $heads = null)
    {
        $nd = [];
        if (!empty($newDocumentData['data'])) {
            $nd = json_decode($newDocumentData['data']);
        }
        if (!empty($heads)) {
            if (!empty($heads['headers'])) {
                if (!empty($heads['headers']['location'][0])) {
                    $nd->DocumentId = explode('/', $heads['headers']['location'][0])[2];
                } else {
                    $nd->DocumentId = null;
                }
                $nd->FileName = $heads['Filename'];
                $nd->Note = $heads['Note'];
                $nd->Description = $heads['Description'];
            } else {
                $nd['Headers'] = null;
                $nd['FileName'] = $heads['Filename'];
                $nd['Note'] = $heads['Note'];
                $nd['Description'] = $heads['Description'];
            }
        }

        return $nd;
    }

    public function createDocumentFront_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Filename',
            'Description',
            'Note'
        ]);

        // Checks required parameters.
        if (empty($head['heads']['Filename']) || empty($head['heads']['Accesstoken']) || empty($head['heads']['Applicationid'])) {
            $this->missingDataResponse(['identifier' => 'documentFront', 'time' => $start_api]);
        }
        if (empty($head['heads']['Note'])) {
            $head['heads']['Note'] = 'File uploaded via Tappa API for application ID ' . $head['heads']['Applicationid'];
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/documents',
            'postFields' => '{
                "Description": "' . $head['heads']['Description'] . '",
                "FileName": "' . $head['heads']['Filename'] . '",
                "Note": "' . $head['heads']['Note'] . '"
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken'], true);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['documentFront'] = $this->_setCreateDocumentFront($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'documentFront', 'time' => $start_api], $head['heads'], $data['data']['documentFront']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'documentFront', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'documentFront', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'documentFront', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'documentFront', 'time' => $start_api], []);
        }
    }

    // SELFIE

    // Create Selfie
    private function _setCreateSelfie($newDocumentData, $heads = null)
    {
        $nd = [];
        if (!empty($newDocumentData['data'])) {
            $nd = json_decode($newDocumentData['data']);
        }
        if (!empty($heads)) {
            if (!empty($heads['headers'])) {
                if (!empty($heads['headers']['location'][0])) {
                    $nd->DocumentId = explode('/', $heads['headers']['location'][0])[2];
                } else {
                    $nd->DocumentId = null;
                }
                $nd->FileName = $heads['Filename'];
                $nd->Note = $heads['Note'];
                $nd->Description = $heads['Description'];
            } else {
                $nd['Headers'] = null;
                $nd['FileName'] = $heads['Filename'];
                $nd['Note'] = $heads['Note'];
                $nd['Description'] = $heads['Description'];
            }
        }

        return $nd;
    }

    public function createSelfie_post()
    {
        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Filename',
            'Description',
            'Note'
        ]);

        // Checks required parameters.
        if (empty($head['heads']['Filename']) || empty($head['heads']['Accesstoken']) || empty($head['heads']['Applicationid'])) {
            $this->missingDataResponse(['identifier' => 'documentSelfie', 'time' => $start_api]);
        }
        if (empty($head['heads']['Note'])) {
            $head['heads']['Note'] = 'File uploaded via Tappa API for application ID ' . $head['heads']['Applicationid'];
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/documents',
            'postFields' => '{
                "Description": "' . $head['heads']['Description'] . '",
                "FileName": "' . $head['heads']['Filename'] . '",
                "Note": "' . $head['heads']['Note'] . '"
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken'], true);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['documentSelfie'] = $this->_setCreateSelfie($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'documentSelfie', 'time' => $start_api], $head['heads'], $data['data']['documentSelfie']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'documentSelfie', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'documentSelfie', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'documentSelfie', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'documentSelfie', 'time' => $start_api], []);
        }
    }


    // Set Upload ID document
    private function _setUploadSelfie($idData)
    {
        $uData = [];
        if (!empty($idData['data'])) {
            $uData = json_decode($idData['data']);
        }

        return $uData;
    }

    public function uploadSelfie_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Documentid',
            'File'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Documentid']) ||
            empty($head['heads']['File']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'uploadSelfie', 'time' => $start_api]);
        }

        // Make the call.
        $body = '';
        $content_type = '';
        $fn = $head['heads']['File'];
        $exists = $this->externalFileExists($fn, true);
        if (!empty($head['heads']['File']) && $exists) {
            $body = $this->getRemoteFile($fn);
            $content_type = (!empty($exists['content_type']) ? $exists['content_type'] : '');
        }
        if (empty($content_type)) {
            $this->userErrorResponseNew([
                'identifier' => 'uploadSelfie',
                'message' => 'Unable to determine the File mime type.',
                'code' => 400,
                'time' => $start_api
            ], []);
        }
        $callData = [
            'url' => $this->TABaseUrl . '/documents/' . $head['heads']['Documentid'],
            'postFields' => $body,
            'method' => 'POST',
            'header' => [
                'Content-Type: ' . $content_type,
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['uploadSelfie'] = $this->_setUploadSelfie($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'uploadSelfie', 'time' => $start_api], $head['heads'], $data['data']['uploadSelfie']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'uploadSelfie', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'uploadSelfie', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'uploadSelfie', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'uploadSelfie', 'time' => $start_api], []);
        }
    }

    private function _setProcessSelfie($idData)
    {
        $uData = [];
        if (!empty($idData['data'])) {
            $uData = json_decode($idData['data']);
        }

        return $uData;
    }

    public function processSelfie_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Documentidfront',
            'Documentidback',
            'Documentselfie',
            'Description'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Documentidfront']) ||
            empty($head['heads']['Documentselfie']) ||
            empty($head['heads']['Applicationid']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'processSelfie', 'time' => $start_api]);
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/queues/TSO_DocAuth',
            'postFields' => '{
                "Fields": {
                    "IdentityVerification": {
                        "Front": {
                            "Id": "' . $head['heads']['Documentidfront'] . '",
                            "Error": ""
                        },
                        "Back": {
                            "Id": "' . $head['heads']['Documentidback'] . '",
                            "Error": ""
                        },
                        "Selfie": {
                            "Id": "' . $head['heads']['Documentselfie'] . '",
                            "Error": ""
                        },
                        "Type": "' . $head['heads']['Description'] . '",
                        "Step": "selfie",
                        "CurrentStep": "selfie",
                    }
                }
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['processSelfie'] = $this->_setProcessSelfie($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'processSelfie', 'time' => $start_api], $head['heads'], $data['data']['processSelfie']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'processSelfie', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'processSelfie', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'processSelfie', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'processSelfie', 'time' => $start_api], []);
        }
    }

    public function completeSelfie_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead([
            'Accesstoken',
            'Applicationid',
            'Documentidfront',
            'Documentidback',
            'Documentselfie',
            'Description'
        ]);

        // Checks required parameters.
        if (
            empty($head['heads']['Documentidfront']) ||
            empty($head['heads']['Documentselfie']) ||
            empty($head['heads']['Applicationid']) ||
            empty($head['heads']['Accesstoken'])
        ) {
            $this->missingDataResponse(['identifier' => 'processSelfie', 'time' => $start_api]);
        }

        // Make the call.
        $callData = [

            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'] . '/queues/TSO_DocAuth',
            'postFields' => '{
                "Fields": {
                    "IdentityVerification": {
                        "Front": {
                            "Id": "' . $head['heads']['Documentidfront'] . '",
                            "Error": ""
                        },
                        "Back": {
                            "Id": "' . $head['heads']['Documentidback'] . '",
                            "Error": ""
                        },
                        "Selfie": {
                            "Id": "' . $head['heads']['Documentselfie'] . '",
                            "Error": ""
                        },
                        "Type": "' . $head['heads']['Description'] . '",
                        "Step": "selfie",
                        "CurrentStep": "continue",
                    }
                }
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $head['heads']['returnCount'] = count($returnData);
        if (!empty($returnData['headers'])) {
            $head['heads']['headers'] = $returnData['headers'];
        }

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['processSelfie'] = $this->_setProcessSelfie($returnData, $head['heads']);
            $this->dataRetrievedResponse(['identifier' => 'processSelfie', 'time' => $start_api], $head['heads'], $data['data']['processSelfie']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'processSelfie', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'processSelfie', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'processSelfie', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'processSelfie', 'time' => $start_api], []);
        }
    }

    //--


    // Start New Request
    private function _setStartNewRequest($newRequestData)
    {
        $nr = [];
        if (!empty($newRequestData['data'])) {
            $nr = json_decode($newRequestData['data']);
        }

        return $nr;
    }

    public function startNewRequest_post()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead(['Accesstoken']);

        if (empty($head['heads']['Accesstoken'])) {
            $this->missingDataResponse(['identifier' => 'token', 'time' => $start_api]);
        }

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications',
            'postFields' => '{
                "RequestInfo": {
                    "SolutionSetName": "' . $this->TASolutionSetName . '",
                    "ExecuteLatestVersion": "False",
                    "SolutionSetVersion": "' . $this->TASolutionSetVersion . '"
                },
                "Fields": {
                    "TrailLevel": "5",
                    "SYS_WorkflowConfigurationName" :"ConcurrentRuntimeTablesWithSearchFields",
                    "Applicants": {
                        "Applicant": {
                        }
                    },
                    "ApplicationData": {
                    }
                }
            }',
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];

        $returnData = $this->_makeCall($callData, false, $head['heads']['Accesstoken']);
        $post['posts']['returnCount'] = count($returnData);

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['startRequest'] = $this->_setStartNewRequest($returnData);
            $this->dataRetrievedResponse(['identifier' => 'startRequest', 'time' => $start_api], $post['posts'], $data['data']['startRequest']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'startRequest', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 500) {
            $this->serverErrorResponse(['identifier' => 'startRequest', 'time' => $start_api], []);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'startRequest', 'time' => $start_api], []);
        } else {
            $this->userErrorResponseNew(['identifier' => 'startRequest', 'time' => $start_api], []);
        }
    }

    // AccessToken
    private function _setGetAccessTokenData($accessTokenData)
    {
        $at = [];
        if (!empty($accessTokenData['data'])) {
            $at = $accessTokenData['data'];
        }

        return json_decode($at);
    }

    public function getAccessToken_get()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $get['gets'] = [];

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/Token',
            'postFields' => 'grant_type=password&username=' . $this->TAUserName . '&password=' . $this->TAPassWord,
            'method' => 'GET',
            'header' => ['Content-Type: application/json']
        ];
        $returnData = $this->_makeCall($callData, true, null);

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        $returnCount = 1;
        $get['gets']['returnCount'] = 1;
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['token'] = $this->_setGetAccessTokenData($returnData);
            $this->dataRetrievedResponse(['identifier' => 'token', 'time' => $start_api], $get['gets'], $data['data']['token']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'token', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'token', 'time' => $start_api], []);
        } else {
            $this->serverErrorResponse(['identifier' => 'token', 'time' => $start_api], []);
        }
    }

    // AccessToken
    private function _setEndRequestData($requestData)
    {
        $rd = [];
        if (!empty($requestData['data'])) {
            $rd = $requestData['data'];
        }

        return json_decode($rd);
    }

    public function endRequest_get()
    {

        // This initiates the API for our use - authenticates with key, etc.
        $this->verifySettings();
        $start_api = microtime(true);
        $head = $this->setHead(['Accesstoken', 'Applicationid']);

        // Make the call.
        $callData = [
            'url' => $this->TABaseUrl . '/applications/' . $head['heads']['Applicationid'],
            'method' => 'GET',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $head['heads']['Accesstoken']
            ]
        ];
        $returnData = $this->_makeCall($callData, true, null);

        // For calls returning a single response, either set this to 1, or make it generic by counting the number of results.
        $returnCount = 1;
        $get['gets']['returnCount'] = 1;
        if (!empty($returnData['status']) && $returnData['code'] == 200) {
            $data['data']['endRequest'] = $this->_setGetAccessTokenData($returnData);
            $this->dataRetrievedResponse(['identifier' => 'endRequest', 'time' => $start_api], $get['gets'], $data['data']['endRequest']);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 200 && empty($returnData['data'])) {
            $this->noDataResponse(['identifier' => 'endRequest', 'time' => $start_api]);
        } elseif (!empty($returnData['status']) && $returnData['code'] == 403) {
            $this->deniedErrorResponseNew(['identifier' => 'endRequest', 'time' => $start_api], []);
        } else {
            $this->serverErrorResponse(['identifier' => 'endRequest', 'time' => $start_api], []);
        }
    }
}
