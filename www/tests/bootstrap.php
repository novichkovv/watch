<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 02.09.2016
 * Time: 15:01
 */
if(!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if(!defined('ROOT_DIR')) {
    define('ROOT_DIR', 'c:\OpenServer\domains\news-bot\www' . DS);
}
define('DB_NAME', 'feedly');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('API_URL', 'https://sandbox.feedly.com');
define('API_REDIRECT_URL', 'http://localhost');
define('API_APP_ID', 'sandbox');
define('API_APP_SECRET', 'CNKEATM7ICEGVOZ3P5A1');
require_once ROOT_DIR . 'core\autoload.php';
