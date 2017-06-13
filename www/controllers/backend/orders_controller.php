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

        $this->render('order_statuses', $this->model('order_statuses')->getAll('id'));
        $this->render('payment_statuses', $this->model('payment_statuses')->getAll('id'));
        $this->render('cc_statuses', $this->model('cc_statuses')->getAll('id'));
        $this->addScript([
            SITE_DIR . 'js/libs/autocomplete/src/jquery.autocomplete.js',
            SITE_DIR . 'js/libs/fancybox/source/jquery.fancybox.pack.js'
        ]);
        $this->addStyle(SITE_DIR . 'js/libs/fancybox/source/jquery.fancybox.css');
        if(registry::get('user')['view_type'] == 2) {
            $this->render('products', $this->model('products')->getUserProducts(registry::get('user')['id']));
            $this->view('orders' . DS . 'index_wm');
        } else {
            $this->render('products', $this->model('products')->getAll('product_name'));
            $this->view('orders' . DS . 'index');
        }
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_orders":
                if(registry::get('user')['view_type'] == 2) {
                    $params = [];
                    $params['table'] = 'orders o';
                    $params['select'] = [
                        'o.id',
                        'p.product_name',
                        'IF(cs.id IS NULL, " - ", cs.status_name)',
                        'u.user_name',
                        'o.comments',
                        'IF(ccs.id IS NULL, " - ", ccs.status_name)',
                        'IF(DATE(o.create_date) = DATE(NOW()), DATE_FORMAT(o.create_date,"%h:%i"), DATE_FORMAT(o.create_date,"%d.%m %h:%i"))',
                    ];
                    $params['join']['products p'] = [
                        'left' => true,
                        'on' => 'p.id = o.product_id',
                    ];
                    $params['join']['users u'] = [
                        'left' => true,
                        'on' => 'u.id = o.user_id'
                    ];
                    $params['join']['cc_statuses'] = [
                        'as' => 'cs',
                        'left' => true,
                        'on' => 'cs.id = o.cc_status_id'
                    ];
                    $params['join']['cc_cancel_statuses'] = [
                        'as' => 'ccs',
                        'left' => true,
                        'on' => 'o.cc_cancel_status_id = ccs.id'
                    ];
                    $params['where']['o.my_name'] = [
                        'sign' => '=',
                        'value' => registry::get('user')['email'],
                        'left' => true
                    ];
                    $params['order'] = 'o.create_date DESC';
                } else {
                    $params = [];
                    $params['table'] = 'orders o';
                    $params['select'] = [
                        'CONCAT("
                        <div style=\"width: 92px;\">
                        <a data-toggle=\"modal\" class=\"btn btn-xs btn-default show_order",IF(o.status_id = 2, " red-row", ""),"\" href=\"' . SITE_DIR . 'orders/order?id=", o.id, "\">
                            <i class=\"fa fa-search\"></i>
                        </a>
                        <a href=\"http://www.gdezakaz.ru/?code=", di.barcode,"\" data-fancybox-type=\"iframe\" class=\"fancybox iframe btn btn-xs btn-icon btn-default\">
                            <i class=\"fa fa-info-circle\"></i>
                        </a>
                        <a data-toggle=\"modal\" class=\"btn btn-xs btn-default send_sms\" href=\"#sms_modal\" data-id=\"", o.id, "\">
                            <i class=\"fa fa-envelope\"></i>
                        </a>
                        ")',
                        'o.id',
                        'p.product_name',
                        'IF(os.id IS NULL, " - ", os.status_name)',
                        'IF(ps.id IS NULL, " - ", ps.status_name)',
                        'IF(cs.id IS NULL, " - ", cs.status_name)',
                        'IF(cs.id IN (4,5), cc.status_name ,IF(o.delivery_status IS NULL, " - ", o.delivery_status))',
                        'u.phone',
                        'IF(DATE(o.create_date) = DATE(NOW()), DATE_FORMAT(o.create_date,"%h:%i"), DATE_FORMAT(o.create_date,"%d.%m %h:%i"))',
                    ];
                    $params['join']['products p'] = [
                        'left' => true,
                        'on' => 'p.id = o.product_id',
                    ];
                    $params['join']['users u'] = [
                        'left' => true,
                        'on' => 'u.id = o.user_id'
                    ];
                    $params['join']['order_statuses'] = [
                        'as' => 'os',
                        'left' => true,
                        'on' => 'os.id = o.status_id'
                    ];
                    $params['join']['cc_statuses'] = [
                        'as' => 'cs',
                        'left' => true,
                        'on' => 'cs.id = o.cc_status_id'
                    ];
                    $params['join']['payment_statuses'] = [
                        'as' => 'ps',
                        'left' => true,
                        'on' => 'ps.id = o.payment_status_id'
                    ];
                    $params['join']['cc_cancel_statuses'] = [
                        'as' => 'cc',
                        'left' => true,
                        'on' => 'cc.id = o.cc_cancel_status_id'
                    ];
                    $params['join']['parcels pa'] = [
                        'left' => true,
                        'on' => 'pa.order_id = o.id'
                    ];
                    $params['join']['delivery_info di'] = [
                        'left' => true,
                        'on' => 'di.parcel_id = pa.id'
                    ];
//                $params['where']['o.my_name'] = [
//                    'sign' => '=',
//                    'value' => $my_account['account_name'],
//                    'left' => true
//                ];
                    $params['order'] = 'o.create_date DESC';
                }

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

            case "send_sms":
                $order = $this->model('orders')->getById($_POST['sms_order_id']);
                $address = $this->model('user_addresses')->getById($order['address_id']);
                $api = new sms_api_class();
                $api->send_sms($address['phone'], $_POST['sms_text']);
                echo json_encode(array('status' => 1));
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
//                    print_r($order_good);
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
                $params['allpost'] = 1;
                $params['zip'] = $_POST['address']['zip'];
                print_r($params);
                print_r($api->getRates($params));
                exit;
                break;
        }
    }

    public function light()
    {
        $this->view('orders' . DS . 'light');
    }

    public function light_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_orders":
                $params = [
                    'table' => 'orders',
                    'select' => [
                        'id',
                        'IF(payment_status_id = 1, "Оплачено", IF(payment_status_id = "2", "Отказано", "В обработке"))',
                        'price',
                        'paid_amount',
                        'create_date',
                        'pay_date'
                    ]
                ];
                $params['where']['create_date'] = [
                    'sign' => '>',
                    'value' => '2017-06-13 00:00:00'
                ];
                echo json_encode($this->getDataTable($params));
                exit;
                break;
        }
    }
}