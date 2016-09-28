<?php
class System_Router
{
    /**
     *
     * @var string
     */
    private $_path;
    /**
     * Set path
     *
     *
     * @param string $path
     * @throws Exception
     */
    public function setPath($path)
    {
        $path = trim($path, '/\\') . DS;
        //$path .= DS;

        if (is_dir($path) == false) {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }

        $this->_path = $path;
    }
    /**
     * Start routing
     *
     *
     * @throws Exception
     * @return void
     */
    public function start()
    {
        // Анализируем путь
        $this->_getController($file, $controllerName, $action, $args);

//        echo '<pre>';
//        print_r(
//            [
//                $file,
//                $controllerName,
//                $action,
//                $args
//            ]
//        );
//        echo '</pre>';
//
//        die;

        // Файл доступен?
        if (is_readable($file) == false) {
            throw new Exception ('404 error! Controller ' . '\'' . $controllerName . '\''. ' not found');
        }

        // Подключаем файл
        include ($file);

        // Создаём экземпляр контроллера
        $class = 'Controller_' . ucfirst($controllerName);

        $controller = new $class();

        // Действие доступно?
        if (is_callable(array($controller, $action)) == false) {
            throw new Exception('404 error. Action ' . '\'' . $action . '\''. ' Not Found');
        }

//        /**
//         * @var System_View $view
//         */
        $view = $controller->view;
//
        $controller->args = $args;

        call_user_func(array($controller, $action));

        $actionName = substr($action, 0, -6);
        
        
        $viewFolder = ucfirst($controllerName);
        
        $viewFileName = 'View' . DS . $viewFolder . DS . $actionName . '.phtml';
      
        $layoutFileName = 'View' . DS . 'layout.phtml';
       
      
        if (file_exists($layoutFileName)) {
            
            include_once $layoutFileName;
        }  
    }
    /**
     *
     * @param string $file
     * @param string $controller
     * @param string $action
     * @param string $args
     */
    private function _getController(&$file, &$controller, &$action, &$args)
    {
        $route = (empty($_GET['route'])) ? 'index' : $_GET['route'];

        // Получаем раздельные части
        $route = trim($route, '/\\');

        $parts = explode('/', $route);

        // Находим правильный контроллер
        $cmd_path = $this->_path;
        foreach ($parts as $part) {
            $part = ucfirst($part);
            if(!$controller) {
                $cmd_path .= $part . DS;
                $controller = array_shift($parts);
                continue;
            }

            // Находим файл
            if(!$action) {
                $action = array_shift($parts);
                break;
            }
        }

        if(empty($controller)) {
            $controller = 'Index';
        }

        if (empty($action)) {
            $action = 'indexAction';
        }
        else {
            $action .= 'Action';
        }

        $file = trim($cmd_path, '/\\') . '.php';

        $args = $parts;
    }
}