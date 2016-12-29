<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 28.12.2016
 * Time: 15:44
 */
class docs_controller extends controller
{
    public function index()
    {
        if(!empty($_GET['document'])) {
            $dir = ROOT_DIR . 'documents' . DS . 'public' . DS;
            $filename = $dir . $_GET['document'];
            if(file_exists($filename)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . $_GET['document']);
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                readfile($filename);
            }
        }
        exit;
    }

    public function index_na()
    {
        $this->index();
    }
}