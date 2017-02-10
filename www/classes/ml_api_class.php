<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.02.2017
 * Time: 21:26
 */
class ml_api_class extends base
{
    public function makeApiCall($func, array $params = array(), $api = 1, $method = 'POST') {
        $params['api_key'] = ($api == 1 ? ML_AD_API_KEY : ML_WM_API_KEY);
        $params['format'] = 'json';
        $url = ML_API_URL . $func . ($method == 'GET' ? '?' . http_build_query($params) : '');
        $headers = array(
            "User-Agent: php-tutorial/1.0",
        );
        $curl = curl_init($url);
        switch($method) {
            case "GET":
                break;
            case "POST":
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
                break;
            case "PATCH":
                $headers[] = "Content-Type: application/json";
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
            default:
                self::writeLog('EXCHANGE', 'INVALID METHOD ' . $method);
                exit;
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = iconv("windows-1251", "utf-8", curl_exec($curl));
        echo $response;
        return json_decode($response, true);
    }

    public function addLead($params)
    {
        $params['ip'] = 1;
        $params['code'] = 'qy6apbtke';
        $params['traffic_type'] = 0;
        $this->makeApiCall('order.add', $params, 2);
    }

    public function getOrderList($params)
    {
        $this->makeApiCall('order.list', $params, 2);
    }

    public function getOrderInfo($order)
    {
        
    }
}