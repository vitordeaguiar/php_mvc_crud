<?php

namespace App\Http;

class Request {
    // Metodo http da requisição
    private $httpMethod;

    // URI da pagina
    private $uri;

    // Parametros da URL($_GET)
    private $queryParams =[];

    // Variaveis recebidas no POST da pagina ($_POST)
    private $postVars = [];

    // Cabeçalho da requisição
    private $headers = [];

    // construtor da classe
    public function __construct(){
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    // Responsavel por retornar o metodo HTTP da requisição
    public function getHttpMethod(){
        return $this->httpMethod;
    }

    // Responsavel por retornar os headers da requisição
    public function getHeaders(){
        return $this->headers;
    }

    // Responsavel por retornar as variaveis POST da requisição
    public function getPostVars(){
        return $this->postVars;
    }

    // Responsavel por retornar os parametros da requisição
    public function getQueryParams(){
        return $this->queryParams;
    }

    // Responsavel por retornar a URI da requisição
    public function getUri(){
        return $this->uri;
    }
}