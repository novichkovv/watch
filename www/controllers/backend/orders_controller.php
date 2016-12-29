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
                    <a data-toggle=\"modal\" class=\"btn outline blue show_order\" href=\"#order_modal\" data-id=\"", o.id, "\">
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
        }
    }
}