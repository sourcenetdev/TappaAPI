<?php if ( ! defined( 'ABSPATH' ) ) {	return; }

/**
 * Class: Tappa_API_Consumer
 *
 * @package    Tappa Plugin
 * @author     Elsabe Bester <elsabe@lessink.co.za>
 */
class Tappa_API_Consumer {

    // TODO QUEUE

    var $api_key;
    var $api_base;
    var $api_debug;
    var $api_check_ssl;
    var $valid_document_description;
    var $blackbox;
    var $response_info;

    var $token;
    var $access_token;
    var $application_id;
    var $document;
    var $document_description;

    var $retries_available;
    var $retries;

    var $verification_decision;
    var $verification_reason;

    function __construct() {

        $this->blackbox = '';

        $this->api_base = TAPPA_API_BASE;
        $this->api_key = TAPPA_API_KEY;
        $this->api_debug = TAPPA_API_DEBUG;
        $this->api_check_ssl = TAPPA_API_CHECK_SSL;
        $this->document = [];

        $this->verification_decision = 'None';
        $this->verification_reason = '';

        $this->valid_document_description = array(
            'Green ID Book' => 'national_identity_card',
            'Passport' => 'passport',
            'Drivers License' => 'driving_license',
            'SA ID Card' => 'national_identity_card',
        );
        // NOTE THERE IS A SEPERATE PROCESS FOR SA ID CARd
        //
        $this->request_options = [
            'method'      => 'GET',
            'body'        => '',
            'headers'     => [],
            'timeout'     => 60,
            'redirection' => 5,
            'blocking'    => true,
            'httpversion' => '1.0',
            'sslverify'   => $this->api_check_ssl,
            'data_format' => 'body',
        ];
    }

    function is_verified() {
        return strtolower($this->verification_decision) == 'approved';
    }
    function get_verification_decision() {
        return $this->verification_decision;
    }
    function get_verification_decision_reason() {
        return $this->verification_reason;
    }

    /**
     * [verify_process description]
     * @return [type] [description]
     */
    function run_verify_process() {

    }

    /**
     * get_access_token
     * @return array $response from API
     */
    function get_access_token() {
        Tappa_API_Consumer::log('Tappa_API_Consumer->get_access_token()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // REMOTE CALL
        $endpoint = 'getAccessToken';
        $url = $this->api_base.$endpoint;

        $options = $this->request_options;
        $options['method']  = 'GET';
        $options['headers'] = [
                "X-API-KEY" => $this->api_key,
            ];
        $response = wp_remote_get( $url, $options );

        list($error_type, $error_message) = $this->check_valid_response($response);

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            $body = json_decode($response['body']);
            $data = $body->data;
            $this->token = $data->token;
            $this->access_token = $data->token->access_token;
            return $this->token;
        } else {
            return false;
        }
    }

    /**
     * start_new_request
     * @return array $response from API
     */
    function start_new_request() {
        Tappa_API_Consumer::log('Tappa_API_Consumer->start_new_request()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }

        $endpoint = 'startNewRequest';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"     => $this->api_key,
                    "Accesstoken"   => $this->access_token,
                ];
            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        if (!$error_type) {
            // PROCESS RESPONSE
            $body = json_decode($response['body']);
            $data = $body->data;
            if (strtolower($data->startRequest->Status) != 'success') {
                $error_type = 'API';
                $error_message = 'Function fail.';
                Tappa_API_Consumer::log( "ERROR: Function fail.");
                Tappa_API_Consumer::log( json_encode($body->data) );
            }
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {

            $this->retries_available =  !empty($data->startRequest->Fields->IdentityVerification->Link->RetryAttempts) ? $data->startRequest->Fields->IdentityVerification->Link->RetryAttempts : 4;
            $this->application_id = $data->startRequest->ResponseInfo->ApplicationId;
            return $this->application_id;
        } else {
            return false;
        }
    }


    /**
     * end_request
     * @return array $response from API
     */
    function end_request() {
        Tappa_API_Consumer::log('Tappa_API_Consumer->end_request()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }

        $endpoint = 'endRequest';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL

            $options = $this->request_options;
            $options['method']  = 'GET';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"       => $this->access_token,
                    "Applicationid"    => $this->application_id,
                ];
            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            $body = json_decode($response['body']);
            $data = $body->data;


            //Declined
            //Approved
            //Awaiting_Approval
            //
            // switch($data->endRequest->Fields->Decision) {
            //     case "Declined":
            //         $this->verification_result = false;
            //         break;
            //     case "Approved":
            //         $this->verification_result = true;
            //         break;
            //     case "Awaiting_Approval":
            //         $this->verification_result = false;
            //         break;
            //     case "Pending":
            //         $this->verification_result = null;
            //         break;
            //     default: // default??
            //         $this->verification_result = true;
            //         break;
            // }

            $this->verification_decision = $data->endRequest->Fields->Decision;
            $this->verification_reason = empty($data->endRequest->Fields->DecisionReason) ? '' : ($data->endRequest->Fields->DecisionReason->Code.
                                                ' ('.$data->endRequest->Fields->DecisionReason->Type.'): '.
                                                $data->endRequest->Fields->DecisionReason->Description);

            return true;
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }


    /**
     * create_documentfront
     * @return array $response from API
     */
    function create_id_document_front($filename, $note, $description) {
        Tappa_API_Consumer::log('Tappa_API_Consumer->create_id_document_front()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }
        if (!isset($this->valid_document_description[$description])) {
            $error_type = 'Validation';
            $error_message = 'Not a valid document description. ';
            Tappa_API_Consumer::log( "ERROR: Not a valid document description.". $description);
        }

        $endpoint = 'createDocumentFront';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"       => $this->access_token,
                    "Applicationid"    => $this->application_id,
                    "Filename"          => $filename,
                    "Note"              => $note,
                    "Description"       => $this->valid_document_description[$description]
                ];
            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            // RETURN HERE
            $body = json_decode($response['body']);
            $data = $body->data;
            $this->set_document_from_create('front', $data->documentFront);
            $this->document_description = $this->valid_document_description[$description];
            return $this->document['front'];
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    /**
     * upload_id_document_front
     * @return array $response from API
     */
    function upload_id_document_front($file_url) {
        Tappa_API_Consumer::log('Tappa_API_Consumer->upload_id_document_front()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (!$file_url) {
            $error_type = 'Validation';
            $error_message = 'File url needs to be specified. ';
            Tappa_API_Consumer::log( "ERROR: File url needs to be specified.");
        }
        if (empty($this->document['front']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }

        $endpoint = 'uploadIdDocument';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"     => $this->api_key,
                    "Accesstoken"   => $this->access_token,
                    "Documentid"   => $this->document['front']['document_id'],
                    "Description"   => $this->document_description,
                    "File"          => $file_url,
                ];
            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            $this->set_document_file_url('front', $file_url);
            return true;
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    /**
     * process_id_document_front
     * @return array $response from API
     */
    function process_id_document_front() {
        Tappa_API_Consumer::log('Tappa_API_Consumer->process_id_document_front()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }
        if (empty($this->document['front']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }

        $endpoint = 'processIdDocumentFront';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL

            // $request_body = array(
            //     'Fields'=> array(
            //         "IdentityVerification" => array(
            //             "Front" => array(
            //                 "Id" => $this->document['front']['document_id'],
            //                 "Error" => ""
            //             ),
            //             "Type" => $this->document_description,
            //             "Step" => "front"
            //         )
            //     )
            // );

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"      => $this->access_token,
                    "Applicationid"    => $this->application_id,
                    "Documentid"       => $this->document['front']['document_id'],
                    "Description"       => $this->document_description,
                ];
            // $options['body'] = $request_body;

            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        if (!$error_type) {
            // PROCESS RESPONSE
            $body = json_decode($response['body']);
            $data = $body->data;
            if (empty($data->processIdDocument->Status) || strtolower($data->processIdDocument->Status) != 'success') {
                // Processing function error
                $error_type = 'API';
                $error_message = 'Document not processed. ' . (!empty($data->processIdDocument->Fields->IdentityVerification->Front->Error) ? $data->processIdDocument->Fields->IdentityVerification->Front->Error : '');
                Tappa_API_Consumer::log( "ERROR: Document not processed. " . (!empty($data->processIdDocument->Fields->IdentityVerification->Front->Error) ? $data->processIdDocument->Fields->IdentityVerification->Front->Error : ''));
                Tappa_API_Consumer::log( json_encode($body->data) );
            }
        }
        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            $this->set_response_info($data->processIdDocument->ResponseInfo);
            return true;
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    /**
     * complete_id_document_front
     * @return array $response from API
     */
    function complete_id_document_front() {
        Tappa_API_Consumer::log('Tappa_API_Consumer->complete_id_document_front()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }
        if (empty($this->document['front']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'No document ID. ';
            Tappa_API_Consumer::log( "ERROR: No document ID. " );
        }

        $endpoint = 'completeIdDocumentFront';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {

            // $request_body = array(
            //     'Fields'=> array(
            //         "IdentityVerification" => array(
            //             "Front" => array(
            //                 "Id" => $this->document['front']['document_id'],
            //                 "Error" => ""
            //             ),
            //             "Type" => $this->document['front']['description'],
            //             "Step" => "continue"
            //         )
            //     )
            // );

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"      => $this->access_token,
                    "Applicationid"    => $this->application_id,
                    "Documentid"       => $this->document['front']['document_id'],
                    "Description"       => $this->document_description,
                ];
            // $options['body'] = $request_body;

            // REMOTE CALL
            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        if (!$error_type) {
            // PROCESS RESPONSE
            $body = json_decode($response['body']);
            $data = $body->data;

            if (strtolower($data->completeIdDocument->Status) != 'success') {
                // Processing function error
                $error_type = 'API';
                $error_message = 'Document not completed. ';
                Tappa_API_Consumer::log( "ERROR: Document not processed. ");
                Tappa_API_Consumer::log( json_encode($body->data) );
            }
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            return true;
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    /**
     * create_documentfront
     * @return array $response from API
     */
    function create_id_document_back($filename, $note, $description) {
        Tappa_API_Consumer::log('Tappa_API_Consumer->create_id_document_back()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }
        if (!isset($this->valid_document_description[$description])) {
            $error_type = 'Validation';
            $error_message = 'Not a valid document description. ';
            Tappa_API_Consumer::log( "ERROR: Not a valid document description.");
        }

        $endpoint = 'createDocumentBack';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"       => $this->access_token,
                    "Applicationid"    => $this->application_id,
                    "Filename"          => $filename,
                    "Note"              => $note,
                    "Description"       => $this->valid_document_description[$description]
                ];
            $response = wp_remote_post( $url, $options );
           list($error_type, $error_message) = $this->check_valid_response($response);
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            // RETURN HERE
            $body = json_decode($response['body']);
            $data = $body->data;
            $this->set_document_from_create('back', $data->documentBack);
            return $this->document['back'];
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    /**
     * upload_id_document_front
     * @return array $response from API
     */
    function upload_id_document_back($file_url) {
        Tappa_API_Consumer::log('Tappa_API_Consumer->upload_id_document_back()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (!$file_url) {
            $error_type = 'Validation';
            $error_message = 'File url needs to be specified. ';
            Tappa_API_Consumer::log( "ERROR: File url needs to be specified.");
        }
        if (empty($this->document['back']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }

        $endpoint = 'uploadIdDocumentBack';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"     => $this->api_key,
                    "Accesstoken"   => $this->access_token,
                    'Documentid'   => $this->document['back']['document_id'],
                    'File'          => $file_url,
                ];
            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            $this->set_document_file_url('back', $file_url);
            return true;
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    /**
     * process_id_document_front
     * @return array $response from API
     */
    function process_id_document_back() {
        Tappa_API_Consumer::log('Tappa_API_Consumer->process_id_document_back()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }
        if (empty($this->document['front']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }
        if (empty($this->document['back']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }

        $endpoint = 'processIdDocumentBack';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL

            // $request_body = array(
            //     'Fields'=> array(
            //         "IdentityVerification" => array(
            //             "Front" => array(
            //                 "Id" => $this->document['front']['document_id'],
            //                 "Error" => ""
            //             ),
            //             "Back" => array(
            //                 "Id" => $this->document['back']['document_id'],
            //                 "Error" => ""
            //             ),
            //             "Type" => $this->document['back']['description'],
            //             "Step" => "back",
            //             "CurrentStep" => "back"
            //         )
            //     )
            // );

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"       => $this->access_token,
                    "Applicationid"    => $this->application_id,
                    "Documentidfront" => $this->document['front']['document_id'],
                    "Documentidback"  => $this->document['back']['document_id'],
                    "Description"       => $this->document_description,
                ];
            // $options['body'] = $request_body;

            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        if (!$error_type) {
            // PROCESS RESPONSE
            $body = json_decode($response['body']);
            $data = $body->data;
            if (empty($data->processIdDocumentBack->Status) || strtolower($data->processIdDocumentBack->Status) != 'success') {
                // Processing function error
                $error_type = 'API';
                $error_message = 'Document not processed. ' . (!empty($data->processIdDocumentBack->Fields->IdentityVerification->Back->Error) ? $data->processIdDocumentBack->Fields->IdentityVerification->Back->Error : '');
                Tappa_API_Consumer::log( "ERROR: Document not processed. " . (!empty($data->processIdDocumentBack->Fields->IdentityVerification->Back->Error) ? $data->processIdDocumentBack->Fields->IdentityVerification->Back->Error : ''));
                Tappa_API_Consumer::log( json_encode($body->data) );
            }
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            $this->set_response_info($data->processIdDocumentBack->ResponseInfo);
            return true;
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    /**
     * complete_id_document_back
     * @return array $response from API
     */
    function complete_id_document_back() {
        Tappa_API_Consumer::log('Tappa_API_Consumer->complete_id_document_back()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }
        if (empty($this->document['back']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document back has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }
        if (empty($this->document['front']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document front has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }

        $endpoint = 'completeIdDocumentBack';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL
            // //
            // $request_body = array(
            //     'Fields'=> array(
            //         "IdentityVerification" => array(
            //             "Front" => array(
            //                 "Id" => $this->document['front']['document_id'],
            //                 "Error" => ""
            //             ),
            //             "Back" => array(
            //                 "Id" => $this->document['back']['document_id'],
            //                 "Error" => ""
            //             ),
            //             "Type" => $this->document['back']['description'],
            //             "Step" => "back",
            //             "CurrentStep" => "continue"
            //         )
            //     )
            // );

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"       => $this->access_token,
                    "Applicationid"     => $this->application_id,
                    "Documentidfront"   => $this->document['front']['document_id'],
                    "Documentidback"    => $this->document['back']['document_id'],
                    "Description"       => $this->document_description,
                ];
            // $options['body'] = $request_body;

            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        if (!$error_type) {
            // PROCESS RESPONSE
            $body = json_decode($response['body']);
            $data = $body->data;

            if (empty($data->completeIdDocumentBack->Status) || strtolower($data->completeIdDocumentBack->Status) != 'success') {
                // Processing function error
                $error_type = 'API';
                $error_message = 'Document not completed. ';
                Tappa_API_Consumer::log( "ERROR: Document not processed. ");
                Tappa_API_Consumer::log( json_encode($body->data) );
            }
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            return true;
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }


    /**
     * create_documentselfie
     * @return array $response from API
     */
    function create_selfie($filename, $note) {
        Tappa_API_Consumer::log('Tappa_API_Consumer->create_selfie()');
        $description = 'selfie';
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }

        $endpoint = 'createSelfie';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"       => $this->access_token,
                    "Applicationid"     => $this->application_id,
                    "Filename"          => $filename,
                    "Note"              => $note,
                    "Description"       => 'selfie',
                ];
            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            // RETURN HERE
            $body = json_decode($response['body']);
            $data = $body->data;
            $this->set_document_from_create('selfie', $data->documentSelfie);
            // $this->document_description = $this->valid_document_description[$description];
            return $this->document['selfie'];
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    /**
     * upload_selfie
     * @return array $response from API
     */
    function upload_selfie($file_url) {
        Tappa_API_Consumer::log('Tappa_API_Consumer->upload_selfie()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (!$file_url) {
            $error_type = 'Validation';
            $error_message = 'File url needs to be specified. ';
            Tappa_API_Consumer::log( "ERROR: File url needs to be specified.");
        }
        if (empty($this->document['selfie']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }

        $endpoint = 'uploadSelfie';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"     => $this->api_key,
                    "Accesstoken"   => $this->access_token,
                    "Documentid"    => $this->document['selfie']['document_id'],
                    "Description"   => 'selfie',
                    "File"          => $file_url,
                ];
            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            $this->set_document_file_url('selfie', $file_url);
            return true;
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    /**
     * process_selfie
     * @return array $response from API
     */
    function process_selfie() {
        Tappa_API_Consumer::log('Tappa_API_Consumer->process_selfie()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }
         if (empty($this->document['front']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }
        if (empty($this->document['selfie']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }

        $endpoint = 'processSelfie';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"       => $this->access_token,
                    "Applicationid"     => $this->application_id,
                    "Documentidfront"   => $this->document['front']['document_id'],
                    "Documentidback"    => (!empty($this->document['back']['document_id']) ? $this->document['back']['document_id'] : ''),
                    "Documentselfie"    => $this->document['selfie']['document_id'],
                    "Description"       => 'selfie',
                ];
            // $options['body'] = $request_body;

            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        if (!$error_type) {
            // PROCESS RESPONSE
            $body = json_decode($response['body']);
            $data = $body->data;
            if (empty($data->processSelfie->Status) || strtolower($data->processSelfie->Status) != 'success') {
                // Processing function error
                $error_type = 'API';
                $error_message = 'Document not processed. ' . (!empty($data->processSelfie->Fields->IdentityVerification->Selfie->Error) ? $data->processSelfie->Fields->IdentityVerification->Selfie->Error : '');
                Tappa_API_Consumer::log( "ERROR: Document not processed. " . (!empty($data->processSelfie->Fields->IdentityVerification->Selfie->Error) ? $data->processSelfie->Fields->IdentityVerification->Selfie->Error : ''));
                Tappa_API_Consumer::log( json_encode($body->data) );
            }
        }
        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            $this->set_response_info($data->processSelfie->ResponseInfo);
            return true;
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }


    /**
     * complete_selfie
     * @return array $response from API
     */
    function complete_selfie() {
        Tappa_API_Consumer::log('Tappa_API_Consumer->complete_selfie()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }
         if (empty($this->document['front']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }
        if (empty($this->document['selfie']['document_id'])) {
            $error_type = 'Validation';
            $error_message = 'Document has not been created for. ' . $file_url;
            Tappa_API_Consumer::log( "ERROR: Document has not been created for. " . $file_url);
        }

        $endpoint = 'completeSelfie';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"       => $this->access_token,
                    "Applicationid"     => $this->application_id,
                    "Documentidfront"        => $this->document['front']['document_id'],
                    "Documentidback"    => (!empty($this->document['back']['document_id']) ? $this->document['back']['document_id'] : ''),
                    "Documentselfie"    => $this->document['selfie']['document_id'],
                    "Description"       => 'selfie',
                ];
            // $options['body'] = $request_body;

            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        if (!$error_type) {
            // PROCESS RESPONSE
            $body = json_decode($response['body']);
            $data = $body->data;
            if (empty($data->processSelfie->Status) || strtolower($data->processSelfie->Status) != 'success') {
                // Processing function error
                $error_type = 'API';
                $error_message = 'Document not processed. ' . (!empty($data->processSelfie->Fields->IdentityVerification->Selfie->Error) ? $data->processSelfie->Fields->IdentityVerification->Selfie->Error : '');
                Tappa_API_Consumer::log( "ERROR: Document not processed. " . (!empty($data->processSelfie->Fields->IdentityVerification->Selfie->Error) ? $data->processSelfie->Fields->IdentityVerification->Selfie->Error : ''));
                Tappa_API_Consumer::log( json_encode($body->data) );
            }
        }
        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {
            $this->set_response_info($data->processSelfie->ResponseInfo);
            return true;
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }



    /**
     * optional_queue
     * Used with blackbox.
     * @return array $response from API
     */
    function optional_queue($email, $telephone, $blackbox = '', $stated_ip = '', $wp_user_id = '') {

        Tappa_API_Consumer::log('Tappa_API_Consumer->optional_queue()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }

        $endpoint = 'optionalQueue';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL
            // $request_body = array(
            //     'Fields'=> array(
            //         "Applicants_IO" => array(
            //             "Applicant" => array(
            //                 "DeviceRequest" => array(
            //                     "blackboxes" => array(
            //                         "blackbox" => array(
            //                             "value" => $blackbox
            //                         )
            //                     ),
            //                     "accountCode" => "TestAccount1",
            //                     "statedIp" => $stated_ip
            //                 ),
            //                 "EmailAddress" => $email,
            //                 "Telephones" => array(
            //                     "Telephone" => array(array(
            //                             "TelephoneType" => "M",
            //                             "TelephoneCountryCode" => "+27",
            //                             "TelephoneAreaCode" => "",
            //                             "TelephoneNumber" => $telephone
            //                         )
            //                     )
            //                 )
            //             )
            //         )
            //     )
            // );

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"             => $this->api_key,
                    "Accesstoken"           => $this->access_token,
                    "Applicationid"         => $this->application_id,
                    "Blackbox"              => $blackbox,
                    "Accountcode"           => $wp_user_id,
                    "Statedip"              => $stated_ip,
                    "Email"                 => $email,
                    "Telephonetype"         => "M", //fixme
                    "Telephonecountrycode"  => "+27",
                    "Telephoneareacode"     =>  "",
                    "Telephonenumber"       => $telephone,

                ];
            // $options['body'] = $request_body;

            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        if (!$error_type) {
            // PROCESS RESPONSE
            $body = json_decode($response['body']);
            $data = $body->data;

            if (empty($data->optionalQueue->Status) || strtolower($data->optionalQueue->Status) != 'success') {
                // Processing function error
                $error_type = 'API';
                $error_message = 'Optional queue fail. ';
                $error_message .= $data->optionalQueue->Message ? $data->optionalQueue->Message : '';
                Tappa_API_Consumer::log( "ERROR: Document not processed. ");
                Tappa_API_Consumer::log( json_encode($body->data) );
            }
        }
        if (!empty($data->optionalQueue->ResponseInfo)) {
            $this->set_response_info($data->optionalQueue->ResponseInfo);
        }

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {

            $queue = !empty($data->optionalQueue->ResponseInfo->CurrentQueue) ? $data->optionalQueue->ResponseInfo->CurrentQueue : '';
            if ($queue == 'TSO_QDE2') {
                $this->retries++;
                if ($this->retries < $this->retries_available) {
                    sleep(TAPPA_API_RETRY_TIME);
                    return $this->optional_queue($email, $telephone, $blackbox, $stated_ip, $wp_user_id);
                }
                $this->verification_decision = 'Fail';
                $this->verification_reason = $error_message. ' - Maximum retries reached.';
                return false;
            } else if ($queue == "TSO_DARetry") {
                $this->retries++;
                if ($this->retries < $this->retries_available) {
                    sleep(TAPPA_API_RETRY_TIME);
                    return $this->retry_queue($email, $telephone, $blackbox, $stated_ip, $wp_user_id);
                }
                $this->verification_decision = 'Fail';
                $this->verification_reason = $error_message. ' - Maximum retries reached.';
                return false;
            } else {
                return true;
            }
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    /**
     * retry_queue
     * TODO
     * @return array $response from API
     */
    function retry_queue($email, $telephone, $blackbox = '', $stated_ip = '', $wp_user_id = '') {
        Tappa_API_Consumer::log('Tappa_API_Consumer->retry_queue()');
        $error_type = false;
        $error_message = '';
        $response = false;
        $options = [];

        // VALIDATION
        if (empty($this->token)) {
            $error_type = 'Validation';
            $error_message = 'No access token for api call. ';
            Tappa_API_Consumer::log( "ERROR: No access token for api call.");
        }
        if (empty($this->application_id)) {
            $error_type = 'Validation';
            $error_message = 'No application ID for api call. ';
            Tappa_API_Consumer::log( "ERROR: No application ID for api call.");
        }

        $endpoint = 'daRetryQueue';
        $url = $this->api_base.$endpoint;
        if (!$error_type) {
            // REMOTE CALL
            //
            // $request_body = array(
            //     'Fields'=> array(
            //         "Applicants_IO" => array(
            //         )
            //     )
            // );

            $options = $this->request_options;
            $options['method']  = 'POST';
            $options['headers'] = [
                    "X-API-KEY"         => $this->api_key,
                    "Accesstoken"       => $this->access_token,
                    "Applicationid"    => $this->application_id,
                ];
            // $options['body'] = $request_body;

            $response = wp_remote_post( $url, $options );
            list($error_type, $error_message) = $this->check_valid_response($response);
        }

        if (!$error_type) {
            // PROCESS RESPONSE
            $body = json_decode($response['body']);
            $data = $body->data;

            if (empty($data->daRetryQueue->Status) || strtolower($data->daRetryQueue->Status) != 'success') {
                // Processing function error
                $error_type = 'API';
                $error_message = 'Document Authentication Retry queue fail. ';
                $error_message .= $data->daRetryQueue->Message ? $data->daRetryQueue->Message : '';
                Tappa_API_Consumer::log( "ERROR: Document not processed. ");
                Tappa_API_Consumer::log( json_encode($body->data) );
            }
        }
        $this->set_response_info($data->daRetryQueue->ResponseInfo);

        Tappa_Debug_Log::create($user_id = '', $endpoint, json_encode($options), json_encode($response), '', $error_type, $error_message);
        if (!$error_type) {

            $queue = !empty($data->daRetryQueue->ResponseInfo->CurrentQueue) ? $data->daRetryQueue->ResponseInfo->CurrentQueue : '';
            if ($queue == 'TSO_QDE2') {
                $this->retries++;
                if ($this->retries < $this->retries_available) {
                    sleep(TAPPA_API_RETRY_TIME);
                    return $this->optional_queue($email, $telephone, $blackbox, $stated_ip, $wp_user_id);
                }
                $this->verification_decision = 'Fail';
                $this->verification_reason = $error_message. ' - Maximum retries reached.';
                return false;
            } else if ($queue == "TSO_DARetry") {
                $this->retries++;
                if ($this->retries < $this->retries_available) {
                    sleep(TAPPA_API_RETRY_TIME);
                    return $this->retry_queue($email, $telephone, $blackbox, $stated_ip, $wp_user_id);
                }
                $this->verification_decision = 'Fail';
                $this->verification_reason = $error_message. ' - Maximum retries reached.';
                return false;
            } else {
                return true;
            }
        } else {
            $this->verification_decision = 'Fail';
            $this->verification_reason = $error_message;
            return false;
        }
    }

    function set_document_from_create($type, $data_document) {
        if (!isset($this->document[$type])) { $this->document[$type] = []; }
        $this->document[$type]["document_id"]   = $data_document->DocumentId;
        $this->document[$type]["filename"]      = $data_document->FileName;
        $this->document[$type]["note"]          = $data_document->Note;
        $this->document[$type]["description"]   = $data_document->Description;
    }
    function set_document_file_url($type, $url) {
        if (!isset($this->document[$type])) { $this->document[$type] = []; }
        $this->document[$type]['file_url'] = $url;
    }
    function set_response_info($response_info) {
        $this->response_info['application_id'] = '';
        if (!empty($response_info->ApplicationId)) {
            $this->response_info['application_id']             = $response_info->ApplicationId;
        }
        $this->response_info["solution_set_instance_id"] = '';
        if (!empty($response_info->SolutionSetInstanceId)) {
            $this->response_info["solution_set_instance_id"]   = $response_info->SolutionSetInstanceId;
        }
        $this->response_info["current_queue"] = '';
        if (!empty($response_info->CurrentQueue)) {
            $this->response_info["current_queue"]              = $response_info->CurrentQueue;
        }
    }

    function check_http_code($http_code, $message) {
        if ($http_code >= 200 && $http_code < 299) {
            return true;
        } else {
            Tappa_API_Consumer::log( "ERROR: HTTP CODE." . $http_code . ' ' .$message);
            return false;
        }
    }

    function render_data() {
        echo 'Render api consumer data<pre>';
        echo 'token: ';
        print_r( $this->token );
        echo '<br/>';
        echo 'access_token: ';
        echo $this->access_token;
        echo '<br/>';
        echo 'application_id: ';
        echo $this->application_id;
        echo '<br/>';
        echo 'document: ';
        print_r( $this->document );
        echo '<br/>';
        echo 'response info: ';
        print_r( $this->response_info );
        echo '<br/>';
        echo 'verification_decision: ';
        echo $this->verification_decision;
        echo '<br/>';
        echo 'verification_reason: ';
        echo $this->verification_reason;
        echo '<br/>';
        echo '</pre>';
    }

    /**
     * call
     * Does cURL call to the Zoom API
     *
     * @return array
     */
    function call($endpoint, $data = array(), $action = 'GET', $use_token = true) {
        set_time_limit(6000);

        $curl = curl_init();

        $url = $this->api_base.$endpoint.($action == 'GET' && !empty($data) ? '?'.http_build_query($data) : '');
        Tappa_API_Consumer::log( $url );

        $curl_settings = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_HTTPHEADER => array(
                "X-API-KEY: " . $this->api_key,
                // "User-Agent: Tappa-Website-plugning 0.0.1",
                // "Accept: */*",
                // "Cache-Control: no-cache",
                // "Postman-Token: 90a337b6-ee7d-40c5-9618-7c3c3873da25",
                // "Host: apitest.tappa.co.za",
                // "Accept-Encoding: gzip, deflate, br",
                // "Connection: keep-alive",
                // "content-type: application/json"
            ),
        );

        if ($use_token) {
            if (!$this->token) {
                $r = $this->get_access_token();
                if (!$r) {
                    Tappa_API_Consumer::log( "ERROR: No access token for api call.");
                    return false;
                }
            }
            $curl_settings[CURLOPT_HTTPHEADER][] = 'Accesstoken: ' . $this->token->access_token;
            // $data['access_token'] = $this->token->access_token;
        }

        if (!$this->api_check_ssl) {
            $curl_settings[CURLOPT_SSL_VERIFYHOST] = 0;
            $curl_settings[CURLOPT_SSL_VERIFYPEER] = 0;
        }

        if ('POST' == $action) {
            $curl_settings[CURLOPT_URL] = $this->api_base.$endpoint;
            $curl_settings[CURLOPT_POST] = 1;
            $curl_settings[CURLOPT_POSTFIELDS] = json_encode($data);
        } else {
            $curl_settings[CURLOPT_CUSTOMREQUEST] = $action;
        }


        Tappa_API_Consumer::log('curl settings');
        Tappa_API_Consumer::log($curl_settings);

        curl_setopt_array($curl, $curl_settings);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            Tappa_API_Consumer::log( "ERROR: cURL Error #:" . $err);
          return false;
        } else if (empty($response)) {
            Tappa_API_Consumer::log( "ERROR: Response is empty.");
            return false;
        }
        $response = json_decode($response);
        if ($response === false) {
            Tappa_API_Consumer::log( "ERROR: Invalid JSON");
        } else if ($response->status->code >= 200 && $response->status->code <= 299) {
            Tappa_API_Consumer::log( 'API RESPONSE: ');
            Tappa_API_Consumer::log( (array)$response );
            Tappa_API_Consumer::log( "OKAY: Success.");
            return $response;
        } else {
            Tappa_API_Consumer::log( 'HTTP Response: '.$response->status->code.' - '.$response->status->type.' - '.$response->status->message);
            Tappa_API_Consumer::log( "ERROR");
            Tappa_API_Consumer::log( (array)$response );
            return false;
        }
    }

    function error($err) {
        throw new Exception($err);
    }

    function log($msg) {
        if ($this->api_debug) {
            if (is_array($msg)) {
                echo '<pre>';
                print_r($msg);
                echo '</pre>';
            } else {
                echo $msg.'<br/>';
            }
        }
    }

    function reset() {
        $token = null;
        $access_token = null;
        $application_id = null;
        $document = null;
    }


    function check_valid_response($response) {
        $error_type = $error_message = '';
        $options = [];
        if (is_a($response, 'WP_Error')) {
            $error_type = 'WP_Error';
            $error_message = 'Wordpress Error';
            Tappa_API_Consumer::log('WP ERROR');
        } else if (!$this->check_http_code($response['response']['code'], $response['response']['message'])) {
            $error_type = 'HTTP';
            $error_message = $response['response']['code'] . ' ' .$response['response']['message'];

            $body = json_decode($response['body']);
            if ($body != false) {
                if (!empty($body->errors)) {
                    // "type":"uploadIdDocument_user_error";
                    // "message":"Unable to determine the file mime type.";
                    // "developerMessage":"PEBKAC!";
                    // "moreInfo":"https://apitest.tappa.co.za//documentation/errors/user";
                    // "instance":"/api_v3/Tappa/uploadIdDocument";

                    foreach($body->errors as $list) {
                        if($list->message) {
                            $error_message .= ' '.$list->message;
                        }
                        if($list->type) {
                            $error_message .= ' ('. $list->type.')';
                        }
                    }
                }
            }

            Tappa_API_Consumer::log('HTTP ERROR: '.$error_message);
        } else {
            // PROCESS RESPONSE
            $body = json_decode($response['body']);
            if ($body == false) {
                $error_type = 'Response';
                $error_message = 'No valid JSON';
                Tappa_API_Consumer::log('ERROR: No valid JSON');
            } else if (strtolower($body->status->type) != 'success') {
                $error_type = 'API';
                $error_message = $body->status->type.' '.$body->status->message;

                if (!empty($body->errors)) {
                    $error_message .= ' -- ';
                    foreach($body->errors as $list) {
                        foreach($list as $k => $v) {
                            $error_message .= '"'.$k.'":"'.$v.'";'."\n";
                        }
                    }
                }

                Tappa_API_Consumer::log('ERROR: No valid JSON');
            }
        }

        return array($error_type, $error_message);
    }

}