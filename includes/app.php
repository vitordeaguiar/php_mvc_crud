<?php
require __DIR__.'/../vendor/autoload.php';



use App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;

//Carrega Variaveis de Ambiente
Environment::load(__DIR__.'/../');

//Define as configurações do banco
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT'),
);

define('URL', getenv('URL'));

//Define valor padrão das variaveis
View::init([
    'URL'=> URL
]);