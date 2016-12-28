<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 27.12.2016
 * Time: 21:03
 */
class goods_controller extends controller
{
    public function index()
    {
        $api = new b2_api_class();
        print_r($api->getZipInfo(677000));
        exit;
        $this->view('goods' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_goods_list":
                $params = [];
                $params['select'] = [
                    'g.good_name',
                    'gg.group_name',
                    'g.stock_number',
                    'quantity',
                    'price',
                    'create_date',
                    '1'
                ];
                $params['table'] = 'goods g';
                $params['join']['good_groups'] = [
                    'as' => 'gg',
                    'on' => 'gg.id = g.group_id'
                ];
                echo json_encode($this->getDataTable($params));
                exit;
                break;
        }
    }

    public function add()
    {
        $this->render('groups', $this->model('good_groups')->getAll('create_date DESC'));
        $this->view('goods' . DS . 'add');
    }

    public function add_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_groups_list":
                $params = [];
                $params['select'] = [
                    'id',
                    'group_name',
                    'group_key',
                    'CONCAT("
                    <a class=\"btn outline blue edit_group\" href=\"#group_modal\" data-id=\"", id ,"\" data-toggle=\"modal\">
                        <i class=\"fa fa-pencil\"></i> 
                    </a>
                    <a class=\"btn outline red delete_group\" href=\"#delete_group_modal\" data-id=\"", id ,"\" data-toggle=\"modal\">
                        <i class=\"fa fa-remove\"></i>
                    </a>
                    ")',
                ];
                $params['table'] = 'good_groups';
                echo json_encode($this->getDataTable($params));
                exit;
                break;

            case "save_group":
                $group = $_POST['group'];
                if(!$group['id']) {
                    $group['create_date'] = date('Y-m-d H:i:s');
                }
                $this->model('good_groups')->insert($group);
                $groups = $this->model('good_groups')->getAll('create_date DESC');
                echo json_encode(array('status' => 1, 'groups' => $groups));
                exit;
                break;

            case "get_group_form":
                if($_POST['id']) {
                    $this->render('group', $this->model('good_groups')->getById($_POST['id']));
                }
                echo json_encode(array('status' => 1, 'template' => $this->fetch('goods' . DS . 'ajax' . DS . 'group_form')));
                exit;
                break;

            case "delete_group":
                $this->model('good_groups')->deleteById($_POST['id']);
                $groups = $this->model('good_groups')->getAll('create_date DESC');
                echo json_encode(array('status' => 1, 'groups' => $groups));
                exit;
                break;
        }
    }
}