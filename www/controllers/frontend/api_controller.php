<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 27.05.2016
 * Time: 11:32
 */
class api_controller extends controller
{
    public function ml()
    {
        $this->writeLog('test', $_POST);
        $this->writeLog('test', $_GET);
    }

    public function __construct()
    {

    }

    public function index()
    {

    }

    public function m1()
    {
        $this->writeLog('POSTBACK_CONTACT', $_GET);
        if($order = $this->model('orders')->getByField('click_id', $_GET['s'])) {
            $order['price'] = $_GET['web_total'];
            $order['pay_date'] = $_GET['lead_date'];
            $order['my_name'] = $_GET['w'];
            $order['aff_order_id'] = $_GET['order_id'];
            $order['click_id'] = $_GET['s'];
            switch ($_GET['status']) {
                case "approved":
                    $order['status_id'] = 2;
                    break;
                case "declined":
                    $order['status_id'] = 3;
                    break;
            }
            $this->model('orders')->insert($order);
        }
        if($_GET['status'] == 'approved') {
            $data = [];
            $data['cid'] = $_GET['s'];
            $data['payout'] = $_GET['web_total']/65;
            $data['txid'] = $_GET['order_id'];
//            $data['var3'] = $_GET['w'];
            $this->writeLog('POSTBACK_DATA', $data);
            $this->send_post_back($data);
        }
    }

    private function send_post_back($data)
    {
        $headers = array(
            "User-Agent: php-tutorial/1.0",
        );
        $url = VOLUME_POST_BACK_URL . '?' . http_build_query($data);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        return json_decode($response, true);
    }

    public function m1_na()
    {
        $this->m1();
    }

    public function default_action()
    {
        echo json_encode(array(
            'error' => true,
            'error_code' => 2,
            'error_text' => 'Method doesn\'t exist'
        ));
        exit;
    }

    public function ml_na()
    {
        $this->ml();
    }

    public function powers()
    {
        $row = [
            'aff_order_id' => $_GET['id'],
            'payment_status_id' => ($_GET['payment_status'] == '-1' ? 2 : $_GET['payment_status']),
            'price' => $_GET['price'],
            'paid_amount' => $_GET['payment_sum']
        ];
        if($id = $this->model('orders')->getByField('aff_order_id', $_GET['id'])['id']) {
            $row['id'] = $id;
            if($_GET['payment_status'] == 1) {
                $row['pay_date'] = date('Y-m-d H:i:s');
            }
        } else {
            $row['create_date'] = date('Y-m-d H:i:s');
        }
        $this->model('orders')->insert($row);

//        $url = 'http://watch.loc/api/powers/?id={{id}}&payment_status={{payment_status}}&price={{price}}&payment_sum={{payment_sum}}';
        $this->writeLog('test', $_GET);
    }

    public function powers_na()
    {
        $this->powers();
    }
}