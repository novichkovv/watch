<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 18.05.2016
 * Time: 0:38
 */
class paypal_api_class extends base
{
    private $access_token;

    public function test($params)
    {
        $url = PAYPAL_API_URL . 'payments/payment';
        $this->makeApiCall($url, 'POST', $params);
    }

    public function sendPaymentRequest($params)
    {
        $url = PAYPAL_API_URL . 'payments/payment';
        return $this->makeApiCall($url, 'POST', $params);
    }

    public function __construct()
    {
        $this->getAccessToken();
    }

    public function getAccessToken()
    {
        if(!$this->access_token) {
            $params = [
                'grant_type' => 'client_credentials'
            ];
            $headers = [
                'Accept: application/json',
                'Accept-Language: en_US'
            ];
            $client_credentials = PAYPAL_API_CLIENT_ID . ':' . PAYPAL_API_CLIENT_SECRET;
            $curl = curl_init(PAYPAL_API_URL . 'oauth2/token');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_USERPWD, $client_credentials);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
            $response = curl_exec($curl);
            $res = json_decode($response, true);
            $this->access_token = $res['access_token'];
        }
    }

    private function makeApiCall($url, $method, array $params = array()) {
        $headers = array(
            "User-Agent: php-tutorial/1.0",
            "Authorization: Bearer " . $this->access_token,
            "Content-Type: application/json",
        );
        $curl = curl_init($url);
        switch($method) {
            case "GET":
                break;
            case "POST":
                $headers[] = "Content-Type: application/json";
                curl_setopt($curl, CURLOPT_POST, true);
                $params = $params ? json_encode($params) : json_encode($params, JSON_FORCE_OBJECT);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
            case "PATCH":
                $headers[] = "Content-Type: application/json";
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
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        return json_decode($response, true);
    }

    private function getRefreshToken($id)
    {
        return $this->model('system_config')->getByField('config_key', 'paypal_refresh_token')['config_value'];
    }

    private function setRefreshToken($token)
    {
        $this->model('system_config')->insert([
            'config_key' => 'paypal_refresh_token',
            'config_value' => $token
        ]);
        $this->refresh_token = $token;
    }

}