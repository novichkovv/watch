<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 22.10.2016
 * Time: 18:16
 */
class order_controller extends controller
{
    public function index()
    {

    }

    public function m1()
    {
        if(!$_POST['product_id']) {
            $this->writeLog('ORDER_ERROR', 'M1 No Product_id' . "\n" . print_r($_POST, 1));
        }
        if(!$_POST['name']) {
            $this->writeLog('ORDER_ERROR', 'M1 No name' . "\n" . print_r($_POST, 1));
        }
        if(!$_POST['phone']) {
            $this->writeLog('ORDER_ERROR', 'M1 No phone' . "\n" . print_r($_POST, 1));
        }
        $user = [];
        $user['user_name'] = $_POST['name'];
        $user['phone'] = $_POST['phone'];
        if(!$tmp = $this->model('users')->getByFields($user)) {
            $user['create_date'] = date('Y-m-d H:i:s');
            $user['id'] = $this->model('users')->insert($user);
        } else {
            $user = $tmp;
        }
        $order = [];
        $order['product_id'] = $_POST['product_id'];
        $order['create_date'] = date('Y-m-d H:i:s');
        $order['user_id'] = $user['id'];
        $order['click_id'] = $_POST['s'];
        $order['my_name'] = $_POST['w'];
        $order['t_field'] = $_POST['t'];
        $order['id'] = $this->model('orders')->insert($order);
        $product = $this->model('products')->getById($order['product_id']);
        $data = [];
        $data['ref'] = $product['webmaster_id'];
        $data['product_id'] = $product['affiliate_id'];
        $data['phone'] = $_POST['phone'];
        $data['name'] = $_POST['name'];
        $data['ip'] = $this->get_ip();
        $data['referer'] = $_SERVER['HTTP_REFERER'];
        $data['s'] = $_POST['s'];
        $data['w'] = $_POST['w'];
        $data['t'] = $_POST['t'];
        $res = m1_api_class::sendOrder($data);
        if($res['result'] == 'ok') {
            $order['aff_order_id'] = $res['id'];
            $order['status_id'] = 1;
            $this->model('orders')->insert($order);
        } else {
            $this->writeLog('ORDER_ERROR', 'Order not saved' . "\n" . print_r($data, 1));
        }
        $this->view_only('landings' . DS . $product['success_landing_key'] . DS . 'template');
    }

    public function m1_na()
    {
        $this->m1();
    }

    private function get_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}