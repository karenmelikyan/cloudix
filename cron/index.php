<?php

require_once '../app/Config.php';



/**
 *  if URL content start/stop command-
 *  write this command in file
 */
//if(isset($_GET['command'])){
//    if($_GET['command'] == 'stop' || $_GET['command'] == 'start'){
//        file_put_contents('current_status', $_GET['command']);
//    }
//}
//
///**
// *  always to check `current_status` file,
// *  for  to know what to do: stop `cron` or start
// */
//$current_status = file_get_contents('current_status');
//
//$cron = new Cron();
//
//if($current_status == 'start'){
//    $cron->startCurl(Config::$conf['domain'] . '/index.php?r=file/deleteexpiredfiles');// working invoke
//    sleep(20); // delay less than time of server limit
//    $cron->startCurl(Config::$conf['domain'] . '/cron/');// self invoke
//}else if($current_status == 'stop'){
//    if(isset($cron)){
//        $cron->forceStopCurl();
//        unset($cron);
//    }
//}

$cron = new Cron();
$cron->startCurl(Config::$conf['domain'] . '/index.php?r=file/deleteexpiredfiles');// working invoke
sleep(20); // delay less than time of server limit
$cron->startCurl(Config::$conf['domain'] . '/cron/');// self invoke

$cron->forceStopCurl();
        unset($cron);
        exit($cron);

final class Cron
{
    private $curl;

    public function forceStopCurl()
    {
        if(isset($this->curl)){
            curl_close($this->curl); // заканчиваем работу curl
        }
    }

    public function startCurl($request)
    {
        $this->curl = curl_init(); // инициализируем cURL
        // устанавливаем URL к которому нужно обращаться
        curl_setopt($this->curl, CURLOPT_URL, $request);
        curl_exec($this->curl);  // выполняем запрос
        curl_close($this->curl); // заканчиваем работу curl
    }
}