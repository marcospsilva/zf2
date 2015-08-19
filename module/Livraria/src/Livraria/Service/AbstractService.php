<?php

namespace Livraria\Service;

use Doctrine\ORM\EntityManager;
use Livraria\Entity\Categoria as CategoriaService;
use Livraria\Entity\Configurator;

class AbstractService {

    /**
     * @var EntityManager
     */
    protected $em;
    protected $entity;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function insert(Array $data) {
        $entidade = new $this->entity($data);
        $this->em->persist($entidade);
        $this->em->flush();
        return $entity;
    }

    public function update(Array $data) {
        $entity = $this->em->getReference($this->entity, $data['id']);
        $entity = Configurator::configure($entity, $data);
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    public function delete($id) {

        $entity = $this->em->getReference($this->entity, $id);
        if ($entity) {
            $this->em->remove($entity);
            $this->em->flush();
            return $id;
        }
    }

}
