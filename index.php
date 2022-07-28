<?php

require __DIR__.'/includes/app.php';

use App\Http\Router;

//Inicia o roteador
$obRouter = new Router(URL);

//Inclui as rotas de paginas
include __DIR__.'/routes/pages.php';

$obRouter->run()->sendResponse();