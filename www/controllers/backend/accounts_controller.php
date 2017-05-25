<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.12.2016
 * Time: 11:00
 */
class accounts_controller extends controller
{
    public function index()
    {
        if(isset($_POST['save_account_btn'])) {
            $this->model('m1_accounts')->insert($_POST['account']);
            header('Location: ' . SITE_DIR . 'accounts/');
            exit;
        }
        $this->render('accounts', $this->model('m1_accounts')->getAll());
        $this->view('accounts' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_account_form":
                $this->render('users', $this->model('system_users')->getAll());
                if($_POST['id']) {
                    $this->render('account', $this->model('m1_accounts')->getById($_POST['id']));
                }
                $template = $this->fetch('accounts' . DS . 'ajax' . DS . 'account_form');
                echo json_encode(['status' => 1, 'template' => $template]);
                exit;
                break;
        }
    }
}