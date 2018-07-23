<?php
namespace Tests\Helper\Fixture;

use App\Libs\ApiRegistry;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

abstract class TestFixture{
    /**
     *
     * @var type
     */
    protected $_apiName;

    /**
     * 
     */
    protected $_data = [];

    public function getProperty($object, $prop){
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    public function setProperty($object, $prop, $value){
        $refObject   = new \ReflectionClass( $object );
        $refProperty = $refObject->getProperty( $prop );
        $refProperty->setAccessible( true );
        $refProperty->setValue(null, $value);
    }

    public function initData(){
        $apis = $this->getProperty(ApiRegistry::class, "_instances");
        $handler = HandlerStack::create(new MockHandle($this->_data));
        $apis[$this->_apiName] = new Client(['handler' => $handler]);
        $this->setProperty(ApiRegistry::class, "_instances", $apis);
    }

    /**
     *
     */
    public function clear(){
        ApiRegistry::remove($this->_apiName);
    }
}
