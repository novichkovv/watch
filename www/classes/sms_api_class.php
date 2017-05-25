<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 24.01.2017
 * Time: 13:25
 */
class sms_api_class extends base
{
    public function send_sms($to, $text)
    {
        $url = SMS_API_URL . 'sms/send';
        return $this->makeApiCall($url, [
            'to' => $to,
            'text' => $text
        ]);
    }

    private function makeApiCall($url, array $params = array(), $method = 'POST') {
        $params['api_id'] = SMS_API_ID;
        $curl = curl_init($url);
        switch($method) {
            case "GET":
                break;
            case "POST":
//                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
//                $params = $params ? json_encode($params) : json_encode($params, JSON_FORCE_OBJECT);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
            case "PATCH":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
                break;
            default:
                self::writeLog('EXCHANGE', 'INVALID METHOD ' . $method);
                exit;
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        return json_decode($response, true);
    }
}