<?php

class Controller_User extends System_Controller
{
public function  indexAction() {
    
    echo 'Index Action';
}

public function profileAction ()
    {
      $args = $this->_getParams();
      
//      $userId = $args['id'];
//     
//      $modelUser = Model_User::getById($userId);
      
      
      if(!empty($args['id'])){
      try {
          
          $modelUser = Model_User::getById($args['id']);
          $this->view->setParam('user', $modelUser);
      }
      
      catch(Exception $e){
          
           $this->view->setParam('error', $e->getMessage());
         }   
       }
    }

    public function getAction()
    {
        echo 'Get Action';
    }
}