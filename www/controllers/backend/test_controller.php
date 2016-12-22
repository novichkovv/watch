<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 21.12.2016
 * Time: 19:58
 */
class test_controller extends controller
{
    public function index_na()
    {
        $this->view('test');
    }

    public function index()
    {
        $this->view('test');
    }
}