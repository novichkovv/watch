<?php
/**
 * configuration file
 */

error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', realpath($_SERVER['DOCUMENT_ROOT']) . DS);
define('CORE_DIR', ROOT_DIR . 'core' . DS);
define('SITE_DIR', 'http://' . str_replace('http://', '', $_SERVER['HTTP_HOST'] . '/'));
if(count($arr = explode('.', $_SERVER['HTTP_HOST'])) > 2) {
    $sub_domain = array_shift($arr);
    $project = in_array($sub_domain, array(
        'www',
        'dev'
    )) ? 'frontend' : $sub_domain;
    $project = in_array($sub_domain, array(
        'admin',
    )) ? 'backend' : $sub_domain;

} else {
    $project = 'frontend';
}
define('MAIN_SITE_DIR', 'http://' . str_replace('http://', '', implode('.', $arr) . '/'));
define('PROJECT', $project);
define('TEMPLATE_DIR', ROOT_DIR . 'templates' . DS . PROJECT . DS);
define('CONTROLLER_DIR', ROOT_DIR . 'controllers' . DS . PROJECT . DS);
define('LIBS_DIR', ROOT_DIR . 'libs' . DS);
define('IMAGE_DIR', SITE_DIR . '/images/' . PROJECT . '/');
define('DEVELOPMENT_MODE', true);


define('DB_NAME', 'thaib');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

define('PAYPAL_TEST_MODE', true);
if(PAYPAL_TEST_MODE) {
    define('PAYPAL_API_CLIENT_ID', 'ATYvwNUzVoV4WCo7HhvYn2bXR99_5ArqbHGmh3JttfCc3NZ373YiqZmf_aeFkN2cE3Dta5rt0tqhGG5F');
    define('PAYPAL_API_CLIENT_SECRET', 'EJU3wF0-K9_YpoU7OlaC8vJmgbjGiB4VCYV6e5NaZwfZ4twaKphWplQjl5hFeSYEpKhoJ_lhAYHoI8gx');
    define('PAYPAL_API_URL', 'https://api.sandbox.paypal.com/v1/');
}

define('PAYPAL_REDIRECT_URI', 'http://thaib.loc/api/paypal/');
