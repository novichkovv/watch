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
        $this->writeLog('ORDERS_M1_PAGE_REQUESTS', $_POST);
        $_GET['pixel'] = $_POST['pixel'];
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
        $order['product_id'] = $_POST['app_product_id'];
        $order['create_date'] = date('Y-m-d H:i:s');
        $order['user_id'] = $user['id'];
        $order['click_id'] = $_POST['s'];
        $order['visitor_id'] = $_POST['visitor_id'];
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
        $data['s'] = $_POST['s'];
        $data['w'] = $_POST['w'];
        $data['t'] = $_POST['t'];
        $res = m1_api_class::sendOrder($data);
        if($res['result'] == 'ok') {
            $order['aff_order_id'] = $res['id'];
            $order['status_id'] = 1;
            $this->model('orders')->insert($order);
        } else {
            $this->writeLog('ORDER_ERROR', 'Order not saved' . "\n" . print_r($data, 1) . "\n" . print_r($res, 1));
        }
        $path = 'landings' . DS . $product['success_landing_key'] . DS;
        $dir = SITE_DIR . 'templates/frontend/landings' . '/' . $product['success_landing_key'] . '/';
        if($product['cross_product_id']) {
            $this->render('product', $this->model('products')->getById($product['cross_product_id']));
            $this->render('w', $_POST['w']);
            $this->render('s', $_POST['s']);
            $this->render('t', $_POST['t']);
        }
        $this->render('pixel', $_POST['pixel']);
        $this->render('dir', $dir);
        $this->view_only($path . 'template');
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