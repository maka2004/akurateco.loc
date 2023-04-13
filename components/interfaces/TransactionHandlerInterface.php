<?php

namespace app\components\interfaces;

interface TransactionHandlerInterface
{
    public function init(array $params);

    public function run();
}
