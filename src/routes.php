<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Libs\ApiRegistry;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


$app->get('/api/v1/test', function (Request $request, Response $response, array $args) {
    $client = ApiRegistry::get('UserClient');
    $res = $client->request('GET', 'http://foo.bar/api/v1/test_get_users');
    // Render index view
    return $response->withJson(['test' => $res->getBody()]);
});
