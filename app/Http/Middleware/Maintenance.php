<?php

namespace App\Http\Middleware;

class Maintenance{
    //Metodo responsavel por executar o middleware
    public function handle($request, $next){
        if(getenv('MAINTENANCE') == 'true'){
            throw new \Exception("Página em manutenção",200);
        }

        //executa o próximo nivel de middleware
        return $next($request);
    }
}