<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.09.2016
 * Time: 13:21
 */
class payment_controller extends controller
{
    public function index()
    {

    }

    public function methods()
    {
        $payment = new payment_class();
        $order = $this->model('orders')->getById($_GET['id']);
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

    public function methods_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_payment_url":
                $payment = new payment_class();
                $order = [];
                $order['id'] = 134;
                $order['sum'] = 10;
                $order['user_id'] = 123;
                $payment->makeRequest($payment->generateParams($order));
                exit;
                break;
        }
    }

    public function pay()
    {
        if($_POST['MNT_TRANSACTION_ID']) {
            $order = $this->model('orders')->getById($_POST['MNT_TRANSACTION_ID']);
            $order['paid_amount'] = $_POST['MNT_AMOUNT'];
            $order['payment_status_id'] = 1;
            $order['pay_date'] = date('Y-m-d H:i:s');
            $order['status_id'] = 1;
            $this->model('orders')->insert($order);
            header('Content-Type: text/html; charset=utf-8');
            echo 'SUCCESS';
            exit;
        }

    }

    public function pay_na()
    {
        $this->pay();
    }

    public function success()
    {
        $order = $this->model('orders')->getById($_GET['MNT_TRANSACTION_ID']);
        $order['payment_status_id'] = 7;
        $this->model('orders')->insert($order);
        $this->view_only('payment' . DS . 'success');
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


}