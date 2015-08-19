<?php
namespace LivrariaAdmin\Form;
use Zend\InputFilter\InputFilter;

class CategoriaFilter extends InputFilter {
   public function __construct() {
       $this->add(array(
           "name"=>"nome",
           "required"=>true,
           "filters"=>array(
               array("name"=>"StripTags"),
               array("name"=>"StringTrim"),
           ),
           "validators"=>array(              
               "options"=>array(
                    "name"=>"NotEmpty",
                   "messages"=>array("isEmpty"=>"Nome não pode estar em branco")
               )
           )
       ));
   }
}
