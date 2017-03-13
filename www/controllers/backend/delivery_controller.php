<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 16.12.2016
 * Time: 21:03
 */
class delivery_controller extends controller
{
    public function index()
    {
        if($_POST) {
            $this->writeLog('test', $_POST);
        }
        if($_FILES['file']['name']) {
            $existing = [];
            foreach ($this->model('delivery_info')->getAll() as $item) {
                $existing[$item['parcel_id']] = $item;
            }
            $lines = file($_FILES['file']['tmp_name']);
            array_shift($lines);
            foreach ($lines as $line) {
                $line = iconv("windows-1251", "utf-8", $line);
                $row = str_getcsv($line, ';');
                $info = [
                    'parcel_id' => $row[5],
                    'file_date' => $row[2],
                    'delivery_date' => $row[3],
                    'user_id' => $row[4],
                    'act' => $row[1],
                    'client_name' => $row[7],
                    'b2cpl_code' => $row[8],
                    'state' => $row[9],
                    'location' => $row[10],
                    'status_date' => $row[11],
                    'price' => $row[12],
                    'delivery_price' => $row[13],
                    'city' => $row[14],
                    'weight' => $row[15],
                    'zone' => $row[16],
                    'received' => $row[17],
                    'agent' => $row[18],
                    'payment' => $row[19],
                    'cost' => $row[20],
                    'insurance' => $row[21],
                    'pay_date' => $row[22],
                    'delivery_type' => $row[23],
                    'last_call' => $row[24],
                    'last_delivery' => $row[25],
                    'package_comment' => $row[26],
                    'product_description' => $row[27],
                    'estimate_cost' => $row[28],
                    'postal_rate' => $row[29],
                    'barcode' => $row[30],
                    'act_date' => $row[31],
                    'extra' => $row[32],
                    'first_call' => $row[33],
                    'calls_quantity' => $row[34],
                    'first_delivery' => $row[35],
                    'success_delivery' => $row[36],
                    'reason' => $row[37],
                    'last_status' => $row[38]
                ];
                if($existing[$row[5]]) {
                    $info['id'] = $existing[$row[5]]['id'];
                }
                $this->model('delivery_info')->insert($info);
            }

        }
        $this->view('delivery' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_delivery_table":
                $params = [];
                $params['select'] = [
                    'CONCAT("
                    <a href=\"' . SITE_DIR . 'orders/order/?id=", p.order_id,"\" class=\"btn btn-icon btn-default\">
                        <i class=\"fa fa-arrow-right\"></i>
                    </a>
                    ")',
                    'p.order_id',
                    'i.parcel_id',
                    'CONCAT("<div style=\"width: 800px;\">",i.last_status,"</div>")',
                    'CONCAT("<div style=\"width: 120px;\">",i.file_date,"</div>")',
                    'CONCAT("<div style=\"width: 120px;\">",i.delivery_date,"</div>")',
                    'i.user_id',
                    'i.act',
                    'CONCAT("<div style=\"width: 220px;\">",i.client_name,"</div>")',
                    'i.b2cpl_code',
                    'CONCAT("<div style=\"width: 220px;\">",i.state,"</div>")',
                    'CONCAT("<div style=\"width: 220px;\">",i.location,"</div>")',
                    'CONCAT("<div style=\"width: 120px;\">",i.status_date,"</div>")',
                    'i.price',
                    'i.delivery_price',
                    'i.city',
                    'i.weight',
                    'i.zone',
                    'i.received',
                    'i.agent',
                    'i.payment',
                    'i.cost',
                    'i.insurance',
                    'CONCAT("<div style=\"width: 120px;\">",i.pay_date,"</div>")',
                    'CONCAT("<div style=\"width: 220px;\">",i.delivery_type,"</div>")',
                    'CONCAT("<div style=\"width: 120px;\">",i.last_call,"</div>")',
                    'CONCAT("<div style=\"width: 120px;\">",i.last_delivery,"</div>")',
                    'i.package_comment',
                    'CONCAT("<div style=\"width: 500px;\">",i.product_description,"</div>")',
                    'i.estimate_cost',
                    'i.postal_rate',
                    'i.barcode',
                    'CONCAT("<div style=\"width: 120px;\">",i.act_date,"</div>")',
                    'i.extra',
                    'CONCAT("<div style=\"width: 120px;\">",i.first_call,"</div>")',
                    'i.calls_quantity',
                    'CONCAT("<div style=\"width: 120px;\">",i.first_delivery,"</div>")',
                    'CONCAT("<div style=\"width: 120px;\">",i.success_delivery,"</div>")',
                    'i.reason',
                ];
                $params['table'] = 'delivery_info i';
                $params['join']['parcels'] = [
                    'as' => 'p',
                    'on' => 'p.id = i.parcel_id',
                    'left' => true
                ];
                $params['order'] = 'file_date DESC';
                echo json_encode($this->getDataTable($params));
                exit;
                break;

        }
    }

}