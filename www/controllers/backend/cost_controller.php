<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 16.12.2016
 * Time: 21:03
 */
class cost_controller extends controller
{
    public function index()
    {
        if($_POST) {
            $this->writeLog('test', $_POST);
        }
        if($_FILES) {
            $this->writeLog('test', $_FILES);
            $dir = ROOT_DIR . 'tmp' . DS . 'uploaded' . DS . 'cost_tmp';
            foreach (scandir($dir) as $item) {
                if($item != '.' && $item != '..') {
                    unlink($dir . DS . $item);
                }
            }
            foreach ($_FILES['file']['name'] as $k => $file) {
                if(array_pop(explode('.', $file)) == 'csv') {
                    move_uploaded_file($_FILES['file']['tmp_name'][$k], $dir . DS . $file . '.csv');
                }
            }
            exit;
        }
        $this->addScript(SITE_DIR . 'js/libs/dropzone.min.js');
        $this->view('cost' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "get_parsed_csv_table":
                $costs = [];
                $checked_products = [];
                $products = [];
                $dir = ROOT_DIR . 'tmp' . DS . 'uploaded' . DS . 'cost_tmp';
                foreach (scandir($dir) as $item) {
                    if($item != '.' && $item != '..') {
                        foreach (file($dir . DS . $item) as $k => $line) {
                            if($k === 0) {
                                continue;
                            }
                            $row = str_getcsv($line);
                            if($row[8]) {
                                if(!$checked_products[$row[2]] && !$costs[$row[2]]) {
                                    if($product = $this->model('products')->getByField('product_key', $row[2])) {
                                        $costs[$row[2]][$row[0]] = [
                                            'reach' => $row[6],
                                            'results' => $row[4],
                                            'spent' => $row[8],
                                            'relevance_score' => $row[9],
                                            'product_id' => $product['id']
                                        ];
                                        $products[$row[2]] = $product['id'];
                                    } else {
                                        $checked_products[$row[2]] = $row[2];
                                    }
                                } elseif($costs[$row[2]]) {
                                    $costs[$row[2]][$row[0]] = [
                                        'reach' => $row[6],
                                        'results' => $row[4],
                                        'spent' => $row[8],
                                        'relevance_score' => $row[9],
                                        'product_id' => $products[$row[2]]
                                    ];
                                }
                            }
                        }
                    }
                }
                $this->render('costs', $costs);
                $template = $this->fetch('cost' . DS . 'upload_confirm_form');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;
            
            case "save_costs":
                foreach ($_POST['cost'] as $date => $costs) {
                    foreach ($costs as $cost) {
                        if($id = $this->model('costs')->getByField('issue_date', $date)) {
                            $cost['id'] = $id;
                        }
                        $cost['create_date'] = date('Y-m-d H:i:s');
                        $this->model('costs')->insert($cost);
                    }
                }
                exit;
                break;
        }
    }

}