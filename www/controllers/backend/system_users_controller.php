<?php

/**
 * Created by PhpStorm.
 * User: enovichkov
 * Date: 26.03.15
 * Time: 12:42
 */

class system_users_controller extends controller
{
    public function index()
    {
        if(isset($_POST['delete_btn'])) {
            $this->model('system_users')->deleteById($_POST['delete_id']);
            header('Location: ' . SITE_DIR . 'system_users/');
            exit;
        }
        $this->render('users', $this->model('system_users')->getUsers());
        $this->view('system_users' . DS . 'list');
    }



    public function index_ajax()
    {
        switch($_REQUEST['action']) {
            case "get_users_table":
                $params = array();
                $params['table'] = 'system_users u';
                $params['select'] = array(
                    'u.id',
                    'g.group_name',
                    'u.email',
                    'DATE_FORMAT(u.create_date,"%d/%m/%Y")',
                    'CONCAT("<a href=\"' . SITE_DIR .'system_users/add_user/?id=", u.id, "\" class=\"btn btn-default btn-xs\">
                            <span class=\"fa fa-pencil\"></span>
                        </a>
                        <a href=\"#delete_user_modal\" class=\"btn btn-default btn-xs delete_user\" data-id=\"", u.id, "\" data-toggle=\"modal\" role=\"button\">
                            <span class=\"text-danger fa fa-times\"></span>
                        </a>")'
                );
                $params['join']['user_groups'] = array(
                    'on' => 'u.user_group_id = g.id',
                    'as' => 'g',
                    'left' => true
                );
                echo json_encode($this->getDataTable($params));
                exit;
                break;
        }
    }
    
    public function add_user()
    {
        if(isset($_POST['save_user_btn'])) {
            $row = [];
            if($_GET['id']) {
                $row['id'] = $_GET['id'];
            } else {
                $row['create_date'] = date('Y-m-d H:i:s');
            }
            $row['email'] = $_POST['email'];
            $row['user_group_id'] = $_POST['user_group_id'];
            $row['user_name'] = $_POST['user_name'];
            $row['view_type'] = $_POST['view_type'];
            if($_POST['user_password']) {
                $row['user_password'] = md5($_POST['user_password']);
            }
            $user_id = $this->model('system_users')->insert($row);
            $this->model('system_user_products')->delete('system_user_id', $user_id);
            foreach ($_POST['user_products'] as $user_product) {
                $row = [
                    'system_user_id' => $user_id,
                    'product_id' => $user_product
                ];
                $this->model('system_user_products')->insert($row);
            }
            if($_POST['user_password']) {
                $this->logOut();
                $this->auth(registry::get('user')['email'], md5($_POST['user_password']));
                registry::remove('user');
                $this->checkAuth();
            }
            header('Location: ' . SITE_DIR . 'system_users/');
            exit;
        }
        $user_products = [];
        foreach ($this->model('system_user_products')->getByField('system_user_id', $_GET['id'], true) as $item) {
            $user_products[] = $item['product_id'];
        }
//        print_r($user_products);exit;
        $this->render('user_products', $user_products);
        $this->render('user_groups', $this->model('user_groups')->getAll());
        $this->render('products', $this->model('products')->getAll('create_date DESC'));
        if($_GET['id']) {
            $this->render('user', $this->model('system_users')->getById($_GET['id']));
        }
        $this->view('system_users' . DS . 'add');
    }
    
    public function groups()
    {
        if(isset($_POST['delete_btn'])) {
            $this->model('user_groups')->deleteById($_POST['delete_id']);
            header('Location: ' . SITE_DIR . 'system_users/groups/');
            exit;
        }
        $this->render('groups', $this->model('user_groups')->getAll());
        $this->view('users' . DS . 'groups');
    }
    
    public function add_group()
    {
        if(isset($_POST['save_group_btn'])) {
            $row = [];
            if($_GET['id']) {
                $row['id'] = $_GET['id'];
            }
            $row['group_name'] = $_POST['group_name'];
            $row['create_date'] = date('Y-m-d H:i:s');
            $this->model('user_groups')->insert($row);
            header('Location: ' . SITE_DIR . 'system_users/groups/');
            exit;
        }
        
        if($_GET['id']) {
            $this->render('group', $this->model('user_groups')->getById($_GET['id']));
        }
        $this->view('system_users' . DS . 'add_group');
    }

    public function permissions()
    {
        if(isset($_POST['save_permissions_btn'])) {
            $this->model('system_routes_user_groups_relations')->deleteAll();
            foreach($_POST['permission'] as $user_group_id => $routes) {
                if($routes) {
                    foreach($routes as $system_route_id) {
                        $row = [];
                        $row['user_group_id'] = $user_group_id;
                        $row['system_route_id'] = $system_route_id;
                        $this->model('system_routes_user_groups_relations')->insert($row);
                    }
                }
            }

            header('Location: ' . SITE_DIR . 'system_users/permissions/');
            exit;

        }
        $permissions = [];
        $tmp = $this->model('system_routes_user_groups_relations')->getAll();
        foreach($tmp as $v) {
            $permissions[$v['user_group_id']][] = $v['system_route_id'];

        }
        $tmp = $this->model('system_routes')->getByField('permitted', '0', true, 'position');
        $routes = [];
        foreach($tmp as $v) {
            if(!$v['parent']) {
                $routes[$v['id']] = $v;
            } else {
                $routes[$v['parent']]['children'][$v['id']] = $v;
            }
        }

        $groups = $this->model('user_groups')->getAll();

        $result = [];

        foreach($groups as $v) {
            $result[$v['id']]['group_name'] = $v['group_name'];
            $result[$v['id']]['routes'] = $routes;
            foreach($result[$v['id']]['routes'] as $k => $route) {
                if(is_array($permissions[$v['id']]) && in_array($route['id'], $permissions[$v['id']])) {
                    $result[$v['id']]['routes'][$k]['checked'] = true;
                }
                if($route['children']) {
                    foreach($route['children'] as $key => $child) {
                        if(is_array($permissions[$v['id']]) && in_array($child['id'], $permissions[$v['id']])) {
                            $result[$v['id']]['routes'][$k]['children'][$key]['checked'] = true;
                        }
                    }
                }
            }
        }
        $this->render('result', $result);
        $this->view('system_users' . DS . 'permissions');
    }



    public function permissions_ajax()
    {

        switch($_REQUEST['action']) {
            case "save_permission":

                //echo $part . 's_user_groups_relations';

                $this->model('system_routes_user_groups_relations')->deleteAll();

                foreach ($_POST['permission'][1] as $user_group_id => $routes) {

                    if ($routes) {

                        foreach ($routes as $system_route_id) {

                            $row = [];

                            $row['user_group_id'] = $user_group_id;

                            $row['system_route_id'] = $system_route_id;

                            $this->model('system_routes_user_groups_relations')->insert($row);

                        }

                    }

                }

                echo json_encode(array('status' => 1));

                exit;

                break;

        }

    }

}