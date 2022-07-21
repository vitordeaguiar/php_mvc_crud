<?php

namespace App\Utils;

class View {

    // Método responsavel por retornar o conteudo de uma view
    private static function getContentView($view){
        $file = __DIR__.'/../../resources/view/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    // Método responsavel por retornar o conteudo renderizado de uma view
    public static function render($view, $vars = []){
        //Conteudo da View
        $contentView = self::getcontentView($view);

        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return'{{'.$item.'}}';
        },$keys);
       
        // Retorna o conteudo renderizado
        return str_replace($keys,array_values($vars),$contentView);
    }
}