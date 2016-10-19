<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 10.09.2016
 * Time: 14:12
 */
class checkout_controller extends controller
{
    public function index()
    {
        if(empty($_GET['product_id']) && empty($_GET['order_id'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            if(!empty($_GET['order_id'])) {
                $order = $this->model('orders')->getById($_GET['order_id']);
                $product_id = $order['product_id'];
                $this->render('user', $this->model('users')->getById($order['user_id']));
            } else {
                $product_id = $_GET['product_id'];
            }
            $product = $this->model('products')->getById($product_id);
            if(!$product || !$product['price']) {
                throw new Exception('Bad Product Id');
            }
            $sequence = $product['checkout_sequence'] ? $product['checkout_sequence'] : 1;
        }
        if(isset($_GET['error'])) {
            switch($_GET['error']) {
                case "VALIDATION_ERROR":
                default:
                    $this->render('validation_error', 'ข้อมูลบัตรเครดิตที่ไม่ถูกต้อง');
                    break;
            }
        }
        $product['price_usd'] = $this->getRate($product['price']);
        $this->render('product', $product);
        $this->view('payment' . DS . $sequence . '1');
    }

    public function index_na()
    {
        $this->index();
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

    public function payment()
    {
//        echo str_replace(' ', '', $_POST['cc_number']);
//        exit;
        $product = $this->model('products')->getById($_POST['product_id']);
        if(!$product) {
            throw new Exception('Bad Product Id');
        }
        if(empty($_POST['price_usd'])) {
            throw new Exception('No USD Price');
        }
        $user = $this->model('users')->getByField('email', $_POST['user']['email']);
        if(!$user) {
            $user = [];
            $user['create_date'] = date('Y-m-d H:i:s');
        }
        $user['email'] = $_POST['user']['email'];
        $user['phone'] = $_POST['user']['phone'];
        $user['id'] = $this->model('users')->insert($user);
        if(!$user['id']) {
            throw new Exception('Bad User Info');
        }

        if(!$_POST['order_id']) { //sequence 1
            $order = [];
            $order['product_id'] = $product['id'];
            $order['user_id'] = $user['id'];
            $order['status_id'] = 1;
            $order['price'] = $product['price'];
            $order['price_usd'] = $_POST['price_usd'];
            $order['create_date'] = date('Y-m-d H:i:s');
            $order['id'] = $this->model('orders')->insert($order);
        }
        if(empty($order['id'])) {
            throw new Exception('Bad Order Info');
        }
        $payment_systems = [
            2 => 'mir',
            4 => 'visa',
            3 => 'amex',
            5 => 'mastercard' ,
            6 => 'maesrto'
        ];
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
                        "total" => $_POST['price_usd'],
                        "currency" => "USD",
                        "details" => [
                            "subtotal" => $_POST['price_usd'],
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
            $order['status_id'] = 2;
            $order['payment_method'] = $res['payer']['payment_method'];
            $order['payment_info'] = $res['id'];
            $order['pay_date'] = date('Y-m-d H:i:s');
            $this->model('orders')->insert($order);
            switch($product['checkout_sequence']) {
                case "1":
                default:
                    header('Location: ' . SITE_DIR . 'checkout/address/?order_id=' . $order['id']);
                    exit;
                    break;
            }
        } else {
            if($res['name'] = 'VALIDATION_ERROR') {
//                echo 'Location: ' . SITE_DIR . 'checkout/?order_id=' . $order['id'] . '&error=VALIDATION_ERROR';
//                header('Location: ' . SITE_DIR . 'checkout/?order_id=' . $order['id'] . '&error=VALIDATION_ERROR');
            }
            print_r($res);
        }
        exit;
    }

    public function payment_na()
    {
        $this->payment();
    }

    public function address()
    {
        if(isset($_POST['address_btn'])) {
            $order = $this->model('orders')->getById($_POST['order_id']);
            $address = $_POST['address'];
            $address['user_id'] = $order['user_id'];
            if($existing = $this->model('user_addresses')->getByFields($address)) {
                $address['id'] = $existing['id'];
            }
            $address['id'] = $this->model('user_addresses')->insert($address);
            if(!$address['id']) {
                throw new Exception('No Address Id');
            }
            $order['address_id'] = $address['id'];
            $this->model('orders')->insert($order);
            header('Location: ' . SITE_DIR . 'checkout/success/?order_id=' . $order['id']);
            exit;
        }
        $order = $this->model('orders')->getById($_GET['order_id']);
        if(!$order) {
            throw new Exception('Bad Order Id');
        }
        $user = $this->model('users')->getById($order['user_id']);
        $address = $this->model('user_addresses')->getByField('user_id', $user['id'], false, 'id DESC', '1');
        $this->render('address', $address);
        $product = $this->model('products')->getById($order['product_id']);
        $this->render('product', $product);
        $this->render('order', $order);
        $this->view('payment' . DS . $product['checkout_sequence'] . '2');
    }

    public function address_na()
    {
        $this->address();
    }

    public function success()
    {
        if(isset($_POST['order_btn'])) {
            $product = $this->model('products')->getById($_POST['product_id']);
            if(!$product) {
                throw new Exception('Incorrect Product');
            }
            $user = $_POST['user'];
            if($tmp = $this->model('users')->getByFields($user)) {
                $user = $tmp;
            } else {
                $user['create_date'] = date('Y-m-d H:i:s');
                $user['id'] = $this->model('users')->insert($user);
            }
            if(!$user['id']) {
                throw new Exception('No user created');
            }
            $order = [];
            $order['user_id'] = $user['id'];
            $order['product_id'] = $product['id'];
            $order['price'] = $product['price'];
            $order['status_id'] = 1;
            $order['create_date'] = date('Y-m-d H:i:s');
            if(!$order['id'] = $this->model('orders')->insert($order)) {
                throw new Exception('No order created');
            }
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
            $headers .= 'From: Thaibeauty Order <admin@thaibeauty.pro>' . "\r\n";
            $headers .= 'Reply-To: admin@thaibeauty.pro' . "\r\n";
            $message = 'Поступил Заказ № ' . $order['id'];
            mail('novichkovv@bk.ru', 'Поступил Заказ', $message, $headers);
        }
        $this->view('payment' . DS . 'success');
    }

    public function success_na()
    {
        $this->success();
    }
}