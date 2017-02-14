<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 09.02.2017
 * Time: 15:07
 */
require_once 'config.php';
require_once(CORE_DIR . 'registry.php');
require_once(CORE_DIR . 'autoload.php');
$cron = new cron_class();
$cron->sendParcels();