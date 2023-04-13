<?php

namespace app\components\interfaces;

interface TransactionHandlerInterface
{
    function init(array $params);
    function run();
}
