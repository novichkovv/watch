<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 19.10.2016
 * Time: 13:31
 */
class products_controller extends controller
{
    public function index()
    {
        $this->view('products' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_orders":
                $params = [];
                $params['table'] = 'products p';
                $params['select'] = [
                    'p.id',
                    'p.product_name',
                    'p.product_key',
                    'p.landing_key',
                    'p.success_landing_key',
                    'p.affiliate_id',
                    'p.webmaster_id',
                    'p.price',
                    'CONCAT("
                    <a data-toggle=\"modal\" class=\"btn outline blue show_product\" href=\"#product_modal\" data-id=\"", p.id, "\">
                        <i class=\"fa fa-pencil\"></i>
                    </a>")'
                ];
                echo json_encode($this->getDataTable($params));
                exit;
                break;

            case "get_product_modal_form":
                $product = $this->model('products')->getById($_POST['id']);
                $this->render('product', $product);
                $template = $this->fetch('products' . DS . 'ajax' . DS . 'product_modal');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

            case "edit_product_info":
                $product = $_POST['product'];
                if(!$product['id']) {
                    $product['create_date'] = date('Y-m-d H:i:s');
                }
                $this->model('products')->insert($product);
                echo json_encode(array('status' => 1));
                exit;
                break;

            case "get_product_form":
                $template = $this->fetch('products' . DS . 'ajax' . DS . 'product_modal');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

        }
    }
}