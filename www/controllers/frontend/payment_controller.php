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
        $order = [];
        $order['id'] = 123;
        $order['sum'] = 10.00;
        $order['user_id'] = 134;
        $this->render('params', $payment->generateParams($order));
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

    public function success()
    {
        $this->view('payment' . DS . 'success');
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