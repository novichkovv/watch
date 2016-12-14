<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 18.09.2015
 * Time: 20:38
 */
class common_controller extends controller
{
    public function index()
    {
        $new_approved_orders = $this->model('orders')->getNewApprovedOrders();
        $this->render('new_approved_orders', $new_approved_orders);
    }

    public function index_na()
    {

    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "delete_item":
                if($_POST['id'] && $_POST['table']) {
                    if($this->model($_POST['table'])->deleteById($_POST['id'])) {
                        echo json_encode(array('status' => 1));
                    } else {
                        echo json_encode(array('status' => 2));
                    }
                } else {
                    echo json_encode(array('status' => 3));
                }
                exit;
                break;

        }
    }

    protected function render($key, $value)
    {
        $common_vars = registry::get('common_vars');
        if(!isset($common_vars)) {
            $common_vars = [];
        }
        $common_vars[$key] = $value;
        registry::remove('common_vars');
        registry::set('common_vars', $common_vars);
    }
}