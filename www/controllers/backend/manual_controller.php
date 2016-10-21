<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 21.10.2016
 * Time: 14:44
 */
class manual_controller extends controller
{
    public function index()
    {
        $this->view('manual' . DS . 'index');
    }
}