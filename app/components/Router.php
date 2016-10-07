<?php

namespace App\components;

class Router
{
    
    private $routes;
    
    public function __construct()
    {
        $routesPath = ROOT . '/../app/config/routes.php';
        $this->routes = include($routesPath);
    }
    
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }
    
    private function createObj($controllerName)
    {
        
       $controllerName = ucfirst($controllerName);
        $controllerFile = ROOT . '/../app/controllers/' . $controllerName . '.php';              

        if (file_exists($controllerFile)) {             
            include_once($controllerFile);              
        }

        $controllerObj = new $controllerName;
        
        return $controllerObj;
    }

    public function run()
    {      
        
        $uri = $this->getURI();        
        $arr = parse_url($uri);   
        
        if (empty($arr['path'])) {          

            $controllerObj = $this->createObj('mainController');
            $controllerObj->actionIndex();                        
        } else {
        
            foreach ($this->routes as $uriPattern => $path) {

                if (preg_match("~$uriPattern~", $uri)) {

                    $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                    
                    $exp = explode('/', $internalRoute);
                    $controllerName = array_shift($exp) . 'Controller';

                    $actionName = 'action' . ucfirst(array_shift($exp));      

                    $parameters = $exp;

                    $controllerObj = $this->createObj($controllerName);
                    //$result = $controllerObj->$actionName();

                    $result = call_user_func_array(array($controllerObj, $actionName), $parameters);

                    if ($result != null) {
                        break;
                    }
                } 
            }
        }        
    }
}
