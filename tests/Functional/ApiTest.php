<?php
namespace Tests\Functional;

use Tests\Fixture\UserFixture;
use Tests\Helper\IntegrationTestCase;
use App\Libs\ApiRegistry;

class ApiTest extends IntegrationTestCase
{
    public $fixtures = [
        UserFixture::class
    ];

    /**
     * Test that the index route with optional name argument returns a rendered greeting
     */
    public function testApi()
    {
        $response = $this->request('GET', '/api/v1/test');
        $this->assertEquals(200, $response->getStatusCode());
    }
}