<?php

 //разделитель
define ('DS', DIRECTORY_SEPARATOR);

//узнаем путь к файлам сайта
$site_path = realpath(dirname (__FILE__) . DS) .DS;
define ('SITE_PATH', $site_path);

$config     =   file_get_contents(SITE_PATH . DS . 'config.xml');

$configXML  =   new SimpleXMLElement ($config);

$host       =   (string)$configXML->db->host;
$dbname     =   (string)$configXML->db->dbname;
$username   =   (string)$configXML->db->username;
$password   =   (string)$configXML->db->password;

//подключение к базе

try {
        $db = new PDO ('mysql:host='.$host.';dbname='.$dbname, $username,$password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
        catch (PDOException $e) {
            echo "Error!: " . $e->getMessage();
    }

spl_autoload_register ('loadClass');

    function loadClass ($className)
    {
        $file = str_replace('_', DS, $className) . '.php';
     
        if (!file_exists($file)) {
        throw new Exception ('File doesn\'t exist');
    }
    include $file;
    }

try {
        System_Registry :: set ('db', $db);
    }
        catch (Exception $e) {
            echo $e->getMessage();
        }

try {
        $router = new System_Router();
        $router->setPath(SITE_PATH . 'Controller');
        $router->start();
}
catch(Exception $e) {
    echo $e->getMessage();
}