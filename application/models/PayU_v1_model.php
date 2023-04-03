<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Fastfood_v1_model
*
* @uses CI_Model
*
* @author Kobus Myburgh <kobus.myburgh@impero.co.za>
*/
class PayU_v1_model extends CI_Model
{
    private $tables;
    private $date_format;

    public function __construct()
    {
        parent::__construct();
        $this->date_format = 'Y-m-d H:i:s';
        $this->tables = [
            'payu' => 'maxapi_payu'
        ];
    }

    // TODO: Validation on partial updates - currently in controller, and working, but needs more generic approach...
    public function setTransactionSave($saveData, $transactionType = 'PAYMENT')
    {
        $saveData['modify_date'] = date('Y-m-d H:i:s');
        if (empty($saveData)) {
            $err = [
                'status' => -1,
                'error' => lang('payu_v1_model_no_set_transaction_data'),
            ];

            return $err;
        }
        $this->db->where('payUReference', $saveData['return']['payUReference']);
        $res = $this->db->get($this->tables['payu'])->row_array();
        if (empty($res)) {

            // TODO here - immediate completion of transaction.
            if ($transactionType == 'RESERVE') {
                $status = 'Reserved';
            } elseif ($transactionType == 'PAYMENT') {
                $status = 'Payment';
            }
            if (empty($saveData['return']['successful'])) {
                $status = 'Failed';
            }
            $insert_data = [
                'merchantReference' => $saveData['return']['merchantReference'],
                'payUReference' => $saveData['return']['payUReference'],
                'initiateSuccess' => $saveData['return']['successful'],
                'status' => $status,
                'node' => $saveData['node'],
                'botId' => $saveData['botId'],
                'clientId' => $saveData['clientId'],
                'token' => $saveData['token'],
                'count' => $saveData['count'],
                'transactionType' => $transactionType,
                'initiateDate' => date('Y-m-d H:i:s'),
                'createDate' => date('Y-m-d H:i:s'),
                'modifyDate' => date('Y-m-d H:i:s')
            ];
            $this->db->insert($this->tables['payu'], $insert_data);
            $insert_data['id'] = $this->db->insert_id();
            return $insert_data;
        } else {
            $err = [
                'status' => -2,
                'error' => lang('payu_v1_model_transaction_exists'),
            ];

            return $err;
        }
    }

    public function setTransactionGet($reference)
    {
        $this->db->where('payUReference', $reference);
        $setTransaction = $this->db->get($this->tables['payu'])->row_array();
        if (!empty($setTransaction)) {

            return $setTransaction;
        }
        $err = [
            'status' => -1,
            'error' => lang('payu_v1_model_no_setTransaction_found')
        ];

        return $err;
    }

    /*
    public function doTransactionSave($saveData, $transactionType = 'FINALIZE')
    {
        $saveData['modify_date'] = date('Y-m-d H:i:s');
        if (empty($saveData)) {
            $err = [
                'status' => -1,
                'error' => lang('payu_v1_model_no_set_transaction_data'),
            ];

            return $err;
        }
        $this->db->where('payUReference', $saveData['return']['payUReference']);
        $res = $this->db->get($this->tables['payu'])->row_array();
        if (!empty($res)) {
            $status = 'Completed';
            if (empty($saveData['return']['payUReference'])) {
                $status = 'Failed';
            }
            $update_data = [
                'completeSuccess' => $saveData['return']['successful'],
                'completeResultCode' => $saveData['return']['resultCode'],
                'completeResultMessage' => $saveData['return']['resultMessage'],
                'completeDate' => date('Y-m-d H:i:s'),
                'transactionType' => $transactionType,
                'merchantReference' => $saveData['return']['merchantReference'],
                'status' => $status,
                'node' => $saveData['node'],
                'botId' => $saveData['botId'],
                'clientId' => $saveData['clientId'],
                'token' => $saveData['token'],
                'modifyDate' => date('Y-m-d H:i:s')
            ];
            $this->db->where('payUReference', $saveData['return']['payUReference']);
            $this->db->update($this->tables['payu'], $update_data);
            return $update_data;
        } else {
            $err = [
                'status' => -2,
                'error' => lang('payu_v1_model_transaction_does_not_exist'),
            ];

            return $err;
        }
    }
    */

    /*
    public function cancelTransactionSave($saveData, $transactionType = 'RESERVE_CANCEL')
    {
        $saveData['modify_date'] = date('Y-m-d H:i:s');
        if (empty($saveData)) {
            $err = [
                'status' => -1,
                'error' => lang('payu_v1_model_no_set_transaction_data'),
            ];

            return $err;
        }
        $this->db->where('payUReference', $saveData['return']['payUReference']);
        $this->db->where('status', 'Reserved');
        $res = $this->db->get($this->tables['payu'])->row_array();
        if (!empty($res)) {
            $status = 'Cancelled';
            if (empty($saveData['return']['successful'])) {
                $status = 'Failed';
            }
            $update_data = [
                'cancelSuccess' => $saveData['return']['successful'],
                'cancelResultCode' => $saveData['return']['resultCode'],
                'cancelResultMessage' => $saveData['return']['resultMessage'],
                'cancelDisplayMessage' => $saveData['return']['displayMessage'],
                'cancelDate' => date('Y-m-d H:i:s'),
                'transactionType' => $transactionType,
                'merchantReference' => $saveData['return']['merchantReference'],
                'status' => $status,
                'node' => $saveData['node'],
                'botId' => $saveData['botId'],
                'clientId' => $saveData['clientId'],
                'token' => $saveData['token'],
                'modifyDate' => date('Y-m-d H:i:s')
            ];
            $this->db->where('payUReference', $saveData['return']['payUReference']);
            $this->db->update($this->tables['payu'], $update_data);
            return $update_data;
        } else {
            $err = [
                'status' => -2,
                'error' => lang('payu_v1_model_transaction_does_not_exist'),
            ];

            return $err;
        }
    }
    */
}
