<?php
namespace LivrariaAdmin\Controller;
use Zend\View\Model\ViewModel;

class LivroController  extends CrudController {
       public function __construct() {       
        $this->entity="Livraria\Entity\Livro";
        $this->service="Livraria\Service\Livro";
        $this->form="LivrariaAdmin\Form\Livro";
        $this->controller="livros";
        $this->route="livraria-admin";
    }
     public function newAction() {   
        $formulario = $this->getServiceLocator()->get($this->form);  
        $request = $this->getRequest();

        //Verifica se houve post
        if ($request->isPost()) {
            //Preenche os dados do formulário
            $formulario->setData($request->getPost());
            if ($formulario->isValid()) {
                //Rotina de inserir
                $service = $this->getServiceLocator()->get($this->service);
                $service->insert($request->getPost()->toArray());
                return $this->redirect()->toRoute($this->route, array("controller" => $this->controller));
            }
        }
        return new ViewModel(array("form"=>$formulario));
    }

    public function EditAction() {
        $formulario = $this->getServiceLocator()->get($this->form);  
       
        $request = $this->getRequest();
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $repository = $em->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute("id", 0));
        //se realmetne nos tivemos um parametro sendo passado
        if ($this->params()->fromRoute("id", 0))
           $formulario->setData($entity->toArray());

        if ($request->isPost()) {
            $formulario->setData($request->getPost());
            if ($formulario->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());
                return $this->redirect()->toRoute($this->route, array("controller" =>  $this->controller));
            }
        }       
        return new ViewModel(array("form"=>$formulario));        
    }
}
