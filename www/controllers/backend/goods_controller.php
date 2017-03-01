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
                    'g.create_date',
                    'CONCAT("
                    <a class=\"btn outline blue edit_group\" href=\"' . SITE_DIR . 'goods/add?id=", g.id ,"\">
                        <i class=\"fa fa-pencil\"></i> 
                    </a>               
                    ")',
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
        if(isset($_POST['save_good_btn'])) {
            $good = $_POST['good'];
            if(!$good['id']) {
                $good['create_date'] = date('Y-m-d H:i:s');
            }
            $this->model('goods')->insert($good);
        }
        if($_GET['id']) {
            $this->render('good', $this->model('goods')->getById($_GET['id']));
        }

        $this->render('groups', $this->model('good_groups')->getAll('create_date DESC'));
        $this->render('colors', $this->model('good_colors')->getAll('create_date DESC'));
        $this->render('suppliers', $this->model('suppliers')->getAll('create_date DESC'));
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

            case "get_colors_list":
                $params = [];
                $params['select'] = [
                    'id',
                    'color_name',
                    'color_code',
                    'CONCAT("
                    <a class=\"btn outline blue edit_color\" href=\"#color_modal\" data-id=\"", id ,"\" data-toggle=\"modal\">
                        <i class=\"fa fa-pencil\"></i> 
                    </a>
                    <a class=\"btn outline red delete_color\" href=\"#delete_color_modal\" data-id=\"", id ,"\" data-toggle=\"modal\">
                        <i class=\"fa fa-remove\"></i>
                    </a>
                    ")',
                ];
                $params['table'] = 'good_colors';
                echo json_encode($this->getDataTable($params));
                exit;
                break;

            case "save_color":
                $color = $_POST['color'];
                if(!$color['id']) {
                    $color['create_date'] = date('Y-m-d H:i:s');
                }
                $this->model('good_colors')->insert($color);
                $colors = $this->model('good_colors')->getAll('create_date DESC');
                echo json_encode(array('status' => 1, 'colors' => $colors));
                exit;
                break;

            case "get_color_form":
                if($_POST['id']) {
                    $this->render('color', $this->model('good_colors')->getById($_POST['id']));
                }
                echo json_encode(array('status' => 1, 'template' => $this->fetch('goods' . DS . 'ajax' . DS . 'color_form')));
                exit;
                break;

            case "delete_color":
                $this->model('good_colors')->deleteById($_POST['id']);
                $colors = $this->model('good_colors')->getAll('create_date DESC');
                echo json_encode(array('status' => 1, 'colors' => $colors));
                exit;
                break;

            case "verify_stock_number":
                if($this->model('goods')->getByField('stock_number', $_POST['val'])) {
                    echo json_encode(array('status' => 2));
                } else {
                    echo json_encode(array('status' => 1));
                }
                exit;
                break;
        }
    }

    public function docs()
    {
        $this->view('goods' . DS . 'docs');
    }

    public function docs_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_document_form":
                $category = $this->model('document_categories')->getById($_POST['category_id']);
                switch ($_POST['category_id']) {
                    case "1":
                        $this->render('goods', $this->model('goods')->getAll('create_date DESC'));
                        break;
                }
                $template = $this->fetch('goods' . DS . 'ajax' . DS . $category['category_key'] . '_form');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

            case "get_expecting_row":
                $this->render('good', $this->model('goods')->getById($_POST['good_id']));
                $this->render('quantity', $_POST['quantity']);
                $this->render('price', $_POST['price']);
                $template = $this->fetch('goods' . DS . 'ajax' . DS . 'expecting_row');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

            default:
                $params = [];
                $params['select'] = [
                    'id',
                    'document_name',
                    'create_date',
                    'CONCAT("
                    <button class=\"btn outline blue download_document\" data-id=\"", id ,"\">
                        <i class=\"fa fa-pencil\"></i> 
                    </button>             
                    ")',
                ];
                $params['table'] = 'documents';
                echo json_encode($this->getDataTable($params));
                exit;
                break;
        }
    }

    public function suppliers()
    {
        $this->view('goods' . DS . 'suppliers');
    }

    public function suppliers_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_form":
                if($_POST['id']) {
                    $this->render('supplier', $this->model('suppliers')->getById($_POST['id']));
                }
                $template = $this->fetch('goods' . DS . 'ajax' . DS . 'supplier_form');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

            case "save_form":
                $supplier = $_POST['supplier'];
                if(!$supplier['id']) {
                    $supplier['create_date'] = date('Y-m-d H:i:s');
                }
                $this->model('suppliers')->insert($supplier);
                echo json_encode(array('status' => 1));
                exit;
                break;

            case "get_table":
                $params = [];
                $params['table'] = 'suppliers';
                $params['select'] = [
                    'supplier_name',
                    'supplier_code',
                    'CONCAT("
                    <a class=\"btn outline blue edit_btn\" href=\"#form_modal\" data-id=\"", id ,"\" data-toggle=\"modal\">
                        <i class=\"fa fa-pencil\"></i> 
                    </a>
                    <a class=\"btn outline red delete_btn\" href=\"#delete_modal\" data-id=\"", id ,"\" data-toggle=\"modal\">
                        <i class=\"fa fa-remove\"></i>
                    </a>
                    ")'
                ];
                echo json_encode($this->getDataTable($params));
                exit;
                break;

            case "delete_item":
                $this->model('suppliers')->deleteById($_POST['id']);
                echo json_encode(array('status' => 1));
                exit;
                break;
        }
    }
}