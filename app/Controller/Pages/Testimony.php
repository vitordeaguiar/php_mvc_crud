<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;


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

    //Metodo responsavel por cadastrar um depoimento
    public static function insertTestimony($request){
        //Dados recebidos do post
        $postVars = $request->getPostVars();

        //Nova instancia de depoimento
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        return self::getTestimonies();
    }
}