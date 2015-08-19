<?php

namespace LivrariaAdmin\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select;
use Doctrine\ORM\EntityManager;

class User extends Form {
    protected $users;
    public function __construct($nome = null, array $user=null) {
        parent::__construct("user");
        $this->users=$user;
        $this->setAttribute('method', 'post');
        
        #$this->setInputFilter(new CategoriaFilter());
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
                "label" => "Nome",
            ),
            "attibutes" => array(
                "id" => "nome",
                "placeholder" => "Entre com o nome"
            )
        ));
         $this->add(array(
            "name" => "email",
            "options" => array(
                "type" => "text",
                "label" => "Email"
            ),
            "attibutes" => array(
                "id" => "email",
                "placeholder" => "Entre com o Email"
            )
        ));
        $this->add(array(
            "name" => "password",
            "options" => array(
                "type" => "password",
                "label" => "Password"
            ),
            "attibutes" => array(
                "id" => "password",
                "placeholder" => "Entre com o Password"
            )
        ));
        
        

        $this->add(array(
            "name" => "submit",
            "type" => "Zend\Form\Element\Submit",
            "attributes" => array(
                "value" => "Salvar",
                "class" => "btn btn-success"
            )
        ));
    }

}
