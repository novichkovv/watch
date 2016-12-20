<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.12.2016
 * Time: 12:11
 */
class cron_class extends base
{
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