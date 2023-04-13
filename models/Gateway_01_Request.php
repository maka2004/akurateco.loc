<?php

namespace app\models;

use app\components\Model;

class Gateway_01_Request extends Model
{
    public function rules()
    {
        return [
            ['action', ['required', 'string', 'enum' => [Request::SCENARIO_SALE, Request::SCENARIO_CAPTURE, Request::SCENARIO_CREDITVOID]]],
            ['client_key', ['required', 'string', 'min' => 36, 'max' => 36]],
            ['channel_id', ['string', 'max' => 16]],
            ['order_id', ['required', 'string', 'max' => 255]],
            ['order_amount', ['required', 'float']],
            ['order_currency', ['required', 'string', 'max' => 3]],
            ['order_description', ['required', 'string', 'max' => 1024]],
            ['card_number', ['required', 'string', 'min' => 13, 'max' => 19]],
            ['card_exp_month', ['required', 'string', 'min' => 2, 'max' => 2]],
            ['card_exp_year', ['required', 'string', 'min' => 3, 'max' => 4]],
            ['cvv2', ['required', 'string', 'min' => 3, 'max' => 4]],
            ['payer_first_name', ['required', 'string', 'max' => 32]],
            ['payer_last_name', ['required', 'string', 'max' => 32]],
            ['payer_middle_name', ['string', 'max' => 32]],
            ['payer_birth_date', ['string', 'min' => 10, 'max' => 10]],
            ['payer_address', ['required', 'string', 'max' => 255]],
            ['payer_address2', ['string', 'max' => 255]],
            ['payer_country', ['required', 'string', 'min' => 2, 'max' => 2]],
            ['payer_state', ['string', 'max' => 32]],
            ['payer_city', ['required', 'string', 'max' => 32]],
            ['payer_zip', ['required', 'string', 'max' => 10]],
            ['payer_email', ['required', 'string', 'max' => 256]],
            ['payer_phone', ['required', 'string', 'max' => 32]],
            ['payer_ip', ['required', 'string', 'max' => 15]],
            ['term_url_3ds', ['required', 'string', 'max' => 1024]],
            ['recurring_init', ['string', 'max' => 1]],
            ['auth', ['string', 'max' => 1]],
        ];
    }
}