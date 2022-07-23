<?php

require __DIR__.'/vendor/autoload.php';


use App\Http\Router;
use App\Utils\View;

define('URL','http://localhost/php_mvc_crud');

//Define valor padrão das variaveis
View::init([
    'URL'=> URL
]);

//Inicia o roteador
$obRouter = new Router(URL);

//Inclui as rotas de paginas
include __DIR__.'/routes/pages.php';

$obRouter->run()->sendResponse();