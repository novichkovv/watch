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
        if($_GET['landing']) {
            $path = 'landings' . DS . $_GET['landing'] . DS;
            $dir = SITE_DIR . 'templates/frontend/landings/' . $_GET['landing'] . '/';
            $this->render('dir', $dir);
            $this->view_only($path . 'template');
            exit;
        }
        if($_GET['id']) {
            $order = $this->model('orders')->getById($_GET['id']);
            $order['status_id'] = 2;
            $this->model('orders')->insert($order);
            $product = $this->model('products')->getById($order['product_id']);
            $path = 'landings' . DS . $product['success_landing_key'] . DS;
            $dir = SITE_DIR . 'templates/frontend/landings' . '/' . $product['success_landing_key'] . '/';
            if($product['cross_product_id']) {
                $this->render('product', $this->model('products')->getById($product['cross_product_id']));
                $this->render('w', $_POST['w']);
                $this->render('s', $_POST['s']);
                $this->render('t', $_POST['t']);
            }
            $this->render('order', $order);
            $this->render('pixel', $_GET['pixel']);
            $this->render('dir', $dir);
            $this->view_only($path . 'template');
            exit;
        }

        if($_POST['phone']) {
            $_GET['pixel'] = $_POST['pixel'];
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
            $product = $this->model('products')->getById($_POST['app_product_id']);
            $order = [];
            $order['product_id'] = $_POST['app_product_id'];
            $order['create_date'] = date('Y-m-d H:i:s');
            $order['user_id'] = $user['id'];
            $order['click_id'] = $_POST['s'];
            $order['visitor_id'] = $_POST['visitor_id'];
            $order['my_name'] = $_POST['w'];
            $order['t_field'] = $_POST['t'];
            $order['status_id'] = 1;
            $order['price'] = $product['price'];
            $order['id'] = $this->model('orders')->insert($order);
            header('Location: ' . SITE_DIR . 'order/?id=' . $order['id'] . '&pixel=' . $_POST['pixel']);
            exit;
        }
    }

    public function cart()
    {
        if(isset($_POST['save_cart_btn'])) {
            $order = $this->model('orders')->getById($_GET['id']);
            $this->model('order_goods')->delete('order_id', $order['id']);
            $fail_goods = [];
            $total = 0;
            $goods = [];
            $product = $this->model('products')->getById($order['product_id']);
            $mark_first_row = true;
            foreach ($_POST['good'] as $good_id => $quantity) {
                $goods[$good_id] = $this->model('goods')->getById($good_id);
                if($quantity > $goods[$good_id]['quantity']) {
                    $fail_goods[$good_id] = $goods[$good_id]['quantity'];
                } else {
                    for($i = 0; $i < $quantity; $i ++) {
                        $order_good = [
                            'order_id' => $order['id'],
                            'good_id' => $good_id,
                            'product_id' => $order['product_id'],
                            'create_date' => date('Y-m-d H:i:s')
                        ];
                        $order_good['price'] = $mark_first_row ? $product['price_discount_1'] : $product['price_discount_2'];
                        $mark_first_row = false;
                        $this->model('order_goods')->insert($order_good);
                        $goods[$good_id]['quantity'] --;
                        $this->model('goods')->insert($goods[$good_id]);
                    }
                    $total += $product['price_discount_2'];
                }
            }
            if($fail_goods) {
                $total += 690;
                $this->render('fail_goods', $fail_goods);
                $this->render('total', $total);
            } else {
                header('Location: ' . SITE_DIR . 'payment/methods/?id=' . $order['id']);
                exit;
            }
        }
        $order = $this->model('orders')->getById($_GET['id']);
        $product = $this->model('products')->getById($order['product_id']);
        $this->render('product_goods', $this->model('products')->getProductGoods($product['id']));
        $order_goods = [];
        $total_sum = 0;
        foreach ($this->model('order_goods')->getByField('order_id', $order['id'], true) as $item) {
            if(!isset($order_goods[$item['good_id']])) {
                $order_goods[$item['good_id']]['quantity'] = 0;
            }
            $order_goods[$item['good_id']]['quantity'] ++;
            $total_sum += $item['price'];
        }
        $this->render('total_sum', $total_sum + $product['price_delivery']);
        $this->render('order_goods', $order_goods);
        $order['payment_status_id'] = 2;
        $order['status_id'] = 3;
        $this->model('orders')->insert($order);

        $path = 'landings' . DS . $product['success_landing_key'] . DS;
        $dir = SITE_DIR . 'templates/frontend/landings' . '/' . $product['success_landing_key'] . '/';
        $this->render('order', $order);
        $this->render('product', $product);
        $this->render('pixel', $_POST['pixel']);
        $this->render('dir', $dir);
        $this->view_only($path . 'template2');
    }

    public function cart_na()
    {
        $this->cart();
    }

    public function later()
    {
        $order = $this->model('orders')->getById($_GET['id']);
        $order['payment_status_id'] = 3;
        $this->model('orders')->insert($order);
        $product = $this->model('products')->getById($order['product_id']);
        $path = 'landings' . DS . $product['success_landing_key'] . DS;
        $dir = SITE_DIR . 'templates/frontend/landings' . '/' . $product['success_landing_key'] . '/';
        $this->render('order', $order);
        $this->render('product', $product);
        $this->render('pixel', $_POST['pixel']);
        $this->render('dir', $dir);
        $this->view_only($path . 'template3');
    }

    public function later_na()
    {
        $this->later();
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



    public function index_na()
    {
        $this->index();
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