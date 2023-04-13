<?php

namespace app\component\gateways;

use app\components\interfaces\GatewayInterface;
use app\models\Gateway_01_Request;
use app\components\Gateway;

class Gateway_01 extends Gateway implements GatewayInterface
{
    private $url = 'http://akurateco.loc/cap/payment.php'; // payment gateway URL
    private static $capClientPass = 'qwerty';

    /**
     * @return string[]
     */
    function getParamsOut()
    {
        return [
            // request params
            'action' => 'action',
            'client_key' => 'client_key',
            'channel_id' => 'channel_id',
            'merchant_transaction_id' => 'order_id',
            'amount' => 'order_amount',
            'currency' => 'order_currency',
            'description' => 'order_description',
            'card_number' => 'card_number',
            'exp_month' => 'card_exp_month',
            'exp_year' => 'card_exp_year',
            'cvv2' => 'cvv2',
            'first_name' => 'payer_first_name',
            'last_name' => 'payer_last_name',
            'middle_name' => 'payer_middle_name',
            'birth_date' => 'payer_birth_date',
            'address' => 'payer_address',
            'address2' => 'payer_address2',
            'country' => 'payer_country',
            'state' => 'payer_state',
            'city' => 'payer_city',
            'zip' => 'payer_zip',
            'email' => 'payer_email',
            'phone' => 'payer_phone',
            'client_ip' => 'payer_ip',
            'term_url_3ds' => 'term_url_3ds',
            'recurring_init' => 'recurring_init',
            'auth' => 'auth',
        ];
    }

    /**
     * @return string[]
     */
    function getParamsIn()
    {
        return [
            'action' => 'action',
            'result' => 'result',
            'status' => 'status',
            'merchant_transaction_id' => 'order_id',
            'gateway_transaction_id' => 'trans_id',
            'created_at' => 'trans_date',
            'descriptor' => 'descriptor',
            'recurring_token' => 'recurring_token',
            'paid_amount' => 'amount',
            'paid_currency' => 'currency',
            'hash' => 'hash',
        ];
    }

    function getUrl()
    {
        return $this->url;
    }

    function getRequest($transaction)
    {
        $request = new Gateway_01_Request();
        foreach ($this->getParamsOut() as $innerFieldName => $outerFieldName) {
            if (isset($transaction->$innerFieldName)) {
                $request->$outerFieldName = $transaction->$innerFieldName;
            }
        }
        return $request;
    }

    public function generateSignature($transaction)
    {
        return md5(strtoupper(strrev($transaction->email) . self::$capClientPass .
            strrev(substr($transaction->card_number,0,6).substr($transaction->card_number,-4))));
    }

    public function checkSignature($transaction, array $params)
    {
        $checkSignature = md5(
            strtoupper(strrev($transaction->email)
                . self::$capClientPass
                . $params['gateway_transaction_id']
                . strrev(
                    substr($transaction->card_number,0,6)
                    . substr($transaction->card_number,-4)
                )
            )
        );

        return $params['hash'] == $checkSignature;
    }
}