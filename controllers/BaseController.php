<?php
namespace app\controllers;

use app\component\transaction\TransactionBuilder;

class BaseController
{
    public function actionIndex()
    {
        $params = [
            'action' => 'SALE',
            'client_key' => 'c2b8fb04-110f-11ea-bcd3-0242c0a85004',
            'channel_id' => 'channel_id',
            'merchant_transaction_id' => 'ORDER-12345', // merchant
            'transaction_id' => 12,
            'gateway' => 'Gateway_01',
            'amount' => 1.99,
            'currency' => 'USD',
            'description' => 'Product',
            'card_number' => '4111111111111111',
            'exp_month' => '01',
            'exp_year' => '2025',
            'cvv2' => '000',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birth_date' => '1991-01-01',
            'address' => 'Big street',
            'country' => 'US',
            'state' => 'CA',
            'city' => 'City',
            'zip' => '12345',
            'email' => 'doe@example.com',
            'phone' => '199999999',
            'client_ip' => '123.123.123.123',
            'term_url_3ds' => 'http://akurateco.loc/transactionUpdate.php',
            'recurring_init' => 'Y',
            'auth' => 'N',
        ];

        $transactionHandler = TransactionBuilder::getTransactionHandler($params);

        if ($transactionHandler) {
            // process all the stuff
            $transactionHandler->init($params);
            $transaction = $transactionHandler->run();
        } else {
            // broken params
        }

        // do something with transaction
//        dd($transaction);
    }

    /**
     * got outer request after 3d security passed
     *
     * @return void
     */
    public function actionTransactionUpdate()
    {
        // find transaction

        // inject proper gateway class

        // check signature

        // update transaction

        // save transaction
    }

}