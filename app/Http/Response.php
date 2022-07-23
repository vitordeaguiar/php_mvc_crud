<?php

namespace App\Http;

class Response{

    // Código do status http
    private $httpCode = 200;

    // cabeçalho do response
    private $headers =[];

    // Tipo de conteudo que esta sendo retornado
    private $contentType = 'text/html';

    // Conteudo do response
    private $content;

    // Metodo responsavel por iniciar a classe e definir os valores
    public function __construct($httpCode,$content,$contentType = 'text/html'){
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
        
    }

    // Metodo responsavel por alterar o content type do response
    public function setContentType($contentType){
        $this->contentType = $contentType;
        $this->addHeader('Content-Type',$contentType);
    }

    // Metodo responsavel por adicionar um registro no cabeçalho de response
    public function addHeader($key,$value){
        $this->headers[$key] = $value;
        
    }

    // Metodo responsavel por enviar os Headers para o navegador
    private function sendHeaders(){
        // Status
        http_response_code($this->httpCode);
      
        // Enviar os Headers
        foreach($this->headers as $key=>$value){
            header($key.': '.$value);
        }
    }

    // Metodo responsavel por enviar a resposta para o usuário
    public function sendResponse(){
        //Envia os Headers
        $this->sendHeaders();

        // Imprime o conteudo
        switch($this->contentType){
            case 'text/html':
                echo $this->content;
            exit;
        } 
    }
}

