<?php
/**
 * Created by PhpStorm.
 * User: novichkov
 * Date: 14.06.17
 * Time: 18:49
 */
class vertex_api_class extends base
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
        echo $response;
        return json_decode($response, true);
    }

    public function order($params)
    {
        $url = 'https://powers.leadvertex.ru/api/webmaster/v2/addOrder.html?webmasterID=21&token=0258dd41630f47abf515fd88bb373c21';
        return $this->makeApiCall($url, 'POST', $params);

    }

}