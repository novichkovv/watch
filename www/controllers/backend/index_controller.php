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
//        $my_account = $this->model('m1_accounts')->getByField('user_id', registry::get('user')['id']);
//        $account_name = $my_account['account_name'];
//        if(!$my_account) {
//            $account_name = registry::get('user')['email'];
//        }
        $account_name = registry::get('user')['email'];
        $this->render('accounts', $this->model('m1_accounts')->getAll());
        $this->addScript([SITE_DIR . 'js/libs/flot/jquery.flot.min.js']);
        $this->addScript([SITE_DIR . 'js/libs/flot/jquery.flot.time.js']);
        $products = $this->model('products')->getAll('create_date DESC');


        if(registry::get('user')['view_type'] == 2) {
            $stats = $this->model('orders')->getOrderDailyStats(date('Y-m-d', strtotime(date('Y-m-d') . ' - 10 day')), date('Y-m-d'), null, $account_name);
            $stats['today'] = $this->model('orders')->getTodayCount(null, $account_name);
            $stats['month'] = $this->model('orders')->getMonthCount(null, $account_name);
            $stats['period'] = $this->model('orders')->getPeriodCount(null, $account_name, date('Y-m-d', strtotime(date('Y-m-d') . ' - 10 day')), date('Y-m-d'));
            $visitors['today'] = $this->model('orders')->getVisitorsByProduct(null, date('Y-m-d 00:00:00'), null, $account_name);
            $visitors['month'] = $this->model('orders')->getVisitorsByProduct(null, date('Y-m-01 00:00:00'), null, $account_name);
            $cost_stats = $this->model('orders')->getCostApprovedStats(null, date('Y-m-d', strtotime(date('Y-m-d') . ' - 10 day')), date('Y-m-d'), $account_name);
            $stats['cpa'] = $cost_stats['cpa'];
            $stats['revenue'] = $cost_stats['revenue'];
            $this->render('product_stats', $this->model('orders')->getProductsStats(null, null, null, $account_name));
            $this->render('visitors', $visitors);
            $this->render('stats', $stats);
            $this->render('products', $this->model('products')->getUserProducts(registry::get('user')['id']));
            $this->view('index' . DS . 'index_wm');
        } else {
            $stats = $this->model('orders')->getOrderDailyStats(date('Y-m-d', strtotime(date('Y-m-d') . ' - 10 day')), date('Y-m-d'), null, $account_name);
            $stats['today'] = $this->model('orders')->getTodayCount();
            $stats['month'] = $this->model('orders')->getMonthCount();
            $stats['period'] = $this->model('orders')->getPeriodCount(null, null, date('Y-m-d', strtotime(date('Y-m-d') . ' - 10 day')), date('Y-m-d'));
            $stats['del_today'] = $this->model('orders')->getDeliveryStats(null, null, date('Y-m-d'));
            $stats['del_month'] = $this->model('orders')->getDeliveryStats(null, null, date('Y-m-01'), date('Y-m-d'));
            $stats['del_period'] = $this->model('orders')->getDeliveryStats(null, null, date('Y-m-d', strtotime(date('Y-m-d') . ' - 10 day')), date('Y-m-d'));
//            exit;
//            print_r($stats);exit;
            $visitors['today'] = $this->model('orders')->getVisitorsByProduct(null, date('Y-m-d 00:00:00'), null);
            $visitors['month'] = $this->model('orders')->getVisitorsByProduct(null, date('Y-m-01 00:00:00'), null);
            $cost_stats = $this->model('orders')->getCostApprovedStats(null, date('Y-m-d', strtotime(date('Y-m-d') . ' - 10 day')), date('Y-m-d'), $account_name);
            $stats['cpa'] = $cost_stats['cpa'];
            $stats['revenue'] = $cost_stats['revenue'];
            $this->render('product_stats', $this->model('orders')->getProductsStats(null, null, null, $account_name));
            $this->render('visitors', $visitors);
            $this->render('stats', $stats);
            $this->render('products', $products);
            $this->view('index' . DS . 'index');
        }
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_stats":

                $res = $this->model('orders')->getOrderDailyStats($_POST['filter_date_from'], $_POST['filter_date_to'], $_POST['filter_product_id'], $_POST['filter_name']);
                $res['period'] = $this->model('orders')->getPeriodCount($_POST['filter_product_id'], $_POST['filter_name'], $_POST['filter_date_from'], $_POST['filter_date_to']);
                $res['today'] = $this->model('orders')->getTodayCount($_POST['filter_product_id'], $_POST['filter_name']);
                $res['month'] = $this->model('orders')->getMonthCount($_POST['filter_product_id'], $_POST['filter_name']);
                $res['visitors']['today'] = $this->model('orders')->getVisitorsByProduct($_POST['filter_product_id'], date('Y-m-d 00:00:00'), null, $_POST['filter_name']);
                $res['visitors']['month'] = $this->model('orders')->getVisitorsByProduct($_POST['filter_product_id'], date('Y-m-01 00:00:00'), null, $_POST['filter_name']);
                $res['period'] = $this->model('orders')->getPeriodCount($_POST['filter_product_id'], $_POST['filter_name'], $_POST['filter_date_from'], $_POST['filter_date_to']);
                $res['del_today'] = $this->model('orders')->getDeliveryStats($_POST['filter_product_id'], $_POST['filter_name'], date('Y-m-d'));
                $res['del_month'] = $this->model('orders')->getDeliveryStats($_POST['filter_product_id'], $_POST['filter_name'], date('Y-m-01'), date('Y-m-d'));
                $res['del_period'] = $this->model('orders')->getDeliveryStats($_POST['filter_product_id'], $_POST['filter_name'], $_POST['filter_date_from'], $_POST['filter_date_to']);
                $cost_stats = $this->model('orders')->getCostApprovedStats($_POST['filter_product_id'], $_POST['filter_date_from'], $_POST['filter_date_to'], $_POST['filter_name']);
                $res['cpa'] = $cost_stats['cpa'];
                $res['revenue'] = $cost_stats['revenue'];
                $res['status'] = 1;
                echo json_encode($res);
                exit;
                break;

            case "get_tab_stats":
                $cost_stats = $this->model('orders')->getCostApprovedStats($_POST['filter_product_id'], $_POST['filter_date_from'], $_POST['filter_date_to'], $_POST['filter_name']);
                $res['cpa'] = $cost_stats['cpa'];
                $res['revenue'] = $cost_stats['revenue'];
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