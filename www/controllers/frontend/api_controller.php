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

    public function m1()
    {
        $this->writeLog('API_LOG', getallheaders());
        $this->writeLog('API_LOG', $_POST);
        $this->writeLog('API_LOG', $_GET);
        $this->writeLog('API_LOG', $_SERVER);
        $this->writeLog('API_LOG', $_FILES);
    }

    public function m1_na()
    {
        $this->m1();
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