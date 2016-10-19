<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.09.2016
 * Time: 13:21
 */
class payment_controller extends controller
{
    public function index()
    {
        $payment_systems = [
            2 => 'mir',
            4 => 'visa',
            3 => 'amex',
            5 => 'mastercard' ,
            6 => 'maesrto'
        ];
        if(empty($_GET['order_id'])) {
            header('Location: ' . SITE_DIR);
            exit;
        }
        if(isset($_POST['pay_btn'])) {
            $order = $this->model('orders')->getOrder($_POST['order_id']);
            if(!$order) {
                throw new Exception('Incorrect Order');
            }
            $price = $this->getRate($order['price']);
            $params = [
                'intent' => 'sale',
                'payer' => [
                    "payment_method" => "credit_card",
                    "funding_instruments" => [
                        [
                            'credit_card' => [
                                'number' => str_replace(' ', '', $_POST['cc_number']),
                                'type' => $payment_systems[$_POST['cc_number'][0]],
                                "expire_month" => $_POST['cc_month'],
                                "expire_year" => '20' . $_POST['cc_year'],
                                "cvv2" => $_POST['cc_cvv'],
                                "first_name" => array_shift(explode(' ', $_POST['cc_name'])),
                                "last_name" => array_pop(explode(' ', $_POST['cc_name'])),
                            ]
                        ]
                    ]
                ],
                'transactions' => [
                    [
                        "amount" => [
                            "total" => $price,
                            "currency" => "USD",
                            "details" => [
                                "subtotal" => $price,
                                "tax" => "0.00",
                                "shipping" => "0.00"
                             ]
                        ],
                        'description' => $_POST['order_id']
                    ]
                ]
            ];
            $api = new paypal_api_class();
            $res = $api->sendPaymentRequest($params);
            if($res['state'] == 'approved') {
                header('Location: ' . SITE_DIR . 'payment/success/?order_id=' . $_POST['order_id']);
                exit;
            } else {
                if($res['name'] = 'VALIDATION_ERROR') {
                    $this->
                }
                print_r($res);
            }
            exit;
        }

        $this->render('order_id', $_GET['order_id']);
        $order = $this->model('orders')->getById($_GET['order_id']);
        $this->render('order', $order);
        $price = $this->getRate($order['price']);
        $this->render('price', $price);
        $this->view('payment' . DS . 'form');
    }

    private function getRate($price)
    {
        $current = json_decode(file_get_contents('https://query.yahooapis.com/v1/public/yql?q=select+*+from+yahoo.finance.xchange+where+pair+=+%22USDTHB%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=')
            , true);
        $rate = $current['query']['results']['rate']['Bid'];
        if(!$rate) {
            $rate = 30;
        }
        $price_usd = round($price/$rate, 2);
        if(!$price_usd) {
            throw new Exception('No USD');
        }
        return $price_usd;
    }

    public function index_na()
    {
        $this->index();
    }
}