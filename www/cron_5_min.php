<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 14.02.2017
 * Time: 13:46
 */
require_once 'config.php';
require_once(CORE_DIR . 'registry.php');
require_once(CORE_DIR . 'autoload.php');
$cron = new cron_class();
$cron->updateMLInfo();