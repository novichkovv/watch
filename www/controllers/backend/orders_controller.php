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
        $this->render('products', $this->model('products')->getAll('product_name'));
        $this->view('orders' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_orders":
                $params = [];
                $params['table'] = 'orders o';
                $params['select'] = [
                    'o.id',
                    'p.product_name',
                    'u.user_name',
                    'u.phone',
                    'o.create_date',
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
                $this->model('users')->insert($_POST['user']);
                echo json_encode(array('status' => 1));
                exit;
                break;

        }
    }
}