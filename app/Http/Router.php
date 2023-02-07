<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use \App\Http\Middleware\Queue as MiddlewareQueue;

class Router{
    // URL completa
    private $url = '';

    // Prefixo de todas as rotas
    private $prefix = '';

    //Indice de rotas
    private $routes = [];

    //Instancia de request    
    private $request;

    // Metodo responsavel por iniciar a classe
    public function __construct($url){
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

    // Metodo responsavel por definir o prefixo das rotas
    private function setPrefix(){

        $parseUrl = parse_url($this->url);
        
        //Define o prefixo
        $this->prefix = $parseUrl['path'] ?? '';
    }

    //Metodo responsavel por adicionar uma rota na classe
    private function addRoute($method,$route,$params = []){
        //Validação dos parametros
        foreach($params as $key=>$value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //middlewares da rota
        $params['middlewares'] = $params['middlewares'] ?? [];

        //Variaveis da rota
        $params['variables']=[];

        //Padrão de validação das variaveis das rotas
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable,$route,$matches)){
            $route = preg_replace($patternVariable,'(.*?)',$route);
            $params['variables'] = $matches[1];
        }

        // Substituindo tudo que for '/' por '\/' e padrão de validação da URL
        $patternRoute = '/^'.str_replace('/','\/', $route).'$/';
        
        //Adiciona a rota dentro da classe
        $this->routes[$patternRoute][$method] = $params;
        
    }

    //Metodo por definir uma rota de GET
    public function get ($route,$params = []){
        return $this->addRoute('GET',$route,$params);
    }

    //Metodo por definir uma rota de POST
    public function post ($route,$params = []){
        return $this->addRoute('POST',$route,$params);
    }

    //Metodo por definir uma rota de PUT
    public function put ($route,$params = []){
        return $this->addRoute('PUT',$route,$params);
    }

    //Metodo por definir uma rota de DELETE
    public function delete ($route,$params = []){
        return $this->addRoute('DELETE',$route,$params);
    }

    //Metodo responsavel por retornar a URI desconsiderando o prefixo
    private function getUri(){
        //Uri da request
        $uri = $this->request->getUri();
        
        //Fatia a uri com o prefixo
        $xUri = strlen($this->prefix) ? explode($this->prefix,$uri) : [$uri];
        
        //Retorna a URI sem prefixo
        return end($xUri);
    }

    //Metodo responsavel por retornar os dados da rota atual
    private function getRoute(){
        
        //URI
        $uri = $this->getUri();

        //Method
        $httpMethod = $this->request->getHttpMethod();

        //Valida as rotas
        foreach($this->routes as $patternRoute=>$methods){
            //Verifica se a URI bate o padrão
            if(preg_match($patternRoute,$uri,$matches)){
                if(isset($methods[$httpMethod])){
                    //remove a primeira posição
                    unset($matches[0]);

                    //chaves das variaveis
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys,$matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    //Retorno dos parametros da rota
                    return $methods[$httpMethod];
                }

               throw new Exception("Método não é permitido",405);

            }
                
        }

       throw new Exception("URL não encontrada",404);

        
    }

    //Metodo por executar a rota atual
    public function run(){
        try{
            // Obtem a rota atual
            $route = $this->getRoute();
            
            //Verifica o controlador
            if(!isset($route['controller'])){
                throw new Exception("A URL Não pode ser processada",500);
            }
            //Argumentos da função
            $args=[];

            //Reflection
            $reflection = new ReflectionFunction($route['controller']);
            foreach($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            //retorna a execução da fila de middlewares
            return (new MiddlewareQueue($route['middlewares'],$route['controller'],$args))->next($this->request);
        }catch(Exception $e){
            return new Response($e->getCode(), $e->getMessage());
        }

    }

    // Metodo responsavel por retornar a url atual
    public function getcurrentUrl(){
        return $this->url.$this->getUri();
    }
}