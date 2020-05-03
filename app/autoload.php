<?php
    require_once 'app/Config.php';
    require_once 'app/Controller.php';
	require_once 'app/Router.php';
	
	spl_autoload_register(function (string $className){
		if(stripos($className, 'Controller')){
			require_once 'controllers/' . $className . '.php';
		}elseif(stripos($className, 'Model')){
			require_once 'models/' . $className . '.php';
		}elseif(stripos($className, 'Factory')){
            require_once 'factories/' . $className . '.php';
        }
    });
	
