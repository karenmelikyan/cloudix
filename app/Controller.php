<?php declare(strict_types=1);

/**
 *  Header controller of framework
 */
 
namespace mvc\app;

interface ControllerInterface{
	
	/**
	 * The string '$content' should contain the name of the rendering file.
	 * the array `$params` is optional, and can contents additional params 
	 * for handling in rendering file
	 */
	public function render(string $content, array $params = []);
}

abstract class Controller implements ControllerInterface{
	
	/**
     * points to a view layout file for controllers 
	 * that will inherit it
	 *  
	 * @string $layout
     */
    public string $layout = 'main';
	
	/**
	 * @param string $content
	 * @param array $params
	 */
    public function render(string $content, array $params = [])
    {
		if($params){
			foreach($params as $key => $value){
               $a  = $key;
			   $$a = $value;
			}
		}
	
		require 'views/layouts/' . $this->layout . '.php';
	}
}



