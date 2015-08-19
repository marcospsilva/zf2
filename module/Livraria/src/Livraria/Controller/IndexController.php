<?php
namespace Livraria\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {

        /*
         * $categoriaservice=  $this->getServiceLocator()->get("Livraria\Model\CategoriaService");
        $categorias=$categoriaservice->fetchAll();
        return new ViewModel(array("categorias"=>$categorias));
        */
        
          $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
          $categoria = $em->getRepository("Livraria\Entity\Categoria")->findAll();
          
          return new ViewModel(array("categorias"=>$categoria));
    }
}
