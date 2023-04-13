<?php

namespace app\component\transaction;

use app\component\Curl;
use app\component\Helper;
use app\components\interfaces\GatewayInterface;
use app\components\interfaces\TransactionHandlerInterface;

class Sale implements TransactionHandlerInterface
{
    use Curl;

    private GatewayInterface $gateway;
    private Transaction $transaction;

    public function init(array $params)
    {
        $this->transaction = new Transaction();

        // assign transaction fields
        $this->transaction->load($params);

        // assign gateway
        $this->gateway = TransactionBuilder::getGateway($params);

        // save transaction
    }

    public function run()
    {
        if ($this->transaction->validate()) {
            // prepare request
            $request = $this->gateway->getRequest($this->transaction);

            // process transaction
            if ($request->validate()) {
                // prepare request data
                $params = $request->getPropertiesArray();
                $params['hash'] = $this->gateway->generateSignature($this->transaction);

                // send request
                $result = $this->send($this->gateway->getUrl(), json_encode($params), true);

                // interpretation answer
                if (Helper::isJson($result)) {
                    $result = json_decode($result);
                    $result = $this->gateway->getInnerParams($result);
                }

                // check signature
                if ($this->gateway->checkSignature($this->transaction, $result)) {
                    // update transaction
                    $this->transaction->load($result);

                    // save transaction

                    // redirect if 3DS
                    TransactionBuilder::checkRedirect($result);
                }
            } else {
                print_r($request->errors);
            }
        } else {
            print_r($this->transaction->errors);
        }

        return $this->transaction;
    }

}