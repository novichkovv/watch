<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 31.10.2016
 * Time: 2:41
 */
class formatting_controller extends controller
{
    public function index()
    {
        $comments = [
            'Правда не рвутся!',
            'Отличные колготки!',
            'Счастье-то какое, наконец-то!',
            'Ношу две недели уже, еще хочу заказать со скидкой',
            'Тебе понравится',
            'Советую',
            'Ничего себе, очень круто',
            'Реально не рвутся уже неделю',
            'Девочки, советую!',
            'И мне скидку :)',
            'Очень классная вещь, я устала тратить деньги на колготки уже',
            'Круто!!!!',
            'Девочки, берите, не пожалеете!'
        ];
        $lines = [];
        if(isset($_POST['generate_btn'])) {
            $switch = $_POST['switch'];
            $one = [];
            if($file = file($_FILES['file']['tmp_name'])) {
                foreach ($file as $k => $id) {
                    if($k < $_POST['offset']) {
                        continue;
                    }
                    $one[] = trim('@id' . $id, "\n\r");
                    if(($k + 1)%$switch === 0) {
//                    $lines[] = implode(',', $one);

                        $lines[] = $comments[rand(0, count($comments) - 1)] . ' ' . implode(',', $one);
                        $one = [];
                    }
                    if($k == $_POST['total']) {
                        break;
                    }
                }
                $res = '{' . implode('|', $lines) . '}';
                $this->render('res', $res);
                $this->render('count', $k - $_POST['offset']);
            }
        }

#name	email/username	password	proxy-url/proxy-ip:port	proxy username	proxy password	tags
        //$res_arr[] = '#name,email/username,password,proxy-url/proxy-ip:port,proxy username,proxy password,tags';
        if($_POST['generate_inst_btn']) {
            $res_arr = [];
            foreach (file($_FILES['accounts']['tmp_name']) as $k => $item) {
                $res_arr[$k][0] = 'inst_acc_' . $k . time();
                $arr = explode(':', $item);
                $res_arr[$k][1] = $arr[0];
                $res_arr[$k][2] = array_shift(explode('|', $arr[1]));
            }
            foreach (file($_FILES['proxy']['tmp_name']) as $k => $item) {
                if(!$res_arr[$k]) {
                    continue;
                }
                $arr = explode(':', $item);
                $res_arr[$k][3] = $arr[0] . ':' . $arr[1];
                $res_arr[$k][4] = $arr[2];
                $res_arr[$k][5] = trim($arr[3]);
                $res_arr[$k][6] = '';
            }
            $file = '#name,email/username,password,proxy-url/proxy-ip:port,proxy username,proxy password,tags' . "\n";
            foreach ($res_arr as $k => $v) {
                $file .= implode(',', $v) . "\n";
            }
            header("Content-Type: application/download");

            // disposition / encoding on response body
            header("Content-Disposition: attachment;filename=accounts.csv");
            echo $file;
            exit;
        }

        if($_POST['generate_vk_btn']) {
            $res_arr = [];
            foreach (file($_FILES['accounts']['tmp_name']) as $k => $item) {
                $arr = explode(':', $item);
                $res_arr[$k][0] = $arr[0];
                $res_arr[$k][1] = trim(array_shift(explode('|', $arr[1])));
            }
            foreach (file($_FILES['proxy']['tmp_name']) as $k => $item) {
                if(!$res_arr[$k]) {
                    continue;
                }
                $arr = explode(':', $item);
                $res_arr[$k][2] = $arr[0] . ':' . $arr[1];
                $res_arr[$k][3] = 'HTTP';
                $res_arr[$k][4] = $arr[2];
                $res_arr[$k][5] = trim($arr[3]);
            }
            $file = '';
            foreach ($res_arr as $k => $v) {
                $file .= implode(';', $v) . "\n";
            }
            header("Content-Type: application/download");

            // disposition / encoding on response body
            header("Content-Disposition: attachment;filename=accounts.txt");
            echo $file;
            exit;
        }

        $this->view('formatting' . DS . 'index');
    }
}