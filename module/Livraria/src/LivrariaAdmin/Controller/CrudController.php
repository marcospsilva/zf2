<?php

namespace LivrariaAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;


abstract class CrudController extends AbstractActionController {

    /**
     * @var EntityManager
     */
    protected $service;
    protected $entity;
    protected $form;
    protected $route;
    protected $controller;

    public function indexAction() {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $list = $em->getRepository($this->entity)->findAll();

        //Paginação
        $page = $this->params()->fromRoute('page');
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page);
        $paginator->setDefaultItemCountPerPage(10);

        return new ViewModel(array("data" => $paginator, 'page' => $page));
    }

    public function newAction() {   
        $formulario = new $this->form;   
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
        $form = new $this->form;
       
        $request = $this->getRequest();
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $repository = $em->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute("id", 0));
        //se realmetne nos tivemos um parametro sendo passado
        if ($this->params()->fromRoute("id", 0))
           $form->setData($entity->toArray());

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());
                return $this->redirect()->toRoute($this->route, array("controller" =>  $this->controller));
            }
        }       
        return new ViewModel(array("form"=>$form));        
    }
    
    public function deleteAction(){
        
        $service=  $this->getServiceLocator()->get($this->service);
        if($service->delete($this->params()->fromRoute("id",0)))
          return $this->redirect()->toRoute($this->route, array("controller" => $this->controller));
    }

    protected function getEm() {
        if (null === $this->em)
            $this->em = $this->serviceLocator()->get('Doctrine\ORM\EntityManager');
        return $this->em;
    }

}
