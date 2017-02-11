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
//        $response = curl_exec($curl);//iconv("windows-1251", "utf-8", curl_exec($curl));
//        echo $response;
        $response = '[{"add_date":"2017-02-10 15:08:42","cancel_reason":"0","charge":0,"city":"г Новосибирск","client":"Test Api","comments":"проверка передачи )","country":"Россия","country_code":"RU","delivery_type":"Почта России","desired_delivery_date":"","desired_delivery_time":"","flat":"кв 3","foreign_value":"392","foreign_web_id":"","fraud_tel":"0","house":"д 5","ip":"1","label":null,"sum":2270,"nds":"0.00","novaposhta_city_id":null,"novaposhta_ware_id":null,"offer_id":"1621","offer_name":"Антигравитационный чехол КЦ","order_key":"99470003715907","postal_code":"630083","region":"обл Новосибирская","shipping":"","shipping_id":"835","shipping_price":"290.00","status_num":"2","street":"ул Ульяновская","target_completed":"1","tel":"7568797089","trust_level":"1","touch_date":"1486731406","user_hash":"68bd52fd","traffic_type":"0","finance_sum":{"2527845":{"sum":"0","type":"2"},"2527846":{"sum":"30","type":"4"}},"sum_done":"2270.00","products":{"product0":{"product_id":"2495","product_name":"Антиграв. чехол IPhone 5,5s,5c Черный","articul":"","price":"1090.00","count":"1","total":"1090.00"},"product1":{"product_id":"2497","product_name":"Антиграв. чехол IPhone 6,6s Черный","articul":"","price":"590.00","count":"1","total":"590.00"},"product2":{"product_id":"2496","product_name":"Антиграв. чехол  IPhone 5,5s,5c Белый","articul":"","price":"590.00","count":"1","total":"590.00"}},"payments":{"payment0":{"payment_sum":"30","comment":"Списание средств за подтвержденный заказ колцентром"}},"status":"approved","update_date":"2017-02-10 15:56:46","add_time":"1486728522","callcenter":true,"update_time":"1486731406","valid":"true"},{"add_date":"2017-02-10 15:13:39","cancel_reason":"14","charge":0,"city":"","client":"Test Api","comments":"","country":"Россия","country_code":"RU","delivery_type":null,"desired_delivery_date":"","desired_delivery_time":"","flat":"","foreign_value":"393","foreign_web_id":"","fraud_tel":"0","house":"","ip":"1","label":null,"sum":1090,"nds":"0.00","novaposhta_city_id":null,"novaposhta_ware_id":null,"offer_id":"1621","offer_name":"Антигравитационный чехол КЦ","order_key":"99470003715929","postal_code":"","region":"","shipping":"","shipping_id":"0","shipping_price":"0.00","status_num":"4","street":null,"target_completed":"0","tel":"745657869","trust_level":"1","touch_date":"1486731306","user_hash":"68bd52fd","traffic_type":"0","sum_done":"1090.00","products":{"product0":{"product_id":"2495","product_name":"Антиграв. чехол IPhone 5,5s,5c Черный","articul":"","price":"1090.00","count":"1","total":"1090.00"}},"status":"declined","update_date":"2017-02-10 15:55:06","add_time":"1486728819","callcenter":true,"update_time":"1486731306","valid":"false"},{"add_date":"2017-02-10 15:49:04","cancel_reason":"0","charge":0,"city":"г Москва","client":"Test Api","comments":"","country":"Россия","country_code":"RU","delivery_type":"Курьер Мск, Спб","desired_delivery_date":"","desired_delivery_time":"","flat":"кв 1","foreign_value":"394","foreign_web_id":"","fraud_tel":"0","house":"д 5","ip":"1","label":null,"sum":1680,"nds":"0.00","novaposhta_city_id":null,"novaposhta_ware_id":null,"offer_id":"1621","offer_name":"Антигравитационный чехол КЦ","order_key":"99470003716042","postal_code":"119333","region":"Москва и Московская область","shipping":"","shipping_id":"836","shipping_price":"210.00","status_num":"2","street":"ул Дмитрия Ульянова","target_completed":"1","tel":"71325364786","trust_level":"1","touch_date":"1486731270","user_hash":"68bd52fd","traffic_type":"0","finance_sum":{"2527842":{"sum":"0","type":"2"},"2527843":{"sum":"30","type":"4"}},"sum_done":"1680.00","products":{"product0":{"product_id":"2495","product_name":"Антиграв. чехол IPhone 5,5s,5c Черный","articul":"","price":"1090.00","count":"1","total":"1090.00"},"product1":{"product_id":"2497","product_name":"Антиграв. чехол IPhone 6,6s Черный","articul":"","price":"590.00","count":"1","total":"590.00"}},"payments":{"payment0":{"payment_sum":"30","comment":"Списание средств за подтвержденный заказ колцентром"}},"status":"approved","update_date":"2017-02-10 15:54:30","add_time":"1486730944","callcenter":true,"update_time":"1486731270","valid":"true"}]';
        $json_decode = json_decode($response, true);
//        print_r($json_decode);
        return $json_decode;
    }

    public function addLead($params)
    {
        $params['ip'] = 1;
        $params['traffic_type'] = 0;
        $this->makeApiCall('order.add', $params, 2);
    }

    public function getOrderList($params)
    {
        return $this->makeApiCall('order.list', $params);
    }

    public function getOrderListLastUpdate($params)
    {
        return $this->makeApiCall('order.listLastUpdate', $params);
    }

    public function getOrderInfo($order)
    {

    }
}