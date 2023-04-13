<?php

namespace app\component\transaction;

use app\components\Model;

class Transaction extends Model
{
    public const RESULT_SUCCESS = 'SUCCESS';
    public const RESULT_DECLINED = 'DECLINED';
    public const RESULT_REDIRECT = 'REDIRECT';
    public const RESULT_ACCEPTED = 'ACCEPTED';
    public const RESULT_ERROR = 'ERROR';

    public const STATUS_3DS = '3DS';
    public const STATUS_REDIRECT = 'REDIRECT';
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PREPARE = 'PREPARE';
    public const STATUS_SETTLED = 'SETTLED';
    public const STATUS_REVERSAL = 'REVERSAL';
    public const STATUS_REFUND = 'REFUND';
    public const STATUS_CHARGEBACK = 'CHARGEBACK';
    public const STATUS_DECLINED = 'DECLINED';

    public const SCENARIO_SALE = 'SALE';
    public const SCENARIO_CAPTURE = 'CAPTURE';
    public const SCENARIO_CREDITVOID = 'CREDITVOID';

    public function rules(): array
    {
        return [
            ['action', ['required', 'string', 'enum' => [self::SCENARIO_SALE, self::SCENARIO_CAPTURE, self::SCENARIO_CREDITVOID]]],
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