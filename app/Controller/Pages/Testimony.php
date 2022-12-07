<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;


Class Testimony extends Page{

    // Método responsavel por obter a renderização dos items de depoimentos
    private static function getTestimonyItens($request,&$obPagination){
        $itens = '';

        //Quantidade total de registros
        $quantidadeTotal = EntityTestimony::getTestimonies(null,null, null,'COUNT(*) as qtd') ->fetchObject()->qtd;
        
        //Pagina atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //instancia de paginação
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

        //resultados da pagina
        $results = EntityTestimony::getTestimonies(null,'id DESC', $obPagination->getLimit());

        //rendereiza o irem
        while($obTestimony = $results->fetchObject(EntityTestimony::class)){
            $itens .= View::render('pages/testimony/item',[
                'nome' => $obTestimony->nome,
                'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data)),
                'mensagem' => $obTestimony->mensagem
            ]);
        }

        // retorna os depoimentos
        return $itens;
    }

    /*
    * Método responsavel por retornar o conteudo (view) da nossa depoimentos
    * @return string
    */
    public static function getTestimonies($request){
      
        // view de depoimentos
        $content = View::render('pages/testimonies',[
            'itens' => self::getTestimonyItens($request,$obPagination),
            'pagination' => parent::getPagination($request,$obPagination)
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

        return self::getTestimonies($request);
    }
}