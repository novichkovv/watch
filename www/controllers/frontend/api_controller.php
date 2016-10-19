<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 27.05.2016
 * Time: 11:32
 */
class api_controller extends controller
{
    public function __construct()
    {

    }

    public function index()
    {

    }

    public function paypal()
    {

    }

    public function paypal_na()
    {
        $this->paypal();
    }

    public function default_action()
    {
        echo json_encode(array(
            'error' => true,
            'error_code' => 2,
            'error_text' => 'Method doesn\'t exist'
        ));
        exit;
    }
}