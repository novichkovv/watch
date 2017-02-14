"","Загружено в систему"
"","Передано на комплектацию"
"","Комплектация завершена"
"","Передано на предварительный обзвон"
"","Принято на складе B2С"
"","Утеряно"
"","Посылка отмечена как дефектная"
"","Посылка отмечена как не дефектная"
"","Посылка в транспортировке"
"","Утеряно"
"","Оформлен возврат по требованию отправителя"
"","Прибыло в город получателя"
"","Посылка поступила в обзвон"
"","Дата доставки согласована"
"","Отказ получателя от посылки при обзвоне"
"","Вручено получателю"
"","Посылка снята с обзвона"
"","Истек срок хранения"
"","Отказ получателя от посылки при вручении"
"","Посылка возвращена в обзвон"
"","Посылка отправлена в возврат на складе B2C"
"","Посылка отправлена Почтой в возврат"
"","Возврат в транспортировке"
"","Возврат принят на складе"
"","Возврат принят на комплектовочном складе"
"","Возврат заказчику"
"","Оформлена претензия в Почту России (розыск)"
"","Оформлена претензия в Почту России (деньги)"
"","Утеряно Почтой России"
"","Деньги за посылку переведены клиенту"
"","Счет за услуги доставки B2C выставлен"
"","Счет за услуги страхования B2C выставлен"
"","Счет за услуги возврата B2C выставлен"
"","Счет за услуги доставки B2C почтой выставлен"
"","Счет за услуги возврата B2C почтой выставлен"
"","""",""



<?php
require_once 'config.php';
require_once CORE_DIR . 'autoload.php';
//$api = new sms_api_class();
//print_r($api->send_sms('79038236333', 'Ваш Заказ находится в Пункте Выдачи, Москва, пр.Шокальского, д.61 пав. 15'));
$cron = new cron_class();
$cron->sendParcels();
//$api = new ml_api_class();
//$api->getOrderListLastUpdate([]);
/**
$kab = '{"addresses":[{"codes":{"kladr_actual":"500240000720000","kladr_detected":"500240000720000","kladr_pure":"50024000072"},"cover":[{"in":"обл Московская"},{"out":","},{"in":"р-н Орехово-Зуевский"},{"out":","},{"in":"д Кабаново (Горское с\/п"},{"out":"),"},{"in":"164"},{"out":"-"},{"in":"19"}],"fields":[{"c":"50","cover":"обл Московская","level":"Region","name":"Московская","ns":1.00,"ts":1.00,"type":"обл"},{"c":"024","cover":"р-н Орехово-Зуевский","level":"District","name":"Орехово-Зуевский","ns":1.00,"ts":1.00,"type":"р-н"},{"level":"City"},{"c":"072","cover":"д Кабаново (Горское с\/п","level":"Place","name":"Кабаново (Горское с\/п)","ns":1.00,"ts":1.00,"type":"д"},{"level":"Street"},{"c":"0001","cover":"164","level":"House","name":"164","ns":1.00,"ts":0.00,"type":"дом"},{"level":"Building"},{"level":"Structure"},{"cover":"19","level":"Flat","name":"19","ns":0.50,"ts":0.00,"type":"кв"},{"level":"Zip","name":"142664","type":"Индекс"}],"geo_data":{"max":{"lat":55.7607011,"lon":38.9489613},"mid":{"lat":55.7508754,"lon":38.9300545},"min":{"lat":55.7409974,"lon":38.9114513},"object_level":"Place","rel":100},"pretty":"обл Московская, р-н Орехово-Зуевский, д Кабаново (Горское с\/п), дом 164, кв 19","quality":{"canonic_fields":3,"detected_fields":3,"precision":100,"recall":100,"verified_numeric_fields":1,"warnings":"ChildIsSkipped|"}}],"check_info":{"alts":1,"query":"обл Московская, р-н Орехово-Зуевский, д Кабаново (Горское с\/п), 164-19","time":28},"request_process_time":28}';
$ore = '{"addresses":[{"codes":{"kladr_actual":"500000260000167","kladr_detected":"500000260000167","kladr_pure":"500000260000167"},"cover":[{"in":"обл Московская"},{"out":","},{"in":"г Орехово-Зуево"},{"out":","},{"in":"ул Парковская"},{"out":","},{"in":"36"}],"fields":[{"c":"50","cover":"обл Московская","level":"Region","name":"Московская","ns":1.00,"ts":1.00,"type":"обл"},{"level":"District"},{"c":"026","cover":"г Орехово-Зуево","level":"City","name":"Орехово-Зуево","ns":1.00,"ts":1.00,"type":"г"},{"level":"Place"},{"c":"0167","cover":"ул Парковская","level":"Street","name":"Парковская","ns":1.00,"ts":1.00,"type":"ул"},{"c":"0002","cover":"36","level":"House","name":"36","ns":1.00,"ts":0.00,"type":"дом"},{"level":"Building"},{"level":"Structure"},{"level":"Flat"},{"level":"Zip","name":"142608","type":"Индекс"}],"geo_data":{"house_level":"House","max":{"lat":55.8262944,"lon":39.0101344},"mid":{"lat":55.8243759,"lon":39.0074608},"min":{"lat":55.8171493,"lon":38.9896944},"object_level":"Street","rel":100},"pretty":"обл Московская, г Орехово-Зуево, ул Парковская, дом 36","quality":{"canonic_fields":3,"detected_fields":3,"precision":100,"recall":100,"verified_numeric_fields":1}}],"check_info":{"alts":1,"query":"обл Московская, г Орехово-Зуево, ул Парковская, 36","time":25},"request_process_time":27}';
//print_r(json_decode($kab,1));
//print_r(json_decode($ore, 1));
$address = json_decode($kab,1);
$row = [];
$fields = $address['addresses'][0]['fields'];
$row['zip_code'] = $fields[9]['name'];
$row['region'] = $fields[0]['type'] . ' ' . $fields[0]['name'];
$row['county'] = $fields[1]['type'] . ' ' . $fields[1]['name'];
$row['city'] = $fields[2]['type'] . ' ' . $fields[2]['name'];
$row['place'] = $fields[3]['type'] . ' ' . $fields[3]['name'];
$row['street'] = $fields[4]['type'] . ' ' . $fields[4]['name'];
$row['house'] = $fields[5]['type'] . ' ' . $fields[5]['name'];
$row['building'] = $fields[6]['type'] . ' ' . $fields[6]['name'];
$row['structure'] = $fields[7]['type'] . ' ' . $fields[7]['name'];
$row['flat'] = $fields[8]['type'] . ' ' . $fields[8]['name'];
$row['address'] = $row['zip_code'] . ', ' . $address['addresses'][0]['pretty'];
print_r($row);
$address = json_decode($ore,1);
$row = [];
$fields = $address['addresses'][0]['fields'];
$row['zip_code'] = $fields[9]['name'];
$row['region'] = $fields[0]['cover'];
$row['county'] = $fields[1]['cover'];
$row['city'] = $fields[2]['cover'];
$row['place'] = $fields[3]['cover'];
$row['street'] = $fields[4]['cover'];
$row['house'] = $fields[5]['cover'];
$row['building'] = $fields[6]['cover'];
$row['structure'] = $fields[7]['cover'];
$row['flat'] = $fields[8]['cover'];
print_r($row);*/