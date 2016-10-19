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
        header('Location: ' . SITE_DIR . 'mask/');
//        $api = new paypal_api_class();
//        $params = json_decode('{
//          "intent":"sale",
//          "redirect_urls":{
//            "return_url":"http://thaib.loc/api/paypal/",
//            "cancel_url":"http://thaib.loc/api/paypal/"
//          },
//          "payer":{
//            "payment_method":"paypal"
//          },
//          "transactions":[
//            {
//              "amount":{
//                "total":"7.47",
//                "currency":"USD"
//              }
//            }
//          ]
//        }', true);
//        $api->test($params);
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
        $this->render('product', $product);
        $this->render('dir', SITE_DIR . 'templates/frontend/landings/' . $product['landing_key'] . '/');
        $this->view_only('landings' . DS . $product['landing_key'] . DS . 'template');
    }

    public function show_na()
    {
        $this->show();
    }
}