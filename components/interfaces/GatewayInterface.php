<?php

namespace app\components\interfaces;

interface GatewayInterface
{
    public function getParamsOut();
    public function getParamsIn();
    public function getUrl();
    public function getRequest($transaction);
    public function generateSignature($transaction);
    public function checkSignature($transaction, array $params);
}