<?php

namespace app\component\transaction;

use app\component\Curl;
use app\components\interfaces\TransactionHandlerInterface;

class Capture implements TransactionHandlerInterface
{
    use Curl;

    function init(array $params)
    {
        // TODO: Implement init() method.
    }

    function run()
    {
        // TODO: Implement run() method.
    }
}