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
            $this->render('pixel', $_GET['pixel'] ? $_GET['pixel'] : $_POST['pixel']);
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
            $order['my_name'] = strtoupper($_POST['w']);
            $order['t_field'] = $_POST['t'];
            $order['status_id'] = 1;

            $order['last_status_update'] = date('Y-m-d H:i:s');
            $order['price'] = $product['price'];
            $order['id'] = $this->model('orders')->insert($order);
            $this->addLog($order['status_id'], 1, $order['id']);
            switch ($product['checkout_method_id']) {
                case "1":
                    $params = [
                        'tel' => $_POST['phone'],
                        'client' => $_POST['name'],
                        'foreign_value' => $order['id'],
                        'code' => $product['affiliate_id'],
                        'ip' => $_SERVER['REMOTE_ADDR']
                    ];
                    $ml_api = new ml_api_class();
                    $order['status_id'] = 8;
                    $order['last_status_update'] = date('Y-m-d H:i:s');
                    $this->model('orders')->insert($order);
                    if(!DEVELOPER_MODE) {
                        $ml_api->addLead($params);
                    }
                    header('Location: ' . SITE_DIR . 'order/?id=' . $order['id'] . '&pixel=' . $_POST['pixel']);
                    exit;
                    break;

                case "2":
                    header('Location: ' . SITE_DIR . 'order/cart/?id=' . $order['id'] . '&pixel=' . $_POST['pixel']);
                    exit;
                    break;
            }

            exit;
        }
    }

    public function select()
    {
        $order = $this->model('orders')->getById($_GET['id']);
        if(!$order) {
            header('Location: ' . SITE_DIR);
            exit;
        }
        $product = $this->model('products')->getById($order['product_id']);
        if(isset($_POST['save_order_goods_btn'])) {
            $no_good = [];
            if($order_goods = $this->model('order_goods')->getByField('order_id', $order['id'], true)) {
                foreach ($order_goods as $item) {
                    $good = $this->model('goods')->getById($item['good_id']);
                    $good['quantity'] ++;
                    $this->model('goods')->insert($good);
                }
                $this->model('order_goods')->delete('order_id', $order['id']);
            }
            $goods = [];
//            print_r($_POST['good']);
            foreach ($_POST['good'] as $og) {
                $array = explode('_', $og['mod_col']);
                $model_id = array_shift($array);
                $color_id = $array[0];

                $good = $this->model('goods')->getByFields(['model_id' => $model_id, 'color_id' => $color_id]);
//                print_r($good);
                $goods[$good['id']] = $good;
                if($good['quantity'] <= 0) {
                    $no_good[] = $good['id'];
                } else {
                    $order_good = [
                        'order_id' => $order['id'],
                        'good_id' => $good['id'],
                        'product_id' => $order['product_id'],
                        'price' => $og['price'],
                        'create_date' => date('Y-m-d H:i:s')
                    ];
                    if($this->model('order_goods')->insert($order_good)) {
                        $good['quantity'] --;
                        $this->model('goods')->insert($good);
                    }
                }
            }
            if($no_good) {
                $order_goods = $this->model('order_goods')->getByField('order_id', $order['id'], true, 'create_date DESC');
                $check = false;
                foreach ($order_goods as $order_good) {
                    if($product['price'] == $order_good['price']) {
                        $check = true;
                    }
                }
                if(!$check && $order_goods[0]) {
                    $order_goods[0]['price'] = $product['price'];
                    $this->model('order_goods')->insert($order_goods[0]);
                }
                $this->model('orders')->insert([
                    'id' => $order['id'],
                    'last_status_update' => date('Y-m-d H:i:s'),
                    'status_id' => 17
                ]);
                $this->addLog(17, 1, $order['id']);
                header('Location: ' . SITE_DIR . 'order/cart/?id=' . $order['id'] . '&no_good=' . implode(',', $no_good));
                exit;
            }

            $this->model('orders')->insert([
                'id' => $order['id'],
                'last_status_update' => date('Y-m-d H:i:s'),
                'status_id' => 16
            ]);
            $this->addLog(16, 1, $order['id']);
            if($order['pay_online']) {
                header('Location: ' . SITE_DIR . 'order/address/?id=' . $order['id']);
            } else {
                header('Location: ' . SITE_DIR . 'order/select/?id=' . $order['id']);
            }
            exit;
        }
        $dir = SITE_DIR . 'templates/frontend/landings' . '/' . $product['success_landing_key'] . '/';
        $this->render('dir', $dir);
        $tmp = $this->model('orders')->getOrderGoods($_GET['id']);
        $order_goods = [];
        foreach ($tmp as $item) {
            $order_goods['goods'][$item['id']] = $item;
            if($order_goods['sum']) {
                $order_goods['sum'] += $item['order_price'];
            } else {
                $order_goods['sum'] = $item['order_price'];
            }
        }
        $this->render('order_goods', $order_goods);
        $this->render('order', $order);
        $this->view('landings' . DS . $product['success_landing_key'] . DS . 'template_2');
    }

    public function address()
    {
        $order = $this->model('orders')->getById($_GET['id']);
        if(!$order) {
            header('Location: ' . SITE_DIR);
            exit;
        }
        $product = $this->model('products')->getById($order['product_id']);
        if(isset($_POST['select_pay_btn'])) {
            $order['discount'] = $product['discount'];
            $order['status_id'] = 3;
            $order['payment_status_id'] = 2;
            $order['last_status_update'];
            $order['pay_online'] = 1;
            $this->model('orders')->insert($order);
            $this->addLog(3, 1, $order['id']);
            $this->addLog(2, 2, $order['id']);
            header('Location: ' . SITE_DIR . 'order/address/?id=' . $order['id']);
            exit;
        }
        if(isset($_POST['select_later_btn'])) {
            $order['status_id'] = 8;
            $order['payment_status_id'] = 3;
            $order['pay_online'] = 0;
            $order['last_status_update'] = date('Y-m-d H:i:s');
            $this->model('orders')->insert($order);
            $this->addLog(8, 1, $order['id']);
            $this->addLog(3, 2, $order['id']);
            header('Location: ' . SITE_DIR . 'order/address/?id=' . $order['id']);
            exit;
        }
        $tmp = $this->model('orders')->getOrderGoods($_GET['id']);
        $order_goods = [];
        foreach ($tmp as $item) {
            $order_goods['goods'][$item['id']] = $item;
            if($order_goods['sum']) {
                $order_goods['sum'] += $item['order_price'];
            } else {
                $order_goods['sum'] = $item['order_price'];
            }
        }
        if($order['discount']) {
            $sum = $order_goods['sum'];
            $order_goods['sum'] = [
                'full' => $sum,
                'discount'=> ($sum - $order['discount'])
            ];
        }
        
        $this->render('order_goods', $order_goods);
        $this->render('order', $order);
        if($order['address_id']) {
            $address = $this->model('user_addresses')->getById($order['address_id']);
            $address['address'] = preg_replace("/^[0-9]{5,6}, /", "", $address['address']);
            $this->render('address', $address);
        }
        $dir = SITE_DIR . 'templates/frontend/landings' . '/' . $product['success_landing_key'] . '/';
        $this->render('dir', $dir);
        $order['status_id'] = 21;
        $order['last_status_update'] = date('Y-m-d H:i:s');
        $this->model('orders')->insert($order);
        $this->addLog(21, 1, $order['id']);
        $this->view_only('landings' . DS . $product['success_landing_key'] . DS . 'template_3');
    }

    public function address_ajax()
    {
        switch ($_REQUEST['action']) {
            case "check_address":
                $order = $this->model('orders')->getById($_GET['id']);
                $order['status_id'] = 18;
                $order['last_status_update'] = date('Y-m-d H:i:s');
                if($order['payment_status_id'] != 3) {
                    $order['payment_status_id'] = 8;
                    $this->addLog(8, 2, $order['id']);
                }
                $this->model('orders')->insert($order);
                $this->addLog(18, 1, $order['id']);
                $address = $this->model('user_addresses')->getById($order['address_id']);
                $api = new ahunter_api_class();
                $new_address = $api->getNormalAddress($_POST['address']);
                if(!$new_address) {
                    $order['status_id'] = 20;
                    $order['last_status_update'] = date('Y-m-d H:i:s');
                    if($order['payment_status_id'] != 3) {
                        $order['payment_status_id'] = 10;
                        $this->addLog(10, 2, $order['id']);
                    }
                    $this->model('orders')->insert($order);
                    $this->addLog(20, 1, $order['id']);
                    echo json_encode(array('status' => 2, 'message' => 'Адрес не найден.<br>Проверьте правильность'));
                    exit;
                }
                foreach ($new_address as $k => $v) {
                    $new_address[$k] = trim($v);
                }
                if(!$new_address['city'] && !$new_address['place'] && !$new_address['street']) {
                    if($order['payment_status_id'] != 3) {
                        $order['payment_status_id'] = 10;
                        $this->addLog(10, 2, $order['id']);
                    }
                    $order['status_id'] = 20;
                    $order['last_status_update'] = date('Y-m-d H:i:s');
                    $this->model('orders')->insert($order);
                    $this->addLog(20, 1, $order['id']);
                    echo json_encode(array('status' => 2, 'message' => 'Введите Населенный Пункт'));
                    exit;
                }
                if((!$new_address['street'] && !$new_address['house'] && !$new_address['building'] && !$new_address['structure'])) {
                    $order['status_id'] = 20;
                    $order['last_status_update'] = date('Y-m-d H:i:s');
                    if($order['payment_status_id'] != 3) {
                        $order['payment_status_id'] = 10;
                        $this->addLog(10, 2, $order['id']);
                    }
                    $this->model('orders')->insert($order);
                    $this->addLog(20, 1, $order['id']);
                    echo json_encode(array('status' => 2, 'message' => 'Введите Улицу'));
                    exit;
                }
                if((!$new_address['house'] && !$new_address['building'] && !$new_address['structure'])) {
                    $order['status_id'] = 20;
                    if($order['payment_status_id'] != 3) {
                        $order['payment_status_id'] = 10;
                        $this->addLog(10, 2, $order['id']);
                    }
                    $order['last_status_update'] = date('Y-m-d H:i:s');
                    $this->model('orders')->insert($order);
                    $this->addLog(20, 1, $order['id']);
                    echo json_encode(array('status' => 2, 'message' => 'Введите № Дома'));
                    exit;
                }
                foreach ($new_address as $k => $v) {
                    $address[$k] = $new_address[$k];
                }
                if ($address['zip']) {
                    $address['user_id'] = $this->model('orders')->getById($_GET['id'])['user_id'];
                    if ($order['address_id']) {
                        $address['id'] = $order['address_id'];
                    }
                    $address['id'] = $this->model('user_addresses')->insert($address);
                    if (!$order['address_id']) {
                        $order['address_id'] = $address['id'];
                    }
                    $order['status_id'] = 19;
                    $order['last_status_update'] = date('Y-m-d H:i:s');
                    if($order['payment_status_id'] != 3) {
                        $order['payment_status_id'] = 9;
                        $this->addLog(9, 2, $order['id']);
                    }
                    $this->model('orders')->insert($order);
                    $this->addLog(19, 1, $order['id']);
                    echo json_encode(array('status' => 1));
                    exit;
                    break;
                }
                $order['status_id'] = 20;
                $order['last_status_update'] = date('Y-m-d H:i:s');
                if($order['payment_status_id'] != 3) {
                    $order['payment_status_id'] = 10;
                    $this->addLog(10, 2, $order['id']);
                }
                $this->model('orders')->insert($order);
                $this->addLog(20, 1, $order['id']);
                echo json_encode(array('status' => 2, 'message' => 'Адрес не найден.<br>Проверьте правильность'));
                exit;
            break;
        }
    }

    public function delivery()
    {
        $order = $this->model('orders')->getById($_GET['id']);
        if(!$order) {
            header('Location: ' . SITE_DIR);
            exit;
        }
        if(isset($_POST['delivery_method_btn'])) {
            $order['delivery_price'] = $_POST['delivery_price_input'];
            $order['delivery_method'] = $_POST['delivery_method_input'];
            $order['status_id'] = 23;
            $order['last_status_update'] = date('Y-m-d H:i:s');
            $this->model('orders')->insert($order);
            $this->addLog(23, 1, $order['id']);
            if($order['pay_online']) {
                header('Location: ' . SITE_DIR . 'payment/methods/?id=' . $_GET['id']);
                exit;
            } else {
                header('Location: ' . SITE_DIR . 'payment/user/?id=' . $_GET['id']);
                exit;
            }

        }
        if(isset($_POST['address'])) {
            header('Location: ' . SITE_DIR . 'order/delivery/?id=' . $_GET['id']);
            exit;
        }

        $order['status_id'] = 22;
        $order['last_status_update'] = date('Y-m-d H:i:s');
        $this->model('orders')->insert($order);
        $this->addLog(22, 1, $order['id']);

        $product = $this->model('products')->getById($order['product_id']);
        $dir = SITE_DIR . 'templates/frontend/landings' . '/' . $product['success_landing_key'] . '/';
        $this->render('dir', $dir);
        $address = $this->model('user_addresses')->getById($order['address_id']);
        $this->render('address', $address);
        $this->view_only('landings' . DS . $product['success_landing_key'] . DS . 'template_4');
//
    }

    public function delivery_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_delivery_methods":
                $order = $this->model('orders')->getById($_GET['id']);
                $address = $this->model('user_addresses')->getById($order['address_id']);
                $api = new b2_api_class();
                $params = [];
                $params['zip'] = $address['zip'];
                $order_goods = $this->model('orders')->getOrderPrice($order['id']);
                $params['weight'] = $order_goods['sum']['weight'];
                $params['price'] = $order_goods['sum']['price'];
                $methods = $api->getDeliveryMethods($params);
                $res = [];
                if($methods['flag_delivery']) {
                    foreach ($methods['delivery_ways'] as $method) {
                        $post_trigger = false;
                        if($method['Код'] == 'курьер') {
                            $res['currier'] = [
                                'price' => $method['Стоимость'],
                                'insurance' => $method['Страховой сбор'],
                                'agent' => $method['Агентское вознаграждение'],
                                'code' => $method['Код'],
                            ];
                        } elseif(mb_strpos($method['Код'], 'пвз', 0, 'utf8') !== false) {
                            $res['pvz'][] = [
                                'price' => $method['Стоимость'],
                                'insurance' => $method['Страховой сбор'],
                                'agent' => $method['Агентское вознаграждение'],
                                'schedule' => $method['Время работы'],
                                'address' => $method['Адрес'],
                                'code' => $method['Код'],
                                'gps' => $method['GPS'],
                            ];
                        } elseif(mb_strpos($method['Код'], 'пр', 0, 'utf8') !== false) {
                            if($method['Код'] == 'пр11') {
                                $post_trigger = true;
                                $res['post'] = [
                                    'price' => $method['Стоимость'],
                                    'insurance' => $method['Страховой сбор'],
                                    'agent' => $method['Агентское вознаграждение'],
                                    'schedule' => $method['Время работы'],
                                    'address' => $method['Адрес'],
                                    'code' => $method['Код'],
                                    'gps' => $method['GPS'],
                                ];
                            }
                            if($method['Код'] == 'пр1' && !$post_trigger) {
                                $res['post'] = [
                                    'price' => $method['Стоимость'],
                                    'insurance' => $method['Страховой сбор'],
                                    'agent' => $method['Агентское вознаграждение'],
                                    'schedule' => $method['Время работы'],
                                    'address' => $method['Адрес'],
                                    'code' => $method['Код'],
                                    'gps' => $method['GPS'],
                                ];
                            }

                        }
                    }
                    if(in_array($address['region'], ['г Москва', 'г Санкт-Петербург'])) {
//                        unset($res['post']);
                    }
                    $product = $this->model('products')->getById($order['product_id']);
                    $this->render('methods', $res);
                    $this->render('product', $product);
                    $template = $this->fetch('landings' . DS . 'gravity_checkout' . DS . 'delivery_template');
                    echo json_encode(array('status' => 1, 'template' => $template));
                    exit;
                } else {
                    echo json_encode(array('status' => 2));
                }
                exit;
                break;
        }
    }

    public function delivery_na()
    {
        $this->delivery();
    }

    public function delivery_na_ajax()
    {
        $this->delivery_ajax();
    }

    public function address_na_ajax()
    {
        $this->address_ajax();
    }

    public function cart()
    {
        $order = $this->model('orders')->getById($_GET['id']);
        if(!$order) {
            header('Location: ' . SITE_DIR);
            exit;
        }
        $product = $this->model('products')->getById($order['product_id']);
        $this->render('product', $product);
        switch ($product['checkout_method_id']) {
            case "1":
            default:
                $dir = SITE_DIR . 'templates/frontend/landings' . '/' . $product['success_landing_key'] . '/';
                $this->render('dir', $dir);
                $this->model('orders')->insert([
                    'id' => $order['id'],
                    'status_id' => 8
                ]);
                $this->addLog(8, 1, $order['id']);
                $this->view('landings' . DS . $product['success_landing_key'] . DS . 'template_1');
                exit;
                break;

            case "2":
                $order_goods = $this->model('goods')->getOrderGoods($order['id']);

                $this->render('order_goods', $order_goods);
                $this->render('order', $order);
                $dir = SITE_DIR . 'templates/frontend/landings' . '/' . $product['success_landing_key'] . '/';
                $this->render('dir', $dir);
                $this->model('orders')->insert([
                    'id' => $order['id'],
                    'status_id' => 15
                ]);
                $this->addLog(15, 1, $order['id']);
                $product_goods = $this->model('goods')->getProductGoods($order['product_id']);
                $colors = [];
                $models = [];
                foreach ($product_goods['rest'] as $product_good) {
                    $colors[$product_good['color_code']] = $product_good['color_id'];
                    $models[$product_good['model_code']] = $product_good['model_id'];
                }
                $this->render('colors', $colors);
                $this->render('models', $models);
                $this->render('product_goods', $product_goods);
//                print_r($colors);exit;
                if($_GET['no_good']) {
                    $ids = array_unique(explode(',', $_GET['no_good']));
                    $this->render('no_goods', $this->model('goods')->getGoodsWithModel($ids));
                }
//                print_r($this->model('goods')->getGoodsWithModel($ids));
//                print_r($order_goods);exit;
                $this->view('landings' . DS . $product['success_landing_key'] . DS . 'template_1');
                exit;
                break;
        }

//        if(isset($_POST['create_order_btn'])) {
//            $order = $this->model('orders')->getById($_GET['id']);
//            $product = $this->model('products')->getById($order['product_id']);
//            print_r($product);
//            switch ($product['checkout_method_id']) {
//                case "1":
//                    $this->view('landings' . DS . $product['success_landing_key'] . DS . 'template_1');
//                    exit;
//                    break;
//
//                case "2":
//                    $this->view('landings' . DS . $product['success_landing_key'] . DS . 'template_1');
//                    exit;
//                    break;
//            }
//        }

//        if(isset($_POST['save_cart_btn'])) {
//            $order = $this->model('orders')->getById($_GET['id']);
//            $this->model('order_goods')->delete('order_id', $order['id']);
//            $fail_goods = [];
//            $total = 0;
//            $goods = [];
//            $product = $this->model('products')->getById($order['product_id']);
//            $mark_first_row = true;
//            foreach ($_POST['good'] as $good_id => $quantity) {
//                $goods[$good_id] = $this->model('goods')->getById($good_id);
//                if($quantity > $goods[$good_id]['quantity']) {
//                    $fail_goods[$good_id] = $goods[$good_id]['quantity'];
//                } else {
//                    for($i = 0; $i < $quantity; $i ++) {
//                        $order_good = [
//                            'order_id' => $order['id'],
//                            'good_id' => $good_id,
//                            'product_id' => $order['product_id'],
//                            'create_date' => date('Y-m-d H:i:s')
//                        ];
//                        $order_good['price'] = $mark_first_row ? $product['price'] : $product['price_discount_2'];
//                        $mark_first_row = false;
//                        $this->model('order_goods')->insert($order_good);
//                        $goods[$good_id]['quantity'] --;
//                        $this->model('goods')->insert($goods[$good_id]);
//                    }
//                    $total += $product['price_discount_2'];
//                }
//            }
//            if($fail_goods) {
//                $total += 690;
//                $this->render('fail_goods', $fail_goods);
//                $this->render('total', $total);
//            } else {
//                header('Location: ' . SITE_DIR . 'payment/methods/?id=' . $order['id']);
//                exit;
//            }
//        }
//        $order = $this->model('orders')->getById($_GET['id']);
//        $product = $this->model('products')->getById($order['product_id']);
//        $this->render('product_goods', $this->model('products')->getProductGoods($product['id']));
//        $order_goods = [];
//        $total_sum = 0;
//        foreach ($this->model('order_goods')->getByField('order_id', $order['id'], true) as $item) {
//            if(!isset($order_goods[$item['good_id']])) {
//                $order_goods[$item['good_id']]['quantity'] = 0;
//            }
//            $order_goods[$item['good_id']]['quantity'] ++;
//            $total_sum += $item['price'];
//        }
//        $this->render('total_sum', $total_sum + $product['price_delivery']);
//        $this->render('order_goods', $order_goods);
//        $order['payment_status_id'] = 2;
//        $order['last_status_update'] = date('Y-m-d H:i:s');
//        $order['status_id'] = 3;
//        $this->model('orders')->insert($order);
//
//        $path = 'landings' . DS . $product['success_landing_key'] . DS;
//        $dir = SITE_DIR . 'templates/frontend/landings' . '/' . $product['success_landing_key'] . '/';
//        $this->render('order', $order);
//        $this->render('product', $product);
//        $this->render('pixel', $_POST['pixel']);
//        $this->render('dir', $dir);
//        $this->view_only($path . 'template2');
    }

    public function cart_na()
    {
        $this->cart();
    }

    public function later()
    {
        $order = $this->model('orders')->getById($_GET['id']);
        $order['status_id'] = 9;
        $order['payment_status_id'] = 3;
        $order['pay_online'] = 0;
        $order['last_status_update'] = date('Y-m-d H:i:s');
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
    public function select_na()
    {
        $this->select();
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

    public function address_na()
    {
        $this->address();
    }

}