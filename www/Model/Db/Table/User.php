<?php
class Model_Db_Table_User
{
    
    protected $_name = 'user';
    protected $_connection;


    public function __construct() {
        
        $this->_connection = System_Registry::get('db');
    }

    public function  getById($id)
    {
        $sql    = 'select * from ' . $this->_name . ' where id = ?';
        
        $sth    = $this->_connection->prepare($sql);
        
        $sth->execute(array($id));
        
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        
        return $result;
    }
   
    /**
     * 
     * @param array $params
     * @param int $mode
     * @return mixed
     */
    
    public function checkIfExists($params, $mode = Model_User::MODE_REGISTER)
    {
        $login      = trim($params['email']);
        $password   = trim($params['password']);
        
        $requestParams = array($login);
        
        $sql = 'select * from ' . $this->_name . ' where email = ?';
        if($mode == Model_User::MODE_LOGIN) {
            $sql .= 'AND password = ?';
            array_push($requestParams, sha1($password));
        }
        
        /**
         * @var PDOStatement $sth 
         */
        $sth = $this->_connection->prepare($sql);
        $sth->execute($requestParams);
        $result = $sth->fetchAll(PDO::FETCH_OBJ);    
        
//        print_r($result);
//        die;
                
        return $result;
    }
    
    /**
     * @param array $params
     * @return int 
     */
    public function create($params)
    {
        $login      = trim($params['email']);
        $password   = trim($params['password']);
        $sth = $this->_connection->prepare('INSERT INTO ' . $this->_name . ' (email,password) VALUES(?,?)');
        
        $result = $sth->execute(array($login, sha1($password)));
        
        if(!empty($result)) {
            return $this->_connection->lastInsertId();
        }
            
    }
}
   