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

       //inseti o depoimento no banco de dados
       $this->id = (new Database('depoimentos')) ->insert([
        'nome' => $this->nome,
        'mensagem' => $this->mensagem,
        'data' => $this->data
       ]);
       //Sucesso
       return true;
    }
}