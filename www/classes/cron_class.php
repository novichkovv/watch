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
        $orders = $this->model('orders')->id_array()->getAll('create_date DESC', 100);
        $ml_api = new ml_api_class();
//        print_r($ml_api->getOrderListLastUpdate([]));
        foreach ($ml_api->getOrderListLastUpdate([]) as $item) {
//            print_r($item);
//            echo $item['status'];
//            echo $item['foreign_value'];
//            print_r($orders[$item['foreign_value']]);
            if(isset($orders[$item['foreign_value']]) && $orders[$item['foreign_value']]['cc_status_id'] != $item['status_num']) {
                print_r($item);
                switch ($item['status_num']) {
                    case "1":
                        $order = [
                            'id' => $item['foreign_value'],
                            'cc_status_id' => 1,
                            'comments' => ($orders[$item['foreign_language']]['comments'] ? $orders[$item['foreign_language']]['comments'] . '<br>' : '') . $item['comments']
                        ];
                        print_r($order);
                        break;
                    case "2":
                        $order = [
                            'id' => $item['foreign_value'],
                            'cc_status_id' => 2,
                            'comments' => ($orders[$item['foreign_language']]['comments'] ? $orders[$item['foreign_language']]['comments'] . '<br>' : '') . $item['comments'],
                            'status_id' => 9,
                        ];
                        $address = [
                            'user_id' => $orders[$item['foreign_language']]['user_id'],
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
                        if($orders[$item['foreign_language']]['address_id']){
                            $address['id'] = $orders[$item['foreign_language']]['address_id'];
                        } else {
                            $address['create_date'] = date('Y-m-d H:i:s');
                        }
                        $order_goods = [
                            'order_goods'
                        ]
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