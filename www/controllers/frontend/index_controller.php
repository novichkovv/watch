<?php
/**
 * Created by PhpStorm.
 * User: enovichkov
 * Date: 28.08.2015
 * Time: 17:20
 */
class index_controller extends controller
{
    public function index()
    {
        header('Location: ' . SITE_DIR . 'tights/');
        exit;
        $this->view_only('index' . DS . 'index');
    }

    public function index_na()
    {
        $this->index();
    }

    public function secure()
    {
        $this->view('index' . DS . 'secure');
    }

    public function secure_na()
    {
        $this->secure();
    }

    public function show()
    {
        $product = $this->model('products')->getByField('product_key', registry::get('route_parts')[0]);
        if(!$_COOKIE['visitor_id']) {
            $cookie = mktime() . rand();
        } else {
            $cookie = $_COOKIE['visitor_id'];
        }
        setcookie('visitor_id', $cookie, time() + 3600*24*90, "/");
        $visitor = [
            'ip'  => $_SERVER['REMOTE_ADDR'],
            'session_id' => session_id(),
            'cookie' => $cookie,
            'product_id' => $product['id'],
            'account' => strtoupper($_GET['w']),
            'click_id' => $_GET['s'],
            'create_date' => date('Y-m-d H:i:s')
        ];
        $visitor_id = $this->model('visitors')->insert($visitor);
        $this->render('product', $product);
        $this->render('visitor_id', $visitor_id);
        $this->render('dir', SITE_DIR . 'templates/frontend/landings/' . $product['landing_key'] . '/');
        $this->view_only('landings' . DS . $product['landing_key'] . DS . 'template');
    }

    public function show_na()
    {
        $this->show();
    }

    public function show_ajax()
    {
        switch ($_REQUEST['action']) {
            case "save_form":
                $user = [];
                $user['user_name'] = $_POST['name'];
                $user['phone'] = $_POST['phone'];
                if(!$tmp = $this->model('users')->getByFields($user)) {
                    $user['create_date'] = date('Y-m-d H:i:s');
                    $user['id'] = $this->model('users')->insert($user);
                } else {
                    $user = $tmp;
                }
                $order = [];
                $order['product_id'] = $_POST['product_id'];
                $order['create_date'] = date('Y-m-d H:i:s');
                $order['user_id'] = $user['id'];
                $this->model('orders')->insert($order);
                exit;
                break;
        }
    }

    public function show_na_ajax()
    {
        $this->show_ajax();
    }
}