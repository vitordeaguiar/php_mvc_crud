<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;


Class About extends Page{
    /*
    * Método responsavel por retornar o conteudo (view) da nossa Sobre
    * @return string
    */
    public static function getAbout(){
        // Organização
        $obOrganization = new Organization;

        // view da home
        $content = View::render('pages/about',[
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site'=> $obOrganization->site
        ]);
        // retorna view da pagina
        return parent::getPage('Sobre > VDEV', $content);

    }
}