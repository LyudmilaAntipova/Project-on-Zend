<?php
abstract class System_Controller {
    
    /**
     * @var array      
     */
    public $args;
    
    /*
    *Get param
     * @return array
        */
       
      public $view;

      protected $_userId;

      protected function _getParams()
    {
        $count = count($this->args);
        
        $params = array();
        
        for($i = 0; $i < $count - 1; $i += 2) {
            
            $params[$this->args[$i]] = $this->args[$i + 1];
            
            }
        
        return $params; 
    }
    
     /**
     * Set view
     */
    public function __construct()
    {
        session_start();
        
        if( isset($_COOKIE[session_name()]) && $this->getParamByKey('save') == 'true')
            {
            setcookie(session_name(), session_id(), time() + Model_User::LIFETIME_USER_COOKIE, '/');
        }
        $this->view = new System_View();
        
        $this->_userId = $this->_getSessParam('currentUser');
    }
    
    
    protected function _setSessParam($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    protected function _getSessParam($key)
    {   
        if(!empty($_SESSION)) {
            return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : NULL;
        }
        return NULL;
    }
    
    
    public function getParamByKey($key)
    {
        return !empty($_REQUEST[$key]) ? $_REQUEST[$key] : NULL;
    }
    
    
    public function getUserId() {
        
        return $this->_userId;
    }

    
    public function getAllParams()
    {
        return $_REQUEST;
    }

    abstract function indexAction();
    
}