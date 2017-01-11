<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 09.01.2017
 * Time: 12:12
 */


class payment_class extends base
{
    function generateParams($order)
    {
        $params = [];
//        $params['MNT_SIGNATURE'] = md5(MNT_ID . $order['id'] . $order['sum'] . MNT_CURRENCY_CODE . $order['user_id'] . MNT_TEST_MODE . MNT_SECRET);
        $params['MNT_ID'] = MNT_ID;
        $params['MNT_TRANSACTION_ID'] = $order['id'];
        $params['MNT_CURRENCY_CODE'] = 'RUB';
        $params['MNT_AMOUNT'] = $order['sum'];
        return $params;
    }

    public function makeRequest($params)
    {
        $headers = array(
            "User-Agent: php-tutorial/1.0",
        );
        $headers[] = "Content-Type: application/json";
        $curl = curl_init(MNT_URL);
        curl_setopt($curl, CURLOPT_POST, true);
        $params = $params ? json_encode($params) : json_encode($params, JSON_FORCE_OBJECT);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        echo $response;
        var_dump($response);
        return json_decode($response, true);
    }
}