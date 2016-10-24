<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 29.08.2015
 * Time: 0:10
 */
class index_controller extends controller
{
    public function index()
    {
//        header('Location: ' . SITE_DIR . 'orders/');
        $this->addScript([SITE_DIR . 'js/libs/flot/jquery.flot.min.js']);
        $this->addScript([SITE_DIR . 'js/libs/flot/jquery.flot.time.js']);
        $this->render('products', $this->model('products')->getAll());
        $stats = $this->model('orders')->getOrderDailyStats(date('Y-m-d', strtotime(date('Y-m-d') . ' - 6 day')), date('Y-m-d'));
        $stats['today'] = $this->model('orders')->getTodayCount();
        $stats['month'] = $this->model('orders')->getMonthCount();
        $this->render('stats', $stats);
        $this->view('index' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_stats":
                $res = $this->model('orders')->getOrderDailyStats($_POST['filter_date_from'], $_POST['filter_date_to'], $_POST['filter_product_id'], $_POST['filter_name']);
                $res['today'] = $this->model('orders')->getTodayCount($_POST['filter_product_id'], $_POST['filter_name']);
                $res['month'] = $this->model('orders')->getMonthCount($_POST['filter_product_id'], $_POST['filter_name']);
                $res['status'] = 1;
                echo json_encode($res);
                exit;
                break;
        }
    }

    public function index_na()
    {
        $this->sidebar = false;
        $this->header = false;
        $this->footer = false;
        $this->addStyle('backend/theme/login_form');
        $this->view('index' . DS . 'login_form');
    }
}