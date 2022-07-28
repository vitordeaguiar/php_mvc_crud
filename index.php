<?php

require __DIR__.'/vendor/autoload.php';


use App\Http\Router;
use App\Utils\View;
use \WilliamCosta\DotEnv\Environment;

//Carrega Variaveis de Ambiente
Environment::load(__DIR__);

define('URL', getenv('URL'));

//Define valor padrão das variaveis
View::init([
    'URL'=> URL
]);

//Inicia o roteador
$obRouter = new Router(URL);

//Inclui as rotas de paginas
include __DIR__.'/routes/pages.php';

$obRouter->run()->sendResponse();