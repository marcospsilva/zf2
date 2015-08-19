<?php

namespace Livraria\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {

    public function findByEmailAndPassword($email, $password) {
        $user = $this->findOneByEmail($email);
        if ($user) {
            $hashsenha = $user->encriptPassword($password);
          if($hashsenha==$user->getPassword()){
              return $user;
          }else
              return false;

        }else
            return false;
    }
     public function findByPermissao($email) {
        $user = $this->findOneByEmail($email);      
              return $user;
       
    }

}
