<?php
require '../vendor/autoload.php';
require '../src/Database.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;

$app->get('/user/{id}', function (Request $request, Response $response) {
    $db = new Database();
    $id = $request->getAttribute('id');

    echo $db->get($id);
});


$app->post('/create', function (Request $request, Response $response) {
    $db = new Database();
    $db->create(
        $request->getParam('first_name'),
        $request->getParam('last_name'),
        $request->getParam('city'));
});


$app->delete('/user/delete/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $db = new Database();

    $db->delete($id);
});

$app->put('/user/update/{id}', function (Request $request, Response $response) {
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $city = $request->getParam('city');
    $id = $request->getAttribute('id');
    $db = new Database();

    $db->update($first_name, $last_name, $city, $id);
});