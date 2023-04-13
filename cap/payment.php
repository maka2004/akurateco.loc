<?php
$data = json_decode(file_get_contents('php://input'), true);

$capClientPass = 'qwerty';
$trans_id = 'aaaff66a-904f-11ea-833e-0242ac1f0007'; // (string)rand(17, 13360);

$response = [
    'action' => $data['action'],
    'result' => 'SUCCESS',
    'status' => 'SETTLED',
    'order_id' => $data['order_id'],
    'trans_id' => $trans_id, // generate new transaction ID (on gateway side)
    'created_at' => date('YYYY-mm-dd', time()),
    'descriptor' => $data['payer_first_name'] . ' ' . $data['payer_last_name'],
    'recurring_token' => 'recurring_token',
    'amount' => $data['order_amount'],
    'currency' => $data['order_currency'],
];

$response['hash'] = md5(
    strtoupper(strrev($data['payer_email'])
        . $capClientPass
        . $trans_id
        . strrev(
            substr($data['card_number'],0,6)
            . substr($data['card_number'],-4)
        )
    )
);

echo json_encode($response);