<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 22.10.2016
 * Time: 15:41
 */
class m1_api_class extends base
{
    public function makeApiCall($url, $method, array $params = array()) {
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
        $response = curl_exec($curl);
        return json_decode($response, true);
    }

    public static function sendOrder($data)
    {
        $data['api_key'] = M1_API_KEY;
        return self::makeApiCall(M1_API_URL, 'POST', $data);
    }
}