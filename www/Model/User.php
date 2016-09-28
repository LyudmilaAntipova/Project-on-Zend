<?php
class Model_User {
    /*
     * @var int
          */
    public $id;
    /*
     * @var string
          */
    public $first_name;
     /*
     * @var string
          */
    public $last_name;
    /*
     * @var string
          */
    public $email;
    /*
     * @var int
          */
    private $_password;
    /*
     * @var int
          */
    public $roleId;
     /*
     * @var string
          */
    public $skills;
    
    const ROLE_ADMIN_ID = 1;
    const MODE_REGISTER = 1;
    const MODE_LOGIN    = 2;
    const LIFETIME_USER_COOKIE = 10800;
    
    public static function getById($userId) {
        
        $dbUser = new Model_Db_Table_User();
        
        $userData  =  !empty($dbUser->getById($userId)[0]) ? $dbUser->getById($userId)[0] : null;
        
        if(is_object($userData)) {
            
            $modelUser = new self();
            $modelUser->id         = $userData->id;
            $modelUser->first_name = $userData->first_name;
            $modelUser->last_name  = $userData->last_name;
            $modelUser->email      = $userData->email;
            $modelUser->skills     = $userData->skills;
            $modelUser->roleId     = $userData->role_id;
          
//            echo '<pre>';
//            print_r($modelUser);
//            echo '</pre>';
//            die;
            return $modelUser;
            
        }
        
        else {
            
            echo 'User not found';
        }
    }
    
    /**
     * 
     * @param array $params
     * @throws Exception
     */
    public function register($params)
    {
        if(!$this->_validate($params))
        {
            throw new Exception('The entered data is invalid', System_Exception::VALIDATE_ERROR);
        }
        
        $tableUser = new Model_Db_Table_User();
   
        $resIfExists = $tableUser->checkIfExists($params);
        
        if(!empty($resIfExists)) {
            throw new Exception('Such account is already exists.', System_Exception :: ALREADY_EXIST);
        }
        else {
            $resCreate = $tableUser->create($params);
            
            if(!$resCreate) {
                throw new Exception('Can\'t create new user. Try later.', System_Exception :: ERROR_CREATE_USER);
            }
            return $resCreate;
        }
    }
     /**
     * 
     * @param array $params
     * @return boolean
     */
    private function _validate($params)
    {
        $login      = !empty($params['email']) ? $params['email'] : '';
        $password   = !empty($params['password']) ? $params['password'] : '';
        
        
        if(empty($password) || empty($login)) {
            return false;
        }
        
        if(strlen($login > 20)) {
            return false;
        }
        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    
    /**
     * 
     * @param array $params
     * @return int userId
     * @throws Exception
     */
    public function login($params)
    {
        if(!$this->_validate($params))
        {
            throw new Exception('The entered data is invalid', System_Exception::VALIDATE_ERROR);
        }
        $tableUser = new Model_Db_Table_User();
        
        $res = $tableUser->checkIfExists($params, Model_User::MODE_LOGIN);
        
        if(!empty($res)) {
            $user = reset($res);
            return $user; 
        }
        else {
            throw new Exception('Invalid user or password.', System_Exception::INVALID_LOGIN);
        }
    }
}