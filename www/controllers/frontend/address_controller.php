<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 08.09.2016
 * Time: 15:20
 */
class address_controller extends controller
{
    public function index()
    {
        if(empty($_GET['product_id'])) {
            header('Location: ' . SITE_DIR);
            exit;
        }
        if(isset($_POST['add_order_btn'])) {
            if($user = $this->model('users')->getByField('email', $_POST['user']['email'])) {
                $user['phone'] = $_POST['user']['phone'];
                $user['user_name'] = $_POST['user']['user_name'];
            } else {
                $user = $_POST['user'];
                $user['create_date'] = date('Y-m-d H:i:s');
            }
            if($user['id'] = $this->model('users')->insert($user)) {
                $address = $_POST['address'];
                $address['user_id'] = $user['id'];
                if(!$existing = $this->model('user_addresses')->getByFields($address)) {
                    $address['id'] = $this->model('user_addresses')->insert($address);
                } else {
                    $address = $existing;
                }
                if($address['id']) {
                    $product = $this->model('products')->getById($_POST['product_id']);
                    if($product) {
                        $order = [
                            'product_id' => $product['id'],
                            'user_id' => $user['id'],
                            'address_id' => $address['id'],
                            'status_id' => 1,
                            'price' => $product['price'],
                            'create_date' => date('Y-m-d H:i:s')
                        ];
                        $order['id'] = $this->model('orders')->insert($order);
                        if($order['id']) {
                            header('Location: ' . SITE_DIR . 'payment/?order_id=' . $order['id']);
                            exit;
                        } else {
                            throw new Exception('No order cteated');
                        }
                    } else {
                        throw new Exception('Incorrect Product');
                    }
                } else {
                    throw new Exception('No address saved');
                }
            } else {
                throw new Exception('No user saved');
            }

        }
        $this->view('address' . DS . 'form');
    }

    public function index_na()
    {
        $this->index();
    }
}