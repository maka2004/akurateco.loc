<?php

namespace app\component\transaction;

use app\components\Model;
use app\models\Request;

class Transaction extends Model
{
    const RESULT_SUCCESS = 'SUCCESS';
    const RESULT_DECLINED = 'DECLINED';
    const RESULT_REDIRECT = 'REDIRECT';
    const RESULT_ACCEPTED = 'ACCEPTED';
    const RESULT_ERROR = 'ERROR';

    const STATUS_3DS = '3DS';
    const STATUS_REDIRECT = 'REDIRECT';
    const STATUS_PENDING = 'PENDING';
    const STATUS_PREPARE = 'PREPARE';
    const STATUS_SETTLED = 'SETTLED';
    const STATUS_REVERSAL = 'REVERSAL';
    const STATUS_REFUND = 'REFUND';
    const STATUS_CHARGEBACK = 'CHARGEBACK';
    const STATUS_DECLINED = 'DECLINED';

    public function rules()
    {
        return [
            ['action', ['required', 'string', 'enum' => [Request::SCENARIO_SALE, Request::SCENARIO_CAPTURE, Request::SCENARIO_CREDITVOID]]],
            ['gateway', ['required', 'string', 'max' => 255]],
            ['client_key', ['required', 'string', 'min' => 36, 'max' => 36]],
            ['channel_id', ['string', 'max' => 16]],
            ['transaction_id', ['required', 'int']], // internal transaction id
            ['merchant_transaction_id', ['string', 'max' => 255]],
            ['gateway_transaction_id', ['string', 'max' => 255]],
            ['amount', ['required', 'float']],
            ['paid_amount', ['float']], // amount from gateway
            ['currency', ['required', 'string', 'max' => 3]],
            ['paid_currency', ['string', 'max' => 3]], // currency from gateway
            ['description', ['required', 'string', 'max' => 1024]],
            ['card_number', ['required', 'string', 'min' => 13, 'max' => 19]],
            ['exp_month', ['required', 'string', 'min' => 2, 'max' => 2]],
            ['exp_year', ['required', 'string', 'min' => 4, 'max' => 4]],
            ['cvv2', ['required', 'string', 'min' => 3, 'max' => 4]],
            ['first_name', ['required', 'string', 'max' => 32]],
            ['last_name', ['required', 'string', 'max' => 32]],
            ['middle_name', ['string', 'max' => 32]],
            ['birth_date', ['string', 'min' => 10, 'max' => 10]],
            ['address', ['required', 'string', 'max' => 255]],
            ['address2', ['string', 'max' => 255]],
            ['country', ['required', 'string', 'min' => 2, 'max' => 2]],
            ['state', ['string', 'max' => 32]],
            ['city', ['required', 'string', 'max' => 32]],
            ['zip', ['required', 'string', 'max' => 10]],
            ['email', ['required', 'string', 'max' => 256]],
            ['phone', ['required', 'string', 'max' => 32]],
            ['client_ip', ['required', 'string', 'max' => 15]],
            ['term_url_3ds', ['required', 'string', 'max' => 1024]],
            ['recurring_init', ['string', 'max' => 1]],
            ['auth', ['string', 'max' => 1]],
            ['result', ['string', 'enum' => [
                self::RESULT_ACCEPTED,
                self::RESULT_DECLINED,
                self::RESULT_ERROR,
                self::RESULT_REDIRECT,
                self::RESULT_SUCCESS
            ]]],
            ['status', ['string', 'enum' => [
                self::STATUS_3DS,
                self::STATUS_CHARGEBACK,
                self::STATUS_DECLINED,
                self::STATUS_PENDING,
                self::STATUS_PREPARE,
                self::STATUS_REDIRECT,
                self::STATUS_REFUND,
                self::STATUS_REVERSAL,
                self::STATUS_SETTLED,
            ]]],
            ['created_at', ['string', 'min' => 10, 'max' => 10]],
            ['descriptor', ['string', 'max' => 255]],
            ['recurring_token', ['string', 'max' => 255]]
        ];
    }
}