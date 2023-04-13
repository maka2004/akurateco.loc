<?php

namespace app\models;

use app\components\Model;

class Request extends Model
{
    const SCENARIO_SALE = 'SALE';
    const SCENARIO_CAPTURE = 'CAPTURE';
    const SCENARIO_CREDITVOID = 'CREDITVOID';

    public function rules()
    {
        return [
            ['id', ['required']],
            ['firstName', ['string', 'max' => 5]],
            ['lastName', ['string']],
            ['action', ['string', 'enum' => [self::SCENARIO_SALE, self::SCENARIO_CAPTURE, self::SCENARIO_CREDITVOID]]]
        ];
    }
}