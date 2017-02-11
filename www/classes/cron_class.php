<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.12.2016
 * Time: 12:11
 */
class cron_class extends base
{
    public function updateMLInfo()
    {
//        error_reporting(E_ALL);
        $orders = $this->model('orders')->id_array()->getAll('create_date DESC', 100);
        $ml_api = new ml_api_class();
//        print_r($ml_api->getOrderListLastUpdate([]));
        foreach ($ml_api->getOrderListLastUpdate([]) as $item) {

//            echo $item['status'];
//            echo $item['foreign_value'];
//            print_r($orders[$item['foreign_value']]);
            $order_id = $item['foreign_value'];
            if(isset($orders[$order_id]) && $orders[$order_id]['cc_status_id'] != $item['status_num']) {
//                print_r($item);
                switch ($item['status_num']) {
                    case "1":
                        $order = [
                            'id' => $order_id,
                            'cc_status_id' => 1,
                            'comments' => ($orders[$order_id]['comments'] ? $orders[$order_id]['comments'] . '<br>' : '') . $item['comments']
                        ];
                        $this->model('orders')->insert($order);
                        break;
                    case "2":
                        $address = [
                            'user_id' => $orders[$order_id]['user_id'],
                            'phone' => $item['tel'],
                            'first_name' => $item['client'],
//                            'middle_name' => ,
//                            'last_name' => ,
                            'zip' => $item['postal_code'],
                            'country' => $item['country'],
                            'city' => $item['city'],
//                            'place' => ,
                            'street' => $item['street'],
                            'house' => $item['house'],
//                            'building' => ,
//                            'structure' => ,
                            'flat' => $item['flat'],
                            'region' => $item['region'],
//                            'area' => ,
//                            'address' => ,
//                            'comments' => ,
                        ];
                        if($orders[$order_id]['address_id']){
                            $address['id'] = $orders[$order_id]['address_id'];
                        } else {
                            $address['create_date'] = date('Y-m-d H:i:s');
                        }

                        $address['id'] = $this->model('user_addresses')->insert($address);
                        $order = [
                            'id' => $order_id,
                            'cc_status_id' => 2,
                            'comments' => ($orders[$order_id]['comments'] ? $orders[$order_id]['comments'] . '<br>' : '') . $item['comments'],
                            'status_id' => 9,
                            'address_id' => $address['id'],
                            'delivery_price' => $item['shipping_price']

                        ];
                        $this->model('orders')->insert($order);
                        $this->model('order_goods')->delete('order_id', $order_id);
                        $goods = [];
                        foreach ($item['products'] as $g) {
                            $product = $g;
                            $good = $this->model('goods')->getByField('ml_id', $product['product_id']);
                            $good['quantity'] --;
                            for ($i = 0; $i < $product['count']; $i++) {
                                $order_goods = [
                                    'order_id' => $order_id,
                                    'good_id' => $good['id'],
                                    'product_id' => $orders[$order_id]['product_id'],
                                    'price' => $product['price'],
                                    'create_date' => date('Y-m-d H:i:s')
                                ];
                                if($this->model('order_goods')->insert($order_goods)) {
                                    $this->model('goods')->insert($good);
                                }
                            }
                        }
                        switch ($item['delivery_type']) {
                            case "Почта России":
                                $delivery_type_id = 3;
                                break;
                            case "Курьер Мск, Спб":
                                $delivery_type_id = 2;
                                break;
                            default:
                                $delivery_type_id = 3;
                                break;
                        }
                        $delivery_time = 0;
                        if($item['desired_delivery_time']) {
                            $delivery_time = date('H', $item['desired_delivery_time']) > 14 ? 1 : 2;
                        }
                        $parcel = [
                            'order_id' => $order_id,
                            'address_id' => $orders[$order_id]['address_id'],
                            'delivery_type_id' => $delivery_type_id,
                            'delivery_date' => $item['desired_delivery_date'],
                            'delivery_interval' => $delivery_time,
                            'comments' => '',
                            'create_date' => date('Y-m-d H:i:s')
                        ];
                        $this->model('parcels')->insert($parcel);
                        break;

                    case "3":


                    case "4":
                        $order = [
                            'id' => $order_id,
                            'cc_status_id' => 4,
                            'cc_cancel_status_id' => $item['cancel_reason'],
                            'status_id' => 10,
                            'comments' => ($orders[$order_id]['comments'] ? $orders[$order_id]['comments'] . '<br>' : '') . $item['comments']
                        ];
                        $this->model('orders')->insert($order);
                        if($order_goods = $this->model('orders_goods')->getByField('order_id', $order_id, true)) {
                            foreach ($order_goods as $order_good) {
                                $good = $this->model('goods')->getById($order_good['id']);
                                $good['quantity'] ++;
                                $this->model('goods')->insert($good);
                            }
                            $this->model('order_goods')->delete('order_id', $order_id);
                        }
                        break;
                        break;

                    case "5":
                        $order = [
                            'id' => $order_id,
                            'cc_status_id' => 5,
                            'cc_cancel_status_id' => $item['cancel_reason'],
                            'status_id' => 10,
                            'comments' => ($orders[$order_id]['comments'] ? $orders[$order_id]['comments'] . '<br>' : '') . $item['comments']
                        ];
                        $this->model('orders')->insert($order);
                        if($order_goods = $this->model('orders_goods')->getByField('order_id', $order_id, true)) {
                            foreach ($order_goods as $order_good) {
                                $good = $this->model('goods')->getById($order_good['id']);
                                $good['quantity'] ++;
                                $this->model('goods')->insert($good);
                            }
                            $this->model('order_goods')->delete('order_id', $order_id);
                        }
                        break;
                        break;
                }
            }
        }
    }


    public function update_order_statuses()
    {
        $orders = [];
        $order_ids = [];
        $approved = [];
        foreach ($this->model('orders')->getOrdersForCron() as $order) {
            if($order['aff_order_id']) {
                $orders[] = $order['aff_order_id'];
                $order_ids[$order['aff_order_id']] = $order['id'];
                if(!$order['pay_date']) {
                    $approved[$order['aff_order_id']] = $order['id'];
                }
            }
        }
        $api = new m1_api_class();
        $res = $api->get_order_status($orders, 17763);
        print_r($res);
        foreach ($res['result'] as $k => $item) {
            if($item['comments'] || $item['callcenter_comment']) {
                $comments = $item['comment'] . ($item['callcenter_comment'] ? ' КЦ: ' . $item['callcenter_comment'] : '');
                switch ($item['status']) {
                    case "1":
                        $status = 2;
                        break;
                    case "2":
                        $status = 3;
                        break;
                    case "3":
                        $status = 5;
                        break;
                    case "4":
                        $status = 6;
                        break;
                    default:
                        $status = 1;
                        break;
                }
                $row = [
                    'id' => $order_ids[$item['m1_id']],
                    'comments' => $comments,
                    'status_id' => $status
                ];
                if($status == 2 && !$approved[$item['m1_id']]) {
                    $row['pay_date'] = date('Y-m-d H:i:s');
                }
                if($row['id']) {
                    $this->model('orders')->insert($row);
                }
            }
        }

    }
}