<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 28.12.2016
 * Time: 12:23
 */
class b2_api_class extends base
{

    public function upload($file)
    {
        return $this->makeApiCall('UPLOAD', ['file' => $file]);
    }

    public function getStoreInfo()
    {
        return $this->makeApiCall('INFO_STORE');
    }

    public function getZipInfo($zip)
    {
        return $this->makeApiCall('INFO_ZIP', ['zip' => $zip]);
    }

    public function getRates($params)
    {
        return $this->makeApiCall('TARIF', $params);
    }

    public function getStatuses($params)
    {
        $params['code_type'] = 'client';
        return $this->makeApiCall('STATUS_LIST', $params);
    }

    public function makeApiCall($func, array $params = array(), $url = '', $method = 'GET') {
        $params['func'] = $func;
        $params['client'] = B2_API_CLIENT;
        $params['key'] = B2_API_KEY;
        $url = B2_API_URL . $url . ($method == 'GET' ? '?' . http_build_query($params) : '');
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

    public function getOrderStatus()
    {

    }

    public function uploadOrder($order)
    {
        $params = [

        ];
    }
}