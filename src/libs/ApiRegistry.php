<?php
namespace App\Libs;

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;

class ApiRegistry{

    protected static $_instances = [];

    public static function get($id){
        if(!self::has($id)){
            self::$_instances[$id] = new Client();
        }
        return self::$_instances[$id];
    }

    public static function has($id){
        return isset(self::$_instances[$id]);
    }

    public static function remove($name){
        if(self::has($name)){
            unset(self::$_instances[$name]);
        }
    }

    public static function clear(){
        self::$_instances = [];
    }
}