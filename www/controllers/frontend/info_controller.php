<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 30.12.2016
 * Time: 16:45
 */
class info_controller extends controller
{
    public function index()
    {

    }

    public function payment()
    {
        $this->view('info' . DS . 'payment');
    }

    public function geo()
    {
        $this->view('info' . DS . 'geo');
    }

    public function oferta()
    {
        if(isset($_POST['download_oferta_btn'])) {
            $document = 'oferta.docx';
            $dir = ROOT_DIR . 'documents' . DS . 'public' . DS;
            $filename = $dir . $document;
            if(file_exists($filename)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . $document);
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                readfile($filename);
            }
        }
        $this->view('info' . DS . 'oferta');
    }

    public function pvz()
    {
        $this->view('info' . DS . 'pvz');
    }

    public function geo_na()
    {
        $this->geo();
    }

    public function pvz_na()
    {
        $this->pvz();
    }

    public function oferta_na()
    {
        $this->oferta();
    }

    public function payment_na()
    {
        $this->payment();
    }

    public function index_na()
    {
        $this->index();
    }
}