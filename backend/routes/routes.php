<?php

///RUTAS DE LISTADO

require_once('Controllers/OffertsController.php');
require_once('Controllers/DocumentsController.php');

//$router->get('/', function() {
//    echo 'About Page Contents';
//});

//RUTAS PARA LAS LICITACIONES Y CREACION DE ESTAS

$router->mount('/ofertas', function() use ($router) {

    $router->get('/', OffertsController::class.'@list');

    $router->mount('/{id}', function() use ($router) {
        $router->get('/', OffertsController::class.'@getOffert');
        $router->post('/actualizar', OffertsController::class.'@update');

        //RUTAS DE DOCUMENTOS
        $router->get('/document/', DocumentsController::class.'@list');
        $router->post('document/save',DocumentsController::class.'@saveDocument');

    });

    $router->get('/crear', OffertsController::class.'@create');
    $router->post('/crear', OffertsController::class.'@save');
    

});


//$router->get('/', OffertsController::class.'@list');
//$router->get('/oferta/{id}', OffertsController::class.'@getOffert');
//$router->get('/crear', OffertsController::class.'@create');
//$router->post('/crear', OffertsController::class.'@save');
//$router->post('/oferta/{id}/actualizar', OffertsController::class.'@update');
//
//$router->get('/document/{idOffert}', DocumentsController::class.'@list');
//$router->post('document/{idOffert}/save',DocumentsController::class.'@saveDocument');

