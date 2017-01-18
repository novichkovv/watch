<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.09.2016
 * Time: 13:21
 */
class payment_controller extends controller
{
    public function methods()
    {
        $payment = new payment_class();
        if(!empty($_GET['fail'])) {
            $this->render('fail', true);
            $order = $this->model('orders')->getById($_GET['MNT_TRANSACTION_ID']);
            $order['status_id'] = 7;
            $order['payment_status_id'] = 6;
        } elseif(!empty($_GET['decline'])) {
            $this->render('decline', true);
            $order = $this->model('orders')->getById($_GET['MNT_TRANSACTION_ID']);
            $order['status_id'] = 7;
            $order['payment_status_id'] = 6;
        } else {
            $order = $this->model('orders')->getById($_GET['id']);
            $order['status_id'] = 4;
            $order['payment_status_id'] = 4;
        }
        $this->model('orders')->insert($order);
        $product = $this->model('products')->getById($order['product_id']);
        $order['sum'] = 0;
        $count = 0;
        foreach ($this->model('order_goods')->findByField('order_id', $order['id']) as $item) {
            $order['sum'] += $item['price'];
            $count ++;
        }
        $order['sum'] = number_format($order['sum'] + $product['price_delivery'], 2, '.','');
        $description = 'Всего ' . $count . ' товаров плюс доставка на сумму ' . $order['sum'] . ' рублей';
        $this->render('count', $count);
        $this->render('sum', round($order['sum']));
        $params = $payment->generateParams($order);
        $params['MNT_DESCRIPTION'] = $description;
        $this->render('params', $params);
        $this->render('methods', $this->model('payment_methods')->getByField('active', 1, true, 'sort_order'));
        $this->view('payment' . DS . 'methods');
    }

    public function pay()
    {
        $this->writeLog('test', $_POST);
        if($_POST['MNT_TRANSACTION_ID']) {
            $order = $this->model('orders')->getById($_POST['MNT_TRANSACTION_ID']);
            $order['paid_amount'] = $_POST['MNT_AMOUNT'];
            $order['payment_status_id'] = 1;
            $order['pay_date'] = date('Y-m-d H:i:s');
            $order['status_id'] = 5;
            $this->model('orders')->insert($order, 2);
            header('Content-Type: text/html; charset=utf-8');
            echo 'SUCCESS';
            exit;
        }
    }

    public function success()
    {
        if(!empty($_GET['MNT_TRANSACTION_ID'])) {
            $order = $this->model('orders')->getById($_GET['MNT_TRANSACTION_ID']);
            if($order['payment_status_id'] != 1) {
                $order['payment_status_id'] = 7;
                $this->model('orders')->insert($order);
            }
        }
        $this->view_only('payment' . DS . 'success');
    }

    public function decline()
    {

    }

    public function success_na()
    {
        $this->success();
    }

    public function methods_na_ajax()
    {
        $this->methods_ajax();
    }

    public function methods_na()
    {
        $this->methods();
    }

    public function decline_na()
    {
        $this->decline();
    }

    public function pay_na()
    {
        $this->pay();
    }

    public function index()
    {

    }
}