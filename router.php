<?php

require __DIR__.'/vendor/autoload.php';

$path = $_SERVER['PATH_INFO'] ?? '/';

$router = new SON\Router\Router($path, 'GET');

$router->get('/', function ($params) {
    return 'home';
});

$router->get('/blog', function () {
    return 'blog do site';
});

$router->get('/blog/{id}/{title:([a-zA-Z]+)}', function () {
    return 'artigo com id';
});

$router->get('/me/sobre', function () {
    return 'sobre mim';
});

$router->post('/form', function () {
    return 'enviar email';
});

$router->get('/form', function () {
    return 'exibir formulário de email';
});

$data = $router->run();
echo $data['callback']($data['params']);
