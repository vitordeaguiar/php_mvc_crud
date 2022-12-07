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

    //Metodo responsavel por renderizar o layout de paginação
    public static function getPagination($request,$obPagination){
        //Paginas
        $pages = $obPagination->getPages();
        
        //Verifica a quantidade de paginas
        if(count($pages)<=1) return '';

        // Linkds
        $links = '';

        //url atual do projeto
        $url = $request->getRouter()->getCurrentUrl();

        //get
        $queryParams = $request->getQueryParams();

        //renderiza os links
        foreach($pages as $page){
            //altera a pagina
            $queryParams['page'] = $page['page'];

            //link
            $link = $url.'?'.http_build_query($queryParams);

            //view
            $links .= View::render('pages/pagination/link',[
                'page'=>$page['page'],
                'link'=> $link,
                'active'=> $page['current'] ? 'active' : ''
            ]);
        }

        //renderiza
        return View::render('pages/pagination/box',[
            'links'=> $links
        ]);
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