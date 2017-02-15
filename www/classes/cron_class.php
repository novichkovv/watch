<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.12.2016
 * Time: 12:11
 */
class cron_class extends base
{
    public function sendParcels()
    {
        $parcels = $this->model('parcels')->getParcelsToSend();
        if($parcels) {
            $csv = '"Номер накладной";"Номер посылки";"Номер клиента";"Дата заказа";"Индекс";"Город";"Адрес";"ФИО";"Телефон мобильный";"Телефон дополнительный";"e-mail";"Вес посылки";"Полная стоимость доставки";"Стоимость доставки к оплате";"Артикул";"Товар";"Кол-во ед. товара";"Полная стоимость ед. товара";"Стоимость ед. товара к оплате";"Вес товара";"Тип доставки";"Доставка авиа";"Хрупкий товар";"Оценочная стоимость посылки";"Код b2c";"Условия доставки";"Упаковка";"Отправитель";"Дата доставки";"Интервал доставки";"Комментарии";"Частичный отказ"' . "\r\n";
            foreach ($parcels as $parcel) {
                $csv .= '"' . $parcel['consignment_note'] . '";';
                $csv .= '"' . $parcel['parcel_id'] . '";';
                $csv .= '"' . $parcel['user_id'] . '";';
                $csv .= '"' . $parcel['create_date'] . '";';
                $csv .= '"' . $parcel['zip'] . '";';
                $csv .= '"' . $parcel['city'] . '";';
                $csv .= '"' . $parcel['street'] . ', ' . $parcel['house'] . ', ' . $parcel['flat'] . '";';
                $csv .= '"' . $parcel['first_name'] . '";';
                $csv .= '"' . $parcel['phone'] . '";';
                $csv .= ';';
                $csv .= '"' . $parcel['email'] . '";';
                $weight = 0;
                $goods = [];
                $fragile = '';
                $estimate_cost = 0;
                foreach ($parcel['goods'] as $good) {
                    if($good['fragile']) {
                        $fragile = 'да';
                    }
                    if(!$goods[$good['id'] . $good['price']]) {
                        $goods[$good['id'] . $good['price']] = $good;
                        $goods[$good['id'] . $good['price']]['quantity'] = 1;
                    } else {
                        $goods[$good['id'] . $good['price']]['quantity'] ++;
                    }
                    $weight += $good['weight'];
                    $estimate_cost += $good['price'];
                }
                $first_good = array_shift($goods);
                if(!in_array($parcel['delivery_type_id'], [1,2])) {
                    $estimate_cost += $parcel['delivery_price'];
                }
                $weight /= 1000;
                $csv .= '"' . $weight . '";';
                $csv .= '"' . $parcel['delivery_price'] . '";';
                $csv .= '"' . ($parcel['payment_status_id'] != 1 ? $parcel['delivery_price'] : 0) . '";';
                $csv .= '"' . $first_good['stock_number'] . '";';
                $csv .= '"' . $first_good['good_name'] . '";';
                $csv .= '"' . $first_good['quantity'] . '";';
                $csv .= '"' . $first_good['price'] . '";';
                $csv .= '"' . ($parcel['payment_status_id'] != 1 ? $first_good['price'] : 0) . '";';
                $csv .= '"' . $first_good['weight']/1000 . '";';
                $csv .= '"' . $parcel['type_name'] . '";';
                $csv .= ';';
                $csv .= '"' . $fragile . '";';
                $csv .= '"' . $estimate_cost . '";';
                $csv .= ';';
                $csv .= ';';
                $csv .= '"' . $first_good['package'] . '";';
                $csv .= ';';
                $csv .= '"' . ($parcel['delivery_date'] != '0000-00-00' ? $parcel['delivery_date'] : '') . '";';
                $csv .= '"' . ($parcel['delivery_interval'] ? ($parcel['delivery_interval'] == 1 ? '1-я половина' : '2-я половина') : '') . '";';
                $csv .= '"' . $parcel['comments'] . '";';
                $csv .= '"' . ($parcel['partial_decline'] ? 'да' : '') . '"' . "\r\n";
                foreach ($goods as $good) {
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= '"' . $good['stock_number'] . '";';
                    $csv .= '"' . $good['good_name'] . '";';
                    $csv .= '"' . $good['quantity'] . '";';
                    $csv .= '"' . $good['price'] . '";';
                    $csv .= '"' . ($parcel['payment_status_id'] != 1 ? $good['price'] : 0) . '";';
                    $csv .= '"' . $good['weight']/1000 . '";';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= '"' . $good['package'] . '";';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= ';';
                    $csv .= '' . "\r\n";
                }
            }
            $file_name = mktime() . '.csv';
            $name = ROOT_DIR . 'tmp' . DS . 'parcels' . DS . $file_name;
            $file_url = SITE_DIR . 'tmp/parcels/' . $file_name;
            file_put_contents($name, $csv);
            foreach ($parcels as $parcel) {
                $row = [
                    'id' => $parcel['parcel_id'],
                    'status_id' => 1,
                    'filename' => $file_name
                ];
                $this->model('parcels')->insert($row);
                $order = [
                    'id' => $parcel['order_id'],
                    'status_id' => 11,
                    'last_status_update' => date('Y-m-d H:i:s')
                ];
                $this->model('orders')->insert($order);
            }
            $b2_api = new b2_api_class();
            $res = $b2_api->upload($file_url);
            if(!$res['flag_error']) {
                foreach ($parcels as $parcel) {
                    $order = [
                        'id' => $parcel['order_id'],
                        'status_id' => 12,
                        'last_status_update' => date('Y-m-d H:i:s')
                    ];
                    $this->model('orders')->insert($order);
                }
            }
        }
    }

    public function updateMLInfo()
    {
        $orders = $this->model('orders')->id_array()->getAll('create_date DESC', 100);
        $ml_api = new ml_api_class();
        print_r($ml_api->getOrderListLastUpdate([]));
        foreach ($ml_api->getOrderListLastUpdate([]) as $item) {
            $order_id = $item['foreign_value'];
            if(isset($orders[$order_id]) && $orders[$order_id]['cc_status_id'] != $item['status_num']) {
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
                            'zip' => $item['postal_code'],
                            'country' => $item['country'],
                            'city' => $item['city'],
                            'street' => $item['street'],
                            'house' => $item['house'],
                            'flat' => $item['flat'],
                            'region' => $item['region'],
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
                                $delivery_type_id = 1;
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
                        $order = [
                            'id' => $order_id,
                            'cc_status_id' => 3
                        ];
                        $this->model('orders')->insert($order);
                        break;
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

    public function updateDeliveryStatuses()
    {
        $orders = $this->model('orders')->getByField('status_id', '12', true, 'create_date DESC', 100);
        $codes = [];
        $sorted_orders = [];
        foreach ($orders as $order) {
            $parcel = $this->model('parcels')->getByField('order_id', $order['id']);
            $codes['codes'][] = $parcel['id'];
            $sorted_orders[$parcel['id']] = $order;
        }
        $codes['codes'] = json_encode($codes);
        $api = new b2_api_class();

            print_r($api->getStatuses($codes)['codes']);
        foreach ($api->getStatuses($codes)['codes'] as $code) {
            if($sorted_orders[$code['code']]['delivery_status'] != $code['status']) {
                $order = [
                    'id' => $sorted_orders[$code['code']]['id'],
                    'delivery_status' => $code['status']
                ];
                switch ($code['status']) {
                    case "Вручено получателю":
                        $order['status_id'] = 13;
                        $order['payment_status_id'] = 1;
                        $order['pay_date'] = date('Y-m-d H:i:s');
                        $order['last_status_update'] = date('Y-m-d H:i:s');
                        break;
                }
                $this->model('orders')->insert($order);
            }
        }
    }
}