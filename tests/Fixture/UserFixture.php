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
     */
    public function __construct(){
        $this->_data = [
            'Data set 1' => function(RequestInterface $req, array $options, $next){
                $path = $req->getUri()->getPath();
                $method = $req->getMethod();
                if( $path   == '/api/v1/test_get_users' &&
                    $method == 'GET'){
                    return new Response(200, ['Content-Type'=> 'applicaton/json'], 'test');
                }
                return $next($req, $options);
            }
        ];
    }
}