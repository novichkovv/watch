<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 12.01.2017
 * Time: 17:08
 */
class ahunter_api_class extends base
{

    public function getNormalAddress($address_string)
    {
        $url = AHUNTER_API_URL . 'site/cleanse/address';
        $params = [
            'user' => AHUNTER_API_TOKEN,
            'output' => 'json',
            'query' => $address_string
        ];
        $url .= '?' . http_build_query($params);
        return $this->makeAddressArray($this->makeApiCall($url));
    }

    private function makeAddressArray($address_response)
    {
        $row = [];
        $fields = $address_response['addresses'][0]['fields'];
        $row['zip'] = $fields[9]['name'];
        $row['region'] = $fields[0]['type'] . ' ' . $fields[0]['name'];
        $row['area'] = $fields[1]['type'] . ' ' . $fields[1]['name'];
        $row['city'] = $fields[2]['type'] . ' ' . $fields[2]['name'];
        $row['place'] = $fields[3]['type'] . ' ' . $fields[3]['name'];
        $row['street'] = $fields[4]['type'] . ' ' . $fields[4]['name'];
        $row['house'] = $fields[5]['type'] . ' ' . $fields[5]['name'];
        $row['building'] = $fields[6]['type'] . ' ' . $fields[6]['name'];
        $row['structure'] = $fields[7]['type'] . ' ' . $fields[7]['name'];
        $row['flat'] = $fields[8]['type'] . ' ' . $fields[8]['name'];
        $row['address'] = $row['zip'] . ', ' . $address_response['addresses'][0]['pretty'];
        return $row;
    }

    public function makeApiCall($url, $method = 'GET', array $params = array()) {
//        $response = '{"addresses":[{"codes":{"kladr_actual":"500000260000167","kladr_detected":"500000260000167","kladr_pure":"500000260000167"},"cover":[{"in":"обл Московская"},{"out":","},{"in":"г Орехово-Зуево"},{"out":","},{"in":"ул Парковская"},{"out":","},{"in":"36"}],"fields":[{"c":"50","cover":"обл Московская","level":"Region","name":"Московская","ns":1.00,"ts":1.00,"type":"обл"},{"level":"District"},{"c":"026","cover":"г Орехово-Зуево","level":"City","name":"Орехово-Зуево","ns":1.00,"ts":1.00,"type":"г"},{"level":"Place"},{"c":"0167","cover":"ул Парковская","level":"Street","name":"Парковская","ns":1.00,"ts":1.00,"type":"ул"},{"c":"0002","cover":"36","level":"House","name":"36","ns":1.00,"ts":0.00,"type":"дом"},{"level":"Building"},{"level":"Structure"},{"level":"Flat"},{"level":"Zip","name":"142608","type":"Индекс"}],"geo_data":{"house_level":"House","max":{"lat":55.8262944,"lon":39.0101344},"mid":{"lat":55.8243759,"lon":39.0074608},"min":{"lat":55.8171493,"lon":38.9896944},"object_level":"Street","rel":100},"pretty":"обл Московская, г Орехово-Зуево, ул Парковская, дом 36","quality":{"canonic_fields":3,"detected_fields":3,"precision":100,"recall":100,"verified_numeric_fields":1}}],"check_info":{"alts":1,"query":"обл Московская, г Орехово-Зуево, ул Парковская, 36","time":25},"request_process_time":27}';
//        $response = '{"addresses":[{"codes":{"kladr_actual":"500240000720000","kladr_detected":"500240000720000","kladr_pure":"50024000072"},"cover":[{"in":"обл Московская"},{"out":","},{"in":"р-н Орехово-Зуевский"},{"out":","},{"in":"д Кабаново (Горское с\/п"},{"out":"),"},{"in":"164"},{"out":"-"},{"in":"19"}],"fields":[{"c":"50","cover":"обл Московская","level":"Region","name":"Московская","ns":1.00,"ts":1.00,"type":"обл"},{"c":"024","cover":"р-н Орехово-Зуевский","level":"District","name":"Орехово-Зуевский","ns":1.00,"ts":1.00,"type":"р-н"},{"level":"City"},{"c":"072","cover":"д Кабаново (Горское с\/п","level":"Place","name":"Кабаново (Горское с\/п)","ns":1.00,"ts":1.00,"type":"д"},{"level":"Street"},{"c":"0001","cover":"164","level":"House","name":"164","ns":1.00,"ts":0.00,"type":"дом"},{"level":"Building"},{"level":"Structure"},{"cover":"19","level":"Flat","name":"19","ns":0.50,"ts":0.00,"type":"кв"},{"level":"Zip","name":"142664","type":"Индекс"}],"geo_data":{"max":{"lat":55.7607011,"lon":38.9489613},"mid":{"lat":55.7508754,"lon":38.9300545},"min":{"lat":55.7409974,"lon":38.9114513},"object_level":"Place","rel":100},"pretty":"обл Московская, р-н Орехово-Зуевский, д Кабаново (Горское с\/п), дом 164, кв 19","quality":{"canonic_fields":3,"detected_fields":3,"precision":100,"recall":100,"verified_numeric_fields":1,"warnings":"ChildIsSkipped|"}}],"check_info":{"alts":1,"query":"обл Московская, р-н Орехово-Зуевский, д Кабаново (Горское с\/п), 164-19","time":28},"request_process_time":28}';

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

}