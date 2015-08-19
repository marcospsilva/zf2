<?php

namespace Livraria\Model;

class CategoriaService {
    /*
     * @var CategoriaTable
     */
    protected $categoriaTable;
    
    public function __construct(CategoriaTable $table) {
        $this->categoriaTable=$table;
        
    }
    public function FetchAll(){
        $resultset=  $this->categoriaTable->select();
        return $resultset;
    }
}
