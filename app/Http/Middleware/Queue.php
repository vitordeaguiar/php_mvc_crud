<?php

namespace App\Http\Middleware;

class Queue{

    private static  $map = [];

    private static $default = [];

    private $middlewares = [];

    private $controller;

    private $controllerArgs = [];

    // Metodo responsavel por contruis a classe de fila de middlewares
    public function __construct($middlewares, $controller, $controllerArgs){
        $this->middlewares = array_merge(self::$default,$middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    //Metodo responsavel por definir o mapeamento dos middlewares
    public static function setMap($map){
        self::$map = $map;
    }

    //Metodo responsavel por definir o mapeamento de middlewares padrões
    public static function setDefault($default){
        self::$default = $default;
    }

    //Metodo responsavel por executar a nova fila de middleware
    public function next($request){
        //Verifica se a fila esta vazia
        if(empty($this->middlewares)) return call_user_func_array($this->controller,$this->controllerArgs);

        //middleware
        $middleware = array_shift($this->middlewares);

        //Verifica o mapeamento
        if(!isset(self::$map[$middleware])){
            throw new \Exception("Problemas ao processar o middleware da requisição",500);
        }

        //Função next
        $queue = $this;
        $next = function($request) use($queue){
            return $queue->next($request);
        };

        return (new self::$map[$middleware])->handle($request,$next);
    }
}
