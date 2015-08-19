<?php

namespace LivrariaAdmin\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select;
use Doctrine\ORM\EntityManager;

class Livro extends Form {
    protected $categorias;
    public function __construct($nome = null, array $categorias=null) {
        parent::__construct("livro");
        $this->categorias=$categorias;
        $this->setAttribute('method', 'post');
        
        $this->setInputFilter(new CategoriaFilter());
        $this->add(array(
            "name" => "id",
            "attibute" => array(
                "type" => "hidden"
            )
        ));       
         
        $this->add(array(
            "name" => "nome",
            "options" => array(
                "type" => "text",
                "label" => "Nome"
            ),
            "attibutes" => array(
                "id" => "nome",
                "placeholder" => "Entre com o nome"
            )
        ));
      
 
        $categoria=new Select();
        $categoria->setLabel("Categoria");
          $categoria->setName("categoria");
                 echo "<br>";
        $categoria->setOptions(array("value_options"=>  $this->categorias ));
        $this->add($categoria);
        
       
        
        $this->add(array(
            "name" => "autor",
            "options" => array(
                "type" => "text",
                "label" => "Autor"
            ),
            "attributes" => array(
                "id" => "autor",
                "placeholder" => "Entre com o autor"
            ),
                )
        );
        $this->add(array(
            "name" => "isbn",
            "options" => array(
                "type" => "text",
                "label" => "Isbn"
            ),
            "attributes" => array(
                "id" => "isbn",
                "placeholder" => "Entre com o ISBN"
            ),
          )
        );
        
          $this->add(array(
            "name" => "valor",
            "options" => array(
                "type" => "text",
                "label" => "Valor"
            ),
            "attributes" => array(
                "id" => "valor",
                "placeholder" => "Entre com o Valor"
            ),
          )
        );


        $this->add(array(
            "name" => "submit",
            "type" => "Zend\Form\Element\Submit",
            "options" => array(
                "value" => "Salvar",
                "class" => "btn btn-success"
            )
        ));
    }

}
