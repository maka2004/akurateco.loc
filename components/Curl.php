<?php

namespace app\component;

use app\component\Helper;
use ErrorException;

trait Curl
{
    /**
     * @param $url
     * @param $data_json
     * @param bool $is_post
     * @return string
     * @throws ErrorException
     */
    public function send($url, $data_json, $is_post = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-length: " . strlen($data_json)));

        if ($is_post) {
            curl_setopt($ch, CURLOPT_POST, 1);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        }

        if ($data_json !== null) {
            if (Helper::isJson($data_json)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            } else {
                throw new ErrorException('Wrong json format');
            }
        }

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}
