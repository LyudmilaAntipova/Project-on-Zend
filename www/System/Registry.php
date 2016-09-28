<?php
class System_Registry {
/**
     * Registry hash-table
     *
     * @var array
     */
protected static $_registry = [];
/**
     * Put item into the registry
     * 
     * @param $key string
     * @param $item mixed
     * @throws Exception
     * @return void
     */

protected function __construct(){}

    public static function set($key, $item) {
       
        if(!array_key_exists($key, self::$_registry)) {
            foreach (self::$_registry as $val)
            {
                if ($val === $item) {
                    throw new Exception('Item already exist');
                }
            }
            
            self::$_registry[$key] = $item;
        }
        
       else {
           throw new Exception('Key already exist');
       }
       
    }
    
     /**
     * Get item by key
     *
     * @param $key string
     * @return false|object
     */
    public static function get($key)
    {
        if(array_key_exists($key, self::$_registry)) {
            return self::$_registry[$key];
        }
        
        return false;
    }

    /**
     * Remove item from the regisry
     *
     * @param string $key
     * @return void
     */
    public static function remove($key)
    {
        if (array_key_exists($key, self::$_registry)) {
            unset(self::$_registry[$key]);
        }
    }
    
}
