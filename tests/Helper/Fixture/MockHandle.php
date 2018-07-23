<?php
namespace Tests\Helper\Fixture;

use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Response;

class MockHandle{
    protected $_data = [];

    public function __construct($data = []){
        $this->_data = $data;
    }

    public function __invoke(RequestInterface $req, array $options){
        $matchNumber = 0;
        $response = null;
        $next = function(RequestInterface $req, array $options){
            return null;
        };
        foreach($this->_data as $execute){
            if(is_callable($execute)){
                $res = $execute($req, $options, $next);
                if($res && ($res instanceof Response)){
                    $matchNumber++;
                    if(!$response){
                        $response = $res;
                    }
                }
            }
        }

        if($matchNumber == 0){
            throw new \Exception("Data test not found.");
        }

        if($matchNumber >= 2){
            throw new \Exception("Data test was duplicated.");
        }

        $response = \GuzzleHttp\Promise\promise_for($response);

        return $response->then(
            function ($value) {
                return $value;
            },
            function ($reason){
                return \GuzzleHttp\Promise\rejection_for($reason);
            }
        );
    }
}