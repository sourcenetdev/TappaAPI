<?php
/**
 * KyrandiaCMS
 *
 * An extremely customizable CMS based on CodeIgniter 3.1.11.
 *
 * @package   Impero
 * @author    Kobus Myburgh
 * @copyright Copyright (c) 2011 - 2020, Impero, all rights reserved.
 * @license   Proprietary and confidential. Unauthorized copying of this file, via any medium is strictly prohibited.
 * @link      https://www.impero.co.za
 * @since     Version 1.0
 * @version   7.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KyrandiaCMS Config
 *
 * This is the Payfast config file for KyrandiaCMS
 *
 * @package     Impero
 * @subpackage  Configs
 * @category    Configs
 * @author      Kobus Myburgh
 * @link        https://www.impero.co.za
 * @version     7.0.0
 */

define('PF_SERVER', 'LIVE');

$config['payHost'] = (PF_SERVER == 'LIVE') ? 'www.payfast.co.za' : 'sandbox.payfast.co.za';
$config['debug'] = true;
$config['demoMode'] = true;
$config['currency'] = 'ZAR';
$config['payMerchantIdentifier'] = 'GOGO_';
$config['payMerchantReference'] = 'GOGO_';

// Direct payment details
$config['payMerchantId'] = '10010035';
$config['payMerchantKey'] = 'd0qq2lot8q301';
$config['payPassPhrase'] = 'BlinkAndItsGone';

// Subscription payments - LIVE details, because Kobus needs to test this with a live account.
$config['testingSubs'] = true;
$config['paySubscription'] = 2;
$config['payFrequency'] = 3;
$config['payCycles'] = 0;

// $config['paySubMerchantId'] = '10176324';
// $config['paySubMerchantId'] = '10000100';
$config['paySubMerchantId'] = '10611182';

// $config['paySubMerchantKey'] = '663go4s9gwrxc';
// $config['paySubMerchantKey'] = '46f0cd694581a';
$config['paySubMerchantKey'] = 'gpgh4da1k0jci';

// $config['paySubPassPhrase'] = 'Payfast of Kyr4ndi4';
// $config['paySubPassPhrase'] = '';
$config['paySubPassPhrase'] = 'wildfight99';

if (!empty($config['testingSubs'])) {
    $config['payMerchantId'] = $config['paySubMerchantId'];
    $config['payMerchantKey'] = $config['paySubMerchantKey'];
    $config['payPassPhrase'] = $config['paySubPassPhrase'];
    $config['debug'] = false;
    $config['demoMode'] = false;
    $config['payHost'] = 'www.payfast.co.za';
}

$config['returnUrlStage'] = 'https://gogo.maxapi.co.za/api_v3/PayFast/pfReturn';
$config['cancelUrlStage'] = 'https://gogo.maxapi.co.za/api_v3/PayFast/pfCancel';
$config['notifyUrlStage'] = 'https://gogo.maxapi.co.za/api_v3/PayFast/pfNotify';
$config['updateUrlStage'] = 'https://gogo.maxapi.co.za/api_v3/PayFast/pfUpdate';
$config['returnUrlLive'] = 'https://gogo.maxapi.co.za/api_v3/PayFast/pfReturn';
$config['cancelUrlLive'] = 'https://gogo.maxapi.co.za/api_v3/PayFast/pfCancel';
$config['notifyUrlLive'] = 'https://gogo.maxapi.co.za/api_v3/PayFast/pfNotify';
$config['updateUrlLive'] = 'https://gogo.maxapi.co.za/api_v3/PayFast/pfUpdate';
$config['userName'] = 'Kobus';
$config['userSurname'] = 'Myburgh';
$config['userEmail'] = 'kobus.myburgh@impero.co.za';
$config['payButtonClass'] = 'btn btn-primary';
$config['payPrompt'] = 'Pay now';
$config['paymentId'] = '12345';
$config['payAmount'] = '5.00';
$config['payOrderNumber'] = '12345';
$config['payCancelHeading'] = 'Order Demo - CANCELLED';
$config['paySuccessHeading'] = 'Order Demo - SUCCESS';
$config['payHeading'] = 'Order Demo - START';
$config['payTitle'] = 'PayFast Payment Demo';
$config['payUpdateUrl'] = '/eng/recurring/update/{token}?return={return}';
$config['payFastVersion'] = 1;
