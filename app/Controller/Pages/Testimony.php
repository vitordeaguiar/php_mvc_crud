<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;


Class Testimony extends Page{
    /*
    * Método responsavel por retornar o conteudo (view) da nossa depoimentos
    * @return string
    */
    public static function getTestimonies(){
      
        // view de depoimentos
        $content = View::render('pages/testimonies',[
            
        ]);
        // retorna view de depoimentos
        return parent::getPage('Depoimentos > VDEV', $content);

    }
}