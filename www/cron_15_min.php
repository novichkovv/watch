<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.12.2016
 * Time: 12:10
 */
require_once 'config.php';
require_once(CORE_DIR . 'registry.php');
require_once(CORE_DIR . 'autoload.php');
$cron = new cron_class();
$cron->update_order_statuses();