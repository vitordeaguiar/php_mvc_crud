<?php
namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony{

    //id do depoimento
    public $id;

    //nome do depoimento
    public $nome;

    //depoimento
    public $mensagem;

    //data depoimento
    public $data;

    //Metodo responsavel por cadastrar a instancia atual no banco de dados
    public function cadastrar(){
       //Define a data
       $this->data = date('Y-m-d H:i:s');

       //inseri o depoimento no banco de dados
       $this->id = (new Database('depoimentos')) ->insert([
        'nome' => $this->nome,
        'mensagem' => $this->mensagem,
        'data' => $this->data
       ]);
       //Sucesso
       return true;
    }

    // Método responsavel por retornar depoimentos
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*'){
        return(new Database('depoimentos')) ->select($where,$order,$limit,$fields);
    }
}