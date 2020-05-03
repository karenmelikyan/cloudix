<?php

 session_start();

 /** include class autoloader */
 require_once __DIR__ . '/app/autoload.php';

 /** define controller & action for home page */
 (new Router(Config::$conf['homeController'], Config::$conf['homeAction']))->run();



