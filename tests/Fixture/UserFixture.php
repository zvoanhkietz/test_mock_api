<?php
namespace Tests\Fixture;

use Tests\Helper\Fixture\TestFixture;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Response;

class UserFixture extends TestFixture{
    /**
     *
     * @var type
     */
    protected $_apiName = 'UserClient';
    
    /**
     *
     * @var type
     */
    protected $_defaultPath = '/api/v1/test_get_users';

    /**
     * 
     */
    public function __construct(){
        $this->_data = [
            'Data set 1' => function(RequestInterface $req, array $options, $next){
                $path = $req->getUri()->getPath();
                $method = $req->getMethod();
                if( $path   == $this->_defaultPath && $method == 'GET'){
                    return new Response(200, ['Content-Type'=> 'applicaton/json'], 'test');
                }
                return $next($req, $options);
            },
            'Method not allow' => function(RequestInterface $req, array $options, $next){
                $path = $req->getUri()->getPath();
                $method = $req->getMethod();
                if( $path   == $this->_defaultPath && $method == 'POST'){
                    return new Response(405, ['Content-Type'=> 'applicaton/json'], 'Method not allow.');
                }
                return $next($req, $options);
            }
        ];
    }
}
