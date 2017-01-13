<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 09.09.2016
 * Time: 12:16
 */
class orders_controller extends controller
{
    public function index()
    {
        $my_account = $this->model('m1_accounts')->getByField('user_id', registry::get('user')['id']);
        $this->render('my_name', $my_account['account_name']);
        $this->render('products', $this->model('products')->getAll('product_name'));
        $this->render('order_statuses', $this->model('order_statuses')->getAll('id'));
        $this->addScript(SITE_DIR . 'js/libs/autocomplete/src/jquery.autocomplete.js');
        $this->view('orders' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_orders":
                $my_account = $this->model('m1_accounts')->getByField('user_id', registry::get('user')['id']);
                $params = [];
                $params['table'] = 'orders o';
                $params['select'] = [
                    'o.id',
                    'p.product_name',
                    'IF(os.id IS NULL, "Не Принят", os.status_name)',
                    'u.user_name',
                    'u.phone',
                    'o.my_name',
                    'o.create_date',
                    'o.comments',
                    'CONCAT("
                    <a data-toggle=\"modal\" class=\"btn outline blue show_order\" href=\"' . SITE_DIR . 'orders/order?id=", o.id, "\">
                        <i class=\"fa fa-search\"></i>
                    </a>")'
                ];
                $params['join']['products p'] = [
                    'on' => 'p.id = o.product_id',
                ];
                $params['join']['users u'] = [
                    'on' => 'u.id = o.user_id'
                ];
                $params['join']['order_statuses'] = [
                    'as' => 'os',
                    'left' => true,
                    'on' => 'os.id = o.status_id'
                ];
                $params['where']['o.my_name'] = [
                    'sign' => '=',
                    'value' => $my_account['account_name']
                ];
                $params['order'] = 'o.create_date DESC';
                echo json_encode($this->getDataTable($params));
                exit;
                break;

            case "get_order_modal_form":
                $order = $this->model('orders')->getById($_POST['id']);
                $this->render('order', $order);
                $this->render('product', $this->model('products')->getById($order['product_id']));
                $this->render('user', $this->model('users')->getById($order['user_id']));
                $this->render('address', $this->model('user_addresses')->getById($order['address_id']));
                $template = $this->fetch('orders' . DS . 'ajax' . DS . 'order_modal');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

            case "edit_order_info":
                $user_id = $this->model('users')->insert($_POST['user'], 'id');
                $order = $_POST['order'];
                $address = $_POST['address'];
                $address['user_id'] = $user_id;
                if(!$address['id']) {
                    unset($address['id']);
                    $address['create_date'] = date('Y-m-d H:i:s');
                }
                $address['id'] = $this->model('user_addresses')->insert($address, 'id');
                $order['address_id'] = $address['id'];
                $this->model('orders')->insert($order, 'id');
                echo json_encode(array('status' => 1));
                exit;
                break;

            case "suggest_region":
                $res = $this->model('orders')->fiasSuggest($_POST['val'], 1);
                echo json_encode(array('status' => 1, 'suggest' => $res));
                exit;
                break;

            case "suggest_county":
                $res = $this->model('orders')->fiasSuggest($_POST['val'], 3, $_POST['region_code']);
                echo json_encode(array('status' => 1, 'suggest' => $res));
                exit;
                break;

            case "get_region":
                $res = [];
                $res['status'] = 1;
                $res['region'] = $this->model('fias')->getByFields([
                    'REGIONCODE' => $_POST['region_code'],
                    'AOLEVEL' => 1
                ]);
                if($_POST['county_code']) {
                    $res['county'] = $this->model('fias')->getByFields([
                        'REGIONCODE' => $_POST['region_code'],
                        'AREACODE' => $_POST['county_code'],
                        'AOLEVEL' => 3
                    ]);
                }
                echo json_encode($res);
                exit;
                break;

            case "suggest_city":
                $res = $this->model('orders')->citySuggest($_POST['val'], $_POST['region_code'], $_POST['county_code']);
                echo json_encode(array('status' => 1, 'suggest' => $res));
                exit;
                break;

            case "suggest_street":
                $res = $this->model('orders')->fiasSuggest($_POST['val'], null, null, $_POST['parent']);
                echo json_encode(array('status' => 1, 'suggest' => $res));
                exit;
                break;

            case "suggest_house":
                $res = $this->model('orders')->houseSuggest($_POST['val'], $_POST['parent']);
                echo json_encode(array('status' => 1, 'suggest' => $res));
                exit;
                break;
        }
    }

    public function order()
    {
        $this->addScript(SITE_DIR . 'js/libs/autocomplete/src/jquery.autocomplete.js');
        if($_GET['id']) {
            $order = $this->model('orders')->getById($_GET['id']);
            $this->render('order', $order);
            $this->render('goods', $this->model('goods')->getAll('create_date DESC'));
            $this->render('product', $this->model('products')->getById($order['product_id']));
            $this->render('user', $this->model('users')->getById($order['user_id']));
            $this->render('address', $this->model('user_addresses')->getById($order['address_id']));
            $order_goods = $this->model('orders')->getOrderGoods($order['id']);
            $this->render('order_goods', $order_goods);
        }
        $this->view('orders' . DS . 'order');
    }

    public function order_ajax()
    {
        switch ($_REQUEST['action']) {
            case "add_good":
                $order = $this->model('orders')->getById($_GET['id']);
                $good = $this->model('goods')->getById($_POST['good_id']);
                $row = [];
                $row['good_name'] = $good['good_name'];
                $row['order_price'] = $order['price'];
                $row['good_id'] = $_POST['good_id'];
                $row['order_id'] = $order['id'];
                $row['product_id'] = $order['product_id'];
                $row['price'] = $order['price'];
                $row['create_date'] = date('Y-m-d H:i:s');
                $last_id = $_POST['last_id'];
                $last_id ++;
                $this->render('order_goods', [$last_id  => $row]);

                $template = $this->fetch('orders' . DS . 'ajax' . DS . 'goods_table');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

            case "normalize_address":
                $api = new ahunter_api_class();
                $address = $api->getNormalAddress($_POST['address']);
                $address['user_id'] = $this->model('orders')->getById($_GET['id'])['user_id'];
                echo json_encode(array('status' => 1, 'address' => $address));
                exit;
                break;

            case "save_order":
                $address = $_POST['address'];
                $address['user_id'] = $_POST['user']['id'];
                if(!$address['id']) {
                    $address['id'] = $this->model('user_addresses')->getByFields($address)['id'];
                    if(!$address['id']) {
                        $address['create_date'] = date('Y-m-d H:i:s');
                    }
                }
                $address['id'] = $this->model('user_addresses')->insert($address);
                $order = $_POST['order'];
                $order['address_id'] = $address['id'];
                $this->model('orders')->insert($order);
                foreach ($_POST['order_goods'] as $order_good) {
                    if(!$order_good['id']) {
                        $order_good['order_id'] = $_GET['id'];
                        $order_good['create_date'] = date('Y-m-d H:i:s');
                    }
                    $this->model('order_goods')->insert($order_good);
                }
                echo json_encode(array('status' => 1));
                exit;
                break;

            case "get_delivery_methods":
                $api = new b2_api_class();
                $params = [];
                foreach ($_POST['order_goods'] as $order_good) {
                    print_r($order_good);
                    $good = $this->model('goods')->getById($order_good['good_id']);
                    if(!$params['weight']) {
                        $params['weight'] = $good['weight'];
                    } else {
                        $params['weight'] += $good['weight'];
                    }
//                    if(!$params['price_assess']) {
//                        $params['price_assess'] = $good['price'];
//                    } else {
//                        $params['price_assess'] += $good['price'];
//                    }
//                    if(!$params['price']) {
//                        $params['price'] = $order_good['price'];
//                    } else {
//                        $params['price'] += $order_good['price'];
//                    }

//                    if(!$params['x']) {
//                        $params['x'] = $good['x'];
//                    } else {
//                        $params['x'] += $good['x'];
//                    }
//                    if(!$params['y']) {
//                        $params['y'] = $good['y'];
//                    } else {
//                        $params['y'] += $good['y'];
//                    }
//                    if(!$params['z']) {
//                        $params['z'] = $good['z'];
//                    } else {
//                        $params['z'] += $good['z'];
//                    }

                }
//                zip=190000&weight=1001&x=121&y=1&z=1&type=+post&price=1000&price_assess=1000&region=77&allpost=1
                $params['type'] = '+post';
//                $params['region'] = B2_API_REGION;
//                $params['allpost'] = 1;

                $params['zip'] = $_POST['address']['zip'];
                print_r($params);
                print_r($api->getRates($params));
                exit;
                break;
        }
    }
}