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
        $this->render('products', $this->model('products')->getAll());
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
                    'IF(p2.id, p2.product_name, "-")',
                    'p.affiliate_id',
                    'p.webmaster_id',
                    'p.price',
                    'CONCAT("
                    <a data-toggle=\"modal\" class=\"btn outline blue show_product\" href=\"#product_modal\" data-id=\"", p.id, "\">
                        <i class=\"fa fa-pencil\"></i>
                    </a>")'
                ];
                $params['join']['products'] = [
                    'as' => 'p2',
                    'left' => true,
                    'on' => 'p.cross_product_id = p2.id'
                ];
                $params['order'] = 'p.create_date DESC';
                echo json_encode($this->getDataTable($params));
                exit;
                break;

            case "get_product_modal_form":
                $this->render('goods', $this->model('goods')->getAll('good_name'));
                $this->render('products', $this->model('products')->getAll());
                $product = $this->model('products')->getById($_POST['id']);
                foreach ($this->model('product_goods')->getByField('product_id', $product['id'], true) as $item) {
                    $product['goods'][$item['good_id']] = $item['good_id'];
                }
                $this->render('product', $product);
                $template = $this->fetch('products' . DS . 'ajax' . DS . 'product_modal');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

            case "edit_product_info":
                $product = $_POST['product'];
                $goods = $product['goods'];
                unset($product['goods']);
                if(!$product['id']) {
                    $product['create_date'] = date('Y-m-d H:i:s');
                }
                $product['id'] = $this->model('products')->insert($product);
                $this->model('product_goods')->delete('product_id', $product['id']);
                foreach ($goods as $good) {
                    $this->model('product_goods')->insert([
                        'product_id' => $product['id'],
                        'good_id' => $good
                    ]);
                }
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