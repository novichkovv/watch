<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 27.05.2016
 * Time: 11:32
 */
class api_controller extends controller
{
    public function __construct()
    {

    }

    public function index()
    {

    }

    public function m1()
    {
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
}