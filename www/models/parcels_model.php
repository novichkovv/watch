<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 12.02.2017
 * Time: 11:57
 */
class parcels_model extends model
{
    public function getParcelsToSend()
    {
        $stm = $this->pdo->prepare('
            SELECT 
            o.id order_id,
            o.user_id,
            o.payment_status_id,
            o.delivery_price,
            og.price,
            g.id good_id,
            g.good_name,
            g.stock_number,
            g.consignment_note,
            g.weight,
            g.package,
            g.price cost,
            a.phone,
            a.first_name,
            a.zip,
            a.country,
            a.region,
            a.city,
            a.street,
            a.house,
            a.flat,
            dt.type_name,
            p.id parcel_id,
            p.delivery_type_id,
            p.delivery_type_comment,
            p.fragile,
            p.delivery_date,
            p.delivery_interval,
            p.partial_decline,
            o.create_date
        FROM
            orders o
                JOIN
            order_goods og ON og.order_id = o.id
                JOIN
            goods g ON g.id = og.good_id
                JOIN
            user_addresses a ON a.id = o.address_id
                JOIN
            parcels p ON p.order_id = o.id
                JOIN
            delivery_types dt ON dt.id = p.delivery_type_id
        WHERE
            p.status_id = 0
        ');
        $tmp = $this->get_all($stm);
        $res = [];
        foreach ($tmp as $v) {
            foreach ($v as $key => $val) {
                if(in_array($key, [
                    'good_id',
                    'price',
                    'good_name',
                    'stock_number',
                    'weight',
                    'package',
                    'cost'
                ])) {
                    $res[$v['parcel_id']]['goods'][$v['good_id']][$key] = $val;
                } else {
                    $res[$v['parcel_id']][$key] = $val;
                }
            }
        }
        print_r($res);
        return $res;
    }
}