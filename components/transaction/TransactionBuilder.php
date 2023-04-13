<?php

namespace app\component\transaction;

use app\component\gateways\Gateway_01;
use app\component\transaction\Capture;
use app\component\transaction\Sale;

class TransactionBuilder
{
    public const SALE = 'SALE';
    public const CAPTURE = 'CAPTURE';

    /**
     * determine transaction type
     *
     * @param array $params
     * @return \app\component\transaction\Capture|\app\component\transaction\Sale|null
     */
    public static function getTransactionHandler(array $params): \app\component\transaction\Capture|\app\component\transaction\Sale|null
    {
        $handler = null;

        if (isset($params['action']) && !empty($params['action'])) {
            if (self::SALE == $params['action']) {
                $handler = new Sale();
                $handler->init($params);
            } elseif (self::CAPTURE == $params['action']) {
                $handler = new Capture();
                $handler->init($params);
            }
        }

        return $handler;
    }

    /**
     * get payment gateway
     *
     * @param array $params
     * @return mixed|string|null
     */
    public static function getGateway(array $params): mixed
    {
        $gateway = null;

        if (isset($params['gateway']) && !empty($params['gateway'])) {
            $gateway = 'app\component\gateways\\' . $params['gateway'];
            if (class_exists($gateway)) {
                $gateway = new $gateway();
            }
        }

        return $gateway;
    }

    /**
     * check for redirection
     *
     * @param array $params
     * @return void
     */
    public static function checkRedirect(array $params)
    {
        if (Transaction::RESULT_REDIRECT == $params['result']) {
            header('Location: ' . $params['redirect_url'], true, 302);
            exit();
        }
    }
}