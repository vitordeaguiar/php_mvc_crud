<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;


Class Home extends Page{
    /*
    * Método responsavel por retornar o conteudo (view) da nossa home
    * @return string
    */
    public static function getHome(){
        // Organização
        $obOrganization = new Organization;

        // view da home
        $content = View::render('pages/home',[
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site'=> $obOrganization->site
        ]);
        // retorna view da pagina
        return parent::getPage('VDEV - Site para estudo', $content);

    }
}