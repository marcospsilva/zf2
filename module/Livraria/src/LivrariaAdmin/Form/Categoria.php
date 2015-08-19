<?php

namespace LivrariaAdmin\Form;

use Zend\Form\Form;

class Categoria extends Form{
   public function __construct($nome=null) {
       parent::__construct("categoria");
       $this->setAttribute('method','post');
       $this->setInputFilter(new CategoriaFilter());
       $this->add(array(
          "name"=>"id",
           "attibute"=>array(
               "type"=>"hidden"
           )
       ));
       
       $this->add(array(
          "name"=>"nome",
           "attribute"=>array(
            "type"=>"text",
            "label"=>"Nome"
           ),
           "attibutes"=>array(
               "id"=>"nome",
               "placeholder"=>"Entre com o nome"
           )
       ));
       
       $this->add(array(
          "name"=>"submit",
           "type"=>"Zend\Form\Element\Submit",
           "attributes"=>array(
             "value"=>"Salvar",
              "class"=>"btn btn-success"
           )
       ));    
   }

   
}

?>
