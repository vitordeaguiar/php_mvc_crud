<?php

namespace App\Controller\Pages;

use \App\Utils\View;

Class Page{
    // Metodo para renderizar o topo da página
    private static function getHeader(){
        
        return View::render('pages/header');
    }

    // Metodo para renderizar o rodapé da página
    private static function getFooter(){
        
        return View::render('pages/footer');
    }
    
    // Método responsavel por retornar o conteudo (view) da nossa pagina generica
    public static function getPage($title,$content){
        return View::render('pages/page',[
            'title'=>$title,
            'header'=> self::getHeader(),
            'content'=>$content,
            'footer'=> self::getFooter(),
        ]);

    }
}